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
                <div class="row mb-2">
                    <div class="col-6">
                        <h4 class="card-title ">Add Customer Details</h4>
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{ url('Parties') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
                <form action="{{ URL('/SaveParties') }}" method="post">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            {{ csrf_field() }}
                            <div>
                                <p class="card-title-desc"></p>
                                <div class="mb-2 row">
                                    <label for="example-url-input" class="col-md-2 col-form-label fw-bold">Party
                                        Name</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" value="{{ old('PartyName') }}"
                                            name="PartyName" required>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label for="example-url-input" class="col-md-2 col-form-label fw-bold text-danger">TRN
                                        #</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="TRN"
                                            value="{{ old('TRN') }}">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label for="example-url-input" class="col-md-2 col-form-label fw-bold">Address</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="Address"
                                            value="{{ old('Address') }}">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label for="example-url-input"
                                        class="col-md-2 col-form-label fw-bold text-danger">City</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="City"
                                            value="{{ old('City') }}">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label for="tel" class="col-md-2 col-form-label fw-bold">Mobile</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="tel" name="Mobile"
                                            value="{{ old('Mobile') }}">
                                    </div>
                                </div>
                                {{-- <div class="mb-2 row">
                                    <label for="example-url-input" class="col-md-2 col-form-label fw-bold">Phone</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="Phone"
                                            value="{{ old('Phone') }}">
                                    </div>
                                </div> --}}
                                <div class="mb-2 row">
                                    <label for="example-url-input" class="col-md-2 col-form-label fw-bold">Email</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="Email"
                                            value="{{ old('Email') }}">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label for="example-url-input" class="col-md-2 col-form-label fw-bold">Website <small class="text-info fw-medium">(if any)</small></label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="Website"
                                            value="{{ old('Website') }}">
                                    </div>
                                </div>
                                {{-- <div class="mb-2 row">
                                    <label for="example-url-input" class="col-md-2 col-form-label fw-bold">Invoice Due
                                        Days</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="number" name="InvoiceDueDays"
                                            value="{{ old('InvoiceDueDays') }}">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <label for="example-tel-input" class="col-md-2 col-form-label fw-bold">Active</label>
                                    <div class="col-md-4">
                                        <select name="Active" class="form-select">
                                            <option value="Yes"
                                                {{ old('Active') == 'Yes' ? 'selected=selected' : '' }}>Yes</option>
                                            <option value="No" {{ old('Active') == 'No' ? 'selected=selected' : '' }}>
                                                No</option>
                                        </select>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="card-footer  ">
                            <button type="submit"
                                class="btn btn-primary me-1 waves-effect waves-float waves-light">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
