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

        \App\Models\Team::create([     
            'title'         =>'Marketing',
        ]);
        \App\Models\Team::create([     
            'title'         =>'Coordinator',
        ]);
        \App\Models\Team::create([     
            'title'         =>'Customer Service',
        ]);
        \App\Models\Team::create([     
            'title'         =>'HR',
        ]);
        \App\Models\Team::create([     
            'title'         =>'Support',
        ]);
        \App\Models\Team::create([     
            'title'         =>'Sales Manager',
        ]);
        \App\Models\Team::create([     
            'title'         =>'Executive',
        ]);
        \App\Models\Team::create([     
            'title'         =>'Supervisor',
        ]);
        \App\Models\Team::create([     
            'title'         =>'System Analyst',
        ]);
        \App\Models\Team::create([     
            'title'         =>'Business Analyst',
        ]);



    }
}
