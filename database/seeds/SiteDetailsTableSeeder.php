<?php

use Illuminate\Database\Seeder;
use App\Models\SiteDetails;

class SiteDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SiteDetails::query()->delete();

        $data = [
            [
                'contact_number'=>"01234567890",
                'contact_email'=>"mkp3837@gmail.com",
                'address'=>"12 Somerts St
                Dublin",
                'logo1'=>"uploads//d77285f72b5b6803f24aaf45e9780fcb.png",
                'logo2'=>"uploads//4a2a7d1732deeffceb9eb8328d68ec1d.png",
                'currency_code'=>"inr",
                'currency_symbol'=>"₹",
                'pagination_per_page'=>10,
                'stripe_key'=>"pk_test_Ztf6gEUXNn1xylybkkb3yhZj00nGLDLEy1",
                'stripe_secret'=>"sk_test_AVzyw49wcWjmla5scl9Bfliv00HNQMdjhN",
                'instagram_user_id'=>"3164004994",
                'instagram_secret'=>"3164004994.aff5dfd.6b455858ac8d4d5c8d3e86eb591dfa49",
                'number_of_feeds'=>"5"
            ],
        ];

        SiteDetails::insert($data);
    }
}
