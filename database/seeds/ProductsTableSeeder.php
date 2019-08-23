<?php

use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        ProductDetail::truncate();
        for($i = 0; $i < 30; $i++){

            $name    = $faker->sentence(2);

            $product = Product::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => $faker->sentence(10),
                'price'       => $faker->randomFloat(2,1,20)
            ]);

           $detail =$product->detail()->create([
                'image'   => "default.png",
                'show_in_slider' => rand(0,1),
                'show_product_of_day' => rand(0,1),
                'show_ahead' => rand(0,1),
                'show_discounted' => rand(0,1),
                'show_best_seller' => rand(0,1)
            ]);
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
