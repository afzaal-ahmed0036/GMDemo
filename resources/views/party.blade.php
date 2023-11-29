@extends('template.tmp')
@section('title', $pagetitle)
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
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title ">Party / Customer Detail</h4>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                <a href="{{ url('Create/Party') }}" class="btn btn-primary"><i class="fa fa-plus"></i>
                                    Add</a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped  table-sm  m-0" id="student_table">
                                        <thead>
                                            <tr>
                                                <th>Party Code</th>
                                                <th>Name</th>
                                                <th>TRN #</th>
                                                <th>Address</th>
                                                <th>City</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($supplier as $value)
                                                <tr>
                                                    <td>{{ $value->PartyID }}</td>
                                                    <td>{{ $value->PartyName }}</td>
                                                    <td>{{ $value->TRN }}</td>
                                                    <td>{{ $value->Address }}</td>
                                                    <td>{{ $value->City }}</td>
                                                    <td>{{ $value->Phone }}</td>
                                                    <td>{{ $value->Email }}</td>
                                                    <td>
                                                        <div class="d-flex gap-1">
                                                            <a class="btn btn-sm btn-secondary" href="{{ URL('/PartiesEdit/' . $value->PartyID) }}"
                                                                class="text-secondary"><i
                                                                    class="mdi mdi-pencil"></i></a>
                                                            @if (count($value->invoiceMaster) == 0)
                                                                <a class="btn btn-sm btn-danger" href="#" class="text-secondary"
                                                                    onclick="delete_confirm2('PartiesDelete',{{ $value->PartyID }})"><i
                                                                        class="mdi mdi-delete"></i></a>
                                                            @endif

                                                        </div>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
            $('#student_table').DataTable();
        });
    </script>
@endpush
