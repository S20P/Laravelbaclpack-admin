<?php

use Illuminate\Database\Seeder;
use App\Models\SliderModule;

class SliderMediaModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        SliderModule::query()->delete();

        $data = [
            [
                "heading"=>"Home Page Banner",
                "slug"=>"home_page_banner",
                "content"=>"Optional Banner Text",
                "button_text"=>null,
                "button_url"=>null,
                "slide_number"=>1,
                "image"=>"uploads/Slider/5655e106f153f72161fd290f46f73d83.jpg"
            ],
            [
                "heading"=>"Supplierst Page Banner",
                "slug"=>"supplierst_page_banner",
                "content"=>"Browse our Suppliers",
                "button_text"=>null,
                "button_url"=>null,
                "slide_number"=>2,
                "image"=>"uploads/Slider/ce3b1765d8e87513e3f946cab0f956d4.jpg"
            ],
            [
                "heading"=>"Supplierst List Page Banner",
                "slug"=>"supplierst_list_page_banner",
                "content"=>"Our Supplier",
                "button_text"=>null,
                "button_url"=>null,
                "slide_number"=>3,
                "image"=>"uploads/Slider/b3ffcf33334e478b1441e1052d20759f.jpg"
            ],
            [
                "heading"=>"Become a Supplier",
                "slug"=>"becomeSupplier_page_banner",
                "content"=>"Become a Supplier",
                "button_text"=>null,
                "button_url"=>null,
                "slide_number"=>4,
                "image"=>"uploads/Slider/6ab5bee2e63d1f7c797f73a5ae6470ce.jpg"
            ]
        ];

        SliderModule::insert($data);
    }
}
