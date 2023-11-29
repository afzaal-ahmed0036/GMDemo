@extends('template.tmp')

@section('title', 'Purchase Order')


@section('content')
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Purchase Order</h4>
                        <a href="{{URL('/PurchaseOrderCreate')}}" class="btn btn-primary w-md float-right "><i class="bx bx-plus"></i> Add New</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    @if (session('error'))

                    <div class="alert alert-{{ Session::get('class') }} p-1" id="success-alert">

                        {{ Session::get('error') }}
                    </div>

                    @endif

                    @if (count($errors) > 0)

                    <div>
                        <div class="alert alert-danger p-1   border-3">
                            <p class="font-weight-bold"> There were some problems with your input.</p>
                            <ul>

                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>

                                @endforeach
                            </ul>
                        </div>
                    </div>

                    @endif


                    <div class="card">

                        <div class="card-body">
                            <table id="student_table" class="table table-striped table-sm " style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="col-md-2">Purchase Order#</th>
                                        <th>PON</th>
                                        <th class="col-md-3">Supplier</th>
                                        <th class="col-md-2">Date</th>
                                        <th class="col-md-2">Delivery Date</th>
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
<!-- END: Content-->
@endsection

@push('after-scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#student_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ url('PurchaseOrder') }}",
            "columns": [{
                    "data": "PurchaseOrderMasterID"
                },
                {
                    "data": "PON"
                },
                {
                    "data": "SupplierName"
                },
                {
                    "data": "Date"
                },
                {
                    "data": "DeliveryDate"
                },
                {
                    "data": "action"
                },
            ]
        });
    });
</script>

<!-- BEGIN: Vendor JS-->
<!-- BEGIN Vendor JS-->


@endpush
