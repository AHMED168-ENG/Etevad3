<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seting;

class AddSetingSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Seting::create([
            "site_address" => "site_address",
            "site_phone" => "site_phone",
            "site_email" => "site_email",
            "site_name" => "site_name",
            "site_summary" => "site_summary",
            "site_slogan" => "site_slogan",
            "site_facebook" => "site_facebook",
            "site_instegram" => "site_instegram",
            "site_tiktok" => "site_tiktok",
            "site_youtube" => "site_youtube",
            "site_snapchate" => "site_snapchate",
            "site_keywords" => "site_keywords",
            "site_description" => "site_description",
            "site_upper_logo" => "site_upper_logo",
            "site_lower_logo" => "site_lower_logo",
            "site_active" => true,
        ]);
    }
}
