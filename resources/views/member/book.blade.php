@extends('adminlte::page')
@section('title', 'Home Page')
@section('content_header')
    <h1>Data Buku</h1>
@stop
@section('content')
<div class="container-fluid" id="page">
    <div class="card card-default">
        <div class="card-header" id="page-buku">{{__('Buku Yang Tersedia')}}</div>
        <div class="row">
            <div class="col-md-3">
            <a href="#" class="btn btn-primary mt-1 ps-2">Lihat Semua Buku Yang Ada</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-data" class="table table-borderer">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Tipe Buku</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($buku as $item => $value)
                            <tr>
                                <td>{{$item+1}}</td>
                                <td>{{$value}}</td>
                                <td>
                                    <button type="button" class="btn btn-primary">Lihat</button>
                                </td> 
                            </tr>                        
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop