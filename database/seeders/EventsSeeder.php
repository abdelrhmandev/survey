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
            ['title'=>'Marketing','start_date'=>'','end_date'=>''],
            // ['title'=>'Coordinator'],
            // ['title'=>'Customer Service'],
            // ['title'=>'HR'],
            // ['title'=>'Support'],
            // ['title'=>'Sales Manager'],
            // ['title'=>'Executive'],
            // ['title'=>'Supervisor'],
            // ['title'=>'System Analyst'],
            // ['title'=>'Business Analyst'],
        ];
        DB::table('events')->insert($items);






    }
}
