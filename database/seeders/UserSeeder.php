<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'id' => 1
        ], [
            'id' => 1,
            'type' => User::ADMIN_TYPE,
            'last_name' => '管理者',
            'first_name' => 'テスト',
            'last_name_kana' => 'テスト',
            'first_name_kana' => 'テスト',
            'email' => 'admin@mail.com',
            'password' =>  Hash::make('Admin2024@'),
            'status' => User::STATUS_ACTIVE,
        ]);

        User::updateOrCreate([
            'id' => 2
        ], [
            'id' => 2,
            'type' => User::USER_TYPE,
            'last_name' => 'ユーザー',
            'first_name' => 'テスト',
            'last_name_kana' => 'テスト',
            'first_name_kana' => 'テスト',
            'email' => 'user@mail.com',
            'password' =>  Hash::make('User2024@'),
            'status' => User::STATUS_ACTIVE,
        ]);
    }
}
