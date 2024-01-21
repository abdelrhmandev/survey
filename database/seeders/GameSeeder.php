<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('games')->delete();
        ///// 1///////
        $items = [
            [
                'title' => 'Foot Ball',
                'slug' => 'foot-ball',
                'event_id'=>'10',
                'attendees' => '4',
                'type_id'=>'10',
                'play_with_team' => '1',
                'team_players'=>'5',
                'image' => 'uploads/games/1.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],
            ///// 2///////
            [
                'title' => 'Fortnite',
                'slug' => 'fortnite',
                'event_id'=>'1',
                'attendees' => '4',
                'type_id'=>'6',
                'play_with_team' => '1',
                'team_players'=>'1',
                'image' => 'uploads/games/2.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            ///// 3 ///////
            [
                'title' => 'Red Dead Redemption',
                'slug' => 'red-dead-redemption',
                'event_id'=>'2',
                'attendees' => '80',
                'type_id'=>'5',
                'play_with_team' => '1',
                'team_players'=>'3',
                'image' => 'uploads/games/3.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            ///////4/////
            [
                'title' => 'Baket Ball',
                'slug' => 'baket-ball',
                'event_id'=>'1',
                'attendees' => '4',
                'type_id'=>'3',
                'play_with_team' => '1',
                'team_players'=>'1',
                'image' => 'uploads/games/4.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            //////5//////
            [
                'title' => 'Overwatch',
                'slug' => 'overwatch',
                'event_id'=>'7',
                'attendees' => '23',
                'type_id'=>'6',
                'play_with_team' => '0',
                'team_players'=>NULL,
                'image' => 'uploads/games/5.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            ///////6/////
            [
                'title' => 'Metroid Prime',
                'slug' => 'metroid-prime',
                'event_id'=>'8',
                'attendees' => '17',
                'type_id'=>'8',
                'play_with_team' => '1',
                'team_players'=>'7',
                'image' => 'uploads/games/6.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            ///////7/////
            [
                'title' => 'Apex Legends',
                'slug' => 'apex-legends',
                'event_id'=>'4',
                'attendees' => '20',
                'type_id'=>'4',
                'play_with_team' => '0',
                'team_players'=>NULL,
                'image' => 'uploads/games/7.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            ///////8/////
            [
                'title' => 'Bio Shock',
                'slug' => 'bio-shock',
                'event_id'=>'1',
                'attendees' => '4',
                'type_id'=>'6',
                'play_with_team' => '1',
                'team_players'=>'1',
                'image' => 'uploads/games/8.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            //////9//////
            [
                'title' => 'Half Life 2',
                'slug' => 'half-ife-2',
                'event_id'=>'10',
                'attendees' => '150',
                'type_id'=>'9',
                'play_with_team' => '1',
                'team_players'=>'36',
                'image' => 'uploads/games/9.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            ///////10/////
            [
                'title' => 'Blackjack',
                'slug' => 'black-jack',
                'event_id'=>'4',
                'attendees' => '45',
                'type_id'=>'9',
                'play_with_team' => '1',
                'team_players'=>'180',
                'image' => 'uploads/games/10.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],
        ];
        DB::table('games')->insert($items);
    }
}
