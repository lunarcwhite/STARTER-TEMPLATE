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
use App\Models\Peminjaman;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::all();
        return view('admin.peminjaman',compact ('peminjaman'));
    }
    public function aktifkan(Request $request)
    {
        $id = $request->no_reg;
        DB::table('members')->where('no_reg', $id)->update([
            'status' => 1,
        ]);
        return redirect()->back();
    }
}
