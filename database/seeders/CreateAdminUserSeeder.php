<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('roles')->delete();

        $user = User::create([
            'name' => 'abdou', 
            'email' => 'abdousalahgad@yahoo.com',
            'password' => bcrypt('123456'),
            'roles_name' => ["owner"],
            'Status' => 'مفعل',
            ]);
            $role = Role::create(['name' => 'owner']);
            $permissions = Permission::pluck('id','id')->all();
            $role->syncPermissions($permissions);
            $user->assignRole([$role->id]);
    }
}
