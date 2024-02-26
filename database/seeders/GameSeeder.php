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
                'title' => 'Nintendo',
                'slug' => 'nintendo',
                'event_title' => 'Downtown Contemporary Art Festival',
                'event_start_date' => Carbon::parse('2024-02-18'),
                'event_end_date' => Carbon::parse('2024-02-25'),
                'event_location' => 'Abha, Saudi Arabia',
                'attendees' => '4',
                'type_id' => '10',
                'brand_id' =>'1',
                'play_with_team' => '1',
                'team_players' => '5',
                'image' => 'uploads/games/1.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],
            ///// 2///////
            [
                'title' => 'Brave New World',
                'slug' => 'brave-new-world',
                'event_title' => 'Cairo Bites',
                'event_start_date' => Carbon::parse('2024-02-28'),
                'event_end_date' => Carbon::parse('2024-03-25'),
                'event_location' => 'Giza , 6 October',
                'attendees' => '4',
                'type_id' => '6',
                'brand_id' =>'2',
                'play_with_team' => '1',
                'team_players' => '1',
                'image' => 'uploads/games/2.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            ///// 3 ///////
            [
                'title' => 'Marvel comics anti-hero',
                'slug' => 'marvel-comics-anti-hero',
                'event_title' => 'Cairo Food',
                'event_start_date' => Carbon::parse('2024-01-24'),
                'event_end_date' => Carbon::parse('2024-01-27'),
                'event_location' => 'Aswan',
                'attendees' => '80',
                'type_id' => '5',
                'brand_id' =>'3',
                'play_with_team' => '1',
                'team_players' => '3',
                'image' => 'uploads/games/3.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            ///////4/////
            [
                'title' => 'Prehistoric Party',
                'slug' => 'prehistoric-party',
                'event_title' => 'Man Show',
                'event_start_date' => Carbon::parse('2024-01-28'),
                'event_end_date' => Carbon::parse('2024-02-25'),
                'event_location' => 'Alex',
                'attendees' => '4',
                'type_id' => '3',
                'brand_id' =>'4',
                'play_with_team' => '1',
                'team_players' => '1',
                'image' => 'uploads/games/4.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            //////5//////
            [
                'title' => 'Hearthstone',
                'slug' => 'hearthstone',
                'event_title' => 'HR Summit',
                'event_start_date' => Carbon::parse('2024-01-16'),
                'event_end_date' => Carbon::parse('2024-01-25'),
                'event_location' => 'Nasr City',
                'attendees' => '23',
                'type_id' => '6',
                'brand_id' =>'5',
                'play_with_team' => '0',
                'team_players' => null,
                'image' => 'uploads/games/5.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            ///////6/////
            [
                'title' => 'Arkham Origins Blackgate',
                'slug' => 'arkham-origins-blackgate',
                'event_title' => 'Alex Development',
                'event_start_date' => Carbon::parse('2024-01-20'),
                'event_end_date' => Carbon::parse('2024-02-25'),
                'event_location' => 'New Cairo',
                'attendees' => '17',
                'type_id' => '8',
                'brand_id' =>'6',
                'play_with_team' => '1',
                'team_players' => '7',
                'image' => 'uploads/games/6.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            ///////7/////
            [
                'title' => 'Reaper of Souls',
                'slug' => 'reaper-of-souls',
                'event_title' => 'Radio Ceremony',
                'event_start_date' => Carbon::parse('2024-06-18'),
                'event_end_date' => Carbon::parse('2024-06-25'),
                'event_location' => 'USA',
                'attendees' => '20',
                'type_id' => '4',
                'brand_id' =>'7',
                'play_with_team' => '0',
                'team_players' => null,
                'image' => 'uploads/games/7.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            ///////8/////
            [
                'title' => 'Stick of Truth',
                'slug' => 'stick-of-truth',
                'event_title' => 'Development Day',
                'event_start_date' => Carbon::parse('2024-08-28'),
                'event_end_date' => Carbon::parse('2024-09-15'),
                'event_location' => 'Riyadh, Saudi Arabia',
                'attendees' => '4',
                'type_id' => '6',
                'brand_id' =>'8',
                'play_with_team' => '1',
                'team_players' => '1',
                'image' => 'uploads/games/8.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            //////9//////
            [
                'title' => 'Mario',
                'slug' => 'mario',
                'event_title' => 'Fashion Day',
                'event_start_date' => Carbon::parse('2024-01-14'),
                'event_end_date' => Carbon::parse('2024-01-27'),
                'event_location' => 'Riyadh, Saudi Arabia',
                'attendees' => '150',
                'type_id' => '9',
                'brand_id' =>'9',
                'play_with_team' => '1',
                'team_players' => '36',
                'image' => 'uploads/games/9.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            ///////10/////
            [
                'title' => 'Mascots',
                'slug' => 'mascots',
                'event_title' => 'MicroSoft',
                'event_start_date' => Carbon::parse('2024-01-23'),
                'event_end_date' => Carbon::parse('2024-03-19'),
                'event_location' => 'Riyadh, Saudi Arabia',
                'attendees' => '45',
                'type_id' => '9',
                'brand_id' =>'10',
                'play_with_team' => '1',
                'team_players' => '180',
                'image' => 'uploads/games/10.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            ///////11/////
            [
                'title' => 'FIFA 24',
                'slug' => 'fifa-24',
                'event_title' => 'Go GameFun',
                'event_start_date' => Carbon::parse('2024-01-23'),
                'event_end_date' => Carbon::parse('2024-03-19'),
                'event_location' => 'Riyadh, Saudi Arabia',
                'attendees' => '15',
                'type_id' => '4',
                'brand_id' =>'4',
                'play_with_team' => '1',
                'team_players' => '180',
                'image' => null,
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],
           
            ///////12/////
            [
                'title' => 'Mortal Kombat',
                'slug' => 'mortal-kombat',
                'event_title' => 'Health Care',
                'event_start_date' => Carbon::parse('2024-01-23'),
                'event_end_date' => Carbon::parse('2024-03-19'),
                'event_location' => 'Riyadh, Saudi Arabia',
                'attendees' => '35',
                'type_id' => '5',
                'brand_id' => '1',
                'play_with_team' => '0',
                'team_players' => null,
                'image' => null,
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],
        ];
        DB::table('games')->insert($items);
    }
}
