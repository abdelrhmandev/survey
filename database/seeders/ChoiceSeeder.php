<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ChoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('choices')->delete();

        $items = [
            /////////////////////////For Q 1 ///////////////////////////////////////////////
            [
                'title' => 'Mario',
                'question_id' => '1',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Zelda',
                'question_id' => '1',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Samus',
                'question_id' => '1',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Captain Falcon',
                'question_id' => '1',
                'created_at' => Carbon::now(),
            ],
            /////////////////////////For Q 2 ///////////////////////////////////////////////
            [
                'title' => 'Master of Magic',
                'question_id' => '2',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Alpha Centauri',
                'question_id' => '2',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Supreme Commander',
                'question_id' => '2',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Civilization',
                'question_id' => '2',
                'created_at' => Carbon::now(),
                
            ],
            /////////////////////////For Q 3 ///////////////////////////////////////////////
            [
                'title' => 'Lobo',
                'question_id' => '3',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Punisher',
                'question_id' => '3',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Deadpool',
                'question_id' => '3',
                'created_at' => Carbon::now(),
                
            ],
            [
                'title' => 'Deathstroke',
                'question_id' => '3',
                'created_at' => Carbon::now(),
            ],
            /////////////////////////For Q 4 ///////////////////////////////////////////////
            [
                'title' => 'Finding Nemo',
                'question_id' => '4',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'The Croods',
                'question_id' => '4',
                'created_at' => Carbon::now(),
                
            ],
            [
                'title' => 'Flushed Away',
                'question_id' => '4',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Up',
                'question_id' => '4',
                'created_at' => Carbon::now(),
            ],
            /////////////////////////For Q 5 ///////////////////////////////////////////////
            [
                'title' => 'Final Fantasy',
                'question_id' => '5',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Super Mario Brothers',
                'question_id' => '5',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Warcraft',
                'question_id' => '5',
                'created_at' => Carbon::now(),
                
            ],
            [
                'title' => 'Crash Bandicoot',
                'question_id' => '5',
                'created_at' => Carbon::now(),
            ],
            /////////////////////////For Q 6 ///////////////////////////////////////////////
            [
                'title' => 'The Flash',
                'question_id' => '6',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Green Lantern',
                'question_id' => '6',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Batman',
                'question_id' => '6',
                'created_at' => Carbon::now(),
                
            ],
            [
                'title' => 'Aquaman',
                'question_id' => '6',
                'created_at' => Carbon::now(),
            ],
            /////////////////////////For Q 7 ///////////////////////////////////////////////
            [
                'title' => 'Diablo III',
                'question_id' => '7',
                'created_at' => Carbon::now(),
                
            ],
            [
                'title' => 'Mephisto III',
                'question_id' => '7',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Baal III',
                'question_id' => '7',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Lucifer III',
                'question_id' => '7',
                'created_at' => Carbon::now(),
            ],
            /////////////////////////For Q 8 ///////////////////////////////////////////////
            [
                'title' => 'Drawn Together',
                'question_id' => '8',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'South Park',
                'question_id' => '8',
                'created_at' => Carbon::now(),
                
            ],
            [
                'title' => 'The Daily Show',
                'question_id' => '8',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Freak Show',
                'question_id' => '8',
                'created_at' => Carbon::now(),
            ],
            /////////////////////////For Q 9 ///////////////////////////////////////////////
            [
                'title' => 'Hammer Brothers',
                'question_id' => '9',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Triclyde',
                'question_id' => '9',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Freak Wart',
                'question_id' => '9',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Dodonga',
                'question_id' => '9',
                'created_at' => Carbon::now(),
                
            ],
            /////////////////////////For Q 10 ///////////////////////////////////////////////
            [
                'title' => 'Dominos Noid And 7 Ups Spot',
                'question_id' => '10',
                'created_at' => Carbon::now(),
                
            ],
            [
                'title' => 'DodoScrubby Bubbles And Chester Cheetahnga',
                'question_id' => '10',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Little Caesar And Slim Jim',
                'question_id' => '10',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Willy Wonka And The Dots',
                'question_id' => '10',
                'created_at' => Carbon::now(),
            ],

            /////////////////////////For Q 11 ///////////////////////////////////////////////
            [
                'title' => 'Mario',
                'question_id' => '11',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'DodoScrubby',
                'question_id' => '11',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Little Caesar',
                'question_id' => '11',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Lion King',
                'question_id' => '11',
                'created_at' => Carbon::now(),
            ],
        ];
        DB::table('choices')->insert($items);
    }
}
