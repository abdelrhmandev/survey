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
                'difficulty' => 'normal',
                'score' => '20',
                'game_id' => '1',
                'time' => '200',
                'created_at' => Carbon::now(),
            ],
            ///////////////////////////////////////

            [
                'title' => 'Brave New World" was a 2013 expansion to what popular strategy video game?',
                'difficulty' => 'hard',
                'score' => '30',
                'game_id' => '2',
                'time' => '400',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Which Marvel comics anti-hero got his own video game in 2013? ',
                'difficulty' => 'expert',
                'score' => '40',
                'game_id' => '3',
                'time' => '120',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => '"Prehistoric Party" was a 2013 video game adaptation of what movie?',
                'difficulty' => 'easy',
                'score' => '15',
                'game_id' => '4',
                'time' => '300',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => '"Hearthstone" was a 2014 card-collecting video game based on what franchise?',
                'difficulty' => 'expert',
                'score' => '15',
                'game_id' => '5',
                'time' => '120',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Arkham Origins Blackgate" was a 2014 video game starring which comic book character? ',
                'difficulty' => 'medium',
                'score' => '25',
                'game_id' => '6',
                'time' => '200',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Reaper of Souls\" was a 2014 expansion to what video game that\'s partially set in Hell? ',
                'difficulty' => 'easy',
                'score' => '35',
                'game_id' => '7',
                'time' => '150',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'The Stick of Truth" was a 2014 video game based on what Comedy Central TV show? ',
                'difficulty' => 'easy',
                'score' => '10',
                'game_id' => '8',
                'time' => '120',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Who was not a character in any Mario games? ',
                'difficulty' => 'expert',
                'score' => '5',
                'game_id' => '9',
                'time' => '60',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Which characters are two non-videogame "mascots" who have their own NES games? ',
                'difficulty' => 'hard',
                'score' => '20',
                'game_id' => '10',
                'time' => '60',
                'created_at' => Carbon::now(),
            ],

            [
                'title' => 'Which character is the mascot of Nintendo ?',
                'difficulty' => 'normal',
                'score' => '40',
                'game_id' => '1',
                'time' => '140',
                'created_at' => Carbon::now(),
            ],
        ];
        DB::table('questions')->insert($items);
    }
}
