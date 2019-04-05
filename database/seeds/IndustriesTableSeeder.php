<?php

use App\Models\Industry;
use Illuminate\Database\Seeder;

class IndustriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $json = file_get_contents(database_path().'/seed.json');
        $industries = json_decode($json, true)['industries'];

        foreach ($industries as $industry) {
            Industry::firstOrCreate(['name' => $industry]);
        }
    }
}
