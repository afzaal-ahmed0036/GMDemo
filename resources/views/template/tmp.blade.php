<!doctype html>
<html lang="en">

<!-- Mirrored from themesbrand.com/skote-django/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 16 May 2021 18:20:42 GMT -->
<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{URL('/')}}/assets/images/favicon.ico">

    <link href="{{asset('assets/libs/fullcalendar/core/main.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/fullcalendar/daygrid/main.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/fullcalendar/bootstrap/main.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/fullcalendar/timegrid/main.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="{{asset('assets/libs/spectrum-colorpicker2/spectrum.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/libs/chenfengyuan/datepicker/datepicker.min.css')}}">

    <!-- Bootstrap Css -->
    <link href="{{URL('/')}}/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{URL('/')}}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{URL('/')}}/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    <link href="{{URL('/')}}/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{URL('/')}}/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- flatpickr css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/themes/light.css">

    <!-- Responsive datatable examples -->
    <link href="{{URL('/')}}/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Sweet Alert-->
    <link href="{{URL('/')}}/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

    <link href="{{URL('/')}}/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
    <!-- <link rel="stylesheet" href="{{URL('/')}}/assets/libs/%40chenfengyuan/datepicker/datepicker.min.css"> -->

    <link rel="stylesheet" type="text/css" href="{{URL('/')}}/assets/libs/toastr/build/toastr.min.css">
    <!-- Responsive datatable examples -->


    @stack('before-styles')

    @stack('after-styles')

    @yield('page-styles')
    <!-- my own model -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-center">Are you sure to delete this information ?</p>
                    <p class="text-center">
                        <a href="#" class="btn btn-danger " id="delete_link">Delete</a>
                        <button type="button" class="btn btn-info" data-bs-dismiss="modal">Cancel</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- end of my own model -->
</head>

<body data-sidebar="dark">
    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">
        <!-- start of header -->
        @include('template.header')
        <!-- end of header -->

        <!-- ========== Left Sidebar Start ========== -->
        @include('template.sidebar')
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        @yield('content')

        <!-- END layout-wrapper -->

        <!-- start of footer -->
        @include('template.footer')
        <!-- end of footer -->

        <!-- JAVASCRIPT -->
        <script src="{{URL('/')}}/assets/libs/jquery/jquery.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- <script src="{{URL('/')}}/assets/libs/bootstrap/js/bootstrap.min.js"></script> -->
        <script src="{{URL('/')}}/assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/node-waves/waves.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.js"></script>



        <!-- form mask init -->
        <script src="{{URL('/')}}/assets/js/pages/form-mask.init.js"></script>


        <!-- App js -->
        <script src="{{URL('/')}}/assets/js/app.js"></script>

        <!-- form mask -->
        <script src="{{URL('/')}}/assets/libs/inputmask/min/jquery.inputmask.bundle.min.js"></script>

        <!-- form mask init -->

        <!-- Required datatable js -->
        <script src="{{URL('/')}}/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="{{URL('/')}}/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
        <!-- toastr plugin -->
        <script src="{{URL('/')}}/assets/libs/toastr/build/toastr.min.js"></script>

        <!-- toastr init -->
        <script src="{{URL('/')}}/assets/js/pages/toastr.init.js"></script>

        <!-- form repeater js -->
        <script src="{{asset('assets/libs/jquery.repeater/jquery.repeater.min.js')}}"></script>

        <script src="{{asset('assets/js/pages/form-repeater.int.js')}}"></script>


        <!-- Required datatable js -->
        <!-- Buttons examples -->
        <script src="{{URL('/')}}/assets/libs/jszip/jszip.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/pdfmake/build/pdfmake.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/pdfmake/build/vfs_fonts.js"></script>
        <script src="{{URL('/')}}/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

        <!-- Responsive examples -->

        <!-- Datatable init js -->

        <!-- apexcharts -->

        <script src="{{URL('/')}}/assets/libs/select2/js/select2.min.js"></script>

        <!-- init js -->
        <script src="{{URL('/')}}/assets/js/pages/ecommerce-select2.init.js"></script>

        <!-- Sweet Alerts js -->
        <script src="{{URL('/')}}/assets/libs/sweetalert2/sweetalert2.min.js"></script>

        <!-- Sweet alert init js-->
        <script src="{{URL('/')}}/assets/js/pages/sweet-alerts.init.js"></script>

        <!-- form repeater js -->


        <script src="{{URL('/')}}/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <!-- <script src="{{URL('/')}}/assets/libs/%40chenfengyuan/datepicker/datepicker.min.js"></script> -->

        <script src="{{URL('/')}}/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

        <!-- Datatable init js -->
        <script src="{{URL('/')}}/assets/js/pages/datatables.init.js"></script>


        <script src="{{asset('assets/libs/moment/min/moment.min.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
        <script src="{{asset('assets/libs/jquery-ui-dist/jquery-ui.min.js')}}"></script>
       <!-- <script src="{{asset('assets/libs/fullcalendar/core/main.min.js')}}"></script>
        <script src="{{asset('assets/libs/fullcalendar/bootstrap/main.min.js')}}"></script>
        <script src="{{asset('assets/libs/fullcalendar/daygrid/main.min.js')}}"></script>
        <script src="{{asset('assets/libs/fullcalendar/timegrid/main.min.js')}}"></script>
        <script src="{{asset('assets/libs/fullcalendar/interaction/main.min.js')}}"></script>

         Calendar init
        <script src="{{asset('assets/js/pages/calendars-full.init.js')}}"></script> -->
