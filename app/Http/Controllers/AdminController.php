<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Book;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BooksExport;
use App\Imports\BooksImport;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        return view('home', compact('user'));
    }
    
    public function books()
    {
        $user = Auth::user();
        $books = Book::all();
        return view('admin.book', compact('user', 'books'));
    }

    public function submit_book(Request $request)
    {
        $validate = $request->validate([
            'judul' => 'required|max:255',
            'penulis' => 'required',
            'tipe_buku' => 'required',
            'tahun' => 'required',
            'penerbit' => 'required',
            'cover' => 'image|file|max:2048'
        ]);

        $book = new Book;
        $book->judul = $request->get('judul');
        $book->penulis = $request->get('penulis');
        $book->tipe_buku = $request->get('tipe_buku');
        $book->tahun = $request->get('tahun');
        $book->penerbit = $request->get('penerbit');
        
        if ($request->hasFile('cover'))
            {
                $extension = $request->file('cover')->extension();
                $filename = 'cover_buku_'.time().'.'.$extension;
                $request->file('cover')->storeAs(
                    'public/cover_buku', $filename
                );
                $book->cover = $filename;
            }
        $book->save();
        Session::flash('status', 'Data Buku Berhasil Ditambahkan!!!');
        return redirect()->back();
    }

    public function getDataBuku($id)
    {
        
        $buku = Book::find($id);

        return response()->json($buku);
    }

    public function update_book(Request $request)
    {
        $book = Book::find($request->get('id'));

        $validate = $request->validate([
            'judul' => 'required|max:255',
            'penulis' => 'required',
            'tahun' => 'required',
            'tipe_buku' => 'required',
            'penerbit' => 'required',
        ]);

        $book->judul = $request->get('judul');
        $book->penulis = $request->get('penulis');
        $book->tipe_buku = $request->get('tipe_buku');
        $book->tahun = $request->get('tahun');
        $book->penerbit = $request->get('penerbit');
        
        if ($request->hasFile('cover'))
            {
                $extension = $request->file('cover')->extension();
                $filename = 'cover_buku_'.time().'.'.$extension;
                $request->file('cover')->storeAs(
                    'public/cover_buku', $filename
                );

                Storage::delete('public/cover_buku/'.$request->get('old_cover'));

                $book->cover = $filename;
            }

        Session::flash('status', 'Data Buku Berhasil Diupdate!!!');
        $book->save();
        return redirect()->back();

    }

    public function delete_book($id)
    {
        $book = Book::find($id);
        Storage::move('public/cover_buku/'.$book->cover, 'public/recycle/'.$book->cover);
        $book->delete();

        return response()->json($book);
    }

    public function print_books()
    {
        $books = Book::all();
        $pdf = PDF::loadview('print_books',['books'=> $books]);
        return $pdf->download('data_buku.pdf');
    }

    public function export()
    {
        return Excel::download(new BooksExport, 'books.xlsx');
    }

    public function import(Request $request)
    {
        Excel::import(new BooksImport, $request->file('file'));

        return redirect()->route('admin.books');
    }

    public function trash()
    {
        $books = Book::onlyTrashed()->get();
        $user = Auth::user();
        return view ('trash', compact ('books', 'user'));
    }
    public function delete_force($id)
    {
        $book = Book::onlyTrashed()->find($id);
        Storage::delete('public/recycle/'.$book->cover);
        $book->forceDelete();
        Session::flash('status', 'Data Buku Berhasil Dihapus Permanen!!!');
        return redirect()->back();
    }
    public function restore($id)
    {
        $book = Book::onlyTrashed()->find($id);
        Storage::move('public/recycle/'.$book->cover, 'public/cover_buku/'.$book->cover);
        $book->restore();
        Session::flash('status', 'Data Buku Berhasil Dikembalikan!!!');
        return redirect()->back();
    }
    public function restoreAll()
    {
        $book = Book::onlyTrashed()->get();
        foreach($book as $item){
            Storage::move('public/recycle/'.$item->cover, 'public/cover_buku/'.$item->cover);
            $item->restore(); 
        }
        Session::flash('status', 'Semua Data Buku Berhasil Dipulihkan!!!');
        return redirect()->back();
    }
    public function deleteAll()
    {
        $book = Book::onlyTrashed()->get();
        foreach($book as $item){   
            Storage::delete('public/recycle/'.$item->cover);
            $item->forceDelete();
        }
        Session::flash('status', 'Semua Data Buku Berhasil Dihapus Permanen!!!');
        return redirect()->back();
    }
}


