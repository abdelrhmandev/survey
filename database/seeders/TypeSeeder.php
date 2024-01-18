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
            ['title'=>'Adventure','slug'=>'adventure','description'=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry','image' => 'uploads/types/adventure.jpg','created_at' => Carbon::now()],
            ['title'=>'Puzzle','slug'=>'puzzle','description'=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry','image' => 'uploads/types/puzzle.jpg','created_at' => Carbon::now()],
            ['title'=>'Multiplayer battle arenas','slug'=>'multiplayer-battle-arenas','description'=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry','image' => 'uploads/types/multiplayer-battle-arenas.png','created_at' => Carbon::now()],
            ['title'=>'Fighting','slug'=>'fighting','description'=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry','image' => 'uploads/types/fighting.jpg','created_at' => Carbon::now()],
            ['title'=>'Racing','slug'=>'racing','description'=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry','image' => 'uploads/types/racing.jpg','created_at' => Carbon::now()],
            ['title'=>'MMORPG','slug'=>'mmorpg','description'=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry','image' => 'uploads/types/mmorpg.jpg','created_at' => Carbon::now()],
            ['title'=>'Survival horror','slug'=>'survival-horror','description'=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry','image' => 'uploads/types/survival-horror.jpg','created_at' => Carbon::now()],
            ['title'=>'Stealth','slug'=>'stealth','description'=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry','image' => 'uploads/types/stealth.jpg','created_at' => Carbon::now()],
            ['title'=>'Platformer','slug'=>'platformer','description'=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry','image' => 'uploads/types/platformer.jpg','created_at' => Carbon::now()],
            ['title'=>'RPG','slug'=>'rpg','description'=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry','image' => 'uploads/types/rpg.jpg','created_at' => Carbon::now()],
        ];
        DB::table('types')->insert($items);






    }
}
