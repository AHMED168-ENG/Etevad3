<?php

namespace Database\Seeders;
use App\Models\About_us;
use Illuminate\Database\Seeder;

class AboutUsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        About_us::create([
            "description" => "description",
            "vision" => "vision",
            "message" => "message",
            "strategic_one_title" => "strategic_one_title",
            "strategic_one_content" => "strategic_one_content",
            "strategic_tow_title" => "strategic_tow_title",
            "strategic_tow_content" => "strategic_tow_content",
            "strategic_three_title" => "strategic_three_title",
            "strategic_three_content" => "strategic_three_content",
            "page_keywords" => "page_keywords",
            "page_description" => "page_description",
        ]);
    }
}
