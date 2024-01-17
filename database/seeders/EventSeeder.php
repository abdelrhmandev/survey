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
        $items = [
            ['title'=>'Downtown Contemporary Art Festival','slug'=>'downtown-contemporary-art-festival','start_date'=>Carbon::parse('2024-01-11'),'end_date'=>Carbon::parse('2024-02-25'),'logo'=>'uploads/events/1.jpg','created_at'=>Carbon::now()],
            ['title'=>'Panorama Of the European-film','slug'=>'panorama-of-the-european-film','start_date'=>Carbon::parse('2024-02-19'),'end_date'=>Carbon::parse('2024-02-21'),'logo'=>'uploads/events/2.jpg','created_at'=>Carbon::now()],
            ['title'=>'Cairo Bites','slug'=>'cairo-bites','start_date'=>Carbon::parse('2024-03-18'),'end_date'=>Carbon::parse('2024-02-15'),'logo'=>'uploads/events/3.jpg','created_at'=>Carbon::now()],
        ];
        DB::table('events')->insert($items);






    }
}
