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

        $teams = array(
			array('title' => 'Sales'),
			array('title' => 'Marketing'),
			array('title' => 'Customer Service'),
			array('title' => 'HR'),
			array('title' => 'Support'),
		);

       DB::table('teams')->insert($teams);   
    }
}
