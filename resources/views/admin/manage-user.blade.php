@extends('adminlte::page')
@section('title', 'Home Page')
@section('content_header')
<h1>Data User</h1>
@stop
@section('content')
<div class="container-fluid" id="page">
    <div class="card card-default">
        <div class="card-header" id="page-buku">{{__('Pengelolaan User')}}</div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-data" class="table table-hover">
                    <thead>
                        <tr class="text-center">
                            <th>NO</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $no => $value )
                        <tr class="text-center">
                            <td>{{$no+1}}</td>
                            <td>{{$value->username}}</td>
                            <td>{{$value->email}}</td>
                            <td>
                                @if ($value->member == null)
                                Belum Terdaftar Anggota
                                @else
                                Sudah Terdaftar Anggota
                                @endif
                            </td>
                            <td>
                                <form action="manage-user/delete/{{$value->id}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="button" onclick="deleteUser()" id="delete-user" class="btn btn-danger">Hapus</button>
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
function deleteUser(){
            var form = event.target.form;
            Swal.fire({
                title: 'Apa kamu yakin?',
                text: "Kamu Akan Menghapusnya!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
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