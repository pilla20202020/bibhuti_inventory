<?php

namespace Database\Seeders;

use App\Modules\Models\Role\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Role::create([
            'name'=>'SuperAdmin',
            'guard_name'=>'web',
        ]);


        for ($i = 1; $i < 20; $i++)

            DB::table('role_has_permissions')->insert([
                'permission_id'=>$i,
                'role_id'=>'1',
            ]);
        }
}
