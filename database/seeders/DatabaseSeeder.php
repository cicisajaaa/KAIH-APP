<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kaih.app'],
            [
                'name' => 'Admin KAIH',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'orangtua@kaih.app'],
            [
                'name' => 'Orang Tua KAIH',
                'role' => 'orang_tua',
                'password' => Hash::make('orangtua123'),
            ]
        );
    }
}
