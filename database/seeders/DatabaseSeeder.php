<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::create([
        'name' => 'Kepala Sekolah',
        'email' => 'kepsek@gmail.com',
        'password' => Hash::make('12345678'),
        'role' => 'kepsek'
    ]);

    User::create([
        'name' => 'Bendahara',
        'email' => 'bendahara@gmail.com',
        'password' => Hash::make('12345678'),
        'role' => 'bendahara'
    ]);

    User::create([
        'name' => 'Civitas',
        'email' => 'civitas@gmail.com',
        'password' => Hash::make('12345678'),
        'role' => 'civitas'
    ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
