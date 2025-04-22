<?php

namespace App\Jobs;

use App\Services\FirebaseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPublicAnnouncementNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $title;

    protected $body;

    protected $data;

    protected $tokens;

    /**
     * Create a new job instance.
     */
    public function __construct($title, $body, $tokens, $data = [])
    {
        $this->title = $title;
        $this->body = $body;
        $this->tokens = $tokens;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(FirebaseService $firebaseService): void
    {
        $tokenChunks = array_chunk($this->tokens, 500);
        foreach ($tokenChunks as $chunk) {
            $firebaseService->BasicSendNotification(
                $this->title,
                $this->body,
                $chunk,
                $this->data
            );
        }
    }
}
