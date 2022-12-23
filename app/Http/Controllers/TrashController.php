<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use App\Models\Gambar;
use Session;

class TrashController extends Controller
{
    public function trash()
    {
        $books = Book::onlyTrashed()->get();
        $gambars = Gambar::onlyTrashed()->get();
        $user = Auth::user();
        return view ('admin.trash', compact ('books', 'user', 'gambars'));
    }
    public function delete($id)
    {
        $data = strlen($id);
        if($data != 10){
            $gambar = Gambar::onlyTrashed()->find($id);
            Storage::delete('public/gambar_buku/'.$gambar->nama_file);
            $gambar->forceDelete();
            Session::flash('status', 'Data Berhasil Dihapus Permanen!!!');
            return redirect()->back();
        }else{
                $book = Book::onlyTrashed()->find($id);
                $gambar = Gambar::get();
                foreach($gambar as $value){
                    if($value['kode_buku'] == $id){
                        Storage::delete('public/gambar_buku/'.$value->nama_file);
                    }
                }
                $book->forceDelete();
                return redirect()->back();
            }
    }
    public function restore($id)
    {
        $data = strlen($id);
        if($data != 10){
            $gambar = Gambar::onlyTrashed()->find($id);
            $gambar->restore();
            Session::flash('status', 'Data Berhasil Dipulihkan!!!');
            return redirect()->back();
        }else{
                $book = Book::onlyTrashed()->find($id);
            }
            $book->restore();
            return redirect()->back();
        }
    public function restore_all()
    {
        $book = Book::onlyTrashed()->get();
        $gambar = Gambar::onlyTrashed()->get();
        foreach($gambar as $value){
            $value->restore();
        }
        foreach($book as $item){
            $item->restore(); 
        }
        Session::flash('status', 'Semua Data Berhasil Dipulihkan!!!');
        return redirect()->back();
    }
    public function delete_all()
    {
        $book = Book::onlyTrashed()->get();
        $gambar = Gambar::onlyTrashed()->get();
        foreach($gambar as $value){
            Storage::delete('public/gambar_buku/'.$value->nama_file);
            $value->forceDelete();
        }
        foreach($book as $item){   
            $item->forceDelete();
        }
        Session::flash('status', 'Semua Data Buku Berhasil Dihapus Permanen!!!');
        return redirect()->back();
    }
}