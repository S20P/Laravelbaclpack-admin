<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\SupplierCategory;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('users')->where('email', 'admin@example.com')->count() == 0) {
            DB::table('users')->insert([
                'name'     => 'Demo Admin',
                'email'    => 'admin@example.com',
                'password' => bcrypt('admin'),
            ]);
        }

        factory(User::class, 131)->create();


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
