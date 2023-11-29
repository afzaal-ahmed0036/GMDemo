@extends('template.tmp')
@section('title', 'Unit Listing')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
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
                            <h4 class="mb-sm-0 font-size-18">Unit Listing</h4>

                            <div class="page-title-right">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addUnitModal">Add Unit</button>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-xl-12">
                        <!-- Add Modal -->
                        <div class="modal fade" id="addUnitModal" tabindex="-1" role="dialog"
                            aria-labelledby="addUnitModal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addUnitModalTitle">Add Unit</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ url('store-unit') }}" method="POST">
                                            @csrf
                                            <div class="row col-md-12 mt-3">
                                                <div class="form-group">
                                                    <label for="name">Unit</label>
                                                    <input type="text" name="base_unit" class="form-control"
                                                        placeholder="Type Unit Name" id="unit" required>
                                                </div>

                                            </div>
                                            <div class="row col-md-12 mt-3">
                                                <div class="form-group">
                                                    <label for="name">Child Unit</label>
                                                    <input type="text" name="child_unit" class="form-control"
                                                        placeholder="Type Child Unit Name" id="child_unit" required>
                                                </div>

                                            </div>
                                            <div class="row col-md-12 mt-3">
                                                <div class="form-group">
                                                    <label for="">Unit Convert</label><br>
                                                    1 <span id="print_unit">Unit</span> = <input type="text"
                                                        class="form-control" name="unit_value" required=""><span
                                                        id="print_child_unit">Child Unit</span>

                                                </div>
                                            </div>
                                            <div class="row col-md-12 mt-3">
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select class="form-control" name="status">
                                                        <option value="1">Active</option>
                                                        <option value="0">In-Active</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="sumbit" class="btn btn-success">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Edit Modal -->
                        <div class="modal fade" id="editUnitModal" tabindex="-1" role="dialog"
                            aria-labelledby="editUnitModal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editUnitModalTitle">Edit Unit</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ url('update-unit') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="unit_id" value="" id="unit_id">
                                            <div class="row col-md-12 mt-3">
                                                <div class="form-group">
                                                    <label for="name">Unit</label>
                                                    <input type="text" name="base_unit" class="form-control"
                                                        id="edit_unit" required>
                                                </div>

                                            </div>
                                            <div class="row col-md-12 mt-3">
                                                <div class="form-group">
                                                    <label for="name">Child Unit</label>
                                                    <input type="text" name="child_unit" class="form-control"
                                                        id="edit_child_unit" required>
                                                </div>

                                            </div>
                                            <div class="row col-md-12 mt-3">
                                                <div class="form-group">
                                                    <label for="">Unit Convert</label><br>
                                                    1 <span id="edit_print_unit">Unit</span> = <input type="text"
                                                        class="form-control" name="unit_value" id="edit_unit_value"
                                                        required=""><span id="edit_print_child_unit">Child Unit</span>

                                                </div>
                                            </div>
                                            <div class="row col-md-12 mt-3">
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select class="form-control" name="status" id="edit_status">
                                                        <option value="1">Active</option>
                                                        <option value="0">In-Active</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="sumbit" class="btn btn-success">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Units</h4>


                                <table class="table datatable table-hover dt-responsive nowrap w-100 table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col">S.No</th>
                                            <th scope="col">Unit Name</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>


                                    <tbody>

                                    </tbody>
                                </table>

                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div> <!-- container-fluid -->
        </div>
    @endsection

    @push('after-scripts')
        <script type="text/javascript">
            $(document).ready(function() {

                $('.datatable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "pageLength": 50,
                    "ajax": "{{ url('unit-list') }}",
                    "columns": [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            "data": "base_unit",
                            name: 'base_unit'
                        },
                        {
                            "data": "status",
                            name: 'status'
                        },
                        {
                            "data": "action"
                        }
                    ]

                });

                $("#unit").on('keyup', function(e) {
                    $("#print_unit").html($("#unit").val());
                });

                $("#child_unit").on('keyup', function(e) {
                    $("#print_child_unit").html($("#child_unit").val());
                });

                $("#edit_unit").on('keyup', function(e) {
                    $("#edit_print_unit").html($("#edit_unit").val());
                });

                $("#edit_child_unit").on('keyup', function(e) {
                    $("#edit_print_child_unit").html($("#edit_child_unit").val());
                });



                $(document.body).on('click', '.edit_unit', function() {
                    var unit_id = $(this).data('id');
                    $.ajax({
                        url: "{{ url('get-unit-detail') }}",
                        dataType: 'JSON',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            unit_id: unit_id,
                        },
                        success: function(data) {
                            if (data) {
                                $("#unit_id").val(data.id);
                                $("#edit_unit").val(data.base_unit);
                                $("#edit_child_unit").val(data.child_unit);
                                $("#edit_unit_value").val(data.unit_value);
                                $("#edit_print_unit").html(data.base_unit);
                                $("#edit_print_child_unit").html(data.child_unit);
                                $("#edit_status").val(data.status);
                                $('#editUnitModal').modal('show');
                            }
                        }
                    });

                });


            });
        </script>
    @endpush
