<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class JobSeeder extends Seeder
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
            $job = new Job();
            $job->title = $faker->name;
            $job->description = $faker->name;
            $job->min_salary = rand(1000,9999);
            $job->max_salary = rand(1000,9999);

            $job->save();
        }
    }
}
