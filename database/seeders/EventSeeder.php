<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
            ['title'=>'Downtown Contemporary Art Festival','start_date'=>'15-1-2024','end_date'=>'25-1-2024','logo'=>NULL],
            ['title'=>'Cairo Jazz Festival','start_date'=>'20-1-2024','end_date'=>'25-1-2024',,'logo'=>NULL],
            ['title'=>'Panorama Of the European Film','start_date'=>'22-1-2024','end_date'=>'19-2-2024',,'logo'=>NULL],
            ['title'=>'Cairo Bites','start_date'=>'10-2-2024','end_date'=>'18-2-2024',,'logo'=>NULL],
            ['title'=>'Egypt Fitness Fest','start_date'=>'12-2-2024','end_date'=>'18-2-2024',,'logo'=>NULL],
            ['title'=>'Cairo Fashion Festival','start_date'=>'18-2-2024','end_date'=>'24-2-2024',,'logo'=>NULL],
            ['title'=>'Hakawy International Festival For Children','start_date'=>'23-2-2024','end_date'=>'1-3-2024',,'logo'=>NULL],
            ['title'=>'El Gouna Film Festival','start_date'=>'14-2-2024','end_date'=>'16-3-2024',,'logo'=>NULL],
            ['title'=>'Kala Brunch at Four Seasons Hotel Alexandria','start_date'=>'15-3-2024','end_date'=>'25-3-2024',,'logo'=>NULL],
            ['title'=>'Strawberry Extravaganza at Grand Nile Tower’s ','start_date'=>'27-3-2024','end_date'=>'29-3-2024',,'logo'=>NULL],
        ];
        DB::table('events')->insert($items);






    }
}
