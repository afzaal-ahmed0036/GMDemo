@extends('template.tmp')
@section('title', 'Ware House Out Stock')
@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Warehouse IN Stock</h4> 
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
                                        <th class="col-md-2">ID#</th>
                                        <th>Warehouse</th>
                                        <th class="col-md-3">From Warehouse</th>
                                        <th class="col-md-2">TotalQty</th>
                                        <th class="col-md-2">Date</th>
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
            "ajax": "{{ route('warehouse.stock-warehouse-list') }}?warehouse=in",
            "columns": [{
                    "data": "InvoiceMasterID"
                },
                {
                    "data": "WarehouseName"
                },
                {
                    "data": "otherWareHouse"
                },
                {
                    "data": "TotalQty"
                },
                {
                    "data": "Date"
                },
                {
                    "data": "action"
                },
            ]
        });
    });
</script>

<!-- BEGIN: Vendor JS-->
<script src="{{asset('assets/vendors/js/vendors.min.js')}}"></script>
<!-- BEGIN Vendor JS-->


 @endpush