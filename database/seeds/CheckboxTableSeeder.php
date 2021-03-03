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
        $checkbox = \App\Checkbox::find(1);
        if (!$checkbox) {
            DB::table('agile_checkboxes')->insert([
                'name' => "In de mededeling",
            ]);
        }
        $checkbox = \App\Checkbox::find(1);
        if (!$checkbox) {
            DB::table('agile_checkboxes')->insert([
                'name' => "Akkoord klant",
            ]);
        }
    }
}
