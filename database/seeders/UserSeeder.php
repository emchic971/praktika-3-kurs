<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['login' => 'isivanov', 'last_name' => 'Иванов', 'first_name' => 'Иван', 'middle_name' => 'Сергеевич', 'role' => 'admin'],
            ['login' => 'papetrov', 'last_name' => 'Петров', 'first_name' => 'Петр', 'middle_name' => 'Алексеевич', 'role' => 'manager'],
            ['login' => 'asidorova', 'last_name' => 'Сидорова', 'first_name' => 'Анна', 'middle_name' => 'Дмитриевна', 'role' => 'user'],
            ['login' => 'ekuznetsova', 'last_name' => 'Кузнецова', 'first_name' => 'Екатерина', 'middle_name' => 'Андреевна', 'role' => 'manager'],
            ['login' => 'dsmirnov', 'last_name' => 'Смирнов', 'first_name' => 'Дмитрий', 'middle_name' => 'Владимирович', 'role' => 'user'],
            ['login' => 'apopov', 'last_name' => 'Попов', 'first_name' => 'Алексей', 'middle_name' => 'Николаевич', 'role' => 'admin'],
            ['login' => 'ovasileva', 'last_name' => 'Васильева', 'first_name' => 'Ольга', 'middle_name' => 'Игоревна', 'role' => 'user'],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['login' => $userData['login']],
                [
                    'last_name' => $userData['last_name'],
                    'first_name' => $userData['first_name'],
                    'middle_name' => $userData['middle_name'],
                    'email' => $userData['login'] . '@example.com',
                    'password' => Hash::make('password'), // Пароль для всех: password
                ]
            );
            $user->assignRole($userData['role']);
        }
    }
}