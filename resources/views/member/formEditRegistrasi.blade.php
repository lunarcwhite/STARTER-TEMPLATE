{{-- modal form registrasi --}}
<div class="modal fade" id="formEditRegistrasiModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">Form Registrasi</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- id form == #form --}}
                <form id="table-form" method="post" action="{{route('member.update')}}" enctype="multipart/form-data">
                    @method('patch')
                    @csrf
                    <div class="alert alert-primary">
                        <strong>Data Diri</strong>
                        <input type="hidden" name="id" value="{{$member->no_reg}}" id="">
                    </div>
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="form-group">
                                <label>Nama Lengkap:</label>
                                <input type="text" name="nama" value="{{$member->nama}}" class="form-control" placeholder="Masukan Nama Lengkap">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Tempat Lahir:</label>
                                <input type="text" name="tempat_lahir" value="{{$member->tempat_lahir}}" placeholder="Masukan Tempat Lahir"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Tanggal Lahir:</label>
                                <input type="date" name="tanggal_lahir" value="{{$member->tanggal_lahir}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>Jenis Kelamin:</label>
                                <select class="form-control" name="jk">
                                    <option>Pilih Jenis Kelamin</option>
                                    <option value="{{$member->jenis_kelamin}}" selected>{{$member->jenis_kelamin}}</option>
                                    <option value="Perempuan">Perempuan</option>
                                    <option value="Laki - Laki">Laki-laki</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>No Telp / No Whatsapp</label>
                                <input type="text" name="no_telp" value="{{$member->no_telp}}" class="form-control"
                                    placeholder="Masukan Nomor Telepon">
                                <p class="small">Diawali kode negara. <br /> Contoh +62896xxx </p>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-primary">
                        <strong>Data Alamat Asal</strong>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>Alamat:</label>
                                <textarea class="form-control" name="alamat" rows="2" id="alamat">{{$member->alamat}}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Kode Pos:</label>
                                <input type="text" name="kode_pos" value="{{$member->kode_pos}}" class="form-control" placeholder="Kode Pos">
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-primary">
                        <strong>Berkas Pendudukung</strong>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div form-group>
                                <img src="{{asset('storage/kyc/'.$member->kyc)}}" width="350px" alt=""/> 
                            </div>
                            <div class="form-group">
                                <label>Upload Foto Identitas</label>
                                <input type="file" name="kyc" class="form-control">
                                <input type="hidden" name="old" value="{{$member->kyc}}">
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-danger">Reset</button>
                <button type="submit" name="Submit" id="Submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>