@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content_header')
<h1>Dashboard</h1>
@stop
@section('content')
@can('Member')
<div class="container-fluid" id="page">
    <div class="card card-default">
        <div class="card-header" id="page-member">{{ __('Selamat Datang') }}</div>
        <div class="card-body">
            @if($member == false)
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#formRegistrasiModal">
                            <i class="fa fa-plus"></i> Isi Form Registrasi</button>
                    </div>
                </div>
            </div>
            @else
            @if($member == true && $member->status == false)
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2>Akun Anda Sedang Ditinjau Oleh Admin</h2>
                    </div>
                </div>
            </div>
            @else
            <div class="table-responsive-sm">
                <table class="table table-hover bg-white">
                    <thead>
                        <th>No Registrasi</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $member->no_reg }}</td>
                            <td>{{ $member->nama }}</td>
                            <td>
                                <button type="button" id="btn-read-registrasi" class="btn btn-info success"
                                    data-toggle="modal" data-target="#formEditRegistrasiModal"
                                    data-id="{{ $member->no_reg }}">Lihat</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endif
            @endif
            <hr />
        </div>
    </div>
</div>
@include('member.formRegistrasi')
@if($member == true && $member->status == true)
@include('member.formEditRegistrasi')
@endif
@endcan
@stop
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop
@section('js')
<script>
    console.log('Hi!');
</script>
@stop