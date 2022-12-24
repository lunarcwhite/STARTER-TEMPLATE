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
use App\Models\Member;

class ManageMemberController extends Controller
{
    public function index()
    {
        $member = Member::where('status', '=', '1')->get();
        return view('admin.member',compact ('member'));
    }
    public function nonaktif(Request $request)
    {
        $id = $request->no_reg;
        DB::table('members')->where('no_reg', $id)->update([
            'status' => 0,
        ]);
        return redirect()->back();
    }
}
