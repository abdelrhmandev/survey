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
                'is_correct_answer' => '1',
            ],
            [
                'title' => 'Zelda',
                'question_id' => '1',
                'is_correct_answer' => '0',
            ],
            [
                'title' => 'Samus',
                'question_id' => '1',
                'is_correct_answer' => '0',
            ],
            [
                'title' => 'Captain Falcon',
                'question_id' => '1',
                'is_correct_answer' => '0',
            ],
            /////////////////////////For Q 2 ///////////////////////////////////////////////
            [
                'title' => 'Master of Magic',
                'question_id' => '2',
                'is_correct_answer' => '0',
            ],
            [
                'title' => 'Alpha Centauri',
                'question_id' => '2',
                'is_correct_answer' => '0',
            ],
            [
                'title' => 'Supreme Commander',
                'question_id' => '2',
                'is_correct_answer' => '0',
            ],
            [
                'title' => 'Civilization',
                'question_id' => '2',
                'is_correct_answer' => '1',
            ],
            /////////////////////////For Q 3 ///////////////////////////////////////////////
            [
                'title' => 'Lobo',
                'question_id' => '3',
                'is_correct_answer' => '0',
            ],
            [
                'title' => 'Punisher',
                'question_id' => '3',
                'is_correct_answer' => '0',
            ],
            [
                'title' => 'Deadpool',
                'question_id' => '3',
                'is_correct_answer' => '1',
            ],
            [
                'title' => 'Deathstroke',
                'question_id' => '3',
                'is_correct_answer' => '1',
            ],
            /////////////////////////For Q 4 ///////////////////////////////////////////////            
            [
                'title' => 'Finding Nemo',
                'question_id' => '4',
                'is_correct_answer' => '0',
            ],
            [
                'title' => 'The Croods',
                'question_id' => '4',
                'is_correct_answer' => '1',
            ],
            [
                'title' => 'Flushed Away',
                'question_id' => '4',
                'is_correct_answer' => '0',
            ],
            [
                'title' => 'Up',
                'question_id' => '4',
                'is_correct_answer' => '0',
            ],
            /////////////////////////For Q 5 ///////////////////////////////////////////////            
            [
                'title' => 'Final Fantasy',
                'question_id' => '5',
                'is_correct_answer' => '0',
            ],
            [
                'title' => 'Super Mario Brothers',
                'question_id' => '5',
                'is_correct_answer' => '0',
            ],
            [
                'title' => 'Warcraft',
                'question_id' => '5',
                'is_correct_answer' => '1',
            ],
            [
                'title' => 'Crash Bandicoot',
                'question_id' => '5',
                'is_correct_answer' => '0',
            ],
            /////////////////////////For Q 6 ///////////////////////////////////////////////
            [
                'title' => 'The Flash',
                'question_id' => '6',
                'is_correct_answer' => '0',
            ],
            [
                'title' => 'Green Lantern',
                'question_id' => '6',
                'is_correct_answer' => '0',
            ],
            [
                'title' => 'Batman',
                'question_id' => '6',
                'is_correct_answer' => '1',
            ],
            [
                'title' => 'Aquaman',
                'question_id' => '6',
                'is_correct_answer' => '0',
            ],
            /////////////////////////For Q 7 ///////////////////////////////////////////////
            [
                'title' => 'Diablo III',
                'question_id' => '7',
                'is_correct_answer' => '1',
            ],
            [
                'title' => 'Mephisto III',
                'question_id' => '7',
                'is_correct_answer' => '0',
            ],
            [
                'title' => 'Baal III',
                'question_id' => '7',
                'is_correct_answer' => '0',
            ],
            [
                'title' => 'Lucifer III',
                'question_id' => '7',
                'is_correct_answer' => '0',
            ],
            /////////////////////////For Q 8 ///////////////////////////////////////////////
            [
                'title' => 'Drawn Together',
                'question_id' => '8',
                'is_correct_answer' => '0',
            ],
            [
                'title' => 'South Park',
                'question_id' => '8',
                'is_correct_answer' => '1',
            ],
            [
                'title' => 'The Daily Show',
                'question_id' => '8',
                'is_correct_answer' => '0',
            ],
            [
                'title' => 'Freak Show',
                'question_id' => '8',
                'is_correct_answer' => '0',
            ],
            /////////////////////////For Q 9 ///////////////////////////////////////////////
            [
                'title' => 'Hammer Brothers',
                'question_id' => '9',
                'is_correct_answer' => '0',
            ],
            [
                'title' => 'Triclyde',
                'question_id' => '9',
                'is_correct_answer' => '0',
            ],
            [
                'title' => 'Freak Wart',
                'question_id' => '9',
                'is_correct_answer' => '0',
            ],
            [
                'title' => 'Dodonga',
                'question_id' => '9',
                'is_correct_answer' => '1',
            ],
            /////////////////////////For Q 10 ///////////////////////////////////////////////
            [
                'title' => 'Dominos Noid And 7 Ups Spot',
                'question_id' => '10',
                'is_correct_answer' => '1',
            ],
            [
                'title' => 'DodoScrubby Bubbles And Chester Cheetahnga',
                'question_id' => '10',
                'is_correct_answer' => '1',
            ],
            [
                'title' => 'Little Caesar And Slim Jim',
                'question_id' => '10',
                'is_correct_answer' => '1',
            ],
            [
                'title' => 'Willy Wonka And The Dots',
                'question_id' => '10',
                'is_correct_answer' => '1',
            ],
        ];
        DB::table('choices')->insert($items);
    }
}
