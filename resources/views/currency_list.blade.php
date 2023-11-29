@extends('template.tmp')
@section('title', 'Currency Listing')
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
                            <h4 class="mb-sm-0 font-size-18">Currency Listing</h4>

                            <div class="page-title-right">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addCurrencyModal">Add Currency</button>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-xl-12">
                        <!-- Add Modal -->
                        <div class="modal fade" id="addCurrencyModal" tabindex="-1" role="dialog"
                            aria-labelledby="addCurrencyModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addCurrencyModalTitle">Add Currency</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ url('store-currency') }}" method="POST">
                                            @csrf
                                            <div class="row col-md-12">
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input type="text" name="name" class="form-control" required>
                                                </div>

                                            </div>
                                            <div class="row col-md-12">
                                                <div class="form-group">
                                                    <label for="code">Code</label>
                                                    <input type="text" name="code" class="form-control" required>
                                                </div>

                                            </div>
                                            <div class="row col-md-12">
                                                <div class="form-group">
                                                    <label for="exchange_rate">Exchange Rate</label>
                                                    <input type="text" name="exchange_rate" class="form-control"
                                                        required>
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
                        <div class="modal fade" id="editCurrencyModal" tabindex="-1" role="dialog"
                            aria-labelledby="editCurrencyModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editCurrencyModalTitle">Edit Currency</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ url('update-currency') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="currency_id" value="" id="currency_id">
                                            <div class="row col-md-12">
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input type="text" name="name" class="form-control" required>
                                                </div>

                                            </div>
                                            <div class="row col-md-12">
                                                <div class="form-group">
                                                    <label for="code">Code</label>
                                                    <input type="text" name="code" class="form-control" required>
                                                </div>

                                            </div>
                                            <div class="row col-md-12">
                                                <div class="form-group">
                                                    <label for="exchange_rate">Exchange Rate</label>
                                                    <input type="text" name="exchange_rate" class="form-control"
                                                        required>
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
                                <h4 class="card-title mb-4">Salesman List</h4>


                                <table class="table datatable table-hover dt-responsive nowrap w-100 table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col">S.No</th>
                                            <th scope="col">Currency Name</th>
                                            <th scope="col">Currency Code</th>
                                            <th scope="col">Exchange Rate</th>
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
                    "ajax": "{{ url('currency-list') }}",
                    "columns": [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            "data": "name"
                        },
                        {
                            "data": "code"
                        },
                        {
                            "data": "exchange_rate"
                        },
                        {
                            "data": "action"
                        }
                    ]

                });

                $(document.body).on('click', '.edit_currency', function() {
                    var currency_id = $(this).data('id');
                    if (currency_id) {
                        $.ajax({
                            url: '{{ url('/get-currency-data') }}',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            method: "GET",
                            data: {
                                currency_id: currency_id
                            },
                            dataType: "JSON",
                            success: function(data) {
                                if (data) {
                                    $("#editCurrencyModal input[name='currency_id']").val(data.id);
                                    $("#editCurrencyModal input[name='name']").val(data.name);
                                    $("#editCurrencyModal input[name='code']").val(data.code);
                                    $("#editCurrencyModal input[name='exchange_rate']").val(data
                                        .exchange_rate);
                                    $('#editCurrencyModal').modal('show');
                                }

                            }
                        });
                    }
                });


            });
        </script>
    @endpush
