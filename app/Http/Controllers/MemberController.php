<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Member;
use App\Models\Book;

class MemberController extends Controller
{
    public function book()
    {
        $buku = Book::pluck('tipe_buku')->all();
        return view('member.book', compact('buku'));
    }
    public function create(Request $request)
    {
        $validate = $request->validate([

            "nama" => "required|max:50",
            "tempat_lahir" => "required|max:30",
            "tanggal_lahir" => "required",
            "jk" => "required",
            "no_telp" => "required",
            "alamat" => "required",
            "kode_pos" => "required|max:5",
        ]);

        $member = new Member;
        $id = Auth::user()->id;
        $nama = $request->nama;

        $member->no_reg = rand(0000000000, 9999999999);
        $member->nama = $nama;
        $member->tempat_lahir = $request->tempat_lahir;
        $member->tanggal_lahir = $request->tanggal_lahir;
        $member->jenis_kelamin = $request->jk;
        $member->no_telp = $request->no_telp;
        $member->alamat = $request->alamat;
        $member->kode_pos = $request->kode_pos;
        $member->user_id = $id;

        if ($request->hasFile('kyc')) {
            $ext = $request->file('kyc')->extension();
            $foto = 'foto_kyc' . $nama . '_' . $user . '_' . time() . '.' . $ext;

            $request->file('kyc')->storeAs(
                'public/kyc',
                $foto
            );
            $member->foto = $foto;
        }
        $member->save();

        Session::flash('status', 'Data Buku Berhasil Diupdate!!!');
        return redirect()->back();
    }

}
