<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
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

        foreach (range(1,100) as $index){
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
            $employee = new Employee();
            $employee->user_id = $count;
            $employee->first_name = $faker->name;
            $employee->last_name = $faker->name;
            $employee->email = $faker->unique()->safeEmail;
            $employee->phone_number = '+601'.rand(10000000,99999999);
            $employee->department_id = rand(1,9);
            $employee->salary = rand(1000, 9999);
            $employee->job_id = rand(1,9);

            $employee->save();
        }
    }
}
