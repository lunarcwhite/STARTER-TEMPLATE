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
            <button class="btn btn-primary" data-toggle="modal" data-target="#tambahBukuModal">
                Tambah Data <i class="fa fa-plus"></i> 
            </button>
            <a href="{{ route('admin.print.books') }}" target="_blank" class="btn btn-secondary">
                <i class="fa fa-print"></i> Cetak PDF</a>
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
                                    <img src="{{asset('storage/cover_buku/'.$book->cover)}}" width="100px"/>
                                @else
                                [Gambar tidak tersedia]
                                @endif    
                            </td>
                            <td>
                                <form action="books/empty/{{$book->id}}" method="post">
                                    @csrf
                                    @method('delete')
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" id="btn-edit-buku" class="btn btn-success"
                                    data-toggle="modal" data-target="#editBukuModal" data-id="{{ $book->id }}">Edit</button>

                                    <button type="submit" id="btn-force-buku" class="btn btn-danger" data-id="{{$book->id}}" value="{{$book->id}}">Hapus</button>
                                </form>   
                                </div>    
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
{{-- <script>
    $(function(){
            $(document).on('click','#btn-edit-buku', function(){
                let id = $(this).data('id');

                $('#image-area').empty();

                $.ajax({
                    type: "get",
                    url: "{{url('/admin/ajaxadmin/dataBuku')}}/"+id,
                    dataType: 'json',
                    success: function(res){
                        $('#edit-judul').val(res.judul);
                        $('#edit-penerbit').val(res.penerbit);
                        $('#edit-penulis').val(res.penulis);
                        $('#edit-tahun').val(res.tahun);
                        $('#edit-id').val(res.id);
                        $('#edit-old-cover').val(res.cover);
                        
                        if (res.cover !== null) {
                            $('#image-area').append(
                                "<img src='"+baseurl+"/storage/cover_buku/"+res.cover+"' width='200px'/>"
                                );
                            } else {
                                $('#image-area').append('[Gambar tidak tersedia]');
                            }
                        },
                    });
                });
        });
    </script> --}}
    {{-- <script>
        $(function(){
            $(document).on('click', '#btn-force-buku', function(){
                var id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
                    Swal.fire({
                            title: 'Apa kamu yakin ingin menghapus permanen?',
                            text: "Kamu tidak akan dapat mengembalikan ini!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: "books/empty/" +id,
                                    type: "DELETE",
                                    success: function (response) {
                                        Swal.fire('Terhapus!', response.msg, 'success');
                                        console.log(response);
                                            // $("#table-row" + id).remove();
                                            //$('#table-data').load(document.URL +  ' #table-data').ajax.reload();;
                                            location.reload();
                                    }

                                });
                            }
                        })

              });
            });
    </script> --}}
@stop



