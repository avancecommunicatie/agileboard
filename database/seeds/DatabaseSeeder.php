<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $user = \App\User::find(1);
        if (! $user) {
            \App\User::create([
                'name' => 'avance',
                'email' => 'support@avancecommunicatie.nl',
                'password' => bcrypt('1q2w3e4r')
            ]);
        }

        $user = \App\User::find(2);
        if (! $user) {
            \App\User::create([
                'name' => 'guest',
                'email' => 'guest@avancecommunicatie.nl',
                'password' => bcrypt('agile')
            ]);
        }

        $user = \App\User::find(3);
        if (! $user) {
            \App\User::create([
                'name' => 'Dominic',
                'email' => 'online@lesgenereux.nl',
                'password' => bcrypt('BJc1AvB1fDqVXza1')
            ]);
        }

         $this->call(CheckboxTableSeeder::class);

        Model::reguard();
    }
}
