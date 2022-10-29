<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory()->create([
             'name' => 'Админ Админович',
             'email' => 'admin@localhost',
         ]);

         \App\Models\CarUser::factory(20)->create();
         \App\Models\Car::factory(10)->create();
    }
}
