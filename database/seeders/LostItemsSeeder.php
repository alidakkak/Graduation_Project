<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LostItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lost_items')->insert([
            [
                'title' => 'سلك الشاحن',
                'description' => 'يعطيكم العافية ضعلي اليوم سلك الشاحن الأبيض هاد بمخبر النت الي بيلاقيه يحطه عند الهيئة او يتواصل معي للابتوب',
                'image' => '/lostItem/lost1.jpg',
                'date_of_loss' => '2025-08-17',
                'status' => 'notFound',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'لابتوب',
                'description' => 'اللابتوب إنتقل من المخبر G1 إلى مكتب الهيئة',
                'image' => '/lostItem/lost2.jpg',
                'date_of_loss' => '2025-08-23',
                'status' => 'Found',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'أسوارة',
                'description' => 'هاي الأسوارة لقيتا يوم الأحد يلي كان آخر يوم امتحانات .. كنا عم نقدم بنيان 1 المكان يلي لقيتا فيه كان فريق الRBCS عم يتصور',
                'image' => '/lostItem/lost3.jpg',
                'date_of_loss' => '2025-08-06',
                'status' => 'itWasReceived',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
