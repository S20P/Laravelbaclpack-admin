<?php

use Illuminate\Database\Seeder;
use App\Models\SocialMediaModule;

class SocialMediaModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $social_network = ['Facebook','YouTube','WhatsApp','Facebook Messenger','WeChat','Instagram','TikTok','Twitter','LinkedIn','Snapchat','Pinterest'];
        foreach($social_network as $network){
            SocialMediaModule::create([
              "social_network"=>$network,
            ]);
           }
    }
}
