<?php

use Illuminate\Database\Seeder;
use App\Models\Testimonial;
class ClientTestimonialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Testimonial::query()->delete();

        $data = [
            [
                "title"=>"DJ service",
                "tagline"=>null,
                "content_review_message"=>"How do I even begin to thank you?!?  We had so many people come up to us and tell us what an amazing DJ we chose!",
                "client_name"=>"Bose Steven",
                "company_name"=>"example",
                "company_website"=>"http://example.com/",
                "email"=>"devdyna@gmail.com",
                "rating"=>null,
                "image"=>"/images/avtar.png"
            ],
            [
                "title"=>"Bakery",
                "tagline"=>null,
                "content_review_message"=>"I went to Sweet Themes in hopes to have them create the perfect Seahawks cake for my boss who turned 40 this past weekend.",
                "client_name"=>"Sara John",
                "company_name"=>"example",
                "company_website"=>"http://example.com/",
                "email"=>"devdyna@gmail.com",
                "rating"=>null,
                "image"=>"/images/avtar.png"
            ],
            [
                "title"=>"Transport event",
                "tagline"=>null,
                "content_review_message"=>"Transportation Services has the best ground transportation service that I have experienced in my 20+ years of arranging logistics for meetings!",
                "client_name"=>"Butler Boomer",
                "company_name"=>"example",
                "company_website"=>"http://example.com/",
                "email"=>"devdyna@gmail.com",
                "rating"=>null,
                "image"=>"/images/avtar.png"
            ],
            [
                "title"=>"Entertainment Service",
                "tagline"=>null,
                "content_review_message"=>"Thank you so much for doing an amazing job on the Land Rover marquee at Polo in the City We have had such positive feedback from the clients, dealers, VIP’s and media.",
                "client_name"=>"Digs Roy",
                "company_name"=>"example",
                "company_website"=>"http://example.com/",
                "email"=>"devdyna@gmail.com",
                "rating"=>null,
                "image"=>"/images/avtar.png"
            ]
        ];
        Testimonial::insert($data);
    }
}
