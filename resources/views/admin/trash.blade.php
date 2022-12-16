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
            <form id="form-restore-all" action="restore/all" method="post">
            @csrf
            </form>
            <form id="form-delete-all" action="delete/all" method="post">
                @csrf
            </form>
                <button type="button" id="btn-restore-all" class="btn btn-primary">
                    Restore Semua Data Recycle Bin <i class="fa fa-plus"></i> 
                </button>
            <button id="btn-delete-all" class="btn btn-danger" type="submit">Kosongkan Recycle Bin <i class="fa fa-recycle"></i> </button>
            <hr/> 
            <table id="table-data" class="table table-borderer">
                <thead>
                    <tr class="text-center">
                        <th>NO</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Tahun</th>
                        <th>Penerbit</th>
                        <th>Cover</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($books as $item => $book)
                        <tr id="table-row{{$book->id}}">
                            <td>{{$item+1}}</td>
                            <td>{{$book->judul}}</td>
                            <td>{{$book->penulis}}</td>
                            <td>{{$book->tahun}}</td>
                            <td>{{$book->penerbit}}</td>
                            <td>
                                @if ($book->cover !== null)
                                    <img src="{{asset('storage/recycle/'.$book->cover)}}" width="100px"/>
                                @else
                                [Gambar tidak tersedia]
                                @endif    
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" id="btn-restore-buku" class="btn btn-success">Kembalikan Buku</button>
                                    
                                    <button type="button" id="btn-force-buku" class="btn btn-danger">Hapus Permanen</button>
                                </div>    
                                <form id="delete" action="books/empty/{{$book->id}}" method="post">
                                        @csrf
                                        @method('delete')
                                </form>
                                <form id="restore" action="books/restore/{{$book->id}}" method="post">
                                    @csrf
                                </form>    
                            </td>    
                        </tr>                        
                    @empty
                        <h4>Data Kosong</h4>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop
@section('js')
<script>
$(function(){
            $(document).on('click', '#btn-force-buku', function(){
                event.preventDefault(); 
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
                                document.getElementById('delete').submit();
                            }
                        })

              });
              $(document).on('click', '#btn-restore-all', function(){
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
              $(document).on('click', '#btn-restore-buku', function(){
                var x = $('#restore');
                event.preventDefault(); 
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
                                x.submit();
                            }
                        })

              });
              $(document).on('click', '#btn-delete-all', function(){
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



