<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teams')->delete();
        $items = [
            ['title'=>'Marketing'],
            ['title'=>'Coordinator'],
            ['title'=>'Customer Service'],
            ['title'=>'HR'],
            ['title'=>'Support'],
            ['title'=>'Sales Manager'],
            ['title'=>'Executive'],
            ['title'=>'Supervisor'],
            ['title'=>'System Analyst'],
            ['title'=>'Business Analyst'],
        ];
        DB::table('teams')->insert($items);






    }
}
