<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class QuestionCorrectAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('question_correct_answer')->delete();

        $items = [
            [
                'question_id' => '1',
                'correct_answer_id' => '1',
            ],
            [
                'question_id' => '2',
                'correct_answer_id' => '8',
            ],
            [
                'question_id' => '3',
                'correct_answer_id' => '11',
            ],
            [
                'question_id' => '4',
                'correct_answer_id' => '14',
            ],
            [
                'question_id' => '5',
                'correct_answer_id' => '19',
            ],
            [
                'question_id' => '6',
                'correct_answer_id' => '23',
            ],
            [
                'question_id' => '7',
                'correct_answer_id' => '25',
            ],
            [
                'question_id' => '8',
                'correct_answer_id' => '30',
            ],
            [
                'question_id' => '9',
                'correct_answer_id' => '36',
            ],
            [
                'question_id' => '10',
                'correct_answer_id' => '37',
            ],

            [
                'question_id' => '11',
                'correct_answer_id' => '41',
            ],
        ];
        DB::table('question_correct_answer')->insert($items);
    }
}
