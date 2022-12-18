<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\KategoriBook;
use Faker\Factory as Faker;
class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for($i=0; $i < 50; $i++){
            $kategori = KategoriBook::inRandomOrder()->first();
            DB::table('books')->insert([
                'judul' => $faker->name,
                'penulis' => $faker->name,
                'penerbit' => $faker->randomElement(['Nuova Mustofa', 'Cahaya Utama', 'Mizan', 'Gramedia']),
                'tahun' => 2022,
                'id_kategori' => $kategori->id,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }
    }
}
