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
use App\Models\User;

class ManageUserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return view('admin.manage-user', compact('user'));
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        Session::flash('status', 'Data User Berhasil Dihapus!!!');
        return redirect()->back();
    }
}
