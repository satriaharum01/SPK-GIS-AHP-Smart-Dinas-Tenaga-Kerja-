@extends('template.layout')
@section('css')
<style>
    #petapublic{        
            width: 100%;
            position: absolute;
            height: 100%;
        }
    .gmap_canvas {
            overflow: hidden;
            background: none !important;
            height: 100%;
            width: 100%;
        }
</style>
@endsection
@section('content')

<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary" style="padding: 12px 6px;">Foto </h6>
                </div>
                <div class="card-body">
                    @foreach($load as $row)
                    <img src="{{asset('/file/pengaduan/'.$row->foto)}}" style="height:333px;" alt="Foto">
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-6 stretch-card">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary" style="padding: 12px 6px;">{{$title}}</h6>
                </div>
                <div class="card-body">
                    @foreach($load as $row)
                    <div class="modal-body"> 
                        <div class="form-group">
                            <label>Tanggal Laporan</label>
                            <input type="text" name="tanggal" value="{{$row->tanggal}}" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Pelapor</label>
                            <input type="text" name="pelapor"  value="{{$row->pelapor}}" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi"  class="form-control" readonly>{{$row->deskripsi}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Nama Jalan</label>
                            <input type="text" name="jalan"  value="{{$row->jalan}}" class="form-control" readonly>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
  </div>
  <!-- content-wrapper ends -->
<!-- /.container-fluid -->
@endSection()
@section('js')
<script src="<?= asset('/node_modules/axios/dist/axios.min.js') ?>"></script>
</body>
@endSection