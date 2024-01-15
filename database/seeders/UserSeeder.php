<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::table('users')->delete();

          \App\Models\User::create([     
                'username'         =>'admin',
                'password'         =>Hash::make('12345678'),
                'email'            =>'abdelrahman@domain.com',
                'name'             =>'Abdelrahman Magdy',
                'is_admin'         =>'1',
                'mobile'           =>'01872971280',
                'avatar'           =>'uploads/avatars/admin.jpg',
                'country_id'       =>'64',
                'status'           =>'1',
            ])->assignRole(1);

            \App\Models\User::create([    
                'username'         =>'Mab',
                'password'         =>Hash::make('12345678'),
                'email'            =>'Mab@domain.com',
                'name'             =>'Mab Bok',
                'is_admin'         =>'1',
                'mobile'           =>'01872971227',
                'status'           =>'1',
                'country_id'       =>'44',
            ])->assignRole(2);

            
            \App\Models\User::create([    
                'username'         =>'emad',
                'password'         =>Hash::make('12345678'),
                'email'            =>'emad@domain.com',
                'name'             =>'Emad Bishay',
                'is_admin'         =>'1',
                'mobile'           =>'01872971220',
                'avatar'           =>'uploads/avatars/emad.jpg',
                'status'           =>'1',
                'country_id'       =>'64',
            ])->assignRole(1);

            \App\Models\User::create([    
                'username'         =>'DanWilson',
                'password'         =>Hash::make('12345678'),
                'email'            =>'DanWilson@domain.com',
                'name'             =>'Dan Wilson',
                'is_admin'         =>'1',
                'status'           =>'1',
                'country_id'       =>'10',
                'mobile'           =>'0187297444',
                'avatar'           =>'uploads/avatars/danWilson.jpg',
            ])->assignRole(2);

            \App\Models\User::create([    
                'username'         =>'FrancisMitcham',
                'password'         =>Hash::make('12345678'),
                'email'            =>'FrancisMitcham@domain.com',
                'name'             =>'Francis Mitcham',
                'is_admin'         =>'1',
                'mobile'           =>'01872971230',
                'status'           =>'1',
                'country_id'       =>'22',
                'mobile'           =>'07872971280',
                'avatar'           =>'uploads/avatars/francismitcham.jpg',
            ])->assignRole(3);

 
            \App\Models\User::create([    
                'username'         =>'Katia Nol',
                'password'         =>Hash::make('12345678'),
                'email'            =>'Katia@domain.com',
                'name'             =>'Katia Nol',
                'is_admin'         =>'1',
                'mobile'           =>'01872971230',
                'status'           =>'1',
                'country_id'       =>'50',
                'mobile'           =>'0787297127',
            ])->assignRole(3);

 

            
 

 

 


    }
}
