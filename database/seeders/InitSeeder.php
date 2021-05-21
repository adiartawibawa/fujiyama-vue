<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('cache:clear');
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permission Seeder
        Permission::create(['name' => 'manage-user']);

        // Role Seeder
        $role = Role::create([
            'name' => 'root',
        ]);
        $role->givePermissionTo('manage-user');

        // User Seed
        $user = User::create([
            'name' => 'Adi Arta Wibawa',
            'email' => 'surat.buat.adi@gmail.com',
            'password' => Hash::make('madhava11')
        ]);

        $user->assignRole('root');
        // $user->givePermissionTo('manage-user');
    }
}
