<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class BookController extends Controller
{
    public function books()
    {
        try 
        {
            $books = Book::all();

            return response()->json([
                'message' => 'success',
                'books' => $books,
            ], 200);
        } catch (Exception $e)
            {
                return response()->json([
                    'message' => 'Request Failed'
                ], 401);
            }
    }

    public function create(Request $request)
    {
        $kode = 'bk-'. $kategori .'-'. Str::random(5);
        $validated = $request->validate([
            'kode_buku' => $kode,
            'judul' => 'required|max:255',
            'penulis' => 'required',
            'tahun' => 'required',
            'penerbit' => 'required',
            'id_kategori' => 'required'
        ]);

        Book::create($validated);

        return response()->json([
            'message' => 'Buku berhasil ditambahkan',
            'book' => $validated,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'penulis' => 'required',
            'tahun' => 'required',
            'penerbit' => 'required',
            'id_kategori' => 'required'
        ]);

        $book = Book::find($id);
        $book->update($validated);

        return response()->json([
            'message' => 'Buku berhasil diubah',
            'book' => $book,
        ], 200);
    }

    public function delete($id)
    {
        $book = Book::find($id);

        $book->delete();

        return response()->json([
            'message' => 'Buku berhasil dihapus'
        ], 200);
    }
}
