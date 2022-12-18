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
            <hr/>
            <a href="{{ route('admin.print.books') }}" target="_blank" class="btn btn-secondary">
                <i class="fa fa-print"></i> Cetak PDF</a>
            <div class="btn-group" role="group" aria-label="Basic Example">
                <a href="{{ route('admin.book.export') }}" class="btn btn-info" 
                target="_blank"><i class="fa fa-file-excel"></i> Export</a>
                <button type="button" class="btn btn-warning" data-toggle="modal" 
                data-target="#importDataModal"><i class="fa fa-file-excel"></i> Import</button>
            </div>
            <hr/>
            <div class="table-responsive">
                <table id="table-data" class="table table-borderer">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Tahun</th>
                            <th>Penerbit</th>
                            <th>Kategori Buku</th>
                            <th>Gambar</th>
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
                                <td>{{$book->kategori->nama_kategori}}</td>
                                <td>
                                    @if ($book->cover !== null)
                                        <button type="button" id="btn-gambar-buku" class="btn btn-primary"
                                        data-toggle="modal" data-target="#gambarBuku" data-id="{{ $book->id }}">Lihat</button>
                                    @else
                                    [Gambar tidak tersedia]
                                    @endif    
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" id="btn-edit-buku" class="btn btn-success"
                                        data-toggle="modal" data-target="#editBukuModal" data-id="{{ $book->id }}">Edit</button>
                                        <form id="delete" action="books/delete/{{$book->id}}" method="post">
                                            @csrf
                                            @method('delete')
                                        </form>
                                        <button type="button" id="btn-delete-buku" class="btn btn-danger">Hapus</button>   
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
</div>
<div class="modal fade" id="tambahBukuModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <form action="{{ route('admin.book.submit') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="judul">Judul Buku</label>
                            <input type="text" class="form-control" name="judul" id="judul" required/>
                        </div>
                        <div class="form-group">
                            <label for="penulis">Penulis</label>
                            <input type="text" class="form-control" name="penulis" id="penulis" required/>
                        </div>
                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <input type="year" class="form-control" name="tahun" id="tahun" required/>
                        </div>
                        <div class="form-group">
                            <label for="penerbit">Penerbit</label>
                            <input type="text"  class="form-control" name="penerbit" id="penerbit" required/>
                        </div>
                        <div class="form-group">
                            <label for="tipe_buku">Kategori Buku</label>
                            <select name="kategori_buku" id="" class="form-control" required>
                                <option value="" readonly>-- Pilih Kategori Buku --</option>
                                @foreach ($kategori as $item)
                                <option value="{{$item->id}}">{{$item->nama_kategori}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="tambahGambar">
                            <label for="cover">Gambar</label>
                            <input type="file" class="form-control" name="cover[]" id="cover"/>
                        </div>
                        <button type="button" onclick="tambahGambar()" class="btn btn-transparent mt-1">Klik Disini Untuk Menambah Inputan Gambar</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </form>
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
                            <form id="form-hapus-gambar" action="{{route('admin.hapus.gambar')}}" method="post">
                                @csrf
                                @method('patch')
                            <div class="form-group" id="image-area"></div>
                            <input type="hidden" name="id" id="edit-id"/>
                            </form>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editBukuModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <form action="{{ route('admin.book.update') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        @method('patch')
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-group">
                                    <label for="edit-judul">Judul Buku</label>
                                    <input type="text" class="form-control" name="judul" id="edit-judul" required/>
                                </div>
                                <div class="form-group">
                                    <label for="edit-penulis">Penulis</label>
                            <input type="text" class="form-control" name="penulis" id="edit-penulis" required/>
                        </div>
                        <div class="form-group">
                            <label for="edit-tahun">Tahun</label>
                            <input type="year" class="form-control" name="tahun" id="edit-tahun" required/>
                        </div>
                        <div class="form-group">
                            <label for="edit-penerbit">Penerbit</label>
                            <input type="text"  class="form-control" name="penerbit" id="edit-penerbit" required/>
                        </div>
                        <div class="form-group">
                            <label for="edit-penerbit">Kategori</label>
                        <select name="kategori_buku" id="edit-kategori" class="form-control">
                            @foreach ($kategori as $item)
                               <option value="{{$item->id}}">{{$item->nama_kategori}}</option>
                            @endforeach 
                        </select>
                        </div>
                    </div>
                </div>
            </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="edit-id"/>
                    <input type="hidden" name="old_cover" id="edit-old-cover"/>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                    </form>
                </div>
        </div>
    </div>
</div>
<div class="modal fade" id="importDataModal" tabindex="-1" aria-labelledby="exampleModalLable" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <div class="modal-body">
        <form action="{{ route('admin.book.import') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="form-group">
            <label for="cover">Upload File</label>
            <input type="file" class="form-control" name="file"/>
        </div>
    </div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
    <button type="submit" class="btn btn-primary">Import Data</button>
</form>
</div>
</div>
</div>
</div>
@stop
@section('js')
<script>
        $(function(){
              $(document).on('click', '#btn-hapus-gambar', function(){
                event.preventDefault(); 
                    Swal.fire({
                            title: 'Apa kamu yakin?',
                            html: "Ingin Menghapus gambar ini?</strong>",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#form-hapus-gambar').submit();
                            }
                        })

              });
            });
</script>
<script>
    function tambahGambar()
    {
        const y = document.getElementById('tambahGambar');
        var z = document.createElement("input");

        z.setAttribute('type', 'file');
        z.setAttribute('name', 'cover[]');
        z.setAttribute('class', 'form-control');
        y.appendChild(z);
        }
</script>
<script>
    $(function(){
        $(document).on('click','#btn-gambar-buku', function(){
            $('#image-area').empty();
            let id = $(this).data('id');
                $.ajax({
                    type: "get",
                    url: "{{url('/admin/ajaxadmin/dataBuku')}}/"+id,
                    dataType: 'json',
                    success: function(res){
                        let data = res.cover;
                        $('#edit-id').val(res.id);
                        const value = data.split(",");
                        const removeLast = value.pop();
                        value.forEach(x => {
                            $('#image-area').append(
                                `<br/>
                                <button type="button" id="btn-hapus-gambar" class="close text-danger" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                <img src="{{asset('storage/gambar_buku/`+x+`')}}" width="100%"/>
                                <input type="hidden" id="hapusGambar" name="gambar" value="`+x+`">
                                <br/>`
                            );
                        });
                        },
                    });
                });
        });
    </script>
<script>
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
                        $('#edit-kategori').val(res.id_kategori);
                        },
                    });
                });
        });
    </script>
    <script>
        $(function(){
            $(document).on('click', '#btn-delete-buku', function(){
                var id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
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
                                if (result.isConfirmed) {
                                $('#delete').submit();
                            }
                            }
                        })

              });
            });
    </script>
@stop



