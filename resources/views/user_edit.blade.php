@extends('template.tmp')
@section('title', $pagetitle)
@section('content')
<div class="main-content">
<div class="page-content">
<div class="container-fluid">
    @if (session('error'))
    <div class="alert alert-{{ Session::get('class') }} p-3" id="success-alert">
    {{ Session::get('error') }}
    </div>
    @endif
    @if (count($errors) > 0)                                 
    <div>
        <div class="alert alert-danger pt-3 pl-0   border-3">
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
            <form action="{{URL('/UserUpdate')}}" method="post">
            {{csrf_field()}}
            <h4 class="card-title">Update User</h4>
            <p class="card-title-desc"></p>
            <input type="hidden" name="UserID" value="{{$v_users[0]->UserID}}">
            <div class="mb-3 row">
                <label for="example-email-input" class="col-md-2 col-form-label">Full Name</label>
                <div class="col-md-10">
                <input class="form-control" type="text"   name="FullName" id="example-email-input" value="{{$v_users[0]->FullName}}">
                </div>
            </div>
            <div class="mb-3 row">
            <label for="example-url-input" class="col-md-2 col-form-label">Username</label>
            <div class="col-md-10">
            <input class="form-control" type="text"  name="Email" required value="{{$v_users[0]->Email}}">
            </div>
            </div>
            <div class="mb-3 row">
                <label for="example-url-input" class="col-md-2 col-form-label">Password</label>
                <div class="col-md-10">
                <input class="form-control" type="text"  name="Password" required value="{{$v_users[0]->Password}}">
                </div>
            </div>
            <div class="mb-1 row">
                <label for="example-url-input" class="col-md-2 col-form-label fw-bold">Address</label>
                <div class="col-md-10">
                <input class="form-control" type="text"  name="Address"  value="{{$v_users[0]->Address}}">
                </div>
            </div>
            <div class="mb-1 row">
                <label for="example-url-input" class="col-md-2 col-form-label fw-bold">Mobile</label>
                <div class="col-md-10">
                <input class="form-control" type="text"   name="Mobile"  value="{{$v_users[0]->Mobile}}">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="example-tel-input" class="col-md-2 col-form-label">User Type</label>
                <div class="col-md-10">
                    <select name="UserType" class="form-select">
                         <option value="Admin" {{($v_users[0]->UserType == 'Admin' ) ? 'selected=selected':'' }}>Admin</option>
                        <option value="User" {{($v_users[0]->UserType == 'User' ) ? 'selected=selected':'' }}>User</option>
                        <option value="Biller" {{($v_users[0]->UserType == 'Biller' ) ? 'selected=selected':'' }}>Biller</option>
                    </select>
                </div>
            </div>
            <div class="mb-1 row">
                <label for="example-tel-input" class="col-md-2 col-form-label fw-bold">Warehouse</label>
                <div class="col-md-10">
                <select name="WarehouseID" class="form-select">
                    @foreach($warehouse_list as $warehouse)
                        <option value="{{$warehouse->id}}" {{($v_users[0]->WarehouseID == $warehouse->id ) ? 'selected=selected':'' }}>{{$warehouse->name}}</option>
                    @endforeach
                </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="example-tel-input" class="col-md-2 col-form-label">Active</label>
                <div class="col-md-10">
                    <select name="Active" class="form-select">
                    <option value="Yes" {{($v_users[0]->Active == 'Yes' ) ? 'selected=selected':'' }}>Yes</option>
                    <option value="No" {{($v_users[0]->Active == 'No' ) ? 'selected=selected':'' }}>No</option>
                    </select>
                </div>
            </div>
            <input type="submit" class="btn btn-primary w-md" value="Update">  
            <a href="{{URL('/User')}}" class="btn btn-secondary w-md">Cancel</a>
        </form>
        </div>
    </div>
</div>
</div>
</div>
@endsection