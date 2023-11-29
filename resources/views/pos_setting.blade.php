@extends('template.tmp')
@section('title', 'POS Setting')
@section('content')
 <div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <!-- <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">POS Setting</h4>

                        <div class="page-title-right">
                             <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBrandModal">Add Brand</button>
                        </div>

                    </div>
                </div>
            </div> -->
            <!-- end page title -->
            <div class="row">
                <div class="col-xl-12">
                     @if (session('error'))
                        <div class="alert alert-{{ Session::get('class') }} p-3">
                                        
                                      <strong>{{ Session::get('error') }} </strong>
                                    </div>
                    @endif

                    @if (count($errors) > 0) 
                        <div >
    <div class="alert alert-danger pt-3 pl-0   border-3 bg-danger text-white">
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
                <div class="card-header d-flex align-items-center">
                    <h4>{{trans('file.POS Setting')}}</h4>
                </div>
                <div class="card-body">
                    <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                    <form action="{{route('setting.posStore')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Default Customer')}} *</label>
                                    @if($lims_pos_setting_data)
                                    <input type="hidden" name="customer_id_hidden" value="{{$lims_pos_setting_data->customer_id}}">
                                    @endif
                                    <select required name="customer_id" id="customer_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select customer...">
                                        @foreach($lims_customer_list as $customer)
                                        <option value="{{$customer->PartyID}}" {{$lims_pos_setting_data->customer_id == $customer->PartyID ? 'selected':''}}>{{$customer->PartyName . ' (' . $customer->Phone . ')'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Default Supplier *</label>
                                    <select required name="supplier_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select supplier...">
                                        @foreach($lims_supplier_list as $supplier)
                                        <option value="{{$supplier->SupplierID}}" {{$lims_pos_setting_data->supplier_id == $supplier->SupplierID ? 'selected': ''}}>{{$supplier->SupplierName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Stripe Publishable key</label>
                                    <input type="text" name="stripe_public_key" class="form-control" value="@if($lims_pos_setting_data){{$lims_pos_setting_data->stripe_public_key}}@endif" required />
                                </div>
                                <div class="form-group">
                                    <label>Paypal Pro API Username</label>
                                    <input type="text" name="paypal_username" class="form-control" value="{{env('PAYPAL_SANDBOX_API_USERNAME')}}" />
                                </div>
                                <div class="form-group">
                                    <label>Paypal Pro API Signature</label>
                                    <input type="text" name="paypal_signature" class="form-control" value="{{env('PAYPAL_SANDBOX_API_SECRET')}}" />
                                </div>
                                
                                <div class="form-group mt-3">
                                    <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Default Warehouse')}} *</label>
                                    <select required name="warehouse_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select warehouse...">
                                        @foreach($lims_warehouse_list as $warehouse)
                                        <option value="{{$warehouse->id}}" {{$lims_pos_setting_data->warehouse_id == $warehouse->id ? 'selected': ''}}>{{$warehouse->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>{{trans('file.Displayed Number of Product Row')}} *</label>
                                    <input type="number" name="product_number" class="form-control" value="@if($lims_pos_setting_data){{$lims_pos_setting_data->product_number}}@endif" required />
                                </div>
                                <div class="form-group">
                                    <label>Stripe Secret key *</label>
                                    <input type="text" name="stripe_secret_key" class="form-control" value="@if($lims_pos_setting_data){{$lims_pos_setting_data->stripe_secret_key}}@endif"required />
                                </div>
                                <div class="form-group">
                                    <label>Paypal Pro API Password</label>
                                    <input type="password" name="paypal_password" class="form-control" value="{{env('PAYPAL_SANDBOX_API_PASSWORD')}}" />
                                </div>
                                <div class="form-group">
                                    <label>Enable/Disable Dish</label>
                                    <select class="form-control form-select" name="is_dish_enabled">
                                        <option value="1" {{$lims_pos_setting_data->is_dish_enabled == 1 ? 'selected' : ''}}>Enable</option>
                                        <option value="0" {{$lims_pos_setting_data->is_dish_enabled == 0 ? 'selected' : ''}}>Disable</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    @if($lims_pos_setting_data && $lims_pos_setting_data->keybord_active)
                                    <input class="mt-2" type="checkbox" name="keybord_active" value="1" checked>
                                    @else
                                    <input class="mt-2" type="checkbox" name="keybord_active" value="1">
                                    @endif
                                    <label class="mt-2"><strong>{{trans('file.Touchscreen keybord')}}</strong></label>
                                </div>
                            </div>                              
                        </div>
                    </form>
                </div>
                </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->  
        </div> <!-- container-fluid -->
    </div>
 <script type="text/javascript">
     $(document).ready(function(){


     });
 </script>   
@endsection