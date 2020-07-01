<?php

use Illuminate\Database\Seeder;
use App\Models\SupplierCategory;

class SupplierCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ["Backery","DJ's","Venues","Bakeries","Marquee Hire","Transport","Entertainment","Catering","Bar Service","Photography","Confrence","Live Bands","Sound","Wedding","Language"];
        $description = "Test a Description";
        $image = "/uploads/Supplier/default.png";
        $price = 200;
        $rates = 5;
           foreach($names as $name){
            SupplierCategory::create([
              "name"=>$name,
              "description"=>$description,
              "image"=>$image,
              "price"=>$price,
              "rates"=>$rates
            ]);

           }
    }
}
