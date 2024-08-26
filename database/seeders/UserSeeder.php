<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\userDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'super@admin.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'user_type' => 'super_admin',
        ]);

        userDetail::create([
            'user_id' => $user->id,
            'title' => 'Super',
            'last_name' => 'Admin',
            'image' => 'placeholder.jpg',
        ]);
    }
}
