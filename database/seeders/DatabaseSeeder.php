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
            GameSeeder::class,
            BrandSeeder::class,
            QuestionSeeder::class,
            AnswerSeeder::class,
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
            QuestionCorrectAnswerSeeder::class,
            GameQuestionSeeder::class,
            UserTeamSeeder::class,
        ]); 

    }
}
