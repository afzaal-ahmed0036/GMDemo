@extends('template.top-head')
@section('title', 'Edit Voucher')
@section('content')
    @if (session('error'))
        <div class="alert alert-{{ Session::get('class') }} p-1" id="success-alert">
            <strong>{{ Session::get('error') }} </strong>
        </div>
    @endif
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}
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

    <section class="forms pos-section">
        <div class="container-fluid">
            <div class="row">
                <audio id="mysoundclip1" preload="auto">
                    <source src="{{ asset('beep/beep-timber.mp3') }}">
                    </source>
                </audio>
                <audio id="mysoundclip2" preload="auto">
                    <source src="{{ asset('beep/beep-07.mp3') }}">
                    </source>
                </audio>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body" style="padding-bottom: 0">
                            <form action="{{ route('teqInvoice.update', ['id' => $lims_sale_data->InvoiceMasterID]) }}"
                                method="post" class="payment-form">
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                @php
                                    if ($lims_pos_setting_data) {
                                        $keybord_active = $lims_pos_setting_data->keybord_active;
                                    } else {
                                        $keybord_active = 0;
                                    }
                                @endphp
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="text" name="invoice_no" value="{{ $invoice_no }}"
                                                        id="invoice_no" readonly class="form-control" />
                                                    <input type="hidden" name="GiftInvoice" id="GiftInvoice"
                                                        class="form-control" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="date" name="invoice_date" id="invoice_date"
                                                        class="form-control"
                                                        value="{{ isset($lims_sale_data->Date) ? \Carbon\Carbon::parse($lims_sale_data->Date)->format('Y-m-d') : date('Y-m-d') }}" />
                                                </div>
                                            </div>
                                            <div class="col-md-4" style="display: none;">
                                                <div class="form-group">
                                                    <input type="text" id="reference-no" name="reference_no"
                                                        class="form-control" placeholder="Type reference number"
                                                        onkeyup='saveValue(this);' />
                                                </div>
                                                @if ($errors->has('reference_no'))
                                                    <span>
                                                        <strong>{{ $errors->first('reference_no') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    @if ($lims_pos_setting_data)
                                                        <input type="hidden" name="warehouse_id_hidden"
                                                            id="warehouse_id_hidden"
                                                            value="{{ $lims_pos_setting_data->warehouse_id }}">
                                                    @endif
                                                    <select required id="warehouse_id" name="warehouse_id"
                                                        class="selectpicker form-control" data-live-search="true"
                                                        data-live-search-style="begins" title="Select warehouse...">
                                                        @foreach ($lims_warehouse_list as $warehouse)
                                                            <option value="{{ $warehouse->id }}"
                                                                {{ isset($lims_sale_data->WarehouseID) ? ($lims_sale_data->WarehouseID == $warehouse->id ? 'selected' : '') : '' }}>
                                                                {{ $warehouse->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    @if ($lims_pos_setting_data)
                                                        <input type="hidden" name="biller_id_hidden" id="biller_id_hidden"
                                                            value="{{ $lims_pos_setting_data->biller_id }}">
                                                    @endif
                                                    @if (Session::get('UserType') == 'Biller')
                                                        <select required id="biller_id" name="biller_id"
                                                            class="form-control">
                                                            <option value="{{ Session::get('UserID') }}" selected>
                                                                {{ Session::get('FullName') }}</option>
                                                        </select>
                                                    @else
                                                        <select required id="biller_id" name="biller_id"
                                                            class="selectpicker form-control" data-live-search="true"
                                                            data-live-search-style="begins">
                                                            @foreach ($lims_biller_list as $biller)
                                                                <option value="{{ $biller->UserID }}"
                                                                    @if ($biller->UserID == $lims_sale_data->UserID) selected @endif>
                                                                    {{ $biller->FullName }}</option>
                                                            @endforeach
                                                        </select>
                                                    @endif
                                                </div>
                                            </div>
                                            @if ($lims_pos_setting_data->is_dish_enabled == 1)
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <select id="dish_table_id" name="dish_table_id"
                                                            class="selectpicker form-control" data-live-search="true"
                                                            data-live-search-style="begins" title="Take Away...">
                                                            @foreach ($dish_tables as $dish_table)
                                                                <option value="{{ $dish_table->id }}">
                                                                    {{ $dish_table->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    @if ($lims_pos_setting_data)
                                                        <input type="hidden" name="customer_id_hidden"
                                                            id="customer_id_hidden"
                                                            value="{{ $lims_pos_setting_data->customer_id }}">
                                                    @endif
                                                    <div class="input-group pos">
                                                        <select required name="customer_id" id="customer_id"
                                                            class="selectpicker form-control" data-live-search="true"
                                                            style="width: 100px">
                                                            <?php $deposit = []; ?>
                                                            @foreach ($lims_customer_list as $customer)
                                                                @php $deposit[$customer->PartyID] = $customer->Deposit - $customer->Expense; @endphp
                                                                <option value="{{ $customer->PartyID }}"
                                                                    {{ isset($lims_sale_data->PartyID) ? ($lims_sale_data->PartyID == $customer->PartyID ? 'selected' : '') : '' }}>
                                                                    {{ @$customer->PartyName . ' (' . @$customer->Mobile . ')' }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <button type="button" class="btn btn-default btn-sm"
                                                            data-toggle="modal" data-target="#addCustomer"><i
                                                                class="dripicons-plus"></i></button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mt-2">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="servingType"
                                                        id="servingTypePick" value="pickup"
                                                        {{ $lims_sale_data->DeliveryAddress == null && $lims_sale_data->driverName == null ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="servingTypePick">
                                                        PickUp
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="servingType"
                                                        id="servingTypeDeliver" value="delivery"
                                                        {{ $lims_sale_data->DeliveryAddress != null && $lims_sale_data->driverName != null ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="servingTypeDeliver">
                                                        Delivery
                                                    </label>
                                                    <button type="button"
                                                        class="btn btn-sm {{ $lims_sale_data->DeliveryAddress != null && $lims_sale_data->driverName != null ? '' : 'd-none' }}"
                                                        id="changeDelivery"><i class="fa fa-edit"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="search-box form-group col-md-12 mb-0">
                                                <div class="form-group">
                                                    <input type="text" name="product_code_name"
                                                        id="lims_productcodeSearch"
                                                        placeholder="Scan/Search product by name/code"
                                                        class="form-control" />
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row p-2 d-none" id="limsSearchedDiv"
                                            style="position: absolute; z-index:9999;top:130px;width:100%;">
                                            <div class="col-md-12 bg-primary rounded pt-3" id="limsSearchedCol">
                                                {{-- <a href="" class="" style="text-decoration: none; color:white">new</a> --}}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="table-responsive transaction-list">
                                                <table id="myTable"
                                                    class="table table-hover table-striped order-list table-fixed">
                                                    <thead>
                                                        <tr>
                                                            <th class="col-sm-4">{{ trans('file.product') }}</th>
                                                            <!-- <th class="col-sm-1">{{ trans('No') }}</th> -->
                                                            <th class="col-sm-2">{{ trans('file.Price') }}</th>
                                                            <th class="col-sm-3">{{ trans('file.Quantity') }}</th>
                                                            <th class="col-sm-2">{{ trans('file.Subtotal') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbody-id">
                                                        @foreach ($lims_product_sale_data as $product_sale_data)
                                                            <tr>
                                                                <input type="hidden" class="product_id"
                                                                    name="product_id[]"
                                                                    value="{{ $product_sale_data->ItemID }}">
                                                                <td class="col-sm-4">
                                                                    <button type="button"
                                                                        class="edit-product btn btn-link"
                                                                        data-id="{{ $product_sale_data->ItemID }}"
                                                                        data-toggle="modal"
                                                                        data-target="#editModal"><strong>{{ $product_sale_data->ItemName }}</strong>
                                                                    </button><br><span
                                                                        class="ItemCod">{{ $product_sale_data->ItemCode }}</span>
                                                                    <a type="button"
                                                                        data-id="{{ $product_sale_data->ItemID }}"
                                                                        class="btn-topping btn btn-sm" data-toggle="modal"
                                                                        title="Extra-Topping" data-target="#toppingModal">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                    <p>In Stock: <span class="in-stock"></span></p>
                                                                </td>
                                                                <td class="col-sm-2 sellingPrice">
                                                                    <input name="itemChangedRate[]" class="form-control"
                                                                        type="text" readonly
                                                                        value="{{ $product_sale_data->Rate + ($product_sale_data->SellingPrice * (float) $product_sale_data->Percentage) / 100 }}">

                                                                </td>
                                                                <td class="col-sm-3">
                                                                    <div class="input-group"><span
                                                                            class="input-group-btn"><button type="button"
                                                                                class="btn btn-default minus"><span
                                                                                    class="dripicons-minus"></span></button></span><input
                                                                            type="text" name="qty[]"
                                                                            class="form-control qty numkey input-number"
                                                                            step="any" required
                                                                            value="{{ $product_sale_data->Qty }}"><span
                                                                            class="input-group-btn"><button type="button"
                                                                                class="btn btn-default plus"><span
                                                                                    class="dripicons-plus"></span></button></span>
                                                                    </div>
                                                                </td>
                                                                <td class="col-sm-2 itemSubTotal">
                                                                    {{ $product_sale_data->Total }}</td>
                                                                <td class="col-sm-1"><button type="button"
                                                                        class="ibtnDel btn btn-danger btn-sm"><i
                                                                            class="dripicons-cross"></i></button></td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row" style="display: none;">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input type="hidden" name="total_qty" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input type="hidden" name="total_discount" value="0.00" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input type="hidden" name="total_tax" value="0.00" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input type="hidden" name="total_price" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input type="hidden" name="item" />
                                                    <input type="hidden" name="order_tax" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input type="hidden" name="grand_total" />
                                                    <input type="hidden" name="total" id="total" />
                                                    <input type="hidden" name="coupon_discount" />
                                                    <input type="hidden" name="sale_status" value="1" />
                                                    <input type="hidden" name="coupon_active">
                                                    <input type="hidden" name="coupon_id">
                                                    <input type="hidden" name="coupon_discount" />
                                                    <input type="text" name="DiscountPer" />

                                                    <input type="hidden" name="pos" value="1" />
                                                    <input type="hidden" name="draft" value="0" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 totals"
                                            style="border-top: 2px solid #e4e6fc; padding-top: 10px;">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <span class="totals-title">{{ trans('file.Items') }}</span><span
                                                        id="item">{{ $lims_sale_data->TotalQty }}</span>
                                                </div>

                                                <div class="col-sm-4">
                                                    <span class="totals-title"><span
                                                            id="totals-title">{{ trans('file.Discount') }}</span> <button
                                                            type="button" class="btn btn-link btn-sm"
                                                            data-toggle="modal" data-target="#order-discount-modal"> <i
                                                                class="dripicons-document-edit"></i></button></span><span
                                                        id="discount">{{ $lims_sale_data->DiscountAmount != null ? $lims_sale_data->DiscountAmount : '0.00' }}</span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <span class="totals-title">{{ trans('file.Shipping') }} <button
                                                            type="button" class="btn btn-link btn-sm"
                                                            data-toggle="modal" data-target="#shipping-cost-modal"><i
                                                                class="dripicons-document-edit"></i></button></span><span
                                                        id="shipping-cost">{{ $lims_sale_data->Shipping != null ? $lims_sale_data->Shipping : '0.00' }}</span>
                                                </div>
                                                {{-- <div class="col-sm-4">
                                                    <span class="totals-title">{{ trans('file.Coupon') }} <button
                                                            type="button" class="btn btn-link btn-sm"
                                                            data-toggle="modal" data-target="#coupon-modal"><i
                                                                class="dripicons-document-edit"></i></button></span><span
                                                        id="coupon-text">0.00</span>
                                                </div> --}}

                                                <div class="col-sm-4">
                                                    <span class="totals-title">{{ trans('file.Total') }}</span><span
                                                        id="subtotal">{{ $lims_sale_data->Total }}</span>
                                                </div>

                                                <div class="col-sm-4">
                                                    <span class="totals-title">{{ trans('file.Tax') }} <button
                                                            type="button" class="btn btn-link btn-sm"
                                                            data-toggle="modal" data-target="#order-tax"><i
                                                                class="dripicons-document-edit"></i></button></span><span
                                                        id="tax">{{ $lims_sale_data->Tax }}</span>
                                                </div>



                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="payment-amount">
                            <h2>{{ trans('file.grand total') }} <span
                                    id="grand-total">{{ $lims_sale_data->GrandTotal }}</span></h2>
                        </div>

                        <div class="payment-options">
                            @if ($lims_sale_data->sale_status == 1)
                                <div class="column-5">
                                    <button style="background-color: #00b187" type="button" class="btn btn-custom"
                                        id="payment-btn" data-toggle="modal" data-target="#add-payment"><i
                                            class="fa fa-money"></i>Update</button>
                                </div>
                            @endif

                            @if ($lims_sale_data->sale_status == 3)
                                <div class="column-5">
                                    <button style="background-color: #00cec9" type="button" class="btn btn-custom"
                                        id="draft-btn" data-toggle="modal" data-target="#add-partial-payment"><i
                                            class="dripicons-flag"></i>
                                        Update</button>
                                </div>
                                <div class="column-5">
                                    <button style="background-color: #00cec9" type="button" class="btn btn-custom"
                                        id="payment-btn" data-toggle="modal" data-target="#add-payment"><i
                                            class="fa fa-money"></i>Complete Order</button>
                                </div>
                            @endif
                            <div class="column-5">
                                <a href="{{ url('create-voucher') }}" style="background-color: #d63031;"
                                    class="btn btn-custom" id="cancel-btn"><i class="fa fa-close"></i>
                                    Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- order_discount modal -->

                <div id="order-discount-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ trans('file.Order Discount') }}</h5>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                        aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                            </div>
                            <div class="modal-body">

                                <p>Please select:</p>
                                <input type="radio" id="disc_number" name="discount_model" value="number"
                                    autocomplete="off" {{ $lims_sale_data->DiscountModel == 'number' ? 'checked' : '' }}>
                                <label for="disc_percent">Number</label><br>

                                <input type="radio" id="disc_percent" name="discount_model" value="percentage"
                                    autocomplete="off"
                                    {{ $lims_sale_data->DiscountModel == 'percentage' ? 'checked' : '' }}>
                                <label for="disc_number">%</label><br>

                                <div class="form-group">
                                    <input type="number" name="order_discount" class="form-control numkey"
                                        id="order-discount"
                                        value="{{ $lims_sale_data->DiscountModel == 'percentage' ? $lims_sale_data->DiscountPer : $lims_sale_data->DiscountAmount }}">
                                </div>
                                <button type="button" name="order_discount_btn" id="order_discount_btn"
                                    class="btn btn-primary" data-dismiss="modal">{{ trans('file.submit') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- order_tax modal -->
                <div id="order-tax" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ trans('file.Order Tax') }}</h5>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                        aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="hidden" name="order_tax_rate">
                                    <input type="hidden" name="order_tax_id">
                                    <select class="form-control" name="order_tax_rate_select" id="order-tax-rate-select">
                                        @foreach ($lims_tax_list as $tax)
                                            <option value="{{ $tax->rate }}"
                                                @if ($lims_sale_data->TaxPer == $tax->rate) selected="selected" @endif
                                                data-id="{{ $tax->id }}" data-value="{{ $tax->name }}">
                                                {{ $tax->name }}</option>
                                        @endforeach
                                        <option value="0" data-value="No Tax"
                                            {{ $lims_sale_data->TaxPer == 0 ? 'selected' : '' }}>No Tax</option>
                                    </select>
                                </div>
                                <button type="button" id="order_tax_btn" name="order_tax_btn" class="btn btn-primary"
                                    data-dismiss="modal">{{ trans('file.submit') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- shipping_cost modal -->
                <div id="shipping-cost-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ trans('file.Shipping Cost') }}</h5>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                        aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="number" name="shipping_cost" class="form-control numkey"
                                        id="shipping-cost-val" step="any" value="{{ $lims_sale_data->Shipping }}">
                                </div>
                                <button type="button" name="shipping_cost_btn" id="shipping_cost_btn"
                                    class="btn btn-primary" data-dismiss="modal">{{ trans('file.submit') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="delivery-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delivery Address</h5>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                        aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="">Select City</label>
                                    <select name="delivery_state_shipping" id="delivery_state_shipping"
                                        class="form-control">
                                        <option value="0" selected>--Select One--</option>
                                        <option value="35">Sharjah Near (Shipping : AED 35)</option>
                                        <option value="50">Sharjah Far (Shipping : AED 50)</option>
                                        <option value="35">Ajman (Shipping : AED 35)</option>
                                        <option value="50">Dubai (Shipping : AED 50)</option>
                                        <option value="50">Abu Dhabi (Shipping : AED 50)</option>
                                        <option value="50">Ras Al-Khaimah (Shipping : AED 50)</option>
                                        <option value="50">Umm Al Quwain (Shipping : AED 50)</option>
                                        <option value="50">Fujairah (Shipping : AED 50)</option>
                                        <option value="50">Al Ain (Shipping : AED 50)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Address</label>
                                    <input type="text" name="DeliveryAddress" class="form-control"
                                        value="{{ $lims_sale_data->DeliveryAddress }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Driver Name</label>
                                    <input type="text" name="driverName" class="form-control"
                                        value="{{ $lims_sale_data->driverName }}">
                                </div>
                                <button type="button" name="add_delivery_btn" class="btn btn-primary"
                                    data-dismiss="modal">Done</button>
                            </div>
                        </div>
                    </div>
                </div>

                </form>
                <!-- product list -->
                <div class="col-md-6">
                    <!-- navbar-->

                    <header class="header">
                        <nav class="navbar">
                            <div class="container-fluid">
                                <div class="navbar-holder d-flex align-items-center justify-content-between">
                                    <!-- <a id="toggle-btn" href="#" class="menu-btn"><i class="fa fa-bars"> </i></a> -->
                                    @if (Session::get('UserType') == 'Biller')
                                        <a href="#" class="menu-btn"><i class="fa fa-bars"></i></a>
                                    @else
                                        <a href="{{ url('invoice-listing') }}" class="menu-btn"><i
                                                class="fa fa-bars"></i></a>
                                    @endif
                                    <div class="navbar-header">

                                        <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                                            <li class="nav-item"><a id="btnFullscreen" title="Full Screen"><i
                                                        class="dripicons-expand"></i></a></li>
                                            {{-- <li class="nav-item" id="notification-icon">
                                                <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false"
                                                    class="nav-link dropdown-item"><i class="dripicons-bell"></i><span
                                                        class="badge badge-danger notification-number"></span>
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </a>
                                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default notifications"
                                                    user="menu">
                                                    <li class="notifications">
                                                        <a href="" class="btn btn-link">product exceeds alert
                                                            quantity</a>
                                                    </li>
                                                    <li class="notifications">
                                                        <a href="#" class="btn btn-link">notification</a>
                                                    </li>

                                                </ul>
                                            </li> --}}
                                            {{-- <a href="" id="register-details-btn" data-toggle="tooltip"
                                                title="" data-original-title="Cash Register Details"><i
                                                    class="dripicons-briefcase"></i></a> --}}
                                            <li class="nav-item">
                                                <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false"
                                                    class="nav-link dropdown-item"><i class="dripicons-user"></i>
                                                    <span>{{ Session::get('FullName') }}</span> <i
                                                        class="fa fa-angle-down"></i>
                                                </a>
                                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                    user="menu">
                                                    @if (Session::get('UserType') !== 'Biller')
                                                        <li>
                                                            <a href="{{ url('/UserProfile') }}"><i
                                                                    class="dripicons-user"></i>
                                                                {{ trans('file.profile') }}</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ url('/pos-setting') }}"><i
                                                                    class="dripicons-gear"></i>
                                                                {{ trans('file.settings') }}</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ url('/invoice-listing') }}"><i
                                                                    class="dripicons-swap"></i>
                                                                {{ trans('file.My Transaction') }}</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ url('/ChangePassword') }}"><i
                                                                    class="dripicons-vibrate"></i> Change Password</a>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <a href="{{ URL('/Logout') }}"><i
                                                                class="dripicons-power"></i>Logout</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                        </nav>
                    </header>
                    <div class="filter-window">
                        <div class="category mt-3">
                            <div class="row ml-2 mr-2 px-2">
                                <div class="col-7">Choose category</div>
                                <div class="col-5 text-right">
                                    <button id="filterWindowClose" class="btn btn-default btn-sm">
                                        <i class="dripicons-cross"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row ml-2 mt-3">
                                @foreach ($lims_category_list as $category)
                                    <div class="col-md-3 category-img text-center"
                                        data-category="{{ $category->ItemCategoryID }}">
                                        @if ($category->image)
                                            <img src="{{ asset('assets/images/category/' . $category->image) }}"
                                                style="width:93px;height: 70px;">
                                        @else
                                            <img src="{{ asset('assets/images/product/zummXD2dvAtI.png') }}" />
                                        @endif
                                        <p class="text-center">{{ $category->title }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="brand mt-3">
                            <div class="row ml-2 mr-2 px-2">
                                <div class="col-7">Choose brand</div>
                                <div class="col-5 text-right">
                                    <span class="btn btn-default btn-sm">
                                        <i class="dripicons-cross"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="row ml-2 mt-3">
                                @foreach ($lims_brand_list as $brand)
                                    @if ($brand->image)
                                        <div class="col-md-3 brand-img text-center" data-brand="{{ $brand->id }}">
                                            <img src="{{ asset('assets/images/brand/' . $brand->image) }}"
                                                style="width:93px;height: 70px;">
                                            <p class="text-center">{{ $brand->title }}</p>
                                        </div>
                                    @else
                                        <div class="col-md-3 brand-img text-center" data-brand="{{ $brand->id }}">
                                            <img src="{{ asset('assets/images/product/zummXD2dvAtI.png') }}" />
                                            <p class="text-center">{{ $brand->title }}</p>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="dish mt-3">
                            <div class="row ml-2 mr-2 px-2">
                                <div class="col-7">Choose Dish</div>
                                <div class="col-5 text-right">
                                    <span class="btn btn-default btn-sm">
                                        <i class="dripicons-cross"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="row ml-2 mt-3">
                                @foreach ($dishes as $dish)
                                    <div class="col-md-3 dish-img text-center" data-dish="{{ $dish->id }}">
                                        @if ($dish->image_thumbnail)
                                            <img src="{{ asset('thumbnail/' . $dish->image_thumbnail) }}" />
                                        @else
                                            <img src="{{ asset('assets/images/product/zummXD2dvAtI.png') }}" />
                                        @endif
                                        <p class="text-center">{{ ucwords($dish->name) }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @if ($lims_pos_setting_data->is_dish_enabled == 1)
                            <div class="col-md-3">
                                <button class="btn btn-block btn-warning"
                                    id="dish-filter">{{ trans('file.Dish') }}</button>
                            </div>
                        @endif
                        <div class="col-md-3">
                            <button class="btn btn-block btn-primary"
                                id="category-filter">{{ trans('file.category') }}</button>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-block btn-info" id="brand-filter">{{ trans('file.Brand') }}</button>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-block btn-danger"
                                id="featured-filter">{{ trans('file.Featured') }}</button>
                        </div>
                        <div class="col-md-12 mt-1 table-container ">
                            <table id="product-table" class="table no-shadow product-list bg-white">
                                <thead class="d-none">
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 0; $i < ceil($product_number / 5); $i++)
                                        <tr>
                                            <td class="product-img sound-btn"
                                                title="{{ $lims_product_list[0 + $i * 5]->name }}"
                                                data-product="{{ $lims_product_list[0 + $i * 5]->code . ' (' . $lims_product_list[0 + $i * 5]->name . ')' }}">
                                                <img src="{{ asset('assets/images/items/' . $lims_product_list[0 + $i * 5]->base_image) }}"
                                                    width="100%" />

                                                <p>{{ $lims_product_list[0 + $i * 5]->name }}</p>
                                                <span>{{ $lims_product_list[0 + $i * 5]->code }}</span>
                                            </td>
                                            @if (!empty($lims_product_list[1 + $i * 5]))
                                                <td class="product-img sound-btn"
                                                    title="{{ $lims_product_list[1 + $i * 5]->name }}"
                                                    data-product="{{ $lims_product_list[1 + $i * 5]->code . ' (' . $lims_product_list[1 + $i * 5]->name . ')' }}">
                                                    <img src="{{ asset('assets/images/items/' . $lims_product_list[1 + $i * 5]->base_image) }}"
                                                        width="100%" />
                                                    <p>{{ $lims_product_list[1 + $i * 5]->name }}</p>
                                                    <span>{{ $lims_product_list[1 + $i * 5]->code }}</span>
                                                </td>
                                            @else
                                                <td style="border:none;"></td>
                                            @endif
                                            @if (!empty($lims_product_list[2 + $i * 5]))
                                                <td class="product-img sound-btn"
                                                    title="{{ $lims_product_list[2 + $i * 5]->name }}"
                                                    data-product="{{ $lims_product_list[2 + $i * 5]->code . ' (' . $lims_product_list[2 + $i * 5]->name . ')' }}">
                                                    <img src="{{ asset('assets/images/items/' . $lims_product_list[2 + $i * 5]->base_image) }}"
                                                        width="100%" />
                                                    <p>{{ $lims_product_list[2 + $i * 5]->name }}</p>
                                                    <span>{{ $lims_product_list[2 + $i * 5]->code }}</span>
                                                </td>
                                            @else
                                                <td style="border:none;"></td>
                                            @endif
                                            @if (!empty($lims_product_list[3 + $i * 5]))
                                                <td class="product-img sound-btn"
                                                    title="{{ $lims_product_list[3 + $i * 5]->name }}"
                                                    data-product="{{ $lims_product_list[3 + $i * 5]->code . ' (' . $lims_product_list[3 + $i * 5]->name . ')' }}">
                                                    <img src="{{ asset('assets/images/items/' . $lims_product_list[3 + $i * 5]->base_image) }}"
                                                        width="100%" />
                                                    <p>{{ $lims_product_list[3 + $i * 5]->name }}</p>
                                                    <span>{{ $lims_product_list[3 + $i * 5]->code }}</span>
                                                </td>
                                            @else
                                                <td style="border:none;"></td>
                                            @endif
                                            @if (!empty($lims_product_list[4 + $i * 5]))
                                                <td class="product-img sound-btn"
                                                    title="{{ $lims_product_list[4 + $i * 5]->name }}"
                                                    data-product="{{ $lims_product_list[4 + $i * 5]->code . ' (' . $lims_product_list[4 + $i * 5]->name . ')' }}">
                                                    <img src="{{ asset('assets/images/items/' . $lims_product_list[4 + $i * 5]->base_image) }}"
                                                        width="100%" />
                                                    <p>{{ $lims_product_list[4 + $i * 5]->name }}</p>
                                                    <span>{{ $lims_product_list[4 + $i * 5]->code }}</span>
                                                </td>
                                            @else
                                                <td style="border:none;"></td>
                                            @endif
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- product edit modal -->
                {{-- <div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 id="modal_header" class="modal-title"> Add Additional Informaton</h5>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                        aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url('addItemAdditional') }}" method="POST"
                                    enctype="multipart/form-data" id="itemAdditionalForm">
                                    @csrf
                                    <div class="card mt-2">

                                        <div class="card-body">
                                            <input type="hidden" name="itemId" id="itemId">
                                            <input type="hidden" name="invoiceNumber" id="itemInvoiceNumber"
                                                value="{{ $invoice_no }}">

                                            <div class="form-group" style="float: right !important;">
                                                <button id="addExtraRow" type="button" class="btn btn-success"
                                                    style="width: 50px !important; padding: 2px !important; margin: 0px !important; background-color: rgb(0, 255, 0) !important"><i
                                                        class="fa fa-plus"></i></button>
                                            </div>
                                            <div class="row" id="existingAdditionalDataRow"></div>
                                            <div class="row" id="itemAdditionalFirstDataRow">
                                                <div class="row pt-2">
                                                    <div class="col-6">
                                                        <strong>Description:</strong>
                                                        <textarea name="item_description[]" id="itemDescriptionData" cols="30" rows="4" class="form-control"></textarea>
                                                    </div>
                                                    <div class="col-6">
                                                        <strong>File:</strong>
                                                        <input type="file" name="item_file[]" id="itemFileData"
                                                            class="form-control" accept="image/*">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="itemAdditionalDataRow">
                                            </div>
                                            <div class="mt-2">
                                                <button class="btn btn-primary" id="submitItemAdditionalForm">Add</button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- payment modal -->
                <div id="add-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Finalize Sale') }}</h5>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                        aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="print_status" id="print_status" value="">
                                <div class="row">
                                    <div class="col-md-10">
                                        <form action="{{ url('finalize/draft/payment') }}" method="post"
                                            id="finalizeDraftPayment" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                @if ($lims_sale_data->sale_status == 3)
                                                    <div class="col-md-4 mt-1">
                                                        <label>Received Amount</label>
                                                        <input type="number" name="" class="form-control numkey"
                                                            step="any" id="alreadyPaid" readonly
                                                            value="{{ $lims_sale_data->Paid }}">
                                                    </div>
                                                @endif
                                                <div
                                                    class="{{ $lims_sale_data->sale_status == 3 ? 'col-md-4' : 'col-md-6' }} mt-1">
                                                    @if ($lims_sale_data->sale_status == 1)
                                                        <label>{{ trans('file.Recieved Amount') }} *</label>
                                                    @else
                                                        <label>Due Amount *</label>
                                                    @endif
                                                    <input type="number" name="paying_amount" id="paying_amount"
                                                        class="form-control numkey" required step="any">
                                                </div>
                                                <div
                                                    class="{{ $lims_sale_data->sale_status == 3 ? 'col-md-4' : 'col-md-6' }} mt-1">
                                                    <label>{{ trans('file.Paying Amount') }} *</label>
                                                    <input type="number" name="paid_amount" class="form-control numkey"
                                                        step="any" id="paid_amount">
                                                </div>

                                                <div class="col-md-6 mt-1">
                                                    <input type="hidden" name="paid_by_id">
                                                    <label>{{ trans('file.Paid By') }}</label>
                                                    <select name="paid_by_id_select" id="paid_by_id_select"
                                                        class="form-control selectpicker">
                                                        <option value="1"
                                                            {{ isset($lims_sale_data->PaymentMode) && $lims_sale_data->PaymentMode == 'Cash' ? 'selected' : '' }}>
                                                            Cash</option>
                                                        <option value="4"
                                                            {{ isset($lims_sale_data->PaymentMode) && $lims_sale_data->PaymentMode == 'Card' ? 'selected' : '' }}>
                                                            Card</option>
                                                        <option value="6"
                                                            {{ isset($lims_sale_data->PaymentMode) && $lims_sale_data->PaymentMode == 'Cash And Card' ? 'selected' : '' }}>
                                                            Cash And Card</option>
                                                        <option value="7"
                                                            {{ isset($lims_sale_data->PaymentMode) && $lims_sale_data->PaymentMode == 'Cash By Tabby' ? 'selected' : '' }}>
                                                            Cash By Tabby</option>
                                                        <option value="8"
                                                            {{ isset($lims_sale_data->PaymentMode) && $lims_sale_data->PaymentMode == 'Bank Transfer' ? 'selected' : '' }}>
                                                            Bank Transfer</option>
                                                        <option value="9"
                                                            {{ isset($lims_sale_data->PaymentMode) && $lims_sale_data->PaymentMode == 'Credit' ? 'selected' : '' }}>
                                                            Credit</option>
                                                        <option value="10"
                                                            {{ isset($lims_sale_data->PaymentMode) && $lims_sale_data->PaymentMode == 'Cash On Delivery' ? 'selected' : '' }}>
                                                            Cash on Delivery</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mt-1">
                                                    <label for="">Payment Proof</label>
                                                    <input type="file" class="form-control" name="payment_proof"
                                                        id="payment_proof">
                                                </div>
                                            </div>
                                            <div class="row" style="display: none;">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="hidden" name="total_qty" />
                                                        <input type="hidden" name="invoice_master_id"
                                                            value="{{ $lims_sale_data->InvoiceMasterID }}" />
                                                        <input type="hidden" name="invoice_no"
                                                            value="{{ $lims_sale_data->InvoiceNo }}" />
                                                        <input type="hidden" name="invoice_date" />
                                                        <input type="hidden" name="warehouse_id_hidden" />
                                                        <input type="hidden" name="warehouse_id" />
                                                        <input type="hidden" name="biller_id_hidden" />
                                                        <input type="hidden" name="biller_id" />
                                                        <input type="hidden" name="customer_id_hidden" />
                                                        <input type="hidden" name="customer_id" />
                                                        <input type="hidden" name="DeliveryAddress" />
                                                        <input type="hidden" name="product_id" />
                                                        <input type="hidden" name="qty" />
                                                        <input type="hidden" name="total_discount" value="0.00" />
                                                        <input type="hidden" name="total_tax" value="0.00" />
                                                        <input type="hidden" name="grand_total" />
                                                        <input type="hidden" name="total_price" />
                                                        <input type="hidden" name="item" />
                                                        <input type="hidden" name="order_tax" value="1" />
                                                        <input type="hidden" name="total">
                                                        <input type="hidden" name="coupon_discount">
                                                        <input type="hidden" name="sale_status" />
                                                        <input type="hidden" name="coupon_active" />
                                                        <input type="hidden" name="coupon_id" />
                                                        <input type="hidden" name="DiscountPer" />
                                                        <input type="hidden" name="pos" value="1" />
                                                        <input type="hidden" name="draft" value="0" />
                                                        <input type="hidden" name="discount_model" />
                                                        <input type="hidden" name="order_discount" />
                                                        <input type="hidden" name="order_tax_rate" />
                                                        <input type="hidden" name="order_tax_id" />
                                                        <input type="hidden" name="shipping_cost" />
                                                        <input type="hidden" name="driverName">
                                                        <input type="hidden" name="itemChangedRate">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="mt-3">
                                                <button id="submit-btn" type="button"
                                                    class="btn btn-primary">{{ trans('file.submit') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Partial payment modal -->
                <div id="add-partial-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 id="exampleModalLabel" class="modal-title">Update Sale</h5>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                        aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="print_status" id="print_status" value="">
                                <div class="row">
                                    <div class="col-md-10">
                                        <form action="{{ url('add/partial/payment') }}" method="post"
                                            id="addPartialPayment" enctype="multipart/form-data">
                                            @csrf
                                            @if ($lims_sale_data->sale_status == 3)
                                                <div class="row">

                                                    <div class="col-md-6 mt-1">
                                                        <label>Received Amount</label>
                                                        <input type="number" name="" class="form-control numkey"
                                                            step="any" id="alreadyPartialPaid" readonly
                                                            value="{{ $lims_sale_data->Paid }}">
                                                    </div>
                                                    <div class="col-md-6 mt-1">
                                                        <label>Remaining Amount</label>
                                                        <input type="number" name="" class="form-control numkey"
                                                            step="any" id="" readonly
                                                            value="{{ $lims_sale_data->Balance }}">
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row">
                                                <div class="col-md-6 mt-1">
                                                    @if ($lims_sale_data->sale_status == 1)
                                                        <label>{{ trans('file.Recieved Amount') }} *</label>
                                                    @else
                                                        <label>Re Payment Amount</label>
                                                    @endif
                                                    <input type="number" name="partial_paying_amount"
                                                        id="partial_paying_amount" class="form-control numkey"
                                                        max="" required step="any">
                                                </div>
                                                <div class="col-md-6 mt-1">
                                                    <label>{{ trans('file.Paying Amount') }} *</label>
                                                    <input type="number" name="partial_paid_amount"
                                                        class="form-control numkey" step="any"
                                                        id="partial_paid_amount">
                                                </div>

                                                <div class="col-md-6 mt-1">
                                                    <input type="hidden" name="paid_by_id">
                                                    <label>{{ trans('file.Paid By') }}</label>
                                                    <select name="paid_by_id_select" id="partial_paid_by_id_select"
                                                        class="form-control selectpicker">
                                                        <option value="1"
                                                            {{ isset($lims_sale_data->PaymentMode) && $lims_sale_data->PaymentMode == 'Cash' ? 'selected' : '' }}>
                                                            Cash</option>
                                                        <option value="4"
                                                            {{ isset($lims_sale_data->PaymentMode) && $lims_sale_data->PaymentMode == 'Card' ? 'selected' : '' }}>
                                                            Card</option>
                                                        <option value="6"
                                                            {{ isset($lims_sale_data->PaymentMode) && $lims_sale_data->PaymentMode == 'Cash And Card' ? 'selected' : '' }}>
                                                            Cash And Card</option>
                                                        <option value="7"
                                                            {{ isset($lims_sale_data->PaymentMode) && $lims_sale_data->PaymentMode == 'Cash By Tabby' ? 'selected' : '' }}>
                                                            Cash By Tabby</option>
                                                        <option value="8"
                                                            {{ isset($lims_sale_data->PaymentMode) && $lims_sale_data->PaymentMode == 'Bank Transfer' ? 'selected' : '' }}>
                                                            Bank Transfer</option>
                                                        <option value="9"
                                                            {{ isset($lims_sale_data->PaymentMode) && $lims_sale_data->PaymentMode == 'Credit' ? 'selected' : '' }}>
                                                            Credit</option>
                                                        <option value="10"
                                                            {{ isset($lims_sale_data->PaymentMode) && $lims_sale_data->PaymentMode == 'Cash On Delivery' ? 'selected' : '' }}>
                                                            Cash on Delivery</option>
                                                    </select>
                                                </div>
                                                {{-- <div class="col-md-6 mt-1">
                                                    <label for="">Payment Proof</label>
                                                    <input type="file" class="form-control" name="payment_proof"
                                                        id="payment_proof">
                                                </div> --}}
                                            </div>
                                            <div class="row" style="display: none;">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="hidden" name="total_qty" />
                                                        <input type="hidden" name="invoice_master_id"
                                                            value="{{ $lims_sale_data->InvoiceMasterID }}" />
                                                        <input type="hidden" name="invoice_no"
                                                            value="{{ $lims_sale_data->InvoiceNo }}" />
                                                        <input type="hidden" name="invoice_date" />
                                                        <input type="hidden" name="warehouse_id_hidden" />
                                                        <input type="hidden" name="warehouse_id" />
                                                        <input type="hidden" name="biller_id_hidden" />
                                                        <input type="hidden" name="biller_id" />
                                                        <input type="hidden" name="customer_id_hidden" />
                                                        <input type="hidden" name="customer_id" />
                                                        <input type="hidden" name="DeliveryAddress" />
                                                        <input type="hidden" name="product_id" />
                                                        <input type="hidden" name="qty" />
                                                        <input type="hidden" name="total_discount" value="0.00" />
                                                        <input type="hidden" name="total_tax" value="0.00" />
                                                        <input type="hidden" name="grand_total" />
                                                        <input type="hidden" name="total_price" />
                                                        <input type="hidden" name="item" />
                                                        <input type="hidden" name="order_tax" value="1" />
                                                        <input type="hidden" name="total">
                                                        <input type="hidden" name="coupon_discount">
                                                        <input type="hidden" name="sale_status" />
                                                        <input type="hidden" name="coupon_active" />
                                                        <input type="hidden" name="coupon_id" />
                                                        <input type="hidden" name="DiscountPer" />
                                                        <input type="hidden" name="pos" value="1" />
                                                        <input type="hidden" name="draft" value="0" />
                                                        <input type="hidden" name="discount_model" />
                                                        <input type="hidden" name="order_discount" />
                                                        <input type="hidden" name="order_tax_rate" />
                                                        <input type="hidden" name="order_tax_id" />
                                                        <input type="hidden" name="shipping_cost" />
                                                        <input type="hidden" name="driverName">
                                                        <input type="hidden" name="itemChangedRate">


                                                    </div>
                                                </div>

                                            </div>
                                            <div class="mt-3">
                                                <button id="partial-submit-btn" type="button"
                                                    class="btn btn-primary">{{ trans('file.submit') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- add customer modal -->
        <div id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
            class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('party.store') }}" method="post" id="addCustomerForm">
                        @csrf
                        <div class="modal-header">
                            <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Add Customer') }}
                            </h5>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                    aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                        </div>
                        <div class="modal-body">
                            <p class="italic">
                                <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                            </p>
                            <div class="form-group">
                                {{-- <label>{{ trans('file.Customer Group') }} *</strong> </label> --}}
                                <input type="hidden" name="customer_group_id" value="1">
                                {{-- <select required class="form-control selectpicker" name="customer_group_id">
                                @foreach ($lims_customer_group_all as $customer_group)
                                    <option value="{{ $customer_group->id }}">{{ $customer_group->name }}
                                    </option>
                                @endforeach
                            </select> --}}
                            </div>
                            <div class="form-group">
                                <label>{{ trans('file.name') }} *</strong> </label>
                                <input type="text" name="party_name" class="form-control" value=""
                                    placeholder="Customer Name">
                            </div>
                            <div class="form-group">
                                {{-- <label>{{ trans('file.Email') }}</label> --}}
                                <input type="hidden" name="party_email" placeholder="example@example.com"
                                    class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('file.Phone Number') }} * </label>
                                <input type="text" name="phone_number" required="" class="form-control">
                            </div>
                            <div class="form-group d-none">
                                <label>NTN Number</label>
                                <input type="text" name="tax_no" placeholder="NTN Number" class="form-control">
                            </div>
                            <div class="form_group d-none">
                                <!-- radion check filer -->
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="radio1" name="postal_code"
                                        value="none" checked>None
                                    <label class="form-check-label" for="radio1"></label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="radio1" name="postal_code"
                                        value="filer">Filer
                                    <label class="form-check-label" for="radio1"></label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="radio2" name="postal_code"
                                        value="non_filer">Non filer
                                    <label class="form-check-label" for="radio2"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                {{-- <label>{{ trans('file.Address') }} *</label> --}}
                                <input type="hidden" name="address" class="form-control" value="">
                            </div>
                            <div class="form-group d-none">
                                <label>{{ trans('file.City') }} *</label>
                                <input type="text" name="city" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="pos" value="1">
                                <input type="button" id="addCustomerSubmit" value="{{ trans('file.submit') }}"
                                    class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            var existSelectedOrderTaxValue = $('#order-tax-rate-select').find('option:selected');
            var exist_order_tax_rate_value = existSelectedOrderTaxValue.data('value');
            var exist_order_tax_rate_rate = existSelectedOrderTaxValue.val();
            var order_tax_rate_value = exist_order_tax_rate_value;
            var order_tax_rate_rate = exist_order_tax_rate_rate;
            var product_row_number = <?php echo json_encode($lims_pos_setting_data->product_number); ?>;
            // var rowindex;

            $("#myTable").on('click', '.minus', function() {
                rowindex = $(this).closest('tr').index();

                var sellingPrice = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) +
                    ') .sellingPrice input').val();
                var grandTotal = $('#grand-total').text();
                var qty = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty')
                    .val()) - 1;
                // var
                if (qty > 0) {
                    var subtotal = qty * sellingPrice
                    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(qty);
                    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .itemSubTotal').text(
                        subtotal);
                    // alert(order_tax_rate_value);
                    if (order_tax_rate_value == "Exclusive") {
                        var exist_total = (parseFloat(grandTotal) / (1 + (parseFloat(order_tax_rate_rate) /
                            100))).toFixed(2);
                        // alert(exist_total);
                        var newTotal = (exist_total - sellingPrice).toFixed(2);
                        var newTax = (newTotal * parseFloat(order_tax_rate_rate) / 100).toFixed(2);
                        var newGrandTotal = (parseFloat(newTotal) + parseFloat(newTax)).toFixed(2);
                    } else {
                        var newGrandTotal = (grandTotal - sellingPrice).toFixed(2);
                        var newTax = (newGrandTotal * parseFloat(order_tax_rate_rate) / 100).toFixed(
                            2);
                        var newTotal = (newGrandTotal - newTax).toFixed(2);
                    }

                    $('#grand-total').text(newGrandTotal);
                    $('#subtotal').text(newTotal);
                    $('#tax').text(newTax);

                } else {
                    qty = 1;
                }
                // checkQuantity(String(qty), true);
            });
            $("#myTable").on('click', '.plus', function() {
                rowindex = $(this).closest('tr').index();
                // var order_tax_rate = $('#order-tax-rate-select').val();
                // alert(order_tax_rate);
                var sellingPrice = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) +
                    ') .sellingPrice input').val();
                var grandTotal = $('#grand-total').text();
                var qty = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty')
                    .val()) + 1;
                if (qty > 0) {
                    var subtotal = qty * sellingPrice
                    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(qty);
                    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .itemSubTotal').text(
                        subtotal);
                    if (order_tax_rate_value == "Exclusive") {
                        var exist_total = (parseFloat(grandTotal) / (1 + (parseFloat(order_tax_rate_rate) /
                            100))).toFixed(2);
                        // alert(exist_total);
                        var newTotal = (parseFloat(exist_total) + parseFloat(sellingPrice)).toFixed(2);
                        var newTax = (newTotal * parseFloat(order_tax_rate_rate) / 100).toFixed(2);
                        var newGrandTotal = (parseFloat(newTotal) + parseFloat(newTax)).toFixed(2);
                    } else {
                        var newGrandTotal = (parseFloat(grandTotal) + parseFloat(sellingPrice)).toFixed(2);
                        var newTax = (newGrandTotal * parseFloat(order_tax_rate_rate) / 100).toFixed(
                            2);
                        var newTotal = (newGrandTotal - newTax).toFixed(2);
                    }
                    $('#grand-total').text(newGrandTotal);
                    $('#subtotal').text(newTotal);
                    $('#tax').text(newTax);

                } else {
                    qty = 1;
                }
                // checkQuantity(String(qty), true);
            });

            $('#order_tax_btn').click(function() {
                // alert(exist_order_tax_rate_value);
                // alert(exist_order_tax_rate_rate);
                var grandTotal = $('#grand-total').text();
                // alert(exist_order_tax_rate_value);
                if (exist_order_tax_rate_value == 'Exclusive') {
                    var exist_total = (parseFloat(grandTotal) / (1 + (parseFloat(
                            exist_order_tax_rate_rate) /
                        100))).toFixed(2);
                    var selectedOrderTaxValue = $('#order-tax-rate-select').find('option:selected');
                    order_tax_rate_value = selectedOrderTaxValue.data('value');
                    order_tax_rate_rate = selectedOrderTaxValue.val();
                    if (order_tax_rate_value == "Inclusive") {
                        var newTax = (exist_total * (parseFloat(order_tax_rate_rate) / 100)).toFixed(2);
                        var newTotal = (parseFloat(exist_total) - parseFloat(newTax)).toFixed(2);
                        var newGrandTotal = (parseFloat(newTotal) + parseFloat(newTax)).toFixed(2);
                        $('#grand-total').text(newGrandTotal);
                        $('#subtotal').text(newTotal);
                        $('#tax').text(newTax);
                        exist_order_tax_rate_value = order_tax_rate_value;
                        exist_order_tax_rate_rate = order_tax_rate_rate;
                    } else if (order_tax_rate_value == 'No Tax') {
                        var newTax = order_tax_rate_rate;
                        var newTotal = (parseFloat(exist_total)).toFixed(2);
                        var newGrandTotal = (parseFloat(newTotal)).toFixed(2);
                        $('#grand-total').text(newGrandTotal);
                        $('#subtotal').text(newTotal);
                        $('#tax').text(newTax);
                        exist_order_tax_rate_value = order_tax_rate_value;
                        exist_order_tax_rate_rate = order_tax_rate_rate;
                    }
                    // alert(exist_total);
                } else if (exist_order_tax_rate_value == 'Inclusive') {
                    var exist_total = (parseFloat(grandTotal) - (parseFloat(grandTotal) * (parseFloat(
                        exist_order_tax_rate_rate) / 100))).toFixed(2);
                    // alert(exist_total);
                    var selectedOrderTaxValue = $('#order-tax-rate-select').find('option:selected');
                    order_tax_rate_value = selectedOrderTaxValue.data('value');
                    // alert(order_tax_rate_value);
                    order_tax_rate_rate = selectedOrderTaxValue.val();
                    // alert(order_tax_rate_rate);

                    if (order_tax_rate_value == "Exclusive") {
                        var newTax = (grandTotal * (parseFloat(order_tax_rate_rate) / 100)).toFixed(2);
                        // alert(newTax);
                        var newTotal = (parseFloat(grandTotal)).toFixed(2);
                        // alert(newTotal);
                        var newGrandTotal = (parseFloat(newTax) + parseFloat(newTotal)).toFixed(2);
                        // alert(newGrandTotal);
                        $('#grand-total').text(newGrandTotal);
                        $('#subtotal').text(newTotal);
                        $('#tax').text(newTax);
                        exist_order_tax_rate_value = order_tax_rate_value;
                        exist_order_tax_rate_rate = order_tax_rate_rate;
                    } else if (order_tax_rate_value == 'No Tax') {
                        var newTax = order_tax_rate_rate;
                        var newTotal = (parseFloat(grandTotal)).toFixed(2);
                        var newGrandTotal = (parseFloat(newTotal)).toFixed(2);
                        $('#grand-total').text(newGrandTotal);
                        $('#subtotal').text(newTotal);
                        $('#tax').text(newTax);
                        exist_order_tax_rate_value = order_tax_rate_value;
                        exist_order_tax_rate_rate = order_tax_rate_rate;
                    }
                    // alert(exist_total);

                } else {
                    // alert('here');
                    var exist_total = (parseFloat(grandTotal)).toFixed(2);
                    // alert(exist_total);
                    var selectedOrderTaxValue = $('#order-tax-rate-select').find('option:selected');
                    order_tax_rate_value = selectedOrderTaxValue.data('value');
                    // alert(order_tax_rate_value);
                    order_tax_rate_rate = selectedOrderTaxValue.val();
                    // alert(order_tax_rate_rate);

                    if (order_tax_rate_value == "Exclusive") {
                        var newTax = (grandTotal * (parseFloat(order_tax_rate_rate) / 100)).toFixed(2);
                        // alert(newTax);
                        var newTotal = (parseFloat(grandTotal)).toFixed(2);
                        // alert(newTotal);
                        var newGrandTotal = (parseFloat(newTax) + parseFloat(newTotal)).toFixed(2);
                        // alert(newGrandTotal);
                        $('#grand-total').text(newGrandTotal);
                        $('#subtotal').text(newTotal);
                        $('#tax').text(newTax);
                        exist_order_tax_rate_value = 'Exclusive';
                        exist_order_tax_rate_rate = order_tax_rate_rate;
                    } else if (order_tax_rate_value == "Inclusive") {
                        var newTax = (exist_total * (parseFloat(order_tax_rate_rate) / 100)).toFixed(2);
                        var newTotal = (parseFloat(exist_total) - parseFloat(newTax)).toFixed(2);
                        var newGrandTotal = (parseFloat(newTotal) + parseFloat(newTax)).toFixed(2);
                        $('#grand-total').text(newGrandTotal);
                        $('#subtotal').text(newTotal);
                        $('#tax').text(newTax);
                        exist_order_tax_rate_value = 'Inclusive';
                        exist_order_tax_rate_rate = order_tax_rate_rate;
                    }
                }


            })
            $('#shipping_cost_btn').click(function() {
                // alert('here');
                var order_shipping_cost = $('#shipping-cost-val').val();
                // alert(order_shipping_cost);
                if (order_shipping_cost != '') {
                    var existShipping = $('#shipping-cost').text();
                    var grandTotal = $('#grand-total').text();
                    if (existShipping > 0) {
                        grandTotal = parseFloat(grandTotal) - parseFloat(existShipping);
                    }
                    var newGrandTotal = parseFloat(grandTotal) + parseFloat(order_shipping_cost);
                    $('#grand-total').text(newGrandTotal);
                    $('#shipping-cost').text(order_shipping_cost);
                    // var newTax = (newGrandTotal * 0.18).toFixed(2);
                    // alert(order_shipping_cost);
                }

            })

            $('#order_discount_btn').click(function() {
                var discountType = $('input[name=discount_model]:checked').val();
                var discountValue = $('#order-discount').val();
                var selectedOrderTaxValue = $('#order-tax-rate-select').find('option:selected');
                order_tax_rate_value = selectedOrderTaxValue.data('value');
                order_tax_rate_rate = selectedOrderTaxValue.val();
                // alert(order_tax_rate_value);
                // alert(order_tax_rate_rate);
                if (discountValue > 0) {
                    var exsitDiscount = $('#discount').text();
                    var grandTotal = $('#grand-total').text();

                    if (exsitDiscount > 0) {
                        grandTotal = parseFloat(grandTotal) + parseFloat(exsitDiscount);
                    }
                    var existShipping = $('#shipping-cost').text();
                    if (existShipping > 0) {
                        grandTotal = parseFloat(grandTotal) - parseFloat(existShipping);
                    }

                    if (discountType == "percentage") {
                        if (order_tax_rate_value == 'Exclusive') {
                            var newTotal = (parseFloat(grandTotal) / (1 + (parseFloat(order_tax_rate_rate) /
                                100))).toFixed(2);
                            var totalDiscount = (newTotal * parseFloat((discountValue / 100))).toFixed(2);
                            var newTax = ((newTotal - totalDiscount) * (parseFloat(order_tax_rate_rate) /
                                100)).toFixed(2);
                            // alert(newTax);
                            var newGrandTotal = parseFloat(newTotal) - parseFloat(totalDiscount) +
                                parseFloat(
                                    existShipping) + parseFloat(newTax);
                            newTotal = (newTotal - totalDiscount).toFixed(2);
                        } else {
                            var totalDiscount = (grandTotal * parseFloat((discountValue / 100))).toFixed(2);
                            var grandTotalWS = parseFloat(grandTotal) - parseFloat(totalDiscount);
                            var newGrandTotal = parseFloat(grandTotal) - parseFloat(totalDiscount) +
                                parseFloat(existShipping);
                            var newTax = (parseFloat(grandTotalWS) * (parseFloat(order_tax_rate_rate) /
                                100)).toFixed(2);
                            var newTotal = (parseFloat(grandTotalWS) - parseFloat(newTax)).toFixed(2);
                        }
                        $('#grand-total').text(newGrandTotal);
                        $('#discount').text(totalDiscount);
                        $('#subtotal').text(newTotal);
                        $('#tax').text(newTax);

                    } else {
                        if (order_tax_rate_value == 'Exclusive') {
                            var newTotal = (parseFloat(grandTotal) / (1 + (parseFloat(order_tax_rate_rate) /
                                100))).toFixed(2);
                            var totalDiscount = parseFloat(discountValue);
                            var newTax = ((newTotal - totalDiscount) * (parseFloat(order_tax_rate_rate) /
                                100)).toFixed(2);
                            var newGrandTotal = parseFloat(newTotal) - parseFloat(totalDiscount) +
                                parseFloat(
                                    existShipping) + parseFloat(newTax);
                            newTotal = (newTotal - totalDiscount).toFixed(2);
                        } else {
                            var totalDiscount = parseFloat(discountValue);
                            var grandTotalWS = parseFloat(grandTotal) - parseFloat(totalDiscount);
                            var newGrandTotal = parseFloat(grandTotal) - parseFloat(totalDiscount) +
                                parseFloat(existShipping);
                            var newTax = (parseFloat(grandTotalWS) * (parseFloat(order_tax_rate_rate) /
                                100)).toFixed(2);
                            var newTotal = (parseFloat(grandTotalWS) - parseFloat(newTax)).toFixed(2);
                        }
                        $('#grand-total').text(newGrandTotal);
                        $('#discount').text(totalDiscount);
                        $('#subtotal').text(newTotal);
                        $('#tax').text(newTax);
                    }
                    // var newGrandTotal = parseFloat(grandTotal) - parseFloat(order_shipping_cost);
                }

            })
            $("#itemAdditionalForm").submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ url('/addItemAdditional') }}",
                    data: formData,
                    processData: false, // Important: Prevent jQuery from processing the data
                    contentType: false,
                    success: function(response) {
                        // Handle the successful response (e.g., show a success message)
                        $('#editModal').modal('hide');
                        alert(response.message);
                    },
                    error: function(error) {
                        // Handle the error (e.g., display validation errors)
                        console.log(error.error);
                    },
                });
            });
            // $("#draft-btn").on("click", function() {
            //     var audio = $("#mysoundclip2")[0];
            //     audio.play();
            //     var orderGrandTotal = $('#grand-total').text();
            //     var orderTax = $('#tax').text();
            //     var orderTotal = $('#subtotal').text();
            //     var orderShipping = $('#shipping-cost').text();
            //     var orderDiscount = $('#discount').text();
            //     var selectedOrderTaxValue = $('#order-tax-rate-select').find('option:selected');
            //     var orderTaxId = selectedOrderTaxValue.data('id');
            //     var orderTaxRate = selectedOrderTaxValue.val();

            //     $('input[name="grand_total"]').val(parseFloat(orderGrandTotal));
            //     $('input[name="order_tax"]').val(parseFloat(orderTax));
            //     $('input[name="total"]').val(parseFloat(orderTotal));
            //     $('input[name="shipping_cost"]').val(parseFloat(orderShipping));
            //     $('input[name="order_discount"]').val(parseFloat(orderDiscount));
            //     $('input[name="order_tax_id"]').val(parseFloat(orderTaxId));
            //     $('input[name="order_tax_rate"]').val(parseFloat(orderTaxRate));

            //     $('input[name="sale_status"]').val(3);
            //     $('input[name="paying_amount"]').prop('required', false);
            //     $('input[name="paid_amount"]').prop('required', false);
            //     var rownumber = $('table.order-list tbody tr:last').index();
            //     // alert(rownumber);
            //     if (rownumber < 0) {
            //         alert("Please insert product to order table!")
            //     } else {
            //         selectedservingType = $("input[name='servingType']:checked").val();
            //         var deliveryAddress = $("input[name='DeliveryAddress']").val();
            //         selectedState = $('#shipping-cost').text();
            //         var driverName = $("input[name='driverName']").val();
            //         // alert(deliveryAddress);
            //         // alert(selectedState);

            //         if (selectedservingType == 'delivery') {
            //             if (selectedState == 0) {
            //                 alert('Please Select City for Delivery');
            //                 $('#delivery-modal').modal('show');
            //             } else if (deliveryAddress == '') {
            //                 alert('Please Add Address for Delivery');
            //                 $('#delivery-modal').modal('show');
            //             } else if (driverName == '') {
            //                 alert('Please Add Driver Name for Delivery');
            //                 $('#delivery-modal').modal('show');
            //             } else {
            //                 $('.payment-form').submit();
            //                 localStorage.clear();
            //             }

            //         } else {
            //             $('.payment-form').submit();
            //             localStorage.clear();
            //         }
            //     }
            // });

            $(document).on('click', '.product-img', function() {
                var invoice_number = $('#invoice_no').val();
                var customer_id = $('#customer_id').val();
                var warehouse_id = $('select[name="warehouse_id"]').val();
                if (!customer_id)
                    alert('Please select Customer!');
                else if (!warehouse_id)
                    alert('Please select Warehouse!');
                else {
                    var data = $(this).data('product');
                    data = data.split(" ");
                    var code = data[0];
                    // alert(code);

                    $.ajax({
                        url: '../../check/item/availabilty/' + code + '/' + invoice_number,
                        method: 'GET',

                        success: function(response) {
                            // alert(response.invoice_detail);
                            if ((response.invoice_detail) == null) {

                                var sellPrice = (response.item.SellingPrice);
                                var taxPer = parseFloat((response.item.Percentage) / 100);
                                var sellingPrice = sellPrice + taxPer;
                                var newRowHtml = '<tr>' +
                                    '<input type="hidden" class="product_id" name="product_id[]" value="' +
                                    (
                                        response.item.ItemID) + '">' +
                                    '<td class="col-sm-4">' +
                                    '<button type="button" class="edit-product btn btn-link" data-id="' +
                                    (response.item.ItemID) +
                                    '" data-toggle="modal" data-target="#editModal"><strong>' +
                                    (response.item.ItemName) +
                                    '</strong></button><br><span class="ItemCod">' + (
                                        response.item.ItemCode) + '</span>' +
                                    '<a type="button" data-id="' + (response.item.ItemID) +
                                    '" class="btn-topping btn btn-sm" data-toggle="modal" title="Extra-Topping" data-target="#toppingModal"><i class="fa fa-eye"></i></a>' +
                                    '<p>In Stock: <span class="in-stock"></span></p>' +
                                    '</td>' +
                                    '<td class="col-sm-2 sellingPrice">' +
                                    '<input name="itemChangedRate[]" class="form-control" type="text" readonly value="' +
                                    sellingPrice +
                                    '">' +
                                    '</td>' +
                                    '<td class="col-sm-3">' +
                                    '<div class="input-group">' +
                                    '<span class="input-group-btn"><button type="button" class="btn btn-default minus"><span class="dripicons-minus"></span></button></span>' +
                                    '<input type="text" name="qty[]" class="form-control qty numkey input-number" step="any" required value="1">' +
                                    '<span class="input-group-btn"><button type="button" class="btn btn-default plus"><span class="dripicons-plus"></span></button></span>' +
                                    '</div>' +
                                    '</td>' +
                                    '<td class="col-sm-2 itemSubTotal">' + sellingPrice +
                                    '</td>' +
                                    '<td class="col-sm-1"><button type="button" class="ibtnDel btn btn-danger btn-sm"><i class="dripicons-cross"></i></button></td>' +
                                    '</tr>';

                                // Append the new row to the table with the ID 'your-table-id'
                                $('#tbody-id').append(newRowHtml);
                                var grandTotal = $('#grand-total').text();
                                if (order_tax_rate_value == "Exclusive") {
                                    var exist_total = (parseFloat(grandTotal) / (1 + (
                                        parseFloat(order_tax_rate_rate) /
                                        100))).toFixed(2);
                                    // alert(exist_total);
                                    var newTotal = (parseFloat(exist_total) + parseFloat(
                                        sellingPrice)).toFixed(2);
                                    var newTax = (newTotal * parseFloat(order_tax_rate_rate) /
                                        100).toFixed(2);
                                    var newGrandTotal = (parseFloat(newTotal) + parseFloat(
                                        newTax)).toFixed(2);
                                } else {
                                    var newGrandTotal = (parseFloat(grandTotal) + parseFloat(
                                        sellingPrice)).toFixed(2);
                                    var newTax = (newGrandTotal * parseFloat(
                                        order_tax_rate_rate) / 100).toFixed(
                                        2);
                                    var newTotal = (newGrandTotal - newTax).toFixed(2);
                                }
                                $('#grand-total').text(newGrandTotal);
                                $('#subtotal').text(newTotal);
                                $('#tax').text(newTax);
                            } else {
                                var numRows = $('table.order-list tbody tr').length;
                                for (let index = 1; index <= numRows; index++) {
                                    var ItemCodee = $('table.order-list tbody tr:nth-child(' + (
                                        index) + ') .ItemCod').text();
                                    if (ItemCodee == code) {
                                        var sellingPrice = $(
                                            'table.order-list tbody tr:nth-child(' + index +
                                            ') .sellingPrice input').val();
                                        var grandTotal = $('#grand-total').text();
                                        var qty = parseFloat($(
                                                'table.order-list tbody tr:nth-child(' +
                                                index + ') .qty')
                                            .val()) + 1;
                                        if (qty > 0) {
                                            var subtotal = qty * sellingPrice
                                            $('table.order-list tbody tr:nth-child(' + index +
                                                ') .qty').val(qty);
                                            $('table.order-list tbody tr:nth-child(' + index +
                                                ') .itemSubTotal').text(
                                                subtotal);
                                            if (order_tax_rate_value == "Exclusive") {
                                                var exist_total = (parseFloat(grandTotal) / (1 +
                                                    (parseFloat(order_tax_rate_rate) /
                                                        100))).toFixed(2);
                                                // alert(exist_total);
                                                var newTotal = (parseFloat(exist_total) +
                                                    parseFloat(sellingPrice)).toFixed(2);
                                                var newTax = (newTotal * parseFloat(
                                                    order_tax_rate_rate) / 100).toFixed(2);
                                                var newGrandTotal = (parseFloat(newTotal) +
                                                    parseFloat(newTax)).toFixed(2);
                                            } else {
                                                var newGrandTotal = (parseFloat(grandTotal) +
                                                    parseFloat(sellingPrice)).toFixed(2);
                                                var newTax = (newGrandTotal * parseFloat(
                                                    order_tax_rate_rate) / 100).toFixed(
                                                    2);
                                                var newTotal = (newGrandTotal - newTax).toFixed(
                                                    2);
                                            }
                                            $('#grand-total').text(newGrandTotal);
                                            $('#subtotal').text(newTotal);
                                            $('#tax').text(newTax);
                                        }
                                    }
                                }
                            }

                        },
                        error: function() {
                            alert('Error occurred while fetching item data.');
                        }
                    });
                }
            });
            $('#lims_productcodeSearch').keyup(function() {
                var value = $('#lims_productcodeSearch').val();
                // alert(value);
                if (value == "") {
                    $('#limsSearchedDiv').addClass('d-none');
                } else {
                    $.ajax({
                        url: '../../search/item/' + value,
                        method: 'GET',

                        success: function(response) {
                            // alert('success');
                            $('#limsSearchedCol').empty();
                            $('#limsSearchedDiv').removeClass('d-none');
                            (response.data).forEach(element => {
                                var html =
                                    '<a href="#" data-id="' + element.ItemCode +
                                    '" class="searchedAnchor" style="text-decoration: none; color:white">' +
                                    element.ItemName + ' (' + element.ItemCode + ')</a>'
                                html += '<hr>'
                                // html += '<br>'
                                $('#limsSearchedCol').append(html);
                            });
                        },
                        error: function() {
                            alert('Error occurred while fetching item data.');
                        }
                    });
                }
            });
            $('#limsSearchedCol').on('click', '.searchedAnchor', function() {
                var id = $(this).data('id');
                addProduct(id);
            });

            function addProduct(code) {
                // alert(code);
                $('#limsSearchedDiv').addClass('d-none');
                $('#lims_productcodeSearch').val('');
                var invoice_number = $('#invoice_no').val();
                var customer_id = $('#customer_id').val();
                var warehouse_id = $('select[name="warehouse_id"]').val();
                if (!customer_id)
                    alert('Please select Customer!');
                else if (!warehouse_id)
                    alert('Please select Warehouse!');
                else {
                    $.ajax({
                        url: '../../check/item/availabilty/' + code + '/' + invoice_number,
                        method: 'GET',

                        success: function(response) {
                            // alert(response.invoice_detail);
                            if ((response.invoice_detail) == null) {

                                var sellPrice = (response.item.SellingPrice);
                                var taxPer = parseFloat((response.item.Percentage) / 100);
                                var sellingPrice = sellPrice + taxPer;
                                var newRowHtml = '<tr>' +
                                    '<input type="hidden" class="product_id" name="product_id[]" value="' +
                                    (
                                        response.item.ItemID) + '">' +
                                    '<td class="col-sm-4">' +
                                    '<button type="button" class="edit-product btn btn-link" data-id="' +
                                    (response.item.ItemID) +
                                    '" data-toggle="modal" data-target="#editModal"><strong>' +
                                    (response.item.ItemName) +
                                    '</strong></button><br><span class="ItemCod">' + (
                                        response.item.ItemCode) + '</span>' +
                                    '<a type="button" data-id="' + (response.item.ItemID) +
                                    '" class="btn-topping btn btn-sm" data-toggle="modal" title="Extra-Topping" data-target="#toppingModal"><i class="fa fa-eye"></i></a>' +
                                    '<p>In Stock: <span class="in-stock"></span></p>' +
                                    '</td>' +
                                    '<td class="col-sm-2 sellingPrice">' +
                                    '<input name="itemChangedRate[]" class="form-control" type="text" readonly value="' +
                                    sellingPrice +
                                    '">' +
                                    '</td>' +
                                    '<td class="col-sm-3">' +
                                    '<div class="input-group">' +
                                    '<span class="input-group-btn"><button type="button" class="btn btn-default minus"><span class="dripicons-minus"></span></button></span>' +
                                    '<input type="text" name="qty[]" class="form-control qty numkey input-number" step="any" required value="1">' +
                                    '<span class="input-group-btn"><button type="button" class="btn btn-default plus"><span class="dripicons-plus"></span></button></span>' +
                                    '</div>' +
                                    '</td>' +
                                    '<td class="col-sm-2 itemSubTotal">' + sellingPrice +
                                    '</td>' +
                                    '<td class="col-sm-1"><button type="button" class="ibtnDel btn btn-danger btn-sm"><i class="dripicons-cross"></i></button></td>' +
                                    '</tr>';

                                // Append the new row to the table with the ID 'your-table-id'
                                $('#tbody-id').append(newRowHtml);
                                var grandTotal = $('#grand-total').text();
                                if (order_tax_rate_value == "Exclusive") {
                                    var exist_total = (parseFloat(grandTotal) / (1 + (
                                        parseFloat(order_tax_rate_rate) /
                                        100))).toFixed(2);
                                    // alert(exist_total);
                                    var newTotal = (parseFloat(exist_total) + parseFloat(
                                        sellingPrice)).toFixed(2);
                                    var newTax = (newTotal * parseFloat(order_tax_rate_rate) /
                                        100).toFixed(2);
                                    var newGrandTotal = (parseFloat(newTotal) + parseFloat(
                                        newTax)).toFixed(2);
                                } else {
                                    var newGrandTotal = (parseFloat(grandTotal) + parseFloat(
                                        sellingPrice)).toFixed(2);
                                    var newTax = (newGrandTotal * parseFloat(
                                        order_tax_rate_rate) / 100).toFixed(
                                        2);
                                    var newTotal = (newGrandTotal - newTax).toFixed(2);
                                }
                                $('#grand-total').text(newGrandTotal);
                                $('#subtotal').text(newTotal);
                                $('#tax').text(newTax);
                            } else {
                                var numRows = $('table.order-list tbody tr').length;
                                for (let index = 1; index <= numRows; index++) {
                                    var ItemCodee = $('table.order-list tbody tr:nth-child(' + (
                                        index) + ') .ItemCod').text();
                                    if (ItemCodee == code) {
                                        var sellingPrice = $(
                                            'table.order-list tbody tr:nth-child(' + index +
                                            ') .sellingPrice input').val();
                                        var grandTotal = $('#grand-total').text();
                                        var qty = parseFloat($(
                                                'table.order-list tbody tr:nth-child(' +
                                                index + ') .qty')
                                            .val()) + 1;
                                        if (qty > 0) {
                                            var subtotal = qty * sellingPrice
                                            $('table.order-list tbody tr:nth-child(' + index +
                                                ') .qty').val(qty);
                                            $('table.order-list tbody tr:nth-child(' + index +
                                                ') .itemSubTotal').text(
                                                subtotal);
                                            if (order_tax_rate_value == "Exclusive") {
                                                var exist_total = (parseFloat(grandTotal) / (1 +
                                                    (parseFloat(order_tax_rate_rate) /
                                                        100))).toFixed(2);
                                                // alert(exist_total);
                                                var newTotal = (parseFloat(exist_total) +
                                                    parseFloat(sellingPrice)).toFixed(2);
                                                var newTax = (newTotal * parseFloat(
                                                    order_tax_rate_rate) / 100).toFixed(2);
                                                var newGrandTotal = (parseFloat(newTotal) +
                                                    parseFloat(newTax)).toFixed(2);
                                            } else {
                                                var newGrandTotal = (parseFloat(grandTotal) +
                                                    parseFloat(sellingPrice)).toFixed(2);
                                                var newTax = (newGrandTotal * parseFloat(
                                                    order_tax_rate_rate) / 100).toFixed(
                                                    2);
                                                var newTotal = (newGrandTotal - newTax).toFixed(
                                                    2);
                                            }
                                            $('#grand-total').text(newGrandTotal);
                                            $('#subtotal').text(newTotal);
                                            $('#tax').text(newTax);
                                        }
                                    }
                                }
                            }

                        },
                        error: function() {
                            alert('Error occurred while fetching item data.');
                        }
                    });
                }
            }
            $("table.order-list tbody").on("click", ".ibtnDel", function(event) {
                var audio = $("#mysoundclip2")[0];
                audio.play();
                rowindex = $(this).closest('tr').index();
                var invoice_number = $('#invoice_no').val();
                var grandTotal = $('#grand-total').text();
                var oldTotal = $('#subtotal').text();
                var code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .ItemCod').text();
                var qty = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty')
                    .val());
                var sellingPrice = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) +
                    ') .sellingPrice input').val();
                if (order_tax_rate_value == 'Exclusive') {
                    var newTotal = (parseFloat(oldTotal) - (parseFloat(sellingPrice) * parseFloat(qty)))
                        .toFixed(2);
                    var newTax = (parseFloat(newTotal) * (parseFloat(order_tax_rate_rate) / 100)).toFixed();
                    var newGrandTotal = (parseFloat(newTotal) + parseFloat(newTax)).toFixed(2);
                } else {
                    var newGrandTotal = (parseFloat(grandTotal) - (parseFloat(sellingPrice) * parseFloat(
                        qty))).toFixed(2);
                    var newTax = (parseFloat(newGrandTotal) * (parseFloat(order_tax_rate_rate) / 100))
                        .toFixed();
                    var newTotal = (parseFloat(newGrandTotal) - parseFloat(newTax)).toFixed(2);
                }
                $('#grand-total').text(newGrandTotal);
                $('#subtotal').text(newTotal);
                $('#tax').text(newTax);
                $.ajax({
                    url: '../../delete/item/availabilty/' + code + '/' + invoice_number,
                    method: 'GET',
                    success: function(response) {},
                    error: function() {
                        alert('Error occurred while fetching item data.');
                    }
                });
                $(this).closest("tr").remove();
            });
            $("#addExtraRow").click(function() {
                var html = '';
                html += '<div class="row p-2" id="inputFormRow">';
                html +=
                    '<div class="col-6"><div class="form-group"><strong>Description:</strong><textarea name="item_description[]" id="" cols="30" rows="4" class="form-control"></textarea></div></div>';
                html +=
                    '<div class="col-5"><div class="form-group"><strong>File:</strong><input type="file" name="item_file[]" class="form-control" accept="image/*"></div></div>';
                html += '<div class="col-1 pt-3 text-right">';
                html += '<div class="form-group">';
                html +=
                    '<button id="removeRow" type="button" class="btn btn-danger mt-4" style="width: 50px !important; padding: 2px !important; margin-top: 10px !important;"><i class="fa fa-minus"></i></button>';
                html += '</div>';
                html += '</div>';
                // html +=
                //     '<button id="addRow" type="button" class="btn btn-danger mt-4" style="width: 50px !important; padding: 2px !important; margin: 10px 0px 0px 5px !important; background-color: rgb(0, 255, 0) !important"><i class="fa fa-plus"></i></button>';
                html += '</div>';
                html += '</div>';
                $('#itemAdditionalDataRow').append(html);
            });
            $(document).on('click', '#removeRow', function() {
                $(this).closest('#inputFormRow').remove();
            });
            $('#category-filter').on('click', function(e) {
                e.stopPropagation();
                $('.filter-window').show('slide', {
                    direction: 'right'
                }, 'fast');
                $('.category').show();
                $('.brand').hide();
                $('.dish').hide();
            });
            $('.category-img').on('click', function() {
                var category_id = $(this).data('category');
                var brand_id = 0;

                $(".table-container").children().remove();
                $.get('../../sales/getproduct/' + category_id + '/' + brand_id, function(data) {
                    //    console.log(data.length);
                    populateProduct(data);
                });
            });
            $('#brand-filter').on('click', function(e) {
                e.stopPropagation();
                $('.filter-window').show('slide', {
                    direction: 'right'
                }, 'fast');
                $('.brand').show();
                $('.category').hide();
                $('.dish').hide();
            });

            $('.brand-img').on('click', function() {
                var brand_id = $(this).data('brand');
                var category_id = 0;

                $(".table-container").children().remove();
                $.get('../../sales/getproduct/' + category_id + '/' + brand_id, function(data) {
                    populateProduct(data);
                });
            });

            $('#featured-filter').on('click', function() {
                $(".table-container").children().remove();
                $.get('../../sales/getfeatured', function(data) {
                    populateProduct(data);
                });
            });
            $('#filterWindowClose').click(function() {
                $('.filter-window').hide();

            })

            function populateProduct(data) {
                $('.filter-window').hide();
                var tableData =
                    '<table id="product-table" class="table no-shadow product-list"> <thead class="d-none"> <tr> <th></th> <th></th> <th></th> <th></th> <th></th> </tr></thead> <tbody><tr>';
                // alert(tableData);
                if (Object.keys(data).length != 0) {
                    // alert('here');
                    $.each(data['name'], function(index) {
                        var product_info = data['code'][index] + ' (' + data['name'][index] + ')';
                        var base_url = "{{ asset('assets/images/items') }}/" + data['image'][index];

                        if (index % 5 == 0 && index != 0)
                            tableData += '</tr><tr><td class="product-img sound-btn" title="' + data['name']
                            [index] +
                            '" data-product = "' + product_info + '"><img  src="' + base_url +
                            '" width="100%" /><p>' +
                            data['name'][index] + '</p><span>' + data['code'][index] + '</span></td>';
                        else
                            tableData += '<td class="product-img sound-btn" title="' + data['name'][index] +
                            '" data-product = "' + product_info + '"><img  src="' + base_url +
                            '" width="100%" /><p>' +
                            data['name'][index] + '</p><span>' + data['code'][index] + '</span></td>';
                    });

                    if (data['name'].length % 5) {
                        var number = 5 - (data['name'].length % 5);
                        while (number > 0) {
                            tableData += '<td style="border:none;"></td>';
                            number--;
                        }
                    }

                    tableData += '</tr></tbody></table>';
                    $(".table-container").html(tableData);
                    $('#product-table').DataTable({
                        "order": [],
                        'pageLength': product_row_number,
                        'language': {
                            'paginate': {
                                'previous': '<i class="fa fa-angle-left"></i>',
                                'next': '<i class="fa fa-angle-right"></i>'
                            }
                        },
                        dom: 'tp'
                    });
                    $('table.product-list').hide();
                    $('table.product-list').show(500);
                } else {

                    tableData += '<td class="text-center">No data avaialable</td></tr></tbody></table>'
                    $(".table-container").html(tableData);
                }
            }
            $("table.order-list").on("click", ".edit-product", function() {
                var row_product_id = $(this).data('id');
                var itemAdditionalDataContainer = $("#itemAdditionalData");
                // var row_itemId = $('#itemId')
                $("#itemId").val("");
                $("#itemId").val(row_product_id);
                $("#itemDescriptionData").val("")
                $("#itemFileData").val("")
                $("#itemAdditionalDataRow").empty();
                $("#existingAdditionalDataRow").empty();

                var invoiceNomber = $('#itemInvoiceNumber').val();
                // alert(invoiceNomber);

                $.ajax({
                    type: "get",
                    url: '../../getItemAdditional/' + row_product_id + '/' + invoiceNomber,
                    success: function(response) {
                        var existingItemData = (response.data);
                        $("#itemAdditionalFirstDataRow").empty();

                        if (existingItemData.length > 0) {
                            // alert('fjhdfjhdf');
                            var headH3 = '<h3>Already Added Information</h3>';
                            var headSpan =
                                '<small class="text-danger">(You cannot edit the already added information but you can delete it.)</small>'
                            $('#existingAdditionalDataRow').append(headH3);

                            $('#existingAdditionalDataRow').append(headSpan);

                            existingItemData.forEach(element => {
                                // alert(element.file);
                                var html = '';

                                html += '<div class="row p-2" id="inputFormRow">';
                                html +=
                                    '<div class="col-6"><div class="form-group"><strong>Description:</strong><textarea name="" id="" cols="30" rows="4" class="form-control" readonly>' +
                                    element.description + '</textarea></div></div>';
                                html +=
                                    '<div class="col-5"><div class="form-group"><strong>File:</strong><br><img src="../../assets/images/items/' +
                                    element.file + '" alt="" width="60%"></div></div>';
                                html += '<input type="hidden" name="ids[]" value="' +
                                    element
                                    .id + '" />'
                                html += '<div class="col-1 pt-3 text-right">';
                                html += '<div class="form-group">';
                                html +=
                                    '<button id="removeRow" type="button" class="btn btn-danger mt-4" style="width: 50px !important; padding: 2px !important; margin-top: 10px !important;"><i class="fa fa-minus"></i></button>';
                                html += '</div>';
                                html += '</div>';
                                html += '</div>';
                                html += '</div>';
                                $('#existingAdditionalDataRow').append(html);
                            });
                        } else {
                            var htmlContent = `<div class="row pt-2">
                                            <div class="col-6">
                                            <strong>Description:</strong>
                                            <textarea name="item_description[]" id="itemDescriptionData" cols="30" rows="4" class="form-control"></textarea>
                                            </div>
                                            <div class="col-6">
                                            <strong>File:</strong>
                                            <input type="file" name="item_file[]" id="itemFileData" class="form-control" accept="image/*">
                                            </div>
                                            </div>
                                            `;

                            $("#itemAdditionalFirstDataRow").append(htmlContent);
                        }
                        // alert(response.data);
                    },
                    error: function(error) {
                        // Handle the error (e.g., display validation errors)
                        console.log(error.error);
                    },
                });
                // alert(row_product_id);
            });
            $('#payment-btn').click(function() {
                var payingAmount = $('#grand-total').text();
                var alreadyPaid = $('#alreadyPaid').val();
                // alert(alreadyPaid);
                if (alreadyPaid != null) {
                    $('#paying_amount').val(payingAmount - alreadyPaid);
                } else {
                    $('#paying_amount').val(payingAmount);

                }
                $('#paid_amount').val(payingAmount);

            });
            $('#draft-btn').click(function() {
                var payingAmount = $('#grand-total').text();
                var alreadyPaid = $('#alreadyPartialPaid').val();
                $('#partial_paid_amount').val(payingAmount);

            });
            $('#submit-btn').click(function() {
                // alert('here');
                var product_ids = [];
                var qtys = [];
                var changedRates = [];
                var iddddds = $("#tbody-id input[name='product_id[]']");
                var qtyss = $("#tbody-id input[name='qty[]']");
                var ratesss = $("#tbody-id input[name='itemChangedRate[]']");


                for (var i = 0; i < iddddds.length; i++) {
                    product_ids.push($(iddddds[i]).val());
                    qtys.push($(qtyss[i]).val());
                    changedRates.push($(ratesss[i]).val());

                }
                var audio = $("#mysoundclip2")[0];
                audio.play();
                var orderGrandTotal = $('#grand-total').text();
                var orderTax = $('#tax').text();
                var orderTotal = $('#subtotal').text();
                var orderShipping = $('#shipping-cost').text();
                var orderDiscount = $('#discount').text();
                var selectedOrderTaxValue = $('#order-tax-rate-select').find('option:selected');
                var orderTaxId = selectedOrderTaxValue.data('id');
                var orderTaxRate = selectedOrderTaxValue.val();

                $('input[name="grand_total"]').val(parseFloat(orderGrandTotal));
                $('input[name="order_tax"]').val(parseFloat(orderTax));
                $('input[name="total"]').val(parseFloat(orderTotal));
                $('input[name="shipping_cost"]').val(parseFloat(orderShipping));
                $('input[name="order_discount"]').val(parseFloat(orderDiscount));
                $('input[name="order_tax_id"]').val(parseFloat(orderTaxId));
                $('input[name="order_tax_rate"]').val(parseFloat(orderTaxRate));
                $('input[name="invoice_date"]').val($('#invoice_date').val());
                $('input[name="warehouse_id_hidden"]').val($('#warehouse_id_hidden').val());
                $('input[name="warehouse_id"]').val($('#warehouse_id').val());
                $('input[name="biller_id_hidden"]').val($('#biller_id_hidden').val());
                $('input[name="biller_id"]').val($('#biller_id').val());
                $('input[name="customer_id_hidden"]').val($('#customer_id_hidden').val());
                $('input[name="customer_id"]').val($('#customer_id').val());
                // $('input[name="DeliveryAddress"]').val($('#DeliveryAddress').val());
                $('input[name="product_id"]').val(product_ids);
                $('input[name="qty"]').val(qtys);
                $('input[name="itemChangedRate"]').val(changedRates);

                $('input[name="sale_status"]').val(1);
                $('input[name="discount_model"]').val($('input[name=discount_model]:checked').val());
                var rownumber = $('table.order-list tbody tr:last').index();
                // alert(rownumber);
                if (rownumber < 0) {
                    alert("Please insert product to order table!");
                    $('#add-payment').modal('hide');
                } else {
                    selectedservingType = $("input[name='servingType']:checked").val();
                    var deliveryAddress = $("input[name='DeliveryAddress']").val();
                    selectedState = $('#shipping-cost').text();
                    var driverName = $("input[name='driverName']").val();
                    // alert(deliveryAddress);
                    // alert(selectedState);

                    if (selectedservingType == 'delivery') {
                        if (selectedState == 0) {
                            alert('Please Select City for Delivery');
                            $('#add-payment').modal('hide');
                            $('#delivery-modal').modal('show');
                        } else if (deliveryAddress == '') {
                            alert('Please Add Address for Delivery');
                            $('#add-payment').modal('hide');
                            $('#delivery-modal').modal('show');
                        } else if (driverName == '') {
                            alert('Please Add Driver Name for Delivery');
                            $('#add-payment').modal('hide');
                            $('#delivery-modal').modal('show');
                        } else {
                            $('input[name="DeliveryAddress"]').val(deliveryAddress);
                            $('input[name="driverName"]').val(driverName);
                            $('#finalizeDraftPayment').submit();
                            localStorage.clear();
                        }

                    } else {
                        $('#finalizeDraftPayment').submit();
                        localStorage.clear();
                    }

                }
            });
            $('#partial-submit-btn').click(function() {
                // alert('here');
                var product_ids = [];
                var qtys = [];
                var changedRates = [];
                var iddddds = $("#tbody-id input[name='product_id[]']");
                var qtyss = $("#tbody-id input[name='qty[]']");
                var ratesss = $("#tbody-id input[name='itemChangedRate[]']");
                var partialPaid = $("#partial_paid_amount").val();
                var partialRePayment = $("#partial_paying_amount").val();
                var partialAlreadyPaid = $("#alreadyPartialPaid").val();
                var diff = partialPaid - partialAlreadyPaid;
                // alert(diff);



                for (var i = 0; i < iddddds.length; i++) {
                    product_ids.push($(iddddds[i]).val());
                    qtys.push($(qtyss[i]).val());
                    changedRates.push($(ratesss[i]).val());

                }
                var audio = $("#mysoundclip2")[0];
                audio.play();
                var orderGrandTotal = $('#grand-total').text();
                var orderTax = $('#tax').text();
                var orderTotal = $('#subtotal').text();
                var orderShipping = $('#shipping-cost').text();
                var orderDiscount = $('#discount').text();
                var selectedOrderTaxValue = $('#order-tax-rate-select').find('option:selected');
                var orderTaxId = selectedOrderTaxValue.data('id');
                var orderTaxRate = selectedOrderTaxValue.val();

                $('input[name="grand_total"]').val(parseFloat(orderGrandTotal));
                $('input[name="order_tax"]').val(parseFloat(orderTax));
                $('input[name="total"]').val(parseFloat(orderTotal));
                $('input[name="shipping_cost"]').val(parseFloat(orderShipping));
                $('input[name="order_discount"]').val(parseFloat(orderDiscount));
                $('input[name="order_tax_id"]').val(parseFloat(orderTaxId));
                $('input[name="order_tax_rate"]').val(parseFloat(orderTaxRate));
                $('input[name="invoice_date"]').val($('#invoice_date').val());
                $('input[name="warehouse_id_hidden"]').val($('#warehouse_id_hidden').val());
                $('input[name="warehouse_id"]').val($('#warehouse_id').val());
                $('input[name="biller_id_hidden"]').val($('#biller_id_hidden').val());
                $('input[name="biller_id"]').val($('#biller_id').val());
                $('input[name="customer_id_hidden"]').val($('#customer_id_hidden').val());
                $('input[name="customer_id"]').val($('#customer_id').val());
                // $('input[name="DeliveryAddress"]').val($('#DeliveryAddress').val());
                $('input[name="product_id"]').val(product_ids);
                $('input[name="qty"]').val(qtys);
                $('input[name="itemChangedRate"]').val(changedRates);

                $('input[name="sale_status"]').val(3);
                $('input[name="discount_model"]').val($('input[name=discount_model]:checked').val());
                var rownumber = $('table.order-list tbody tr:last').index();
                // alert(rownumber);
                if (rownumber < 0) {
                    alert("Please insert product to order table!");
                    $('#add-payment').modal('hide');
                } else {
                    selectedservingType = $("input[name='servingType']:checked").val();
                    var deliveryAddress = $("input[name='DeliveryAddress']").val();
                    selectedState = $('#shipping-cost').text();
                    var driverName = $("input[name='driverName']").val();
                    // alert(deliveryAddress);
                    // alert(selectedState);

                    if (selectedservingType == 'delivery') {
                        if (selectedState == 0) {
                            alert('Please Select City for Delivery');
                            $('#add-payment').modal('hide');
                            $('#delivery-modal').modal('show');
                        } else if (deliveryAddress == '') {
                            alert('Please Add Address for Delivery');
                            $('#add-payment').modal('hide');
                            $('#delivery-modal').modal('show');
                        } else if (driverName == '') {
                            alert('Please Add Driver Name for Delivery');
                            $('#add-payment').modal('hide');
                            $('#delivery-modal').modal('show');
                        } else {
                            if (partialRePayment > diff) {
                                alert(
                                    'Partial Payment Amount Should be less than or equal to Remaining Amount'
                                );
                            } else {
                                $('input[name="DeliveryAddress"]').val(deliveryAddress);
                                $('input[name="driverName"]').val(driverName);
                                $('#addPartialPayment').submit();
                                localStorage.clear();
                            }

                        }

                    } else {
                        if (partialRePayment > diff) {
                            alert(
                                'Partial Re Payment Amount Should be less than or equal to Remaining Amount'
                            );
                        } else {
                            $('#addPartialPayment').submit();
                            localStorage.clear();
                        }
                    }

                }
            });
        });
    </script>
