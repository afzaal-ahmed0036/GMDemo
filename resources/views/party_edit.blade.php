@extends('template.tmp')
@section('title', $pagetitle)
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        @if (session('error'))
                            <div class="alert alert-{{ Session::get('class') }} p-1" id="success-alert">

                                {{ Session::get('error') }}
                            </div>
                        @endif

                        @if (count($errors) > 0)

                            <div>
                                <div class="alert alert-danger p-2 border-1">
                                    <p class="font-weight-bold"> There were some problems with your input.</p>
                                    <ul>

                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                        @endif


                        <div class="card shadow-sm ">
                            <div class="card-body">
                                <form action="{{ URL('/PartiesUpdate') }}" method="post">
                                    {{ csrf_field() }}

                                    <input type="hidden" name="PartyID" value="{{ $supplier->PartyID }}">
                                    <div>
                                        <div>

                                            <h4 class="card-title">Update Party / Customer</h4>
                                            <p class="card-title-desc"></p>



                                            <?php
                                            $PartyName = old('PartyName') ? old('PartyName') : $supplier->PartyName;
                                            $TRN = old('TRN') ? old('TRN') : $supplier->TRN;
                                            $City = old('City') ? old('City') : $supplier->City;
                                            $Address = old('Address') ? old('Address') : $supplier->Address;
                                            $Mobile = old('Mobile') ? old('Mobile') : $supplier->Mobile;
                                            $Phone = old('Phone') ? old('Phone') : $supplier->Phone;
                                            $Email = old('Email') ? old('Email') : $supplier->Email;
                                            $Website = old('Website') ? old('Website') : $supplier->Website;
                                            $InvoiceDueDays = old('InvoiceDueDays') ? old('InvoiceDueDays') : $supplier->InvoiceDueDays;
                                            $Active = old('Active') ? old('Active') : $supplier->Active;

                                            ?>





                                            <div class="mb-2 row">
                                                <label for="example-url-input"
                                                    class="col-md-2 col-form-label fw-bold">Customer Name</label>
                                                <div class="col-md-4">
                                                    <input class="form-control" type="text" value="{{ $PartyName }}"
                                                        name="PartyName">
                                                </div>

                                            </div>

                                            <div class="mb-2 row">
                                                <label for="example-url-input" class="col-md-2 col-form-label fw-bold">TRN #
                                                </label>
                                                <div class="col-md-4">
                                                    <input class="form-control" type="text" value="{{ $TRN }}"
                                                        name="TRN">
                                                </div>

                                            </div>




                                            <div class="mb-2 row">
                                                <label for="example-url-input"
                                                    class="col-md-2 col-form-label fw-bold">Address</label>
                                                <div class="col-md-4">
                                                    <input class="form-control" type="text" name="Address"
                                                        value="{{ $Address }}">
                                                </div>

                                            </div>

                                            <div class="mb-2 row">
                                                <label for="example-url-input" class="col-md-2 col-form-label fw-bold">City
                                                </label>
                                                <div class="col-md-4">
                                                    <input class="form-control" type="text" value="{{ $City }}"
                                                        name="City">
                                                </div>

                                            </div>

                                            <div class="mb-2 row">
                                                <label for="example-url-input"
                                                    class="col-md-2 col-form-label fw-bold">Mobile</label>
                                                <div class="col-md-4">
                                                    <input class="form-control" type="text" name="Mobile"
                                                        value="{{ $Mobile }}">
                                                </div>

                                            </div>


                                            <div class="mb-2 row">
                                                <label for="example-url-input"
                                                    class="col-md-2 col-form-label fw-bold">Phone</label>
                                                <div class="col-md-4">
                                                    <input class="form-control" type="text" name="Phone"
                                                        value="{{ $Phone }}">
                                                </div>

                                            </div>

                                            <div class="mb-2 row">
                                                <label for="example-url-input"
                                                    class="col-md-2 col-form-label fw-bold">Email</label>
                                                <div class="col-md-4">
                                                    <input class="form-control" type="text" name="Email"
                                                        value="{{ $Email }}">
                                                </div>

                                            </div>

                                            <div class="mb-2 row">
                                                <label for="example-url-input"
                                                    class="col-md-2 col-form-label fw-bold">Website</label>
                                                <div class="col-md-4">
                                                    <input class="form-control" type="text" name="Website"
                                                        value="{{ $Website }}">
                                                </div>

                                            </div>



                                            <div class="mb-2 row">
                                                <label for="example-url-input"
                                                    class="col-md-2 col-form-label fw-bold">Invoice Due Days</label>
                                                <div class="col-md-4">
                                                    <input class="form-control" type="number" name="InvoiceDueDays"
                                                        value="{{ $InvoiceDueDays }}">
                                                </div>

                                            </div>

                                            <div class="mb-1 row">
                                                <label for="example-tel-input"
                                                    class="col-md-2 col-form-label fw-bold">Active</label>
                                                <div class="col-md-4">
                                                    <select name="Active" class="form-select">


                                                        <option value="Yes"
                                                            {{ $Active == 'Yes' ? 'selected=selected' : '' }}>Yes</option>
                                                        <option value="No"
                                                            {{ $Active == 'No' ? 'selected=selected' : '' }}>No</option>




                                                    </select>
                                                </div>
                                            </div>














                                        </div>

                                    </div>







                            </div>
                            <div class="card-footer  ">
                                <button type="submit"
                                    class="btn btn-primary me-1 waves-effect waves-float waves-light">Update</button>




                                <a href="{{ URL('/Parties') }}" class="btn btn-outline-secondary waves-effect">Cancel</a>
                            </div>
                        </div>
                        <!-- card end here -->
                        </form>



                    </div>
                </div>

            </div>
        </div>
    </div>
