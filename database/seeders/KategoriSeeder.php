<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['Novel','Ensiklopedia','Biografi ','Pengembangan Diri',
        'Autobiografi','Karya Ilmiah','Komik','Kamus'];
        foreach($data as $value){
           DB::table('kategori_books')->insert([
            'nama_kategori' => $value
           ]); 
        }
    }
}
