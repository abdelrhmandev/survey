<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->delete();
        $items = [
            ['title'=>'Knowledge Hub','slug'=>'knowledge-hub','description'=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry','image' => 'uploads/types/adventure.jpg','created_at' => Carbon::now()],
            ['title'=>'knowledge Wheel','slug'=>'knowledge-wheel','description'=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry','image' => 'uploads/types/puzzle.jpg','created_at' => Carbon::now()],
            ['title'=>'Treasure Hunt','slug'=>'treasure-hunt','description'=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry','image' => 'uploads/types/rpg.jpg','created_at' => Carbon::now()],
        ];
        DB::table('types')->insert($items);






    }
}