</body>
@stack('before-scripts')
<script>
    $("#success-alert").fadeTo(4000, 500).slideUp(100, function() {
        $("#success-alert").slideUp(500);
        $("#success-alert").alert('close');
    });
    $("#monthpicker").datepicker({
        format: "yyyy-mm",
        viewMode: "months",
        minViewMode: "months"
    }).on('changeDate', function(e) {
        $(this).datepicker('hide');
    });

    $("#yearPicker").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years"
    }).on('changeDate', function(e) {
        $(this).datepicker('hide');
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function delete_confirm(url_plus_id) {
        var url;

        url = "{{URL::TO('/delete_customer')}}" + '/' + url_plus_id;
        jQuery('#staticBackdrop').modal('show', {
            backdrop: 'static'
        });
        document.getElementById('delete_link').setAttribute('href', url);

    }

    function delete_confirm2(url, id) {
        url = "{{URL::TO('/')}}/" + url + '/' + id;
        // console.log(url);return

        jQuery('#staticBackdrop').modal('show', {
            backdrop: 'static'
        });
        document.getElementById('delete_link').setAttribute('href', url);

    }

    function cal(id) {

        // var result = parseFloat('2.3') + parseFloat('2.4');
        // alert(result);
        var Bonus = document.getElementById('Bonus' + id).value;
        var Grand = document.getElementById('GrandOld' + id).value;
        var GrandOld = document.getElementById('GrandOld' + id).value;


        if (Bonus == '') {

            // Bonus = 0.1;
            //alert(Bonus);
            // var Total = parseInt(Bonus) + parseInt(Grand);
            $('#Grand' + id).val(parseFloat(GrandOld));
            $('#Bonus' + id).val(0);
        } else {
            //alert(0.2);
            var Total = 0;
            Total = parseInt(Bonus) + parseInt(GrandOld);
            $('#Grand' + id).val(parseInt(Total).toFixed(2));

        }

        if (Bonus == 0) {
            // alert(0.2);
            var Total = 0;
            $('#Grand' + id).val(parseFloat(GrandOld));
            $('#Bonus' + id).val(0);

        }
    }
</script>
@stack('after-scripts')

@yield('page-scripts')

</html>
