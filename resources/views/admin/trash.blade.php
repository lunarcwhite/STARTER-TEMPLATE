@extends('adminlte::page')
@section('title', 'Home Page')
@section('content_header')
<h1>Data Buku</h1>
@stop
@section('content')
<div class="container-fluid" id="page">
    <div class="card card-default">
        <div class="card-header" id="page-buku">{{__('Pengelolaan Buku')}}</div>
        <div class="card-body">
            <div class="btn btn-group">
                <form id="form-restore-all" action="trash/restore/all/data" method="post">
                    @csrf
                    <button type="button" id="btn-restore-all" class="btn btn-primary">
                        Restore Semua Data Recycle Bin <i class="fa fa-plus"></i>
                    </button>
                </form>
                <form id="form-delete-all" action="trash/delete/all/data" method="post">
                    @csrf
                    @method('delete')
                    <button id="btn-delete-all" class="btn btn-danger" type="submit">Kosongkan Recycle Bin <i
                            class="fa fa-recycle"></i> </button>
                </form>
            </div>
            <hr />
            <div class="table-responsive">
                <table id="table-data" class="table table-hover">
                    <thead>
                        <tr class="text-center">
                            <th>NO</th>
                            <th>Item</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $p = 1;
                        @endphp
                        @foreach ($books as $book)
                        <tr id="table-row{{$book->id}}" class="text-center">
                            <td>{{$p++}}</td>
                            <td>{{$book->judul}}</td>
                            <td><button type="button" id="btn-gambar-buku" class="btn btn-primary" data-toggle="modal"
                                    data-target="#gambarBuku" data-id="{{ $book->kode_buku }}">Lihat</button></td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <form id="restore" action="trash/restore/{{$book->kode_buku}}" method="post">
                                        @csrf
                                        <button type="button" id="btn-restore" class="btn btn-success">Kembalikan
                                            Data</button>
                                    </form>
                                    <form id="delete" action="trash/delete/{{$book->kode_buku}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="button" id="btn-delete" class="btn btn-danger">Hapus
                                            Permanen</button>
                                    </form>
                                </div>

                            </td>
                        </tr>
                        @endforeach
                        @foreach ($gambars as $data => $gambar)
                        <tr id="table-row{{$gambar->id}}" class="text-center">
                            <td>{{$data+$p}}</td>
                            <td><img src="/storage/gambar_buku/{{$gambar->nama_file}}" class="img-fluid" width="200px"
                                    height="200px" /></td>
                            <td>Gambar</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <form id="restore" action="trash/restore/{{$gambar->id}}" method="post">
                                        @csrf
                                        <button type="button" id="btn-restore" class="btn btn-success">Kembalikan
                                            Data</button>
                                    </form>
                                    <form id="delete" action="trash/delete/{{$gambar->id}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="button" id="btn-delete" class="btn btn-danger">Hapus
                                            Permanen</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="gambarBuku" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Gambar Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="form-group" id="gambar">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script>
    $(function () {
        $(document).on('click', '#btn-gambar-buku', function () {
            let id = $(this).data('id');
            $('#gambar').empty();
            $.ajax({
                type: "get",
                url: "{{ url('/admin/gambar') }}",
                dataType: 'json',
                success: function (res) {
                    res.forEach(x => {
                        if (x.kode_buku == id) {
                            $('#gambar').append(
                                `<br/>
                            <img src="{{asset('storage/gambar_buku/` + x.nama_file + `')}}" class="img-fluid" width="100%" height="50%"/>
                            <br/>
                            `
                            );
                        }
                    });
                },
            });
        });
    });
</script>
<script>
    $(function () {
        $(document).on('click', '#btn-delete', function () {
            var form = event.target.form;
            Swal.fire({
                title: 'Apa kamu yakin?',
                text: "Kamu tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })

        });
        $(document).on('click', '#btn-restore-all', function () {
            var x = $('#form-restore-all');
            event.preventDefault();
            Swal.fire({
                title: 'Apa kamu yakin?',
                text: "Ingin Mengembalikan Semua Data Yang Ada Di Recycle Bin?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Kembalikan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    x.submit();
                }
            })

        });
        $(document).on('click', '#btn-restore', function () {
            var form = event.target.form;
            Swal.fire({
                title: 'Apa kamu yakin?',
                text: "Ingin Mengembalikan Data Buku Ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Kembalikan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })

        });
        $(document).on('click', '#btn-delete-all', function () {
            event.preventDefault();
            Swal.fire({
                title: 'Apa kamu yakin?',
                html: "Ingin Mengosongkan Recycle Bin? <br> <strong>Data Tidak Dapat Dikembalikan!</strong>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-delete-all').submit();
                }
            })

        });
    });
</script>
@stop