    
    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="{{ asset('js/off-canvas.js') }}"></script>
    <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
    <script src="{{asset('vendors/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('js/dashboard-chart-area.js')}}"></script>
    <!-- Page level plugins -->
    <script src="{{ asset('vendors/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('vendors/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(function () {
        $(".alert").fadeOut(3000);
        });
        $("body").on("click", ".btn-hapus", function() {
            var x = jQuery(this).attr("data-id");
            var y = jQuery(this).attr("data-handler");
            var xy = x + '-' + y;
            event.preventDefault()
            Swal.fire({
                title: 'Hapus Data ?',
                text: "Data yang dihapus tidak dapat dikembalikan !",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                        'Data Dihapus!',
                        '',
                        'success'
                    );
                    document.getElementById('delete-form-' + xy).submit();
                }
            });

        })
    </script>