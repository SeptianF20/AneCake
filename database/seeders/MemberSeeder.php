<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $members = [
            [
                'nama' => 'Sipaul Jaya',
                'alamat' => 'Jl. Kenangan No. 1',
                'phone' => '08123456789',
                'email' => 'sipaul@email.com',
                'password' => Hash::make('password'),
                'password_lihat' => 'password', // ini asumsi saja, bisa disesuaikan dengan logika aplikasi Anda
            ],
            [
                'nama' => 'Firdaus Woko',
                'alamat' => 'Jl. Mantan No. 3',
                'phone' => '08123456789',
                'email' => 'firdaus@email.com',
                'password' => Hash::make('password'),
                'password_lihat' => 'password', // ini asumsi saja, bisa disesuaikan dengan logika aplikasi Anda
            ]

        ];

        foreach ($members as $userData) {
            Member::create($userData);
        };
    }
}
