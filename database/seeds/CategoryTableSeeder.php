<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('categories')->truncate();

        $id = DB::table('categories')->insertGetId([
            'name' => 'Elektronik',
            'slug' => 'elektronik',
            'icon' => 'fa fa-television'
        ]);
            DB::table('categories')->insert([
                'name' => 'Bilgisayar/Tablet',
                'slug' => 'bilgisayar-tablet',
                'icon' => 'fa fa-phone',
                'ust_id' => $id
            ]);
        DB::table('categories')->insert([
            'name' => 'TV ve Ses Sistemleri',
            'slug' => 'tv-ve-ses-sistemleri',
            'icon' => 'fa fa-television',
            'ust_id' => $id
        ]);
        $id = DB::table('categories')->insertGetId([
            'name' => 'Kitap',
            'slug' => 'kitap',
            'icon' => 'fa fa-book-reader'

        ]);
            DB::table('categories')->insert([
                'name' => 'Edebiyat',
                'slug' => 'edebiyat',
                'icon' => 'fa fa-book',
                'ust_id' => $id
            ]);
            DB::table('categories')->insert([
                'name' => 'Çocuk',
                'slug' => 'cocuk',
                'icon' => 'fa fa-baby',
                'ust_id' => $id
            ]);
            DB::table('categories')->insert([
                'name' => 'Bilgisayar',
                'slug' => 'bilgisayar',
                'icon' => 'fa fa-laptop',
                'ust_id' => $id
            ]);
        DB::table('categories')->insert([
            'name' => 'Dergi',
            'slug' => 'dergi',
            'icon' => 'fa fa-book'
        ]);
        DB::table('categories')->insert([
            'name' => 'Mobilya',
            'slug' => 'mobilya',
            'icon' => 'fa fa-chair'
        ]);
        DB::table('categories')->insert([
            'name' => 'Kişisel Bakım',
            'slug' => 'kisisel-bakim',
            'icon' => 'fa fa-user-cog'
        ]);
        DB::table('categories')->insert([
            'name' => 'Anne ve Çocuk',
            'slug' => 'anne-ve-cocuk',
            'icon' => 'fa fa-baby'
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