@endsection
@section('scripts')
    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
    <script>
        $('document').ready(function() {
            $("input[name='servingType']").change(function() {
                selectedservingType = $("input[name='servingType']:checked").val();
                // alert(selectedservingType);
                if (selectedservingType == 'delivery') {
                    $('#delivery-modal').modal('show');
                    $('#changeDelivery').removeClass('d-none');
                } else {
                    $('#changeDelivery').addClass('d-none');
                    $('#delivery_state_shipping').val(0);
                    $('#delivery_state_shipping').selectpicker('refresh');
                    $("input[name='DeliveryAddress']").val('');
                    $("input[name='driverName']").val('');
                    selectedState = 0;
                    var existShipping = $('#shipping-cost').text();
                    var grandTotal = $('#grand-total').text();
                    if (existShipping > 0) {
                        grandTotal = parseFloat(grandTotal) - parseFloat(existShipping);
                    }
                    var newGrandTotal = parseFloat(grandTotal) + parseFloat(selectedState);
                    $('#grand-total').text(newGrandTotal);
                    $('#shipping-cost').text(selectedState);
                    $("input[name='shipping_cost']").val(selectedState);
                }
            });
            $('#delivery_state_shipping').change(function() {
                // alert('here');
                selectedState = $('#delivery_state_shipping').val();
                var existShipping = $('#shipping-cost').text();
                var grandTotal = $('#grand-total').text();
                if (existShipping > 0) {
                    grandTotal = parseFloat(grandTotal) - parseFloat(existShipping);
                }
                var newGrandTotal = parseFloat(grandTotal) + parseFloat(selectedState);
                $('#grand-total').text(newGrandTotal);
                $('#shipping-cost').text(selectedState);
                $("input[name='shipping_cost']").val(selectedState);

            });
            $('button[name="add_delivery_btn"]').on("click", function() {
                selectedState = $('#delivery_state_shipping').val();
                var existShipping = $('#shipping-cost').text();
                var grandTotal = $('#grand-total').text();
                if (existShipping > 0) {
                    grandTotal = parseFloat(grandTotal) - parseFloat(existShipping);
                }
                var newGrandTotal = parseFloat(grandTotal) + parseFloat(selectedState);
                $('#grand-total').text(newGrandTotal);
                $('#shipping-cost').text(selectedState);
                $("input[name='shipping_cost']").val(selectedState);

            });
            $('#changeDelivery').click(function() {
                $('#delivery-modal').modal('show');
            })
            $('#addCustomerSubmit').click(function() {
                // alert('here');
                // $('#addCustomerForm').submit();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('party.store') }}',
                    data: $('#addCustomerForm').serialize(),
                    success: function(data) {
                        alert(data.message);
                        $('#addCustomer').modal('hide');
                        $("input[name='phone_number']").val('');
                        // alert(data.data.PartyID);
                        var select = $('#customer_id');

                        $.get('{{ route('get-updated-customers') }}', function(response) {
                            var select = $('#customer_id');
                            // alert(select.val());
                            select.empty();
                            // alert(select.val());
                            if (response.options && response.options.length > 0) {
                                $.each(response.options, function(index, option) {
                                    select.append($('<option>', {
                                        value: option.value,
                                        text: option.text
                                    }));
                                });
                                // select.val(data.data.PartyID);
                                // alert(select.val());
                                select.selectpicker('val', data.data.PartyID);
                                select.selectpicker('refresh');

                            }
                        });
                    },
                    error: function(data) {
                        // Handle errors here
                    }
                });
            })
        })
    </script>
@endsection
