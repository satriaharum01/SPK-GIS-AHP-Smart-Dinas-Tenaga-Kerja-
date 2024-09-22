@extends('landing.head')
@section('css')
     <link rel="stylesheet" href="{{asset('vendors')}}/css/vendor.bundle.base.css">
    <!-- base:css -->
    <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendors/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<!-- End of Topbar -->

<nav class="navbar navbar-expand-lg navbar-light shadow-sm" style="background-color: #13b56a;">
    <div class="container mx-auto">
    </div>
</nav>
<div class="container-fluid page-body-wrapper p-5">
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 stretch-card">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary" style="padding: 12px 6px;">{{$title}}</h6>
            </div>
            <div class="card-body">
                
            <form action="{{url('/pengaduan/save')}}" method="POST" id="compose-form" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <div class="modal-body"> 
                    <div class="form-group row">
                        <label class="col-sm-4">Identitas Pelapor</label>
                        <div class="col-sm-8">
                            <input type="text" name="pelapor" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Jalan</label>
                        <div class="col-sm-8">
                            <select name="id_jalan" id="id_jalan" class="form-control">
                                <option value="0" selected disabled>-- Pilih Jalan --</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Deskripsi</label>
                        <div class="col-sm-8">
                            <textarea  name="deskripsi" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Foto</label>
                        <div class="col-sm-8">
                            <input type="file" name="foto" accept="images/*" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary text-white btn-simpan mx-4 pull-right">Submit</button>
                </div>
            </form>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
  <!-- content-wrapper ends -->
<!-- /.container-fluid -->
@endsection
@section('custom_script')
<script>
    $.ajax({
            url: "{{ url('/get/jalan/json')}}",
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function(dataResult) {
                console.log(dataResult);
                var resultData = dataResult.data;
                $.each(resultData, function(index, row) {
                    $('#id_jalan').append('<option value="' + row.id_alternatif + '">' + row.nama_alternatif + '</option>');
                })
            }
        });
</script>
</body>
</html>
@endsection