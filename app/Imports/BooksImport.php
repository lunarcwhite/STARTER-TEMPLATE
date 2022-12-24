<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class BooksImport implements WithHeadingRow,ToModel 
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Book([
            'kode_buku' => $kode = 'bk-'. $row['kategori'] .'-'. Str::random(5),
            'judul' => $row['judul'],
            'penulis' => $row['penulis'],
            'tahun' => $row['tahun'],
            'id_kategori' => $row['kategori'],
            'penerbit' => $row['penerbit'],
        ]);
    }
}
