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
use Illuminate\Support\Str;
use App\Models\Gambar;

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
        $books = Book::orderBy('judul', 'asc')->get();
        $kategori = KategoriBook::all();
        $gambar = Gambar::all();
        return view('admin.book', compact('user', 'books', 'kategori', 'gambar'));
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
        $kategori = $request->get('kategori_buku');
        $kode = 'bk-'. $kategori .'-'. Str::random(5);
        $judul = $request->get('judul');
        $book->kode_buku = $kode;
        $book->judul = $judul;
        $book->penulis = $request->get('penulis');
        $book->id_kategori = $kategori;
        $book->tahun = $request->get('tahun');
        $book->penerbit = $request->get('penerbit');
        $data = $request->file('cover');
        $book->save();
        if ($request->hasFile('cover')) {
            foreach ($data as $value => $cover) {
                $extension = $cover->extension();
                $filename = 'gambar_'.$judul.'_'.time().'_'.$value.'.'.$extension;
                $cover->storeAs(
                    'public/gambar_buku',$filename
                );
                $gambar = new Gambar;
                $gambar->kode_buku = $kode;
                $gambar->nama_file = $filename;
                $gambar->save();
            }
        }
                Session::flash('status', 'Data Buku Berhasil Ditambahkan!!!');
        return redirect()->back();
    }

    public function getDataBuku($id)
    {
        $buku = Book::find($id);
        return $buku->toJson();
        // return response()->json($buku);
    }
    public function gambar()
    {
        $gambar = Gambar::get();
        return response()->json($gambar);
    }
    public function hapus_gambar($id)
    {
        $gambar = Gambar::find($id);
        $gambar->delete();
        return response()->json($gambar);
    }
    public function update_book(Request $request)
    {
        $kode = $request->get('id');
        $book = Book::find($kode);

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
        $book->save();
        $data = $request->file('gambar');
        if ($request->hasFile('gambar')) {
            foreach ($data as $value => $gambar) {
                $extension = $gambar->extension();
                $filename = 'gambar_'.$judul.'_'.time().'_'.$value.'.'.$extension;
                $gambar->storeAs(
                    'public/gambar_buku',$filename
                );
                DB::table('gambars')->insert([
                    'kode_buku' => $kode,
                    'nama_file' => $filename

                ]);
            }
        }
        $book->save();
        Session::flash('status', 'Data Buku Berhasil Diupdate!!!');
        return redirect()->back();

    }

    public function delete_book($id)
    {
        $book = Book::find($id);
        $gambar = Gambar::onlyTrashed()->get();
        foreach($gambar as $value){
            if($value['kode_buku'] == $id){
                DB::table('gambars')->where('kode_buku', $id)->update([
                    'deleted_at' => NULL
                ]);
            }
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

}