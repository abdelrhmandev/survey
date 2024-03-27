<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->delete();

        $items = [
            ['title' => 'Group A', 'brand_id'=>'1','created_at' => Carbon::now()],
            ['title' => 'Group B', 'brand_id'=>'2','created_at' => Carbon::now()],
            ['title' => 'Group C', 'brand_id'=>'3','created_at' => Carbon::now()],
            ['title' => 'Group D', 'brand_id'=>'4','created_at' => Carbon::now()],
            ['title' => 'Group F', 'brand_id'=>'5','created_at' => Carbon::now()],
            ['title' => 'Group G', 'brand_id'=>'6','created_at' => Carbon::now()], 
        ];
        DB::table('groups')->insert($items);
    }
}
