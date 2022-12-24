@extends('adminlte::page')
@section('title', 'Home Page')
@section('content_header')
<h1>Data Peminjaman</h1>
@stop
@section('content')
<div class="container-fluid" id="page">
    <div class="card card-default">
        <div class="card-header" id="page-buku">{{__('Pengelolaan Peminjaman')}}</div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-data" class="table table-hover">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Peminjam</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Lama Peminjaman</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman as $no => $value )
                        <tr class="text-center">
                            <td>{{$no+1}}</td>
                            <td>{{$value->nama}}</td>
                            <td>{{$value->judul}}</td>
                            <td>{{$value->tanggal_peminjaman}}</td>
                            <td>{{$value->lama_peminjaman}}</td>
                            <td>{{$value->status}}</td>
                            <td>
                                <form action="aktifasi/akun" method="post">
                                    @csrf
                                    @method('patch')
                                    <input type="hidden" name="no_reg" value="{{$value->no_reg}}">
                                    <button type="button" onclick="aktifasiMember({{$value->no_reg}})" 
                                        class="btn btn-warning">Aktifkan</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
function aktifasiMember(id){
            var form = event.target.form;
            Swal.fire({
                title: 'Apa kamu yakin?',
                text: "Kamu Akan Mengaktifasi Akun "+id,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, aktifkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                }
            })
        }
</script>
@stop