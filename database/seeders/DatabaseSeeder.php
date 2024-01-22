<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,
            TeamSeeder::class,
            TypeSeeder::class,
            EventSeeder::class,
            GameSeeder::class,
            QuestionSeeder::class,
            ChoiceSeeder::class,
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
            
        ]); 

    }
}
