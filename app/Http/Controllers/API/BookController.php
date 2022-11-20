<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Exception;
use Illuminate\Support\Facades\Storage;

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
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'penulis' => 'required',
            'tahun' => 'required',
            'penerbit' => 'required',
            'cover' => 'image|file|max:4084'
        ]);

        if ($request->hasFile('cover'))
        {
            $extension = $request->file('cover')->extension();
            $filename = 'cover_buku_'.time().'.'.$extension;
            $request->file('cover')->storeAs(
                'public/cover_buku', $filename
            );
            $validated['cover'] = $filename;
        }

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
            'cover' => 'image|file|max:2048'
        ]);

        if ($request->hasFile('cover'))
        {
            $extension = $request->file('cover')->extension();
            $filename = 'cover_buku_'.time().'.'.$extension;
            $request->file('cover')->storeAs(
                'public/cover_buku', $filename
            );
            $validated['cover'] = $filename;
        }

        $book = Book::find($id);
        Storage::delete('public/cover_buku/' . $book->cover);
        $book->update($validated);

        return response()->json([
            'message' => 'Buku berhasil diubah',
            'book' => $book,
        ], 200);
    }

    public function delete($id)
    {
        $book = Book::find($id);

        Storage::delete('public/cover_buku/' . $book->cover);

        $book->delete();

        return response()->json([
            'message' => 'Buku berhasil dihapus'
        ], 200);
    }
}
