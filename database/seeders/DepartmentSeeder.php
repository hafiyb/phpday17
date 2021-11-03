<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $count = 0;

        foreach (range(1,10) as $index){
            $count++;
            // DB::table('companies')->insert([
            //     'user_id' => $count,
            //     'first_name' => $faker->name,
            //     'last_name' => $faker->name,
            //     'email' => $faker->unique()->safeEmail,
            //     'phone_number' => '+601'.rand(10000000,99999999),
            //     'department_id' => rand(1,9),
            //     'salary'
            // ]); // same
            $dept = new Department();
            $dept->name = $faker->name;
            $dept->save();
        }
    }
}
