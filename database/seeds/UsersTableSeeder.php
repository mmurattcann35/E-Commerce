<?php


use App\Models\UserDetail;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker\Generator $faker)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        User::truncate();
        UserDetail::truncate();

        $userAdmin = User::create([
            'name'      => 'Murat CAN',
            'email'     => 'murat@diffea.com',
            'password'  => bcrypt('123456789'),
            'is_active' => 1,
            'is_admin'  => 1
        ]);
        $userAdmin->detail()->create([
            'address' => 'İzmir/Selçuk',
            'phone' => '0232 892 0000',
            'gsm_phone' => '0555 555 5555'
        ]);

        for($i = 0; $i <= 50; $i++){

            $userCustomer = User::create([
                'name'      => $faker->name,
                'email'     => $faker->unique()->safeEmail,
                'password'  => bcrypt('123456789'),
                'is_active' => rand(0,1),
                'is_admin'  => 0
            ]);

            $userCustomer->detail()->create([
                'address' => $faker->address,
                'phone'   => $faker->phoneNumber,
                'gsm_phone' => $faker->phoneNumber
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
