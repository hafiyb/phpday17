<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $count=0;
        foreach (range(1,100) as $index){
            $count++;
            $user = new User();
            $user->name = $faker->name;
            $user->email = $faker->unique()->safeEmail;
            $user->password = bcrypt($count);
            $user->role = rand(1,9);

            $user->save();
        }
    }
}
