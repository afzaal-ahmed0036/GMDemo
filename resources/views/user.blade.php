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
                <div class="card">
                    <div class="card-body">
                        <form action="{{ URL('/UserSave') }}" method="post">
                            {{ csrf_field() }}
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Add New User</h4>
                                    <p class="card-title-desc"></p>
                                    <div class="mb-1 row">
                                        <div class="col-6">
                                            <label for="example-email-input" class="fw-bold">Full
                                                Name</label>
                                            <input class="form-control" type="text" value="{{ old('FullName') }}"
                                                name="FullName" id="example-email-input" required>
                                        </div>
                                        <div class="col-6">
                                            <label for="example-url-input" class="fw-bold">Username</label>
                                            <input class="form-control" type="text" value="{{ old('Email') }}"
                                                name="Email" required>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <div class="col-6">
                                            <label for="example-tel-input" class="fw-bold">Password</label>
                                            <input class="form-control" type="text" name="Password"
                                                value="{{ old('Password') }}" required>
                                        </div>
                                        <div class="col-6">
                                            <label for="example-tel-input" class="fw-bold">Address</label>
                                            <input class="form-control" type="text" value="{{ old('Address') }}"
                                                name="Address">
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <div class="col-6">
                                            <label for="example-tel-input" class="fw-bold">Phone Number</label>
                                            <input class="form-control" type="text" value="{{ old('Mobile') }}"
                                                name="Mobile">
                                        </div>
                                        <div class="col-6">
                                            <label for="example-tel-input" class="fw-bold">User Type</label>
                                            <select name="UserType" class="form-select">
                                                <option value="Admin">Admin</option>
                                                {{-- <option value="User">User</option> --}}
                                                <option value="Biller">Biller</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-1 row">
                                        <div class="col-6">
                                            <label for="example-tel-input" class="fw-bold">Warehouse</label>
                                            <select name="WarehouseID" class="form-select">
                                                @foreach ($warehouse_list as $warehouse)
                                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="example-tel-input" class="fw-bold">Active</label>
                                            <select name="Active" class="form-select">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12 d-flex justify-content-end">
                                            <input type="submit" class="btn btn-primary w-md">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title ">Manage Users</h4>
                                <div class="table-responsive">
                                    <table class="table  m-0" class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Full Name</th>
                                                <th>Username</th>
                                                <th>Password</th>
                                                <th>Address</th>
                                                <th>Mobile</th>
                                                <th>User Type</th>
                                                <th>Warehouse</th>
                                                <th>Created on</th>
                                                <th>Active</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            @foreach ($user as $value)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td scope="row">{{ $value->FullName }}</td>
                                                    <td>{{ $value->Email }}</td>
                                                    <td>*********</td>
                                                    <td>{{ $value->Address }}</td>
                                                    <td>{{ $value->Mobile }}</td>
                                                    <td>{{ $value->UserType }}</td>
                                                    <td>{{ $value->warehouseName ? $value->warehouseName : 'N/A' }}</td>
                                                    <td>{{ $value->eDate }}</td>
                                                    <td>{{ $value->Active }}</td>
                                                    <td>
                                                        <div class="d-flex gap-1">
                                                            <a href="{{ URL('/UserEdit/' . $value->UserID) }}"
                                                                class="text-secondary"><i
                                                                    class="mdi mdi-pencil font-size-15"></i></a>
                                                            <a href="#"
                                                                onclick="delete_confirm2('UserDelete',{{ $value->UserID }});"
                                                                class="text-secondary"><i
                                                                    class="mdi mdi-delete font-size-15"></i></a>
                                                            <a href="{{ URL('/checkUserRole/' . $value->UserID) }}"
                                                                class="text-secondary"><i
                                                                    class="fas fa-user-lock
                                font-size-12"></i></a>
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
    </div>
    </div>
    </div>
@endpush
