<?php

use App\Models\Course;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $json = file_get_contents(database_path().'/seed.json');
        $courses = json_decode($json, true)['courses'];

        foreach ($courses as $course) {
            Course::firstOrCreate(['name' => $course]);
        }
    }
}
