<?php

use Illuminate\Database\Seeder;

class CheckboxTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('agile_checkboxes')->insert([
            'name' => "In de mededeling",
        ]);

        DB::table('agile_checkboxes')->insert([
            'name' => "Akkoord klant",
        ]);
    }
}
