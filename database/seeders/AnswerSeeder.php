<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('answers')->delete();

        $items = [
            /////////////////////////For Q 1 ///////////////////////////////////////////////
            [
                'title' => 'Mario',
                'question_id' => '1',
            ],
            [
                'title' => 'Zelda',
                'question_id' => '1',
            ],
            [
                'title' => 'Samus',
                'question_id' => '1',
            ],
            [
                'title' => 'Captain Falcon',
                'question_id' => '1',
            ],
            /////////////////////////For Q 2 ///////////////////////////////////////////////
            [
                'title' => 'Master of Magic',
                'question_id' => '2',
            ],
            [
                'title' => 'Alpha Centauri',
                'question_id' => '2',
            ],
            [
                'title' => 'Supreme Commander',
                'question_id' => '2',
            ],
            [
                'title' => 'Civilization',
                'question_id' => '2',
            ],
            /////////////////////////For Q 3 ///////////////////////////////////////////////
            [
                'title' => 'Lobo',
                'question_id' => '3',
            ],
            [
                'title' => 'Punisher',
                'question_id' => '3',
            ],
            [
                'title' => 'Deadpool',
                'question_id' => '3',
            ],
            [
                'title' => 'Deathstroke',
                'question_id' => '3',
            ],
            /////////////////////////For Q 4 ///////////////////////////////////////////////
            [
                'title' => 'Finding Nemo',
                'question_id' => '4',
            ],
            [
                'title' => 'The Croods',
                'question_id' => '4',
            ],
            [
                'title' => 'Flushed Away',
                'question_id' => '4',
            ],
            [
                'title' => 'Up',
                'question_id' => '4',
            ],
            /////////////////////////For Q 5 ///////////////////////////////////////////////
            [
                'title' => 'Final Fantasy',
                'question_id' => '5',
            ],
            [
                'title' => 'Super Mario Brothers',
                'question_id' => '5',
            ],
            [
                'title' => 'Warcraft',
                'question_id' => '5',
            ],
            [
                'title' => 'Crash Bandicoot',
                'question_id' => '5',
            ],
            /////////////////////////For Q 6 ///////////////////////////////////////////////
            [
                'title' => 'The Flash',
                'question_id' => '6',
            ],
            [
                'title' => 'Green Lantern',
                'question_id' => '6',
            ],
            [
                'title' => 'Batman',
                'question_id' => '6',
            ],
            [
                'title' => 'Aquaman',
                'question_id' => '6',
            ],
            /////////////////////////For Q 7 ///////////////////////////////////////////////
            [
                'title' => 'Diablo III',
                'question_id' => '7',
            ],
            [
                'title' => 'Mephisto III',
                'question_id' => '7',
            ],
            [
                'title' => 'Baal III',
                'question_id' => '7',
            ],
            [
                'title' => 'Lucifer III',
                'question_id' => '7',
            ],
            /////////////////////////For Q 8 ///////////////////////////////////////////////
            [
                'title' => 'Drawn Together',
                'question_id' => '8',
            ],
            [
                'title' => 'South Park',
                'question_id' => '8',
            ],
            [
                'title' => 'The Daily Show',
                'question_id' => '8',
            ],
            [
                'title' => 'Freak Show',
                'question_id' => '8',
            ],
            /////////////////////////For Q 9 ///////////////////////////////////////////////
            [
                'title' => 'Hammer Brothers',
                'question_id' => '9',
            ],
            [
                'title' => 'Triclyde',
                'question_id' => '9',
            ],
            [
                'title' => 'Freak Wart',
                'question_id' => '9',
            ],
            [
                'title' => 'Dodonga',
                'question_id' => '9',
            ],
            /////////////////////////For Q 10 ///////////////////////////////////////////////
            [
                'title' => 'Dominos Noid And 7 Ups Spot',
                'question_id' => '10',
            ],
            [
                'title' => 'DodoScrubby Bubbles And Chester Cheetahnga',
                'question_id' => '10',
            ],
            [
                'title' => 'Little Caesar And Slim Jim',
                'question_id' => '10',
            ],
            [
                'title' => 'Willy Wonka And The Dots',
                'question_id' => '10',
            ],

            /////////////////////////For Q 11 ///////////////////////////////////////////////
            [
                'title' => 'Mario',
                'question_id' => '11',
            ],
            [
                'title' => 'DodoScrubby',
                'question_id' => '11',
            ],
            [
                'title' => 'Little Caesar',
                'question_id' => '11',
            ],
            [
                'title' => 'Lion King',
                'question_id' => '11',
            ],
        ];
        DB::table('answers')->insert($items);
    }
}
