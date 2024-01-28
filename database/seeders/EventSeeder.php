<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->delete();
        ///// 1///////
        $items = [
            [
                'title' => 'Downtown Contemporary Art Festival',
                'slug' => 'downtown-contemporary-art-festival',
                'start_date' => Carbon::parse('2024-02-18'),
                'end_date' => Carbon::parse('2024-02-25'),
                'image' => 'uploads/events/1.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],
            ///// 2///////
            [
                'title' => 'Cairo Bites',
                'slug' => 'cairo-bites',
                'start_date' => Carbon::parse('2024-02-28'),
                'end_date' => Carbon::parse('2024-03-25'),
                'image' => 'uploads/events/2.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            ///// 3 ///////
            [
                'title' => 'Cairo Food',
                'slug' => 'cairo-food',
                'start_date' => Carbon::parse('2024-01-24'),
                'end_date' => Carbon::parse('2024-01-27'),
                'image' => 'uploads/events/3.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            ///////4/////
            [
                'title' => 'Man Show',
                'slug' => 'man-show',
                'start_date' => Carbon::parse('2024-01-28'),
                'end_date' => Carbon::parse('2024-02-25'),
                'image' => 'uploads/events/4.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            //////5//////
            [
                'title' => 'HR Summit',
                'slug' => 'hr-summit',
                'start_date' => Carbon::parse('2024-01-16'),
                'end_date' => Carbon::parse('2024-01-25'),
                'image' => 'uploads/events/5.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            ///////6/////
            [
                'title' => 'Alex Development',
                'slug' => 'alex-development',
                'start_date' => Carbon::parse('2024-01-20'),
                'end_date' => Carbon::parse('2024-02-25'),
                'image' => 'uploads/events/6.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            ///////7/////
            [
                'title' => 'Radio Ceremony',
                'slug' => 'radio-ceremony',
                'start_date' => Carbon::parse('2024-06-18'),
                'end_date' => Carbon::parse('2024-06-25'),
                'image' => 'uploads/events/7.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            ///////8/////
            [
                'title' => 'Development Day',
                'slug' => 'development-day',
                'start_date' => Carbon::parse('2024-08-28'),
                'end_date' => Carbon::parse('2024-09-15'),
                'image' => 'uploads/events/8.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            //////9//////
            [
                'title' => 'Fashion Day',
                'slug' => 'fashion-day',
                'start_date' => Carbon::parse('2024-01-14'),
                'end_date' => Carbon::parse('2024-01-27'),
                'image' => 'uploads/events/9.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],

            ///////10/////
            [
                'title' => 'MicroSoft',
                'slug' => 'microsoft',
                'start_date' => Carbon::parse('2024-01-23'),
                'end_date' => Carbon::parse('2024-03-19'),
                'image' => 'uploads/events/10.jpg',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => Carbon::now(),
            ],
        ];
        DB::table('events')->insert($items);
    }
}
