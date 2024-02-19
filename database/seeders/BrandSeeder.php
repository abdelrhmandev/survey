<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->delete();

        $items = [
            ['title' => 'Anoro', 'created_at' => Carbon::now()],
            ['title' => 'Augmentin', 'created_at' => Carbon::now()],
            ['title' => 'Avamys', 'created_at' => Carbon::now()],
            ['title' => 'Benlysta', 'created_at' => Carbon::now()],
            ['title' => 'Bexsero', 'created_at' => Carbon::now()],
            ['title' => 'Boostrix', 'created_at' => Carbon::now()],
            ['title' => 'Cervarix', 'created_at' => Carbon::now()],
            ['title' => 'Dovato', 'created_at' => Carbon::now()],
            ['title' => 'Duodart', 'created_at' => Carbon::now()],
            ['title' => 'Keppra', 'created_at' => Carbon::now()],
            ['title' => 'Lamictal', 'created_at' => Carbon::now()],
            ['title' => 'Nucala', 'created_at' => Carbon::now()],
            ['title' => 'Relvar', 'created_at' => Carbon::now()],
            ['title' => 'Rotarix', 'created_at' => Carbon::now()],
            ['title' => 'Seroxat', 'created_at' => Carbon::now()],
            ['title' => 'Shingrix', 'created_at' => Carbon::now()],
            ['title' => 'Trelegy', 'created_at' => Carbon::now()],
            ['title' => 'Triumeq', 'created_at' => Carbon::now()],
            ['title' => 'Xyzal', 'created_at' => Carbon::now()],
        ];
        DB::table('brands')->insert($items);
    }
}
