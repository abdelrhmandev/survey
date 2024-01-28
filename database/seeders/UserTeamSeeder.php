<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UserTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_team')->delete();

        $items = [
            [
                'user_id' => '1',
                'team_id'=>'2',
            ],[
                'user_id' => '1',
                'team_id'=>'4',
            ],[
                'user_id' => '1',
                'team_id'=>'5',
            ],[
                'user_id' => '1',
                'team_id'=>'8',
            ],
        ////////////////////        
        [
            'user_id' => '2',
            'team_id'=>'5',
        ],[
            'user_id' => '2',
            'team_id'=>'6',
        ],[
            'user_id' => '2',
            'team_id'=>'7',
        ],[
            'user_id' => '2',
            'team_id'=>'10',
        ],
        ////////////////////        
        [
            'user_id' => '3',
            'team_id'=>'2',
        ],[
            'user_id' => '3',
            'team_id'=>'4',
        ],[
            'user_id' => '4',
            'team_id'=>'6',
        ],[
            'user_id' => '4',
            'team_id'=>'7',
        ],

            
        ];
        DB::table('user_team')->insert($items);
    }
}
