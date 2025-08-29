<?php

namespace App\Jobs;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Recipient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CreateMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $messageId;

    protected bool $isHate;

    /**
     * Create a new job instance.
     */
    public function __construct(Message $message, bool $isHate)
    {
        // نخزّن id بدل object كامل (أخف على الـ queue)
        $this->messageId = $message->id;
        $this->isHate = $isHate;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $message = Message::with('sender', 'conversation')->find($this->messageId);

        if (! $message) {
            Log::warning("Message not found: {$this->messageId}");

            return;
        }

        // ✅ تحديث conversation.last_message_id لو مو hate
        if (! $this->isHate) {
            $message->conversation?->update([
                'last_message_id' => $message->id,
            ]);
        }$otherStudentIds = Conversation::findOrFail($message->conversation_id)->students()->where('students.id', '!=',$message->student_id)->pluck('students.id');

        $recipientsData = $otherStudentIds->map(fn ($sid) => [
            'student_id' => $sid,
            'conversation_id' => $message->conversation_id,
            'message_id' => $message->id,
        ])->toArray();

        if (! empty($recipientsData)) {
            Recipient::insertOrIgnore($recipientsData);
        }
        if ($message->type === 'text' && ! $this->isHate) {
            try {
                Http::post('http://89.116.23.191:8100/api/add_messages', [
                    'messages' => [
                        [
                            'text' => $message->body,
                            'message_id' => (string) $message->id,
                            'sender' => $message->sender?->first_name ?? ' ',
                            'timestamp' => now()->toIso8601String(),
                            'group_id' => (string) $message->conversation_id,
                        ],
                    ],
                ]);
            } catch (\Exception $e) {
                Log::error("SendMessageToExternalService failed: {$e->getMessage()}");
            }
        }

    }
}
