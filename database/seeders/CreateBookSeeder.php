<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as faker;

class CreateBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for($i = 0; $i <= 35; $i++){
            DB::table('books')->insert([
                'judul' => $faker->name, 
                'penulis' => $faker->name,
                'tahun' => 2022,
                'penerbit' => 'Gramedia',
                'cover' => '[Gambar tidak tersedia]',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }
    }
}
