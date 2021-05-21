<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class FakeUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(20)->create()->each(function ($user) {
            $roles = ['root' => 'root', 'administrator' => 'administrator', 'user' => 'user'];
            $user->assignRole(array_rand($roles));
        });
    }
}
