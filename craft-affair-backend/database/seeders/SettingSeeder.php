<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'fb_link' => 'www.google.com',
            'linkedin_link' => 'www.google.com',
            'instagram_link' => 'www.google.com',
            'twitter_link' => 'www.google.com',
            'site_title' => 'craft affair',
            'site_description' => 'craft affair is good business',
            'promotion_line' => 'Free shipping, 30-day return or refund guarantee.'
        ]);
    }
}
