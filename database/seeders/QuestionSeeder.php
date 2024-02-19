<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->delete();

        $items = [
            [
                'title' => 'Which Nintendo character appears alongside Donkey Kong in the title the 2013 game "Minis on the Move"?',
                'score' => '5',
                'brand_id' => '1',
                'time' => '45',
                'created_at' => Carbon::now(),
            ],
            ///////////////////////////////////////

            [
                'title' => 'Brave New World" was a 2013 expansion to what popular strategy video game?',
                'score' => '5',
                'brand_id' => '2',
                'time' => '45',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Which Marvel comics anti-hero got his own video game in 2013? ',
                'score' => '5',
                'brand_id' => '3',
                'time' => '45',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => '"Prehistoric Party" was a 2013 video game adaptation of what movie?',
                'score' => '5',
                'brand_id' => '4',
                'time' => '30',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => '"Hearthstone" was a 2014 card-collecting video game based on what franchise?',
                'score' => '5',
                'brand_id' => '5',
                'time' => '30',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Arkham Origins Blackgate" was a 2014 video game starring which comic book character? ',
                'score' => '5',
                'brand_id' => '6',
                'time' => '45',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Reaper of Souls\" was a 2014 expansion to what video game that\'s partially set in Hell? ',
                'score' => '5',
                'brand_id' => '7',
                'time' => '30',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'The Stick of Truth" was a 2014 video game based on what Comedy Central TV show? ',
                'score' => '5',
                'brand_id' => '8',
                'time' => '45',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Who was not a character in any Mario games? ',
                'score' => '5',
                'brand_id' => '9',
                'time' => '15',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Which characters are two non-videogame "mascots" who have their own NES games? ',
                'score' => '5',
                'brand_id' => '10',
                'time' => '15',
                'created_at' => Carbon::now(),
            ],

            [
                'title' => 'Which character is the mascot of Nintendo ?',
                'score' => '5',
                'brand_id' => '1',
                'time' => '30',
                'created_at' => Carbon::now(),
            ],
        ];
        DB::table('questions')->insert($items);
    }
}
