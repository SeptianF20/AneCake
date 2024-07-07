<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_categories')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Kue Basah',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_categories')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Kue Kering',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_categories')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Kripik',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_categories')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Cake',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_categories')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Roti Besar',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
