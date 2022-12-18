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
use App\Models\KategoriBook;
use Illuminate\Support\Facades\DB;

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
    public function hapus_gambar(Request $request)
    {
        $id = $request->id;
        $book = Book::find($id);
        $value = $book['cover'];
        $gambar = $request->gambar;
        $data = explode("," , $value);
        array_pop($data);
        $z = null;
            foreach ($data as $p) {
                if ($p != $gambar) {
            $z .= $p .= ',';
                } else {
                    Storage::delete('public/gambar_buku/'.$p);
            }
                }
        Session::flash('status', 'Gambar Berhasil Dihapus!!!');
        DB::table('books')->where('id', $id)->update(['cover' => $z]);
        return redirect()->back();  
    }
    
    public function books()
    {
        $user = Auth::user();
        $books = Book::all();
        $kategori = KategoriBook::all();
        return view('admin.book', compact('user', 'books', 'kategori'));
    }

    public function submit_book(Request $request)
    {
        $validate = $request->validate([
            'judul' => 'required|max:255',
            'penulis' => 'required',
            'kategori_buku' => 'required',
            'tahun' => 'required',
            'penerbit' => 'required',
            'cover[]' => 'image|max:2048'
        ]);

        $book = new Book;
        $judul = $request->get('judul');
        $book->judul = $judul;
        $book->penulis = $request->get('penulis');
        $book->id_kategori = $request->get('kategori_buku');
        $book->tahun = $request->get('tahun');
        $book->penerbit = $request->get('penerbit');
        $data = $request->file('cover');
        $z = '';
        foreach($data as $value => $cover){
                $extension = $cover->extension();
                $filename = 'gambar_'.$judul.time().'.'.$value.'.'.$extension;
                $cover->storeAs(
                    'public/gambar_buku',$filename
                    );
                    $z .= $filename .= ',';
                }
                $book->cover = $z;
                Session::flash('status', 'Data Buku Berhasil Ditambahkan!!!');
                $book->save();
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
            'penerbit' => 'required',
        ]);

        $judul = $request->get('judul');
        $book->judul = $judul;
        $book->penulis = $request->get('penulis');
        $book->id_kategori = $request->get('kategori_buku');
        $book->tahun = $request->get('tahun');
        $book->penerbit = $request->get('penerbit');

        Session::flash('status', 'Data Buku Berhasil Diupdate!!!');
        $book->save();
        return redirect()->back();

    }

    public function delete_book($id)
    {
        $book = Book::find($id);
        if (empty($book->cover) == false) {
        Storage::move('public/gambar_buku/'.$book->cover, 'public/recycle/'.$book->cover);
        }
        $book->delete();
        Session::flash('status', 'Data Buku Berhasil Dihapus!!!');
        return redirect()->back();
    }

    public function print_books()
    {
        $books = Book::all();
        $pdf = PDF::loadview('admin.print_books',['books'=> $books]);
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
        return view ('admin.trash', compact ('books', 'user'));
    }
    public function delete_force($id)
    {
        $book = Book::onlyTrashed()->find($id);
if (empty($book->cover) == false) {
    Storage::delete('public/recycle/'.$book->cover);
}
        $book->forceDelete();
        Session::flash('status', 'Data Buku Berhasil Dihapus Permanen!!!');
        return redirect()->back();
    }
    public function restore($id)
    {
        $book = Book::onlyTrashed()->find($id);
if (empty($book->cover) == false) {
    Storage::move('public/recycle/'.$book->cover, 'public/gambar_buku/'.$book->cover);
}
        $book->restore();
        Session::flash('status', 'Data Buku Berhasil Dipulihkan!!!');
        return redirect()->back();
    }
    public function restoreAll()
    {
        $book = Book::onlyTrashed()->get();
        foreach($book as $item){
if (empty($book->cover) == false) {
    Storage::move('public/recycle/'.$item->cover, 'public/gambar_buku/'.$item->cover);
}
            $item->restore(); 
        }
        Session::flash('status', 'Semua Data Buku Berhasil Dipulihkan!!!');
        return redirect()->back();
    }
    public function deleteAll()
    {
        $book = Book::onlyTrashed()->get();
        foreach($book as $item){   
if (empty($book->cover) == false) {
    Storage::delete('public/recycle/'.$item->cover);
}
            $item->forceDelete();
        }
        Session::flash('status', 'Semua Data Buku Berhasil Dihapus Permanen!!!');
        return redirect()->back();
    }
}