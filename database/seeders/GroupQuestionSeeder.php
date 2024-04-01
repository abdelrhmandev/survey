<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class GroupQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('group_question')->delete();

        $items = [
            ['group_id' => '1', 'question_id'=>'2','order'=>NULL],
            ['group_id' => '1', 'question_id'=>'4','order'=>NULL],


            ['group_id' => '2', 'question_id'=>'1','order'=>NULL],
            ['group_id' => '2', 'question_id'=>'3','order'=>NULL],

            
            ['group_id' => '10', 'question_id'=>'10','order'=>NULL],
            ['group_id' => '1', 'question_id'=>'1','order'=>NULL],
            ['group_id' => '9', 'question_id'=>'10','order'=>NULL],
           

            
            ['group_id' => '7', 'question_id'=>'7','order'=>NULL],
            ['group_id' => '7', 'question_id'=>'8','order'=>NULL],
            ['group_id' => '6', 'question_id'=>'19','order'=>NULL],

            ['group_id' => '5', 'question_id'=>'15','order'=>NULL],
            ['group_id' => '4', 'question_id'=>'14','order'=>NULL],

            ['group_id' => '3', 'question_id'=>'1','order'=>NULL],
            ['group_id' => '3', 'question_id'=>'3','order'=>NULL],


        ];
        DB::table('group_question')->insert($items);
    }
}
