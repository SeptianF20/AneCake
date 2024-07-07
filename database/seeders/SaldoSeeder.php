<?php

namespace Database\Seeders;

use App\Models\Saldo;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SaldoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $saldos = [
            [
                'member_id' => '2448375a-c8b4-4861-b321-1da47028179d',
                'saldo' => '20000',
            ],
            [
                'member_id' => 'e4c2248c-7e98-46f8-a2b2-86be95a01829',
                'saldo' => '30000',
            ],
        ];

        foreach ($saldos as $userData) {
            Saldo::create($userData);
        };
    }
}
