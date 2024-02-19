<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class GameQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('game_question')->delete();

        $items = [
            [
                'game_id' => '1',
                'question_id' => '1',
            ],
            [
                'game_id' => '2',
                'question_id' => '8',
            ],
            [
                'game_id' => '3',
                'question_id' => '11',
            ],
            [
                'game_id' => '4',
                'question_id' => '5',
            ],
            [
                'game_id' => '5',
                'question_id' => '1',
            ],
            [
                'game_id' => '6',
                'question_id' => '10',
            ],
            [
                'game_id' => '7',
                'question_id' => '4',
            ],
            [
                'game_id' => '8',
                'question_id' => '3',
            ],
            [
                'game_id' => '9',
                'question_id' => '3',
            ],
            [
                'game_id' => '10',
                'question_id' => '2',
            ],

            [
                'game_id' => '11',
                'question_id' => '1',
            ],
        ];
        DB::table('game_question')->insert($items);
    }
}
