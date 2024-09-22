@extends('template.layout')
@section('content')



<!-- Page Heading
<h1 class="h3 mb-2 text-gray-800">Tables</h1>
<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank"
        href="https://datatables.net">official DataTables documentation</a>.</p>
 -->
<!-- DataTales Example -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary" style="padding: 12px 6px;">{{$title}}</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datawidth" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="8%" style="text-align:center; vertical-align: middle;">No</th>
                                        <th width="25%" style="text-align:center; vertical-align: middle;">Nama Jalan</th>
                                        <th style="text-align:center; vertical-align: middle;">Nilai</th>
                                        <th width="15%" style="text-align:center; vertical-align: middle;">Rangking</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align:center; vertical-align: middle;">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- /.container-fluid -->
@endSection()
@section('js')
<script>
    $(function() {
        table = $('#datawidth').DataTable({
            processing: true,
            serverSide: true,
            seraching: false,
            lenghtchange: false,
            ajax: {
                url: '{{url("$page/json")}}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_alternatif'
                },
                {
                    data: 'nilai'
                },
                {
                    data: 'rank'
                },
            ]
        });

    });

</script>
@endSection