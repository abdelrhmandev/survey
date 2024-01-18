<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
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
            ['title' => 'Marketing', 'slug' => 'marketing', 'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 'created_at' => Carbon::now()],
            ['title' => 'Coordinator', 'slug' => 'coordinator', 'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 'created_at' => Carbon::now()],
            ['title' => 'Customer Service', 'slug' => 'customer-service', 'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 'created_at' => Carbon::now()],
            ['title' => 'HR', 'slug' => 'hr', 'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 'created_at' => Carbon::now()],
            ['title' => 'Support', 'slug' => 'support', 'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 'created_at' => Carbon::now()],
            ['title' => 'Sales Manager', 'slug' => 'sales-manager', 'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 'created_at' => Carbon::now()],
            ['title' => 'Executive', 'slug' => 'executive', 'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 'created_at' => Carbon::now()],
            ['title' => 'Supervisor', 'slug' => 'supervisor', 'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 'created_at' => Carbon::now()],
            ['title' => 'System Analyst', 'slug' => 'system-analyst', 'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 'created_at' => Carbon::now()],
            ['title' => 'Business Analyst', 'slug' => 'business-analyst', 'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 'created_at' => Carbon::now()],
        ];
        DB::table('teams')->insert($items);
    }
}
