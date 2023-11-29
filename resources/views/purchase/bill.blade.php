@extends('template.tmp')
@section('title', 'Purchase Invoices')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @if (session('error'))
                    <div class="alert alert-{{ Session::get('class') }} p-1" id="success-alert">
                        <strong>{{ Session::get('error') }} </strong>
                    </div>
                @endif
                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                            data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}
                    </div>
                @endif
                @if (session()->has('not_permitted'))
                    <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close"
                            data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
                @endif
                @if (count($errors) > 0)
                    <div>
                        <div class="alert alert-danger p-1 border-1 bg-danger text-white">
                            <p class="font-weight-bold"> There were some problems with your input.</p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Purchase Invoices</h4>
                            <a href="{{ URL('/BillCreate') }}" class="btn btn-success w-md float-right "><i
                                    class="bx bx-plus"></i> Add New</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="student_table" class="table table-striped table-sm " style="width:100%">
                                    <thead>
                                        <tr>
                                            {{-- <th>#</th> --}}
                                            <th class="col-md-2">Invoice #</th>
                                            <th class="col-md-3">Supplier</th>
                                            <th class="col-md-3">WareHouse</th>
                                            <th class="col-md-2">Date</th>
                                            <th class="col-md-2">Payment Mode</th>
                                            <th>Total</th>
                                            <th>Paid</th>
                                            <th>Balance</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('after-scripts')
    <!-- END: Content-->
    <script type="text/javascript">
        $(document).ready(function() {

            $('#student_table').DataTable({
                "processing": true,
                "serverSide": true,
                "searching": true,
                "ajax": "{{ url('Bill') }}",
                "columns": [
                    // {
                    //     "data": "InvoiceMasterID"
                    // },
                    {
                        "data": "InvoiceNo"
                    },
                    {
                        "data": "SupplierName"
                    },
                    {
                        "data": "WarehouseName"
                    },
                    {
                        "data": "Date"
                    },
                    {
                        "data": "PaymentMode"
                    },
                    {
                        // "data": "Total"
                        "data": "GrandTotal"
                    },
                    {
                        "data": "Paid"
                    },
                    {
                        "data": "Balance"
                    },
                    {
                        "data": "action"
                    },

                ],
                // "order": [
                //     [0, 'desc']
                // ],
            });


            $('#student_table  tr').clone(true).appendTo('#student_table thead');
            $('#student_table thead tr:eq(1) th').each(function(i) {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder=" Search ' + title +
                    '"  class="form-control form-control-sm" />');
                // hide text field from any column you want too
                if (title == 'Action') {
                    $(this).hide();
                }
                if (title == 'Balance') {
                    $(this).hide();
                }
                $('input', this).on('keyup change', function() {

                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });

            });
            var table = $('#student_table').DataTable({
                orderCellsTop: false,
                fixedHeader: true,
                retrieve: true,
                paging: false

            });
            setInterval(() => {
                $('.delete-btn').on('click', function(e) {
                    var url = $(this).data('url');
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = url;
                            // Swal.fire({
                            //     title: "Deleted!",
                            //     text: "Your file has been deleted.",
                            //     icon: "success"
                            // });
                        }
                    });
                });
            }, 100);

        });
    </script>

    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->
@endpush
