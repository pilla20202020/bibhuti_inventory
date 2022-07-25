<?php

namespace Database\Seeders;

use App\Modules\Models\Branch\Branch;
use App\Modules\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $user=User::create([
            'name'=>'SuperAdmin',
            'email'=>'admin@customer.com',
            'password'=>Hash::make('admin@customer'),
            'status' => 'active',
        ]);
        $user->assignRole('SuperAdmin');
    }
}
