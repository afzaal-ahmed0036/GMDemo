@extends('template.top-head')
@section('title', 'Create Voucher')
@section('content')
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
                            <form action="{{ url('/save-voucher') }}" method="post" class="payment-form">
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
                                                    <input type="date" name="invoice_date" value="<?php echo date('Y-m-d'); ?>"
                                                        id="invoice_date" class="form-control" />
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
                                                            value="{{ $lims_pos_setting_data->warehouse_id }}">
                                                    @endif
                                                    <select required id="warehouse_id" name="warehouse_id"
                                                        class="selectpicker form-control" data-live-search="true"
                                                        data-live-search-style="begins">
                                                        @foreach ($lims_warehouse_list as $warehouse)
                                                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    @if ($lims_pos_setting_data)
                                                        <input type="hidden" name="biller_id_hidden"
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
                                                                    @if ($biller->UserID == 14) selected @endif>
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
                                                            value="{{ $lims_pos_setting_data->customer_id }}">
                                                    @endif
                                                    <div class="input-group pos">
                                                        <select required name="customer_id" id="customer_id"
                                                            class="selectpicker form-control" data-live-search="true"
                                                            style="width: 100px">
                                                            <?php $deposit = []; ?>
                                                            @foreach ($lims_customer_list as $customer)
                                                                @php $deposit[$customer->PartyID] = $customer->Deposit - $customer->Expense; @endphp
                                                                <option value="{{ $customer->PartyID }}">
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
                                                        id="servingTypePick" value="pickup" checked>
                                                    <label class="form-check-label" for="servingTypePick">
                                                        PickUp
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="servingType"
                                                        id="servingTypeDeliver" value="delivery">
                                                    <label class="form-check-label" for="servingTypeDeliver">
                                                        Delivery
                                                    </label>
                                                    <button type="button" class="btn btn-sm d-none"
                                                        id="changeDelivery"><i class="fa fa-edit"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="search-box form-group col-md-12">
                                                <div class="form-group">
                                                    <input type="text" name="product_code_name"
                                                        id="lims_productcodeSearch"
                                                        placeholder="Scan/Search product by name/code"
                                                        class="form-control" />
                                                </div>
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
                                                            <th class="col-sm-2">{{ trans('file.Quantity') }}</th>
                                                            <th class="col-sm-3">{{ trans('file.Subtotal') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbody-id">
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
                                                        id="item">0</span>
                                                </div>

                                                <div class="col-sm-4">
                                                    <span class="totals-title"><span
                                                            id="totals-title">{{ trans('file.Discount') }}</span> <button
                                                            type="button" class="btn btn-link btn-sm"
                                                            data-toggle="modal" data-target="#order-discount-modal"> <i
                                                                class="dripicons-document-edit"></i></button></span><span
                                                        id="discount">0.00</span>
                                                </div>
                                                {{-- <div class="col-sm-4">
                                                    <span class="totals-title">{{ trans('file.Coupon') }} <button
                                                            type="button" class="btn btn-link btn-sm"
                                                            data-toggle="modal" data-target="#coupon-modal"><i
                                                                class="dripicons-document-edit"></i></button></span><span
                                                        id="coupon-text">0.00</span>
                                                </div> --}}
                                                <div class="col-sm-4">
                                                    <span class="totals-title">{{ trans('file.Shipping') }} <button
                                                            type="button" class="btn btn-link btn-sm"
                                                            data-toggle="modal" data-target="#shipping-cost-modal"><i
                                                                class="dripicons-document-edit"></i></button></span><span
                                                        id="shipping-cost">0.00</span>
                                                </div>

                                                <div class="col-sm-4">
                                                    <span class="totals-title">{{ trans('file.Total') }}</span><span
                                                        id="subtotal">0.00</span>
                                                </div>

                                                <div class="col-sm-4">
                                                    <span class="totals-title">{{ trans('file.Tax') }} <button
                                                            type="button" class="btn btn-link btn-sm"
                                                            data-toggle="modal" data-target="#order-tax"><i
                                                                class="dripicons-document-edit"></i></button></span><span
                                                        id="tax">0.00</span>
                                                </div>



                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="payment-amount">
                            <h2>{{ trans('file.grand total') }} <span id="grand-total">0.00</span></h2>
                        </div>
                        <div class="payment-options">
                            <div class="column-5" style="display: none;">
                                <button style="background: #0984e3" type="button" class="btn btn-custom payment-btn"
                                    data-toggle="modal" data-target="#add-payment" id="credit-card-btn"><i
                                        class="fa fa-credit-card"></i> Card</button>
                            </div>
                            <div class="column-5">
                                <button style="background: #00cec9" type="button" class="btn btn-custom payment-btn"
                                    data-toggle="modal" data-target="#add-payment" id="cash-print-btn"><i
                                        class="fa fa-money"></i> Cash & Print</button>
                            </div>
                            <div class="column-5">
                                <button style="background: #e28d02" type="button" class="btn btn-custom payment-btn"
                                    data-toggle="modal" data-target="#add-payment" id="cash-new-btn"><i
                                        class="fa fa-money"></i> Cash & New</button>
                            </div>
                            <div class="column-5" style="display: none;">
                                <button style="background-color: #213170" type="button"
                                    class="btn btn-custom payment-btn" data-toggle="modal" data-target="#add-payment"
                                    id="paypal-btn"><i class="fa fa-paypal"></i> Paypal</button>
                            </div>
                            <div class="column-5">
                                <button style="background-color: #e28d02" type="button" class="btn btn-custom"
                                    id="draft-btn"><i class="dripicons-flag"></i> For Future</button>
                            </div>
                            <div class="column-5" style="display: none;">
                                <button style="background-color: #fd7272" type="button"
                                    class="btn btn-custom payment-btn" data-toggle="modal" data-target="#add-payment"
                                    id="cheque-btn"><i class="fa fa-money"></i> Cheque</button>
                            </div>
                            <div class="column-5" style="display: none;">
                                <button style="background-color: #5f27cd" type="button"
                                    class="btn btn-custom payment-btn" data-toggle="modal" data-target="#add-payment"
                                    id="gift-card-btn"><i class="fa fa-credit-card-alt"></i> GiftCard</button>
                            </div>
                            <div class="column-5" style="display: none;">
                                <button style="background-color: #b33771" type="button"
                                    class="btn btn-custom payment-btn" data-toggle="modal" data-target="#add-payment"
                                    id="deposit-btn"><i class="fa fa-university"></i> Deposit</button>
                            </div>
                            <div class="column-5">
                                <button style="background-color: #d63031;" type="button" class="btn btn-custom"
                                    id="cancel-btn" onclick="return confirmCancel()"><i class="fa fa-close"></i>
                                    Cancel</button>
                            </div>
                            <div class="column-5">
                                <button style="background-color: #ffc107;" type="button" class="btn btn-custom"
                                    data-toggle="modal" data-target="#recentTransaction"><i class="dripicons-clock"></i>
                                    Recent transaction</button>
                            </div>
                            @if (Session::get('UserType') != 'Biller')
                                <div class="column-5">
                                    <button style="background-color: #ffc107;" type="button" class="btn btn-custom"
                                        id="home-btn" onclick="window.location='{{ route('kashif') }}'"><i
                                            class="fa fa-home"></i> Home</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
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
                                        <div class="row">
                                            <div class="col-md-6 mt-1">
                                                <label>{{ trans('file.Recieved Amount') }} *</label>
                                                <input type="text" name="paying_amount" class="form-control numkey"
                                                    required step="any">
                                            </div>
                                            <div class="col-md-6 mt-1">
                                                <label>{{ trans('file.Paying Amount') }} *</label>
                                                <input type="text" name="paid_amount" class="form-control numkey"
                                                    step="any">
                                            </div>
                                            <div class="col-md-6 mt-1">
                                                <label>{{ trans('file.Change') }} : </label>
                                                <p id="change" class="ml-2">0.00</p>
                                            </div>
                                            <div class="col-md-6 mt-1">
                                                <input type="hidden" name="paid_by_id">
                                                <label>{{ trans('file.Paid By') }}</label>
                                                <select name="paid_by_id_select" class="form-control selectpicker">
                                                    <option value="1">Cash</option>
                                                    <option value="4">Card</option>
                                                    <option value="6">Cash And Card</option>
                                                    <option value="7">Cash By Tabby</option>
                                                    <option value="8">Bank Transfer</option>
                                                    <option value="9">Credit</option>
                                                    <option value="10">Cash on Delivery</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12 mt-3">
                                                <div class="card-element form-control">
                                                </div>
                                                <div class="card-errors" role="alert"></div>
                                            </div>
                                            <div class="form-group col-md-12 gift-card">
                                                <label> {{ trans('file.Gift Card') }} *</label>
                                                <input type="hidden" name="gift_card_id">
                                                <select id="gift_card_id_select" name="gift_card_id_select"
                                                    class="selectpicker form-control" data-live-search="true"
                                                    data-live-search-style="begins" title="Select Gift Card..."></select>
                                            </div>

                                            <div class="form-group col-md-6 cheque">
                                                <label>Reference Number *</label>
                                                <input type="text" name="cheque_no" class="form-control">
                                            </div>
                                            <div class="form-group col-md-4 AmountPaidByCard">
                                                <label>Amount Paid By Card/Tabby *</label>
                                                <input type="text" name="AmountPaidByCard" id="AmountPaidByCard"
                                                    class="form-control">
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>{{ trans('file.Payment Note') }}</label>
                                                <textarea id="payment_note" rows="2" class="form-control" name="payment_note"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label>{{ trans('file.Sale Note') }}</label>
                                                <textarea rows="3" class="form-control" name="sale_note"></textarea>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>{{ trans('file.Staff Note') }}</label>
                                                <textarea rows="3" class="form-control" name="staff_note"></textarea>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label>Gift Print</label>
                                                <select name="GiftInvoice1" id="GiftInvoice1"
                                                    class="form-control selectpicker">
                                                    <option value="Normal">With Price</option>
                                                    <option value="Gift">Gift Print</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button id="submit-btn" type="button"
                                                class="btn btn-primary">{{ trans('file.submit') }}</button>
                                        </div>
                                    </div>
                                    <div class="col-md-2 qc" data-initial="1">
                                        <h4><strong>{{ trans('file.Quick Cash') }}</strong></h4>
                                        <button class="btn btn-block btn-primary qc-btn sound-btn" data-amount="10"
                                            type="button">10</button>
                                        <button class="btn btn-block btn-primary qc-btn sound-btn" data-amount="20"
                                            type="button">20</button>
                                        <button class="btn btn-block btn-primary qc-btn sound-btn" data-amount="50"
                                            type="button">50</button>
                                        <button class="btn btn-block btn-primary qc-btn sound-btn" data-amount="100"
                                            type="button">100</button>
                                        <button class="btn btn-block btn-primary qc-btn sound-btn" data-amount="500"
                                            type="button">500</button>
                                        <button class="btn btn-block btn-primary qc-btn sound-btn" data-amount="1000"
                                            type="button">1000</button>
                                        <button class="btn btn-block btn-danger qc-btn sound-btn" data-amount="0"
                                            type="button">{{ trans('file.Clear') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ---------------For Future Payment Modal----------------->
                <div id="add-future-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Finalize Sale') }}</h5>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                        aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="col-md-6 mt-1">
                                                <label>{{ trans('file.Recieved Amount') }} *</label>
                                                <input type="text" name="future_paid_amount"
                                                    class="form-control numkey" required step="any">
                                            </div>
                                            <div class="col-md-6 mt-1">
                                                <label>{{ trans('file.Paying Amount') }} *</label>
                                                <input type="text" name="future_paying_amount"
                                                    class="form-control numkey" step="any">
                                            </div>
                                            <div class="col-md-6 mt-1">
                                                <input type="hidden" name="future_paid_by_id" id="future_paid_by_id">
                                                <label>{{ trans('file.Paid By') }}</label>
                                                <select name="future_paid_by_id_select" class="form-control selectpicker" id="future_paid_by_id_select">
                                                    <option value="1">Cash</option>
                                                    <option value="4">Card</option>
                                                    <option value="6">Cash And Card</option>
                                                    <option value="7">Cash By Tabby</option>
                                                    <option value="8">Bank Transfer</option>
                                                    <option value="9">Credit</option>
                                                    <option value="10">Cash on Delivery</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button id="future-submit-btn" type="button"
                                                class="btn btn-primary">{{ trans('file.submit') }}</button>
                                        </div>
                                    </div>
                                </div>
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
                                    autocomplete="off">
                                <label for="disc_percent">Number</label><br>

                                <input type="radio" id="disc_percent" name="discount_model" value="percentage"
                                    autocomplete="off" checked>
                                <label for="disc_number">%</label><br>

                                <div class="form-group">
                                    <input type="text" name="order_discount" class="form-control numkey"
                                        id="order-discount" onkeyup='saveValue(this);'>
                                </div>
                                <button type="button" name="order_discount_btn" class="btn btn-primary"
                                    data-dismiss="modal">{{ trans('file.submit') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- coupon modal -->
                <div id="coupon-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ trans('file.Coupon Code') }}</h5>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                        aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="text" id="coupon-code" class="form-control"
                                        placeholder="Type Coupon Code...">
                                </div>
                                <button type="button" class="btn btn-primary coupon-check"
                                    data-dismiss="modal">{{ trans('file.submit') }}</button>
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
                                            <option value="{{ $tax->rate }}" data-id="{{ $tax->id }}"
                                                data-value="{{ $tax->name }}">
                                                {{ $tax->name }}</option>
                                        @endforeach
                                        <option value="0">No Tax</option>
                                    </select>
                                </div>
                                <button type="button" name="order_tax_btn" class="btn btn-primary"
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
                                    <input type="text" name="shipping_cost" class="form-control numkey"
                                        id="shipping-cost-val" step="any" onkeyup='saveValue(this);'>
                                </div>
                                <button type="button" name="shipping_cost_btn" class="btn btn-primary"
                                    data-dismiss="modal">{{ trans('file.submit') }}</button>
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
                                    <input type="text" name="DeliveryAddress" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Driver Name</label>
                                    <input type="text" name="driverName" class="form-control">
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
                                            <li class="nav-item"><a href="{{ url('daily/transactions') }}"
                                                    target="_blank" class="btn"><i class="dripicons-download"></i></a>
                                            </li>
                                            @if (Session::get('UserType') != 'Biller')
                                                <li class="nav-item" id="notification-icon">
                                                    <a rel="nofollow" data-target="#" href="#"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        class="nav-link dropdown-item"><i class="dripicons-bell"></i><span
                                                            class="badge badge-danger notification-number"></span>
                                                        <span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </a>
                                                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default notifications"
                                                        user="menu">
                                                        {{-- <li class="notifications">
                                                        <a href="" class="btn btn-link">product exceeds alert quantity</a>
                                                    </li> --}}
                                                        <li class="notifications">
                                                            <a href="{{ URL('/SaleReport') }}" target="_blank"
                                                                class="btn btn-link">Sale Report</a>
                                                            <a href="{{ URL('/Expense') }}" target="_blank"
                                                                class="btn btn-link">Add Expenses </a>
                                                            <a href="{{ URL('/ExpenseReport') }}" target="_blank"
                                                                class="btn btn-link">Expense Report</a>
                                                            <a href="{{ URL('/DailyIncomeExpense') }}" target="_blank"
                                                                class="btn btn-link">Daily Income/Expense</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            @endif
                                            <a href="" id="register-details-btn" data-toggle="tooltip"
                                                title="" data-original-title="Cash Register Details"><i
                                                    class="dripicons-briefcase"></i></a>
                                            <!-- <li class="nav-item">
                                                                                                                                                                            <a class="dropdown-item" href="" target="_blank"><i class="dripicons-information"></i> {{ trans('file.Help') }}</a>
                                                                                                                                                                        </li>&nbsp; -->
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
                                    <span class="btn btn-default btn-sm">
                                        <i class="dripicons-cross"></i>
                                    </span>
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
                        <div class="col-md-12 mt-1 table-container">
                            <table id="product-table" class="table no-shadow product-list">
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
                                                <br>
                                                <small>AED: {{ $lims_product_list[0 + $i * 5]->SellingPrice }}</small>
                                            </td>
                                            @if (!empty($lims_product_list[1 + $i * 5]))
                                                <td class="product-img sound-btn"
                                                    title="{{ $lims_product_list[1 + $i * 5]->name }}"
                                                    data-product="{{ $lims_product_list[1 + $i * 5]->code . ' (' . $lims_product_list[1 + $i * 5]->name . ')' }}">
                                                    <img src="{{ asset('assets/images/items/' . $lims_product_list[1 + $i * 5]->base_image) }}"
                                                        width="100%" />
                                                    <p>{{ $lims_product_list[1 + $i * 5]->name }}</p>
                                                    <span>{{ $lims_product_list[1 + $i * 5]->code }}</span>
                                                    <br>
                                                    <small>AED: {{ $lims_product_list[1 + $i * 5]->SellingPrice }}</small>
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
                                                    <br>
                                                    <small>AED: {{ $lims_product_list[2 + $i * 5]->SellingPrice }}</small>
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
                                                    <br>
                                                    <small>{{ $lims_product_list[3 + $i * 5]->SellingPrice }}</small>

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
                                                    <br>
                                                    <small>AED: {{ $lims_product_list[4 + $i * 5]->SellingPrice }}</small>
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
                <div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 id="modal_header" class="modal-title"></h5>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                        aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="row col-md-12">
                                        <div class="form-group col-md-4">
                                            <label>{{ trans('file.Quantity') }}</label>
                                            <input type="text" name="edit_qty" class="form-control numkey">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>{{ trans('file.Unit Discount') }}</label>
                                            <input type="text" name="edit_discount" class="form-control numkey">
                                            <div class="form-check d-none">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                    value="amount" id="radioAmount" checked>
                                                <label class="form-check-label" for="radioAmount">
                                                    Amount
                                                </label>
                                            </div>
                                            <div class="form-check  d-none">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                    value="percent" id="radioPercent">
                                                <label class="form-check-label" for="radioPercent">
                                                    Percentag
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>{{ trans('file.Unit Price') }}</label>
                                            <input type="text" name="edit_unit_price" class="form-control numkey"
                                                step="any">
                                        </div>
                                    </div>
                                    <?php
                                    $tax_name_all[] = 'No Tax';
                                    $tax_rate_all[] = 0;
                                    foreach ($lims_tax_list as $tax) {
                                        $tax_name_all[] = $tax->name;
                                        $tax_rate_all[] = $tax->rate;
                                    }
                                    ?>
                                    <div class="row col-md-12">
                                        <div class="form-group col-md-4">
                                            <label>{{ trans('file.Tax Rate') }}</label>
                                            <select name="edit_tax_rate" class="form-control selectpicker">
                                                @foreach ($tax_name_all as $key => $name)
                                                    <option value="{{ $key }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div id="edit_unit" class="form-group col-md-4">
                                            <label>{{ trans('file.Product Unit') }}</label>
                                            <select name="edit_unit" class="form-control selectpicker">
                                            </select>
                                        </div>
                                    </div>

                                    <button type="button" name="update_btn"
                                        class="btn btn-primary">{{ trans('file.update') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- product edit modal -->
                <div id="toppingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 id="modal_header" class="modal-title">Add Extra Topping</h5>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                        aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <input type="hidden" value="" name="topping_item" id="topping_item">
                                    <div class="row col-md-12">
                                        <div class="form-group col-md-4">
                                            <label>Item</label>
                                            <select name="topping_item_id" class="form-control topping_item">
                                                <option value="">Select Item</option>
                                                @foreach ($resturantItems as $item)
                                                    <option value="{{ $item->ItemID }}">{{ $item->ItemName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Price</label>
                                            <input type="text" name="topping_item_price" class="form-control numkey"
                                                step="any">
                                        </div>
                                    </div>


                                    <button type="button" name="updatebtn" class="btn btn-primary">Add
                                        Topping</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- add customer modal -->
                <div id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" class="modal fade text-left">
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
                                        <input type="text" name="tax_no" placeholder="NTN Number"
                                            class="form-control">
                                    </div>
                                    <div class="form_group d-none">
                                        <!-- radion check filer -->
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="radio1"
                                                name="postal_code" value="none" checked>None
                                            <label class="form-check-label" for="radio1"></label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="radio1"
                                                name="postal_code" value="filer">Filer
                                            <label class="form-check-label" for="radio1"></label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="radio2"
                                                name="postal_code" value="non_filer">Non filer
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
                                        <input type="button" id="addCustomerSubmit"
                                            value="{{ trans('file.submit') }}" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- recent transaction modal -->
                <div id="recentTransaction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content" style="max-height: 90vh; overflow-y: hidden;">
                            <div class="modal-header">
                                <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Recent Transaction') }}
                                    <div class="badge badge-primary">Today & Past 2 Days</div>
                                </h5>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                        aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                            </div>
                            <div class="mt-2">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#sale-latest" role="tab"
                                            data-toggle="tab">{{ trans('file.Sale') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#draft-latest" role="tab"
                                            data-toggle="tab">Future Orders</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="modal-body" style="max-height: 100%; overflow-y: auto;">

                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane show active" id="sale-latest">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>{{ trans('file.date') }}</th>
                                                        <th>{{ trans('file.reference') }}</th>
                                                        <th>{{ trans('file.customer') }}</th>
                                                        <th>{{ trans('file.grand total') }}</th>
                                                        <th>{{ trans('file.action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($recent_sale as $sale)
                                                        <tr>
                                                            <td>{{ date('d-m-Y H:i:s', strtotime($sale->Date)) }}</td>
                                                            <td>{{ $sale->ReferenceNo }}</td>
                                                            <td>{{ $sale->Phone }}</td>
                                                            <td>{{ $sale->GrandTotal }}</td>
                                                            <td>


                                                                <div class="btn-group">
                                                                    <a href="{{ url('sales/' . $sale->InvoiceMasterID . '/edit') }}"
                                                                        class="btn btn-success btn-sm" title="Edit"><i
                                                                            class="dripicons-document-edit"></i></a>
                                                                    &nbsp; <a
                                                                        href="{{ url('print-voucher/' . $sale->InvoiceMasterID) }}"
                                                                        target="_blank" class="btn btn-primary btn-sm"
                                                                        title="Edit"><i
                                                                            class="dripicons-print"></i></a>&nbsp;<a
                                                                        href="{{ url('print-voucher/' . $sale->InvoiceMasterID . '/gift') }}"
                                                                        target="_blank" class="btn btn-secondary"
                                                                        title="gift print"><i
                                                                            class="dripicons-weight"></i></a>&nbsp;
                                                                    <form action="{{ url('cancelOrder') }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" id="cancelInvoiceMasterID"
                                                                            name="InvoiceMasterID"
                                                                            value="{{ $sale->InvoiceMasterID }}">
                                                                        <button type="submit" class="btn btn-danger "
                                                                            onclick="return confirmDelete()"
                                                                            title="Delete"><i
                                                                                class="dripicons-trash"></i></button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="draft-latest">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>{{ trans('file.date') }}</th>
                                                        <th>{{ trans('file.reference') }}</th>
                                                        <th>{{ trans('file.customer') }}</th>
                                                        <th>{{ trans('file.grand total') }}</th>
                                                        <th>Paid</th>
                                                        <th>Due</th>
                                                        <th>{{ trans('file.action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($recent_draft as $draft)
                                                        <tr>
                                                            <td>{{ date('d-m-Y H:i:s', strtotime($draft->Date)) }}</td>
                                                            <td>{{ $draft->ReferenceNo }}</td>
                                                            <td>{{ $draft->Phone }}</td>
                                                            <td>{{ $draft->GrandTotal }}</td>
                                                            <td>{{ $draft->Paid != null ? $draft->Paid : '0' }}</td>
                                                            <td>{{ $draft->Balance != null ? $draft->Balance : '0' }}</td>

                                                            <td>
                                                                <div class="btn-group">
                                                                    <a href="{{ url('sales/' . $draft->InvoiceMasterID . '/edit') }}"
                                                                        class="btn btn-success btn-sm" title="Edit"><i
                                                                            class="dripicons-document-edit"></i></a>
                                                                    &nbsp; <a
                                                                        href="{{ url('print-voucher/' . $draft->InvoiceMasterID) }}"
                                                                        target="_blank" class="btn btn-primary btn-sm"
                                                                        title="Edit"><i
                                                                            class="dripicons-print"></i></a>&nbsp;<a
                                                                        href="{{ url('print-voucher/' . $draft->InvoiceMasterID . '/gift') }}"
                                                                        target="_blank" class="btn btn-secondary"
                                                                        title="gift print"><i
                                                                            class="dripicons-weight"></i></a>&nbsp;

                                                                    <form action="{{ url('cancelOrder') }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" id="cancelInvoiceMasterID"
                                                                            name="InvoiceMasterID"
                                                                            value="{{ $draft->InvoiceMasterID }}">
                                                                        <button type="submit" class="btn btn-danger "
                                                                            onclick="return confirmDelete()"
                                                                            title="Delete"><i
                                                                                class="dripicons-trash"></i></button>
                                                                    </form>
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
                <!-- add cash register modal -->
                <div id="cash-register-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <!-- enctype="multipart/form-data" -->
                            <form action="{{ route('cashRegister.store') }}" method="post"> {{ csrf_field() }}
                                <div class="modal-header">
                                    <h5 id="exampleModalLabel" class="modal-title">
                                        {{ trans('file.Add Cash Register') }}</h5>
                                    {{-- <button type="button" data-dismiss="modal" aria-label="Close"
                                        class="close"><span aria-hidden="true"><i
                                                class="dripicons-cross"></i></span></button> --}}
                                </div>
                                <div class="modal-body">
                                    <p class="italic">
                                        <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                                    </p>
                                    <div class="row">
                                        <div class="col-md-6 form-group warehouse-section">
                                            <label>{{ trans('file.Warehouse') }} *</strong> </label>
                                            <select required name="warehouse_id" class="selectpicker form-control"
                                                data-live-search="true" data-live-search-style="begins"
                                                title="Select warehouse...">
                                                @foreach ($lims_warehouse_list as $warehouse)
                                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>{{ trans('file.Cash in Hand') }} *</strong> </label>
                                            <input type="number" name="cash_in_hand" id="cashInHandAmount" required
                                                class="form-control" value="0">
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <button type="submit" id="submitBtn"
                                                class="btn btn-primary">{{ trans('file.submit') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- cash register details modal -->
                <div id="register-details-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 id="exampleModalLabel" class="modal-title">
                                    {{ trans('file.Cash Register Details') }}</h5>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                        aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                            </div>
                            <div class="modal-body">
                                <p>{{ trans('file.Please review the transaction and payments.') }}</p>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <td>{{ trans('file.Cash in Hand') }}:</td>
                                                    <td id="cash_in_hand" class="text-right">0</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('file.Total Sale Amount') }}:</td>
                                                    <td id="total_sale_amount" class="text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('file.Total Payment') }}:</td>
                                                    <td id="total_payment" class="text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('file.Cash Payment') }}:</td>
                                                    <td id="cash_payment" class="text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('file.Credit Card Payment') }}:</td>
                                                    <td id="credit_card_payment" class="text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('file.Cheque Payment') }}:</td>
                                                    <td id="cheque_payment" class="text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('file.Gift Card Payment') }}:</td>
                                                    <td id="gift_card_payment" class="text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('file.Deposit Payment') }}:</td>
                                                    <td id="deposit_payment" class="text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('file.Paypal Payment') }}:</td>
                                                    <td id="paypal_payment" class="text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('file.Total Sale Return') }}:</td>
                                                    <td id="total_sale_return" class="text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('file.Total Expense') }}:</td>
                                                    <td id="total_expense" class="text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>{{ trans('file.Total Cash') }}:</strong></td>
                                                    <td id="total_cash" class="text-right"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @if (Session::get('UserType') == 'Biller')
                                        <div class="col-md-6" id="closing-section">
                                            <form action="{{ URL('/cash-register/close') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="cash_register_id">
                                                <button type="submit"
                                                    class="btn btn-primary">{{ trans('file.Close Register') }}</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- today sale modal -->
                <div id="today-sale-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Today Sale') }}</h5>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                        aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                            </div>
                            <div class="modal-body">
                                <p>{{ trans('file.Please review the transaction and payments.') }}</p>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <td>{{ trans('file.Total Sale Amount') }}:</td>
                                                    <td class="total_sale_amount text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('file.Cash Payment') }}:</td>
                                                    <td class="cash_payment text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('file.Credit Card Payment') }}:</td>
                                                    <td class="credit_card_payment text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('file.Cheque Payment') }}:</td>
                                                    <td class="cheque_payment text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('file.Gift Card Payment') }}:</td>
                                                    <td class="gift_card_payment text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('file.Deposit Payment') }}:</td>
                                                    <td class="deposit_payment text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('file.Paypal Payment') }}:</td>
                                                    <td class="paypal_payment text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('file.Total Payment') }}:</td>
                                                    <td class="total_payment text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('file.Total Sale Return') }}:</td>
                                                    <td class="total_sale_return text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('file.Total Expense') }}:</td>
                                                    <td class="total_expense text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>{{ trans('file.Total Cash') }}:</strong></td>
                                                    <td class="total_cash text-right"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- today profit modal -->
                <div id="today-profit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Today Profit') }}</h5>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                        aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <select required name="warehouseId" class="form-control">
                                            <option value="0">{{ trans('file.All Warehouse') }}</option>
                                            @foreach ($lims_warehouse_list as $warehouse)
                                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <td>{{ trans('file.Product Revenue') }}:</td>
                                                    <td class="product_revenue text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('file.Product Cost') }}:</td>
                                                    <td class="product_cost text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('file.Expense') }}:</td>
                                                    <td class="expense_amount text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>{{ trans('file.Profit') }}:</strong></td>
                                                    <td class="profit text-right"></td>
                                                </tr>
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
    </section>

    <script type="text/javascript">
        // $(document).ready(function(){
        //     localStorage.clear();
        // })
        $(document).on('click', '.btn-topping', function() {
            $('#topping_item').val($(this).data('id'));
        });

        $('button[name="updatebtn"]').on("click", function() {

        });

        $("ul#sale").siblings('a').attr('aria-expanded', 'true');
        $("ul#sale").addClass("show");
        $("ul#sale #sale-pos-menu").addClass("active");

        var public_key = <?php echo json_encode($lims_pos_setting_data->stripe_public_key); ?>;
        var alert_product = <?php echo json_encode(123); ?>;
        var currency = <?php echo json_encode(config('currency')); ?>;
        var valid;

        // array data depend on warehouse
        var lims_product_array = [];
        var product_code = [];
        var product_name = [];
        var product_qty = [];
        var product_type = [];
        var product_id = [];
        var product_list = [];
        var qty_list = [];

        // array data with selection
        var product_price = [];
        var product_discount = [];
        var tax_rate = [];
        var tax_name = [];
        var tax_method = [];
        var unit_name = [];
        var unit_operator = [];
        var unit_operation_value = [];
        var gift_card_amount = [];
        var gift_card_expense = [];

        // temporary array
        var temp_unit_name = [];
        var temp_unit_operator = [];
        var temp_unit_operation_value = [];

        var deposit = <?php echo json_encode($deposit); ?>;
        var product_row_number = <?php echo json_encode($lims_pos_setting_data->product_number); ?>;
        var rowindex;
        var customer_group_rate;
        var row_product_price;
        var pos;
        var keyboard_active = <?php echo json_encode($keybord_active); ?>;
        var role_id = <?php echo json_encode(1); ?>;
        var warehouse_id = <?php echo json_encode(null); ?>;
        var biller_id = <?php echo json_encode(null); ?>;
        var coupon_list = <?php echo json_encode($lims_coupon_list); ?>;
        var currency = <?php echo json_encode(config('currency')); ?>;

        var localStorageQty = [];
        var localStorageProductId = [];
        var localStorageProductDiscount = [];
        var localStorageTaxRate = [];
        var localStorageNetUnitPrice = [];
        var localStorageTaxValue = [];
        var localStorageTaxName = [];
        var localStorageTaxMethod = [];
        var localStorageSubTotalUnit = [];
        var localStorageSubTotal = [];
        var localStorageProductCode = [];
        var localStorageItemType = [];
        var localStorageSaleUnit = [];
        var localStorageTempUnitName = [];
        var localStorageSaleUnitOperator = [];
        var localStorageSaleUnitOperationValue = [];
        var selectedservingType = '';
        var selectedState = 0;

        $("#reference-no").val(getSavedValue("reference-no"));
        $("#order-discount").val(getSavedValue("order-discount"));
        $("#order-tax-rate-select").val(getSavedValue("order-tax-rate-select"));

        var order_discount_type = getSavedValue("order_discount_type");
        if (order_discount_type == 'number') {
            $('#disc_number').prop('checked', true);
        }
        if (order_discount_type == 'percent') {
            $('#disc_percent').prop('checked', true)
        }

        $("#shipping-cost-val").val(getSavedValue("shipping-cost-val"));

        if (localStorage.getItem("tbody-id")) {
            $("#tbody-id").html(localStorage.getItem("tbody-id"));
        }

        function saveValue(e) {
            var id = e.id; // get the sender's id to save it.
            var val = e.value; // get the value.
            localStorage.setItem(id, val); // Every time user writing something, the localStorage's value will override.
        }
        //get the saved value function - return the value of "v" from localStorage.
        function getSavedValue(v) {
            if (!localStorage.getItem(v)) {
                return ""; // You can change this to your defualt value.
            }
            return localStorage.getItem(v);
        }

        if (getSavedValue("localStorageQty")) {
            localStorageQty = getSavedValue("localStorageQty").split(",");
            localStorageProductDiscount = getSavedValue("localStorageProductDiscount").split(",");
            localStorageTaxRate = getSavedValue("localStorageTaxRate").split(",");
            localStorageNetUnitPrice = getSavedValue("localStorageNetUnitPrice").split(",");
            localStorageTaxValue = getSavedValue("localStorageTaxValue").split(",");
            localStorageTaxName = getSavedValue("localStorageTaxName").split(",");
            localStorageTaxMethod = getSavedValue("localStorageTaxMethod").split(",");
            localStorageSubTotalUnit = getSavedValue("localStorageSubTotalUnit").split(",");
            localStorageSubTotal = getSavedValue("localStorageSubTotal").split(",");
            localStorageProductId = getSavedValue("localStorageProductId").split(",");
            localStorageProductCode = getSavedValue("localStorageProductCode").split(",");
            localStorageItemType = getSavedValue("localStorageItemType").split(",");
            localStorageSaleUnit = getSavedValue("localStorageSaleUnit").split(",");
            localStorageTempUnitName = getSavedValue("localStorageTempUnitName").split(",,");
            localStorageSaleUnitOperator = getSavedValue("localStorageSaleUnitOperator").split(",,");
            localStorageSaleUnitOperationValue = getSavedValue("localStorageSaleUnitOperationValue").split(",,");
            /*localStorageQty.pop();
            localStorage.setItem("localStorageQty", localStorageQty);*/
            for (var i = 0; i < localStorageQty.length; i++) {
                $('table.order-list tbody tr:nth-child(' + (i + 1) + ') .qty').val(localStorageQty[i]);
                $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.discount-value').val(
                    localStorageProductDiscount[i]);
                $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.tax-rate').val(localStorageTaxRate[i]);
                $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.net_unit_price').val(
                    localStorageNetUnitPrice[i]);
                $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.tax-value').val(localStorageTaxValue[i]);
                $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.tax-name').val(localStorageTaxName[i]);
                $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.tax-method').val(localStorageTaxMethod[i]);
                $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.product-price').text(
                    localStorageSubTotalUnit[i]);
                $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.sub-total').text(localStorageSubTotal[i]);
                $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.subtotal-value').val(localStorageSubTotal[
                    i]);
                $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.product-id').val(localStorageProductId[i]);
                $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.product-code').val(localStorageProductCode[
                    i]);
                $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.itemType').val(localStorageItemType[i]);
                $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.sale-unit').val(localStorageSaleUnit[i]);
                if (i == 0) {
                    localStorageTempUnitName[i] += ',';
                    localStorageSaleUnitOperator[i] += ',';
                    localStorageSaleUnitOperationValue[i] += ',';
                }
                $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.sale-unit-operator').val(
                    localStorageSaleUnitOperator[i]);
                $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.sale-unit-operation-value').val(
                    localStorageSaleUnitOperationValue[i]);

                product_price.push(parseFloat($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find(
                    '.product_price').val()));
                var quantity = parseFloat($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.qty').val());
                product_discount.push(parseFloat(localStorageProductDiscount[i] / localStorageQty[i]).toFixed(2));
                tax_rate.push(parseFloat($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.tax-rate')
                    .val()));
                tax_name.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.tax-name').val());
                tax_method.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.tax-method').val());
                temp_unit_name = $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.sale-unit').val().split(
                    ',');
                unit_name.push(localStorageTempUnitName[i]);
                unit_operator.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.sale-unit-operator')
                    .val());
                unit_operation_value.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find(
                    '.sale-unit-operation-value').val());
                $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.sale-unit').val(temp_unit_name[0]);
                calculateTotal();
                //calculateRowProductData(localStorageQty[i]);
            }
        }


        $('.selectpicker').selectpicker({
            style: 'btn-link',
        });

        if (keyboard_active == 1) {

            $("input.numkey:text").keyboard({
                usePreview: false,
                layout: 'custom',
                display: {
                    'accept': '&#10004;',
                    'cancel': '&#10006;'
                },
                customLayout: {
                    'normal': ['1 2 3', '4 5 6', '7 8 9', '0 {dec} {bksp}', '{clear} {cancel} {accept}']
                },
                restrictInput: true, // Prevent keys not in the displayed keyboard from being typed in
                preventPaste: true, // prevent ctrl-v and right click
                autoAccept: true,
                css: {
                    // input & preview
                    // keyboard container
                    container: 'center-block dropdown-menu', // jumbotron
                    // default state
                    buttonDefault: 'btn btn-default',
                    // hovered button
                    buttonHover: 'btn-primary',
                    // Action keys (e.g. Accept, Cancel, Tab, etc);
                    // this replaces "actionClass" option
                    buttonAction: 'active'
                },
            });

            $('input[type="text"]').keyboard({
                usePreview: false,
                autoAccept: true,
                autoAcceptOnEsc: true,
                css: {
                    // input & preview
                    // keyboard container
                    container: 'center-block dropdown-menu', // jumbotron
                    // default state
                    buttonDefault: 'btn btn-default',
                    // hovered button
                    buttonHover: 'btn-primary',
                    // Action keys (e.g. Accept, Cancel, Tab, etc);
                    // this replaces "actionClass" option
                    buttonAction: 'active',
                    // used when disabling the decimal button {dec}
                    // when a decimal exists in the input area
                    buttonDisabled: 'disabled'
                },
                change: function(e, keyboard) {
                    keyboard.$el.val(keyboard.$preview.val())
                    keyboard.$el.trigger('propertychange')
                }
            });

            $('textarea').keyboard({
                usePreview: false,
                autoAccept: true,
                autoAcceptOnEsc: true,
                css: {
                    // input & preview
                    // keyboard container
                    container: 'center-block dropdown-menu', // jumbotron
                    // default state
                    buttonDefault: 'btn btn-default',
                    // hovered button
                    buttonHover: 'btn-primary',
                    // Action keys (e.g. Accept, Cancel, Tab, etc);
                    // this replaces "actionClass" option
                    buttonAction: 'active',
                    // used when disabling the decimal button {dec}
                    // when a decimal exists in the input area
                    buttonDisabled: 'disabled'
                },
                change: function(e, keyboard) {
                    keyboard.$el.val(keyboard.$preview.val())
                    keyboard.$el.trigger('propertychange')
                }
            });

            $('#lims_productcodeSearch').keyboard().autocomplete().addAutocomplete({
                // add autocomplete window positioning
                // options here (using position utility)
                position: {
                    of: '#lims_productcodeSearch',
                    my: 'top+18px',
                    at: 'center',
                    collision: 'flip'
                }
            });
        }

        $("li#notification-icon").on("click", function(argument) {
            $.get('notifications/mark-as-read', function(data) {
                $("span.notification-number").text(alert_product);
            });
        });

        $("#register-details-btn").on("click", function(e) {
            e.preventDefault();
            $.ajax({
                url: 'cash-register/showDetails/' + warehouse_id,
                type: "GET",
                success: function(data) {
                    $('#register-details-modal #cash_in_hand').text(data['cash_in_hand']);
                    $('#register-details-modal #total_sale_amount').text(data['total_sale_amount']);
                    $('#register-details-modal #total_payment').text(data['total_payment']);
                    $('#register-details-modal #cash_payment').text(data['cash_payment']);
                    $('#register-details-modal #credit_card_payment').text(data['credit_card_payment']);
                    $('#register-details-modal #cheque_payment').text(data['cheque_payment']);
                    $('#register-details-modal #gift_card_payment').text(data['gift_card_payment']);
                    $('#register-details-modal #deposit_payment').text(data['deposit_payment']);
                    $('#register-details-modal #paypal_payment').text(data['paypal_payment']);
                    $('#register-details-modal #total_sale_return').text(data['total_sale_return']);
                    $('#register-details-modal #total_expense').text(data['total_expense']);
                    $('#register-details-modal #total_cash').text(data['total_cash']);
                    $('#register-details-modal input[name=cash_register_id]').val(data['id']);
                }
            });
            $('#register-details-modal').modal('show');
        });

        $("#today-sale-btn").on("click", function(e) {
            e.preventDefault();
            $.ajax({
                url: 'sales/today-sale/',
                type: "GET",
                success: function(data) {
                    $('#today-sale-modal .total_sale_amount').text(data['total_sale_amount']);
                    $('#today-sale-modal .total_payment').text(data['total_payment']);
                    $('#today-sale-modal .cash_payment').text(data['cash_payment']);
                    $('#today-sale-modal .credit_card_payment').text(data['credit_card_payment']);
                    $('#today-sale-modal .cheque_payment').text(data['cheque_payment']);
                    $('#today-sale-modal .gift_card_payment').text(data['gift_card_payment']);
                    $('#today-sale-modal .deposit_payment').text(data['deposit_payment']);
                    $('#today-sale-modal .paypal_payment').text(data['paypal_payment']);
                    $('#today-sale-modal .total_sale_return').text(data['total_sale_return']);
                    $('#today-sale-modal .total_expense').text(data['total_expense']);
                    $('#today-sale-modal .total_cash').text(data['total_cash']);
                }
            });
            $('#today-sale-modal').modal('show');
        });

        $("#today-profit-btn").on("click", function(e) {
            e.preventDefault();
            calculateTodayProfit(0);
        });

        $("#today-profit-modal select[name=warehouseId]").on("change", function() {
            calculateTodayProfit($(this).val());
        });

        function calculateTodayProfit(warehouse_id) {
            $.ajax({
                url: 'sales/today-profit/' + warehouse_id,
                type: "GET",
                success: function(data) {
                    $('#today-profit-modal .product_revenue').text(data['product_revenue']);
                    $('#today-profit-modal .product_cost').text(data['product_cost']);
                    $('#today-profit-modal .expense_amount').text(data['expense_amount']);
                    $('#today-profit-modal .profit').text(data['profit']);
                }
            });
            $('#today-profit-modal').modal('show');
        }

        if (role_id > 2) {
            $('#biller_id').addClass('d-none');
            $('#warehouse_id').addClass('d-none');
            $('select[name=warehouse_id]').val(warehouse_id);
            $('select[name=biller_id]').val(biller_id);
            isCashRegisterAvailable(warehouse_id);
        } else {
            if (getSavedValue("warehouse_id")) {
                warehouse_id = getSavedValue("warehouse_id");
            } else {
                warehouse_id = $("input[name='warehouse_id_hidden']").val();
            }

            if (getSavedValue("biller_id")) {
                biller_id = getSavedValue("biller_id");
            } else {
                biller_id = $("input[name='biller_id_hidden']").val();
            }
            $('select[name=warehouse_id]').val(warehouse_id);
            $('select[name=biller_id]').val(biller_id);
        }

        if (getSavedValue("biller_id")) {
            $('select[name=customer_id]').val(getSavedValue("customer_id"));
        } else {
            $('select[name=customer_id]').val($("input[name='customer_id_hidden']").val());
        }

        $('.selectpicker').selectpicker('refresh');

        var id = $("#customer_id").val();
        $.get('sales/getcustomergroup/' + id, function(data) {
            customer_group_rate = (data / 100);
        });

        var id = $("#warehouse_id").val();
        $.get('sales/getproduct/' + id, function(data) {
            lims_product_array = [];
            product_code = data[0];
            product_name = data[1];
            product_qty = data[2];
            product_type = data[3];
            product_id = data[4];
            product_list = data[5];
            qty_list = data[6];
            product_warehouse_price = data[7];
            batch_no = data[8];
            product_batch_id = data[9];
            $.each(product_code, function(index) {
                lims_product_array.push(product_code[index] + ' (' + product_name[index] + ')');
            });
        });

        isCashRegisterAvailable(id);

        function isCashRegisterAvailable(warehouse_id) {
            $.ajax({
                url: 'cash-register/check-availability/' + warehouse_id,
                type: "GET",
                success: function(data) {
                    if (data == 'false') {
                        $("#register-details-btn").addClass('d-none');
                        $('#cash-register-modal select[name=warehouse_id]').val(warehouse_id);

                        if (role_id <= 2)
                            $("#cash-register-modal .warehouse-section").removeClass('d-none');
                        else
                            $("#cash-register-modal .warehouse-section").addClass('d-none');

                        $('.selectpicker').selectpicker('refresh');
                        // $("#cash-register-modal").modal('show');
                        var modal = $('#cash-register-modal');

                        // Prevent the modal from closing when clicking outside of it
                        modal.modal({
                            backdrop: 'static',
                            keyboard: false
                        });

                        // Add a click event to the submit button to close the modal
                        $('#submitBtn').on('click', function() {
                            var cashInHandAmount = $('#cashInHandAmount').val();
                            if (cashInHandAmount != '')
                                modal.modal('hide');
                        });
                    } else
                        $("#register-details-btn").removeClass('d-none');
                }
            });
        }

        if (keyboard_active == 1) {
            $('#lims_productcodeSearch').bind('keyboardChange', function(e, keyboard, el) {
                var customer_id = $('#customer_id').val();
                var warehouse_id = $('select[name="warehouse_id"]').val();
                temp_data = $('#lims_productcodeSearch').val();
                if (!customer_id) {
                    $('#lims_productcodeSearch').val(temp_data.substring(0, temp_data.length - 1));
                    alert('Please select Customer!');
                } else if (!warehouse_id) {
                    $('#lims_productcodeSearch').val(temp_data.substring(0, temp_data.length - 1));
                    alert('Please select Warehouse!');
                }
            });
        } else {
            $('#lims_productcodeSearch').on('input', function() {
                var customer_id = $('#customer_id').val();
                var warehouse_id = $('#warehouse_id').val();
                temp_data = $('#lims_productcodeSearch').val();
                if (!customer_id) {
                    $('#lims_productcodeSearch').val(temp_data.substring(0, temp_data.length - 1));
                    alert('Please select Customer!');
                } else if (!warehouse_id) {
                    $('#lims_productcodeSearch').val(temp_data.substring(0, temp_data.length - 1));
                    alert('Please select Warehouse!');
                }

            });
        }

        $("#print-btn").on("click", function() {
            var divToPrint = document.getElementById('sale-details');
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write(
                '<link rel="stylesheet" href="<?php echo asset('public/vendor/bootstrap/css/bootstrap.min.css'); ?>" type="text/css"><style type="text/css">@media print {.modal-dialog { max-width: 1000px;} }</style><body onload="window.print()">' +
                divToPrint.innerHTML + '</body>');
            newWin.document.close();
            setTimeout(function() {
                newWin.close();
            }, 10);
        });

        $('body').on('click', function(e) {
            $('.filter-window').hide('slide', {
                direction: 'right'
            }, 'fast');
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
            $.get('sales/getproduct/' + category_id + '/' + brand_id, function(data) {
                populateProduct(data);
            });
        });

        $('#dish-filter').on('click', function(e) {
            e.stopPropagation();
            $('.filter-window').show('slide', {
                direction: 'right'
            }, 'fast');
            $('.dish').show();
            $('.category').hide();
            $('.brand').hide();
        });

        $('.dish-img').on('click', function() {
            var dish_id = $(this).data('dish');

            $(".table-container").children().remove();
            $.get('get-dish-types-by-filter/' + dish_id, function(data) {
                var tableData =
                    '<table id="product-table" class="table no-shadow product-list"> <thead class="d-none"> <tr> <th></th> <th></th> <th></th> <th></th> <th></th> </tr></thead> <tbody><tr>';

                if (Object.keys(data).length != 0) {
                    $.each(data['name'], function(index) {
                        var product_info = data['code'][index] + ' (' + data['name'][index] + ')';
                        var url = '{{ URL::asset('/assets/images/dish-types/') }}/';
                        if (index % 5 == 0 && index != 0)
                            tableData += '</tr><tr><td class="product-img sound-btn" title="' +
                            data['name'][index] + '" data-product = "' + product_info +
                            '"><img  src="' + url + '' + data['image'][index] +
                            '" width="100%" /><p>' + data['name'][index] + '</p><span>' + data[
                                'code'][index] + '</span></td>';
                        else
                            tableData += '<td class="product-img sound-btn" title="' + data['name'][
                                index
                            ] + '" data-product = "' + product_info + '"><img  src="' + url + '' +
                            data['image'][index] + '" width="100%" /><p>' + data['name'][index] +
                            '</p><span>' + data['code'][index] + '</span></td>';
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
            $.get('sales/getproduct/' + category_id + '/' + brand_id, function(data) {
                populateProduct(data);
            });
        });

        $('#featured-filter').on('click', function() {
            $(".table-container").children().remove();
            $.get('sales/getfeatured', function(data) {
                populateProduct(data);
            });
        });

        function populateProduct(data) {
            var tableData =
                '<table id="product-table" class="table no-shadow product-list"> <thead class="d-none"> <tr> <th></th> <th></th> <th></th> <th></th> <th></th> </tr></thead> <tbody><tr>';

            if (Object.keys(data).length != 0) {
                $.each(data['name'], function(index) {
                    var product_info = data['code'][index] + ' (' + data['name'][index] + ')';
                    var base_url = "{{ asset('assets/images/items') }}/" + data['image'][index];
                    if (index % 5 == 0 && index != 0)
                        tableData += '</tr><tr><td class="product-img sound-btn" title="' + data['name'][index] +
                        '" data-product = "' + product_info + '"><img  src="' + base_url + '" width="100%" /><p>' +
                        data['name'][index] + '</p><span>' + data['code'][index] + '</span><br><small>AED:' + data[
                            'SellingPrice'][index] + '</small></td>';
                    else
                        tableData += '<td class="product-img sound-btn" title="' + data['name'][index] +
                        '" data-product = "' + product_info + '"><img  src="' + base_url + '" width="100%" /><p>' +
                        data['name'][index] + '</p><span>' + data['code'][index] + '</span><br><small>AED: ' + data[
                            'SellingPrice'][index] + '</small></td>';
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

        $('select[name="customer_id"]').on('change', function() {
            saveValue(this);
            var id = $(this).val();
            $.get('sales/getcustomergroup/' + id, function(data) {
                customer_group_rate = (data / 100);
            });
        });

        $('select[name="biller_id"]').on('change', function() {
            saveValue(this);
        });

        $('select[name="warehouse_id"]').on('change', function() {
            saveValue(this);
            warehouse_id = $(this).val();
            $.get('sales/getproduct/' + warehouse_id, function(data) {
                lims_product_array = [];
                product_code = data[0];
                product_name = data[1];
                product_qty = data[2];
                product_type = data[3];
                product_id = data[4];
                product_list = data[5];
                qty_list = data[6];
                product_warehouse_price = data[7];
                batch_no = data[8];
                product_batch_id = data[9];
                $.each(product_code, function(index) {
                    lims_product_array.push(product_code[index] + ' (' + product_name[index] + ')');
                });
            });

            isCashRegisterAvailable(warehouse_id);
        });

        var lims_productcodeSearch = $('#lims_productcodeSearch');

        lims_productcodeSearch.autocomplete({
            source: function(request, response) {
                var matcher = new RegExp(".?" + $.ui.autocomplete.escapeRegex(request.term), "i");
                response($.grep(lims_product_array, function(item) {
                    return matcher.test(item);
                }));
            },
            response: function(event, ui) {
                if (ui.content.length == 1) {
                    var data = ui.content[0].value;
                    $(this).autocomplete("close");
                    productSearch(data);
                };
            },
            select: function(event, ui) {
                var data = ui.item.value;
                productSearch(data);
            },
        });

        $('#myTable').keyboard({
            accepted: function(event, keyboard, el) {
                checkQuantity(el.value, true);
            }
        });

        $("#myTable").on('click', '.plus', function() {
            rowindex = $(this).closest('tr').index();
            var qty = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val();

            if (!qty)
                qty = 1;
            else
                qty = parseFloat(qty) + 1;

            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(qty);
            checkQuantity(String(qty), true);
            localStorage.setItem("tbody-id", $("table.order-list tbody").html());
        });

        $("#myTable").on('click', '.minus', function() {
            rowindex = $(this).closest('tr').index();
            var qty = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val()) - 1;
            if (qty > -10) {
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(qty);
            } else {
                qty = 1;
            }
            checkQuantity(String(qty), true);
        });

        $("#myTable").on("change", ".batch-no", function() {
            rowindex = $(this).closest('tr').index();
            var product_id = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-id')
                .val();
            var warehouse_id = $('#warehouse_id').val();
            $.get('check-batch-availability/' + product_id + '/' + $(this).val() + '/' + warehouse_id, function(
                data) {
                console.log(data);
                if (data['message'] != 'ok') {
                    alert(data['message']);
                    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.batch-no').val(
                        '');
                    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find(
                        '.product-batch-id').val('');
                } else {
                    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find(
                        '.product-batch-id').val(data['product_batch_id']);
                    code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find(
                        '.product-code').val();
                    pos = product_code.indexOf(code);
                    product_qty[pos] = data['qty'];
                }
            });
        });

        //Change quantity
        $("#myTable").on('input', '.qty', function() {
            rowindex = $(this).closest('tr').index();
            if ($(this).val() < 0 && $(this).val() != '') {
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(1);
                alert("Quantity can't be less than 0");
            }
            checkQuantity($(this).val(), true);
        });

        $("#myTable").on('click', '.qty', function() {
            rowindex = $(this).closest('tr').index();
        });

        $(document).on('click', '.sound-btn', function() {
            var audio = $("#mysoundclip1")[0];
            audio.play();
        });

        $(document).on('click', '.product-img', function() {
            var customer_id = $('#customer_id').val();
            var warehouse_id = $('select[name="warehouse_id"]').val();
            if (!customer_id)
                alert('Please select Customer!');
            else if (!warehouse_id)
                alert('Please select Warehouse!');
            else {
                var data = $(this).data('product');
                data = data.split(" ");
                pos = product_code.indexOf(data[0]);
                // if (pos <= 0)
                if (pos < 0)
                    alert('Product is not avaialable in the selected warehouse');
                else {
                    productSearch(data[0]);
                }
            }
        });
        //Delete product
        $("table.order-list tbody").on("click", ".ibtnDel", function(event) {
            var audio = $("#mysoundclip2")[0];
            audio.play();
            rowindex = $(this).closest('tr').index();
            product_price.splice(rowindex, 1);
            product_discount.splice(rowindex, 1);
            tax_rate.splice(rowindex, 1);
            tax_name.splice(rowindex, 1);
            tax_method.splice(rowindex, 1);
            unit_name.splice(rowindex, 1);
            unit_operator.splice(rowindex, 1);
            unit_operation_value.splice(rowindex, 1);

            localStorageProductId.splice(rowindex, 1);
            localStorageQty.splice(rowindex, 1);
            localStorageSaleUnit.splice(rowindex, 1);
            localStorageProductDiscount.splice(rowindex, 1);
            localStorageTaxRate.splice(rowindex, 1);
            localStorageNetUnitPrice.splice(rowindex, 1);
            localStorageTaxValue.splice(rowindex, 1);
            localStorageSubTotalUnit.splice(rowindex, 1);
            localStorageSubTotal.splice(rowindex, 1);
            localStorageProductCode.splice(rowindex, 1);
            localStorageItemType.splice(rowindex, 1);

            localStorageTaxName.splice(rowindex, 1);
            localStorageTaxMethod.splice(rowindex, 1);
            localStorageTempUnitName.splice(rowindex, 1);
            localStorageSaleUnitOperator.splice(rowindex, 1);
            localStorageSaleUnitOperationValue.splice(rowindex, 1);

            localStorage.setItem("localStorageProductId", localStorageProductId);
            localStorage.setItem("localStorageQty", localStorageQty);
            localStorage.setItem("localStorageSaleUnit", localStorageSaleUnit);
            localStorage.setItem("localStorageProductCode", localStorageProductCode);
            localStorage.setItem("localStorageItemType", localStorageItemType);
            localStorage.setItem("localStorageProductDiscount", localStorageProductDiscount);
            localStorage.setItem("localStorageTaxRate", localStorageTaxRate);
            localStorage.setItem("localStorageTaxName", localStorageTaxName);
            localStorage.setItem("localStorageTaxMethod", localStorageTaxMethod);
            localStorage.setItem("localStorageTempUnitName", localStorageTempUnitName);
            localStorage.setItem("localStorageSaleUnitOperator", localStorageSaleUnitOperator);
            localStorage.setItem("localStorageSaleUnitOperationValue", localStorageSaleUnitOperationValue);
            localStorage.setItem("localStorageNetUnitPrice", localStorageNetUnitPrice);
            localStorage.setItem("localStorageTaxValue", localStorageTaxValue);
            localStorage.setItem("localStorageSubTotalUnit", localStorageSubTotalUnit);
            localStorage.setItem("localStorageSubTotal", localStorageSubTotal);

            $(this).closest("tr").remove();
            localStorage.setItem("tbody-id", $("table.order-list tbody").html());
            calculateTotal();
        });

        //Edit product
        $("table.order-list").on("click", ".edit-product", function() {
            rowindex = $(this).closest('tr').index();
            edit();
        });

        //Update product
        $('button[name="update_btn"]').on("click", function() {
            var edit_discount = $('input[name="edit_discount"]').val();
            var edit_qty = $('input[name="edit_qty"]').val();
            var edit_unit_price = $('input[name="edit_unit_price"]').val();

            if (parseFloat(edit_discount) > parseFloat(edit_unit_price)) {
                alert('Invalid Discount Input!');
                return;
            }

            if (edit_qty < 1) {
                $('input[name="edit_qty"]').val(1);
                edit_qty = 1;
                alert("Quantity can't be less than 1");
            }

            var tax_rate_all = <?php echo json_encode($tax_rate_all); ?>;

            tax_rate[rowindex] = localStorageTaxRate[rowindex] = parseFloat(tax_rate_all[$(
                'select[name="edit_tax_rate"]').val()]);
            tax_name[rowindex] = localStorageTaxName[rowindex] = $('select[name="edit_tax_rate"] option:selected')
                .text();

            product_discount[rowindex] = $('input[name="edit_discount"]').val();
            if (product_type[pos] == 'standard') {
                var row_unit_operator = unit_operator[rowindex].slice(0, unit_operator[rowindex].indexOf(","));
                var row_unit_operation_value = unit_operation_value[rowindex].slice(0, unit_operation_value[
                    rowindex].indexOf(","));
                if (row_unit_operator == '*') {
                    product_price[rowindex] = $('input[name="edit_unit_price"]').val() / row_unit_operation_value;
                } else {
                    product_price[rowindex] = $('input[name="edit_unit_price"]').val() * row_unit_operation_value;
                }
                var position = $('select[name="edit_unit"]').val();
                var temp_operator = temp_unit_operator[position];
                var temp_operation_value = temp_unit_operation_value[position];
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.sale-unit').val(
                    temp_unit_name[position]);
                temp_unit_name.splice(position, 1);
                temp_unit_operator.splice(position, 1);
                temp_unit_operation_value.splice(position, 1);

                temp_unit_name.unshift($('select[name="edit_unit"] option:selected').text());
                temp_unit_operator.unshift(temp_operator);
                temp_unit_operation_value.unshift(temp_operation_value);

                unit_name[rowindex] = localStorageTempUnitName[rowindex] = temp_unit_name.toString() + ',';
                unit_operator[rowindex] = localStorageSaleUnitOperator[rowindex] = temp_unit_operator.toString() +
                    ',';
                unit_operation_value[rowindex] = localStorageSaleUnitOperationValue[rowindex] =
                    temp_unit_operation_value.toString() + ',';

                localStorage.setItem("localStorageTaxRate", localStorageTaxRate);
                localStorage.setItem("localStorageTaxName", localStorageTaxName);
                localStorage.setItem("localStorageTempUnitName", localStorageTempUnitName);
                localStorage.setItem("localStorageSaleUnitOperator", localStorageSaleUnitOperator);
                localStorage.setItem("localStorageSaleUnitOperationValue", localStorageSaleUnitOperationValue);
            } else {
                product_price[rowindex] = $('input[name="edit_unit_price"]').val();
            }
            checkQuantity(edit_qty, false);
        });

        $('button[name="order_discount_btn"]').on("click", function() {
            calculateGrandTotal();
        });

        $('button[name="shipping_cost_btn"]').on("click", function() {
            calculateGrandTotal();
        });
        $('button[name="add_delivery_btn"]').on("click", function() {
            selectedState = $('#delivery_state_shipping').val();
            // alert(selectedState);
            localStorage.setItem('shipping-cost-val', selectedState);
            $('input[name="shipping_cost"]').val(selectedState);

            calculateGrandTotal();
        });

        $('button[name="order_tax_btn"]').on("click", function() {

            calculateGrandTotal();
        });

        $(".coupon-check").on("click", function() {
            couponDiscount();
        });

        $(".payment-btn").on("click", function() {
            var audio = $("#mysoundclip2")[0];
            audio.play();
            $('input[name="paid_amount"]').val($("#grand-total").text());
            $('input[name="paying_amount"]').val($("#grand-total").text());
            $('.qc').data('initial', 1);
        });

        $("#draft-btn").on("click", function() {
            var audio = $("#mysoundclip2")[0];
            audio.play();
            $('input[name="sale_status"]').val(3);
            $('input[name="paying_amount"]').prop('required', false);
            $('input[name="paid_amount"]').prop('required', false);
            var rownumber = $('table.order-list tbody tr:last').index();
            if (rownumber < 0) {
                alert("Please insert product to order table!")
            } else {
                selectedservingType = $("input[name='servingType']:checked").val();
                var deliveryAddress = $("input[name='DeliveryAddress']").val();
                selectedState = $('#delivery_state_shipping').val();
                var driverName = $("input[name='driverName']").val();
                // alert(deliveryAddress);
                // alert(selectedState);

                if (selectedservingType == 'delivery') {
                    if (selectedState == 0) {
                        alert('Please Select City for Delivery');
                        $('#delivery-modal').modal('show');
                    } else if (deliveryAddress == '') {
                        alert('Please Add Address for Delivery');
                        $('#delivery-modal').modal('show');
                    } else if (driverName == '') {
                        alert('Please Add Driver Name for Delivery');
                        $('#delivery-modal').modal('show');
                    } else {
                        // $('input[name="future_paid_amount"]').val($("#grand-total").text());
                        $('input[name="future_paying_amount"]').val($("#grand-total").text());
                        $('#add-future-payment').modal('show');

                    }

                } else {
                    // $('input[name="future_paid_amount"]').val($("#grand-total").text());
                    $('input[name="future_paying_amount"]').val($("#grand-total").text());
                    $('#add-future-payment').modal('show');

                }
            }
        });

        $("#submit-btn").on("click", function() {
            // alert('here');
            selectedservingType = $("input[name='servingType']:checked").val();
            var deliveryAddress = $("input[name='DeliveryAddress']").val();
            selectedState = $('#delivery_state_shipping').val();
            var driverName = $("input[name='driverName']").val();
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
                    localStorage.clear();
                    // alert($("#GiftInvoice1").val());
                    $('input[name="GiftInvoice"]').val($("#GiftInvoice1").val());
                    $('.payment-form').submit();
                }

            } else {
                localStorage.clear();
                // alert($("#GiftInvoice1").val());
                $('input[name="GiftInvoice"]').val($("#GiftInvoice1").val());
                $('.payment-form').submit();
            }

        });
        $("#future-submit-btn").on("click", function() {
            // alert('here');
            selectedservingType = $("input[name='servingType']:checked").val();
            $('#future_paid_by_id').val($('#future_paid_by_id_select').val());
            var deliveryAddress = $("input[name='DeliveryAddress']").val();
            selectedState = $('#delivery_state_shipping').val();
            var driverName = $("input[name='driverName']").val();
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
                    localStorage.clear();
                    // alert($("#GiftInvoice1").val());
                    $('input[name="GiftInvoice"]').val($("#GiftInvoice1").val());
                    $('.payment-form').submit();
                }

            } else {
                localStorage.clear();
                // alert($("#GiftInvoice1").val());
                $('input[name="GiftInvoice"]').val($("#GiftInvoice1").val());
                $('.payment-form').submit();
            }

        });

        $("#gift-card-btn").on("click", function() {
            $('select[name="paid_by_id_select"]').val(2);
            $('.selectpicker').selectpicker('refresh');
            $('div.qc').hide();
            giftCard();
        });

        $("#credit-card-btn").on("click", function() {
            $('select[name="paid_by_id_select"]').val(3);
            $('.selectpicker').selectpicker('refresh');
            $('div.qc').hide();
            creditCard();
        });

        $("#cheque-btn").on("click", function() {
            $('select[name="paid_by_id_select"]').val(4);
            $('.selectpicker').selectpicker('refresh');
            $('div.qc').hide();
            cheque();
        });

        $("#cash-print-btn").on("click", function() {
            $('select[name="paid_by_id_select"]').val(1);
            $('.selectpicker').selectpicker('refresh');
            $('#print_status').val(1);
            $('div.qc').show();
            hide();
        });

        $("#cash-new-btn").on("click", function() {
            $('select[name="paid_by_id_select"]').val(1);
            $('.selectpicker').selectpicker('refresh');
            $('#print_status').val(0);
            $('div.qc').show();
            hide();
        });

        $("#paypal-btn").on("click", function() {
            $('select[name="paid_by_id_select"]').val(5);
            $('.selectpicker').selectpicker('refresh');
            $('div.qc').hide();
            hide();
        });

        $("#deposit-btn").on("click", function() {
            $('select[name="paid_by_id_select"]').val(6);
            $('.selectpicker').selectpicker('refresh');
            $('div.qc').hide();
            hide();
            deposits();
        });

        $('select[name="paid_by_id_select"]').on("change", function() {
            var id = $(this).val();
            $(".payment-form").off("submit");
            if (id == 3) {
                $('div.qc').hide();
                creditCard();
            } else if (id == 4) {
                $('div.qc').hide();
                cheque();
            } else if (id == 6 || id == 7) {
                $('div.qc').hide();
                chequeAndCard();
            } else {
                hide();
                if (id == 1)
                    $('div.qc').show();
                else if (id == 6 || id == 7) {
                    $('div.qc').hide();
                    deposits();
                }
            }
        });

        $('#add-payment select[name="gift_card_id_select"]').on("change", function() {
            var balance = gift_card_amount[$(this).val()] - gift_card_expense[$(this).val()];
            $('#add-payment input[name="gift_card_id"]').val($(this).val());
            if ($('input[name="paid_amount"]').val() > balance) {
                alert('Amount exceeds card balance! Gift Card balance: ' + balance);
            }
        });

        $('#add-payment input[name="paying_amount"]').on("input", function() {
            change($(this).val(), $('input[name="paid_amount"]').val());
        });

        $('input[name="paid_amount"]').on("input", function() {
            if ($(this).val() > parseFloat($('input[name="paying_amount"]').val())) {
                alert('Paying amount cannot be bigger than recieved amount');
                $(this).val('');
            } else if ($(this).val() > parseFloat($('#grand-total').text())) {
                alert('Paying amount cannot be bigger than grand total');
                $(this).val('');
            }

            change($('input[name="paying_amount"]').val(), $(this).val());
            var id = $('select[name="paid_by_id_select"]').val();
            if (id == 2) {
                var balance = gift_card_amount[$("#gift_card_id_select").val()] - gift_card_expense[$(
                    "#gift_card_id_select").val()];
                if ($(this).val() > balance)
                    alert('Amount exceeds card balance! Gift Card balance: ' + balance);
            } else if (id == 6 || id == 7) {
                if ($('input[name="paid_amount"]').val() > deposit[$('#customer_id').val()])
                    alert('Amount exceeds customer deposit! Customer deposit : ' + deposit[$('#customer_id')
                        .val()]);
            }
        });

        $('.transaction-btn-plus').on("click", function() {
            $(this).addClass('d-none');
            $('.transaction-btn-close').removeClass('d-none');
        });

        $('.transaction-btn-close').on("click", function() {
            $(this).addClass('d-none');
            $('.transaction-btn-plus').removeClass('d-none');
        });

        $('.coupon-btn-plus').on("click", function() {
            $(this).addClass('d-none');
            $('.coupon-btn-close').removeClass('d-none');
        });

        $('.coupon-btn-close').on("click", function() {
            $(this).addClass('d-none');
            $('.coupon-btn-plus').removeClass('d-none');
        });

        $(document).on('click', '.qc-btn', function(e) {
            if ($(this).data('amount')) {
                if ($('.qc').data('initial')) {
                    $('input[name="paying_amount"]').val($(this).data('amount').toFixed(2));
                    $('.qc').data('initial', 0);
                } else {
                    $('input[name="paying_amount"]').val((parseFloat($('input[name="paying_amount"]').val()) + $(
                        this).data('amount')).toFixed(2));
                }
            } else
                $('input[name="paying_amount"]').val('0.00');
            change($('input[name="paying_amount"]').val(), $('input[name="paid_amount"]').val());
        });

        function change(paying_amount, paid_amount) {
            $("#change").text(parseFloat(paying_amount - paid_amount).toFixed(2));
        }

        function confirmDelete() {
            if (confirm("Are you sure want to delete?")) {
                return true;
            }
            return false;
        }

        function productSearch(data) {
            $.ajax({
                type: 'GET',
                url: 'sales/lims_product_search',
                data: {
                    data: data
                },
                success: function(data) {
                    var flag = 1;
                    $(".product-code").each(function(i) {
                        if ($(this).val() == data[1]) {
                            rowindex = i;
                            var pre_qty = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) +
                                ') .qty').val();
                            if (pre_qty)
                                var qty = parseFloat(pre_qty) + 1;
                            else
                                var qty = 1;
                            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(
                                qty);
                            flag = 0;
                            checkQuantity(String(qty), true);
                            flag = 0;
                            localStorage.setItem("tbody-id", $("table.order-list tbody").html());
                        }
                    });
                    $("input[name='product_code_name']").val('');
                    if (flag) {
                        addNewProduct(data);
                    }
                }
            });
        }

        function addNewProduct(data) {
            var newRow = $("<tr>");
            var cols = '';
            temp_unit_name = (data[6]).split(',');
            pos = product_code.indexOf(data[1]);
            cols +=
                '<td class="col-sm-2 product-title"><button type="button" class="edit-product btn btn-link" data-toggle="modal" data-target="#editModal"><strong>' +
                data[0] + '</strong></button><br>' + data[1] + '<a type="button" data-id="' + data[9] +
                '" class="btn-topping btn btn-sm" data-toggle="modal" title="Extra-Topping" data-target="#toppingModal"><i class="fa fa-eye"></i></a><p>In Stock: <span class="in-stock"></span></p></td>';
            if (data[12]) {
                cols += '<td class="col-sm-2"><input type="text" class="form-control batch-no" value="' + batch_no[pos] +
                    '" required/> <input type="hidden" class="product-batch-id" name="product_batch_id[]" value="' +
                    product_batch_id[pos] + '"/> </td>';
            } else {
                cols +=
                    '<td class="col-sm-2"><input type="hidden" class="form-control batch-no" disabled/> <input type="hidden" class="product-batch-id" name="product_batch_id[]"/> </td>';
            }
            if (data[13] == 'dishItem') {
                cols += '<input type="hidden" class="itemType" name="itemType[]" value="dish"/>';
            } else {
                cols += '<input type="hidden" class="itemType" name="itemType[]" value="pos"/>';
            }
            cols += '<td class="col-sm-2 product-price"></td>';
            cols +=
                '<td class="col-sm-3"><div class="input-group"><span class="input-group-btn"><button type="button" class="btn btn-default minus"><span class="dripicons-minus"></span></button></span><input type="text" name="qty[]" class="form-control qty numkey input-number" step="any" required><span class="input-group-btn"><button type="button" class="btn btn-default plus"><span class="dripicons-plus"></span></button></span></div></td>';
            cols += '<td class="col-sm-2 sub-total"></td>';
            cols +=
                '<td class="col-sm-1"><button type="button" class="ibtnDel btn btn-danger btn-sm"><i class="dripicons-cross"></i></button></td>';
            cols += '<input type="hidden" class="product-code" name="product_code[]" value="' + data[1] + '"/>';
            cols += '<input type="hidden" class="product-id" name="product_id[]" value="' + data[9] + '"/>';
            cols += '<input type="hidden" class="product_price" />';
            cols += '<input type="hidden" class="sale-unit" name="sale_unit[]" value="' + temp_unit_name[0] + '"/>';
            cols += '<input type="hidden" class="net_unit_price" name="net_unit_price[]" />';
            cols += '<input type="hidden" class="discount-value" name="discount[]" />';
            cols += '<input type="hidden" class="tax-rate" name="tax_rate[]" value="' + data[3] + '"/>';
            cols += '<input type="hidden" class="tax-value" name="tax[]" />';
            cols += '<input type="hidden" class="tax-name" value="' + data[4] + '" />';
            cols += '<input type="hidden" class="tax-method" value="' + data[5] + '" />';
            cols += '<input type="hidden" class="sale-unit-operator" value="' + data[7] + '" />';
            cols += '<input type="hidden" class="sale-unit-operation-value" value="' + data[8] + '" />';
            cols += '<input type="hidden" class="subtotal-value" name="subtotal[]" />';

            newRow.append(cols);
            if (keyboard_active == 1) {
                $("table.order-list tbody").prepend(newRow).find('.qty').keyboard({
                    usePreview: false,
                    layout: 'custom',
                    display: {
                        'accept': '&#10004;',
                        'cancel': '&#10006;'
                    },
                    customLayout: {
                        'normal': ['1 2 3', '4 5 6', '7 8 9', '0 {dec} {bksp}', '{clear} {cancel} {accept}']
                    },
                    restrictInput: true,
                    preventPaste: true,
                    autoAccept: true,
                    css: {
                        container: 'center-block dropdown-menu',
                        buttonDefault: 'btn btn-default',
                        buttonHover: 'btn-primary',
                        buttonAction: 'active',
                        buttonDisabled: 'disabled'
                    },
                });
            } else
                $("table.order-list tbody").prepend(newRow);

            rowindex = newRow.index();

            if (!data[11] && product_warehouse_price[pos]) {
                product_price.splice(rowindex, 0, parseFloat(product_warehouse_price[pos] * currency['exchange_rate']) +
                    parseFloat(product_warehouse_price[pos] * currency['exchange_rate'] * customer_group_rate));
            } else {
                product_price.splice(rowindex, 0, parseFloat(data[2] * 1) + parseFloat(data[2] * 1 * customer_group_rate));
            }
            product_discount.splice(rowindex, 0, '0.00');
            tax_rate.splice(rowindex, 0, parseFloat(data[3]));
            tax_name.splice(rowindex, 0, data[4]);
            tax_method.splice(rowindex, 0, data[5]);
            unit_name.splice(rowindex, 0, data[6]);
            unit_operator.splice(rowindex, 0, data[7]);
            unit_operation_value.splice(rowindex, 0, data[8]);
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(1);
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product_price').val(product_price[
                rowindex]);
            localStorageQty.splice(rowindex, 0, 1);
            localStorageProductId.splice(rowindex, 0, data[9]);
            localStorageProductCode.splice(rowindex, 0, data[1]);
            localStorageItemType.splice(rowindex, 0, data[13]);
            localStorageSaleUnit.splice(rowindex, 0, temp_unit_name[0]);
            localStorageProductDiscount.splice(rowindex, 0, product_discount[rowindex]);
            localStorageTaxRate.splice(rowindex, 0, tax_rate[rowindex].toFixed(2));
            localStorageTaxName.splice(rowindex, 0, data[4]);
            localStorageTaxMethod.splice(rowindex, 0, data[5]);
            localStorageTempUnitName.splice(rowindex, 0, data[6]);
            localStorageSaleUnitOperator.splice(rowindex, 0, data[7]);
            localStorageSaleUnitOperationValue.splice(rowindex, 0, data[8]);
            //put some dummy value
            localStorageNetUnitPrice.splice(rowindex, 0, '0.00');
            localStorageTaxValue.splice(rowindex, 0, '0.00');
            localStorageSubTotalUnit.splice(rowindex, 0, '0.00');
            localStorageSubTotal.splice(rowindex, 0, '0.00');

            localStorage.setItem("localStorageProductId", localStorageProductId);
            localStorage.setItem("localStorageSaleUnit", localStorageSaleUnit);
            localStorage.setItem("localStorageProductCode", localStorageProductCode);
            localStorage.setItem("localStorageItemType", localStorageItemType);
            localStorage.setItem("localStorageTaxName", localStorageTaxName);
            localStorage.setItem("localStorageTaxMethod", localStorageTaxMethod);
            localStorage.setItem("localStorageTempUnitName", localStorageTempUnitName);
            localStorage.setItem("localStorageSaleUnitOperator", localStorageSaleUnitOperator);
            localStorage.setItem("localStorageSaleUnitOperationValue", localStorageSaleUnitOperationValue);
            checkQuantity(1, true);
            localStorage.setItem("tbody-id", $("table.order-list tbody").html());
        }

        function edit() {
            var row_product_name_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find(
                'td:nth-child(1)').text();
            $('#modal_header').text(row_product_name_code);

            var qty = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val();
            $('input[name="edit_qty"]').val(qty);

            $('input[name="edit_discount"]').val(parseFloat(product_discount[rowindex]).toFixed(2));

            var tax_name_all = <?php echo json_encode($tax_name_all); ?>;
            pos = tax_name_all.indexOf(tax_name[rowindex]);
            $('select[name="edit_tax_rate"]').val(pos);

            var row_product_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-code')
                .val();
            var row_product_id = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-id').val();

            pos = product_code.indexOf(row_product_code);
            if (product_type[pos] == 'standard') {
                unitConversion();
                temp_unit_name = (unit_name[rowindex]).split(',');
                temp_unit_name.pop();
                temp_unit_operator = (unit_operator[rowindex]).split(',');
                temp_unit_operator.pop();
                temp_unit_operation_value = (unit_operation_value[rowindex]).split(',');
                temp_unit_operation_value.pop();
                $('select[name="edit_unit"]').empty();
                $.each(temp_unit_name, function(key, value) {
                    $('select[name="edit_unit"]').append('<option value="' + key + '">' + value + '</option>');
                });
                $("#edit_unit").show();
            } else {
                row_product_price = product_price[rowindex];
                $("#edit_unit").hide();
            }
            $('input[name="edit_unit_price"]').val(row_product_price.toFixed(2));
            $('.selectpicker').selectpicker('refresh');

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
                url: 'getItemAdditional/' + row_product_id + '/' + invoiceNomber,
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
                                '<div class="col-5"><div class="form-group"><strong>File:</strong><br><img src="assets/images/items/' +
                                element.file + '" alt="" width="60%"></div></div>';
                            html += '<input type="hidden" name="ids[]" value="' + element.id + '" />'
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


        }

        function couponDiscount() {
            var rownumber = $('table.order-list tbody tr:last').index();
            if (rownumber < 0) {
                alert("Please insert product to order table!")
            } else if ($("#coupon-code").val() != '') {
                valid = 0;
                $.each(coupon_list, function(key, value) {
                    if ($("#coupon-code").val() == value['code']) {
                        valid = 1;
                        todyDate = <?php echo json_encode(date('Y-m-d')); ?>;
                        if (parseFloat(value['quantity']) <= parseFloat(value['used']))
                            alert('This Coupon is no longer available');
                        else if (todyDate > value['expired_date'])
                            alert('This Coupon has expired!');
                        else if (value['type'] == 'fixed') {
                            if (parseFloat($('input[name="grand_total"]').val()) >= value['minimum_amount']) {
                                $('input[name="grand_total"]').val($('input[name="grand_total"]').val() - value[
                                    'amount']);
                                $('#grand-total').text(parseFloat($('input[name="grand_total"]').val()).toFixed(2));
                                if (!$('input[name="coupon_active"]').val())
                                    alert('Congratulation! You got ' + value['amount'] + ' ' + currency +
                                        ' discount');
                                $(".coupon-check").prop("disabled", true);
                                $("#coupon-code").prop("disabled", true);
                                $('input[name="coupon_active"]').val(1);
                                $("#coupon-modal").modal('hide');
                                $('input[name="coupon_id"]').val(value['id']);
                                $('input[name="coupon_discount"]').val(value['amount']);
                                $('#coupon-text').text(parseFloat(value['amount']).toFixed(2));
                            } else
                                alert('Grand Total is not sufficient for discount! Required ' + value[
                                    'minimum_amount'] + ' ' + currency);
                        } else {
                            var grand_total = $('input[name="grand_total"]').val();
                            var coupon_discount = grand_total * (value['amount'] / 100);
                            grand_total = grand_total - coupon_discount;
                            $('input[name="grand_total"]').val(grand_total);
                            $('#grand-total').text(parseFloat(grand_total).toFixed(2));
                            if (!$('input[name="coupon_active"]').val())
                                alert('Congratulation! You got ' + value['amount'] + '% discount');
                            $(".coupon-check").prop("disabled", true);
                            $("#coupon-code").prop("disabled", true);
                            $('input[name="coupon_active"]').val(1);
                            $("#coupon-modal").modal('hide');
                            $('input[name="coupon_id"]').val(value['id']);
                            $('input[name="coupon_discount"]').val(coupon_discount);
                            $('#coupon-text').text(parseFloat(coupon_discount).toFixed(2));
                        }
                    }
                });
                if (!valid)
                    alert('Invalid coupon code!');
            }
        }

        function checkQuantity(sale_qty, flag) {
            var row_product_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-code')
                .val();
            pos = product_code.indexOf(row_product_code);
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.in-stock').text(product_qty[pos]);
            localStorageQty[rowindex] = sale_qty;
            localStorage.setItem("localStorageQty", localStorageQty);
            if (product_type[pos] == 'standard') {
                var operator = unit_operator[rowindex].split(',');
                var operation_value = unit_operation_value[rowindex].split(',');
                if (operator[0] == '*')
                    total_qty = sale_qty * operation_value[0];
                else if (operator[0] == '/')
                    total_qty = sale_qty / operation_value[0];
                if (total_qty > parseFloat(product_qty[pos])) {
                    alert('Quantity exceeds stock quantity!');
                    if (flag) {
                        sale_qty = sale_qty.substring(0, sale_qty.length - 1);
                        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(sale_qty);
                        localStorageQty[rowindex] = sale_qty;
                        localStorage.setItem("localStorageQty", localStorageQty);
                        checkQuantity(sale_qty, true);
                    } else {
                        localStorageQty[rowindex] = sale_qty;
                        localStorage.setItem("localStorageQty", localStorageQty);
                        edit();
                        return;
                    }
                }
            } else if (product_type[pos] == 'combo') {
                child_id = product_list[pos].split(',');
                child_qty = qty_list[pos].split(',');
                $(child_id).each(function(index) {
                    var position = product_id.indexOf(parseInt(child_id[index]));
                    if (parseFloat(sale_qty * child_qty[index]) > product_qty[position]) {
                        alert('Quantity exceeds stock quantity!');
                        if (flag) {
                            sale_qty = sale_qty.substring(0, sale_qty.length - 1);
                            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(
                                sale_qty);
                        } else {
                            edit();
                            flag = true;
                            return false;
                        }
                    }
                });
            }

            if (!flag) {
                $('#editModal').modal('hide');
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(sale_qty);
            }
            calculateRowProductData(sale_qty);

        }

        function unitConversion() {
            var row_unit_operator = unit_operator[rowindex].slice(0, unit_operator[rowindex].indexOf(","));
            var row_unit_operation_value = unit_operation_value[rowindex].slice(0, unit_operation_value[rowindex].indexOf(
                ","));

            if (row_unit_operator == '*') {
                row_product_price = product_price[rowindex] * row_unit_operation_value;
            } else {
                row_product_price = product_price[rowindex] / row_unit_operation_value;
            }
        }

        function calculateRowProductData(quantity) {
            if (product_type[pos] == 'standard')
                unitConversion();
            else
                row_product_price = product_price[rowindex];

            if (tax_method[rowindex] == 1) {
                var amount = $("#radioAmount:checked").val();
                console.log(amount);
                var percent = $("#radioPercent:checked").val();
                console.log(percent);

                if (amount == "amount") {
                    var net_unit_price = row_product_price - product_discount[rowindex];
                } else if (percent == "percent") {
                    var net_unit_price = row_product_price - (row_product_price * (product_discount[rowindex] / 100));
                }
                var tax = net_unit_price * quantity * (tax_rate[rowindex] / 100);
                var sub_total = (net_unit_price * quantity) + tax;

                if (parseFloat(quantity)) {
                    var amount = $("#radioAmount:checked").val();
                    var percent = $("#radioPercent:checked").val();
                    var sub_total_unit = sub_total / quantity;
                } else {
                    var sub_total_unit = sub_total;
                }
            } else {
                var radioAmount = $("#radioAmount").val();
                var radioPercent = $("#radioPercent").val();
                if ($("#radioAmount:selected")) {
                    var sub_total_unit = row_product_price - product_discount[rowindex];
                    console.log("if cindition radio select" + sub_total_unit);
                } else if ($("#radioPercent:selected")) {
                    var sub_total_unit = row_product_price - (row_product_price * (product_discount[rowindex] / 100));
                    console.log("else if cindition radio select" + sub_total_unit);
                }
                var net_unit_price = (100 / (100 + tax_rate[rowindex])) * sub_total_unit;
                var tax = (sub_total_unit - net_unit_price) * quantity;
                var sub_total = sub_total_unit * quantity;
            }

            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.discount-value').val((product_discount[
                rowindex] * quantity).toFixed(2));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-rate').val(tax_rate[rowindex]
                .toFixed(2));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.net_unit_price').val(net_unit_price
                .toFixed(2));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-value').val(tax.toFixed(2));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-price').text(sub_total_unit
                .toFixed(2));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.sub-total').text(sub_total.toFixed(2));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.subtotal-value').val(sub_total.toFixed(
                2));

            localStorageProductDiscount.splice(rowindex, 1, (product_discount[rowindex] * quantity).toFixed(2));
            localStorageTaxRate.splice(rowindex, 1, tax_rate[rowindex].toFixed(2));
            localStorageNetUnitPrice.splice(rowindex, 1, net_unit_price.toFixed(2));
            localStorageTaxValue.splice(rowindex, 1, tax.toFixed(2));
            localStorageSubTotalUnit.splice(rowindex, 1, sub_total_unit.toFixed(2));
            localStorageSubTotal.splice(rowindex, 1, sub_total.toFixed(2));
            console.log(localStorageNetUnitPrice);
            localStorage.setItem("localStorageProductDiscount", localStorageProductDiscount);
            localStorage.setItem("localStorageTaxRate", localStorageTaxRate);
            localStorage.setItem("localStorageNetUnitPrice", localStorageNetUnitPrice);
            localStorage.setItem("localStorageTaxValue", localStorageTaxValue);
            localStorage.setItem("localStorageSubTotalUnit", localStorageSubTotalUnit);
            localStorage.setItem("localStorageSubTotal", localStorageSubTotal);

            calculateTotal();
        }

        function calculateTotal() {
            //Sum of quantity
            var total_qty = 0;
            $("table.order-list tbody .qty").each(function(index) {
                if ($(this).val() == '') {
                    total_qty += 0;
                } else {
                    total_qty += parseFloat($(this).val());
                }
            });
            $('input[name="total_qty"]').val(total_qty);

            //Sum of discount
            var total_discount = 0;
            $("table.order-list tbody .discount-value").each(function() {
                total_discount += parseFloat($(this).val());
            });

            $('input[name="total_discount"]').val(total_discount.toFixed(2));

            //Sum of tax
            var total_tax = 0;
            $(".tax-value").each(function() {
                total_tax += parseFloat($(this).val());
            });

            $('input[name="total_tax"]').val(total_tax.toFixed(2));

            //Sum of subtotal
            var total = 0;
            $(".sub-total").each(function() {
                total += parseFloat($(this).text());
            });
            $('input[name="total_price"]').val(total.toFixed(2));

            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            var item = $('table.order-list tbody tr:last').index();
            var total_qty = parseFloat($('input[name="total_qty"]').val());
            var subtotal = parseFloat($('input[name="total_price"]').val());
            var order_tax = parseFloat($('select[name="order_tax_rate_select"]').val());
            var order_tax_rate_select = $('select[name="order_tax_rate_select"]').find(':selected').attr('data-value');
            var disc_type = '';
            localStorage.setItem("order-tax-rate-select", order_tax);
            var order_discount = parseFloat($('input[name="order_discount"]').val());
            if (!order_discount)
                order_discount = 0.00;

            var shipping_cost = parseFloat($('input[name="shipping_cost"]').val());
            if (!shipping_cost)
                shipping_cost = 0.00;
            item = ++item + '(' + total_qty + ')';

            if (order_tax_rate_select == 'Exclusive') {
                order_tax = (subtotal - order_discount) * (order_tax / 100); //EHSAN OLD
            }


            var disc_number = $('#disc_number').prop('checked');
            var disc_percent = $('#disc_percent').prop('checked');
            $("#discount").text(order_discount.toFixed(2));
            $('input[name="DiscountPer"]').val(order_discount.toFixed(2));

            if (disc_number == true) {
                $("#totals-title").text('Discount');
                var order_discount = $('#order-discount').val();
                //var grand_total = (subtotal + order_tax + shipping_cost) - (order_discount);EHSAN OLD
                subtotal = subtotal - order_discount; //EHSAN

                if (order_tax_rate_select == 'Inclusive') {
                    order_tax = subtotal * (order_tax / 100); //EHSAN
                    subtotal = subtotal - order_tax; //EHSAN
                }
                var grand_total = subtotal + order_tax + shipping_cost; //EHSAN

                localStorage.setItem("order_discount_type", 'number');
            } else {
                var order_discount = $('#order-discount').val();
                //var grand_total = (subtotal + order_tax + shipping_cost) - (subtotal * (order_discount / 100));//EHSAN OLD
                if (disc_percent == true && order_discount > 0) {
                    $("#totals-title").text('Disc(' + order_discount + '%)');
                    $("#discount").text(subtotal * (order_discount / 100));
                    $('input[name="DiscountPer"]').val(subtotal * (order_discount / 100));
                    subtotal = subtotal - (subtotal * (order_discount / 100)); //EHSAN
                }

                if (order_tax_rate_select == 'Inclusive') {
                    order_tax = subtotal * (order_tax / 100); //EHSAN
                    subtotal = subtotal - order_tax; //EHSAN
                }
                localStorage.setItem("order_discount_type", 'percent');
                var grand_total = subtotal + order_tax + shipping_cost; //EHSAN


            }





            $('input[name="grand_total"]').val(grand_total.toFixed(2));
            $('input[name="total"]').val(subtotal.toFixed(2));
            couponDiscount();
            var coupon_discount = parseFloat($('input[name="coupon_discount"]').val());
            if (!coupon_discount)
                coupon_discount = 0.00;
            grand_total -= coupon_discount;

            $('#item').text(item);
            $('input[name="item"]').val($('table.order-list tbody tr:last').index() + 1);
            $('#subtotal').text(subtotal.toFixed(2));
            $('#tax').text(order_tax.toFixed(2));
            $('input[name="order_tax"]').val(order_tax.toFixed(2));
            $('#shipping-cost').text(shipping_cost.toFixed(2));


            $('#grand-total').text(grand_total.toFixed(2));
            $('input[name="grand_total"]').val(grand_total.toFixed(2));
        }

        $('select[name="payment_status"]').on("change", function() {
            var payment_status = $(this).val();
            if (payment_status == 3 || payment_status == 4) {
                $("#paid-amount").prop('disabled', false);
                $("#payment").show();
                $("#paying-amount").prop('required', true);
                $("#paid-amount").prop('required', true);
                if (payment_status == 4) {
                    $("#paid-amount").prop('disabled', true);
                    $('input[name="paying_amount"]').val($('input[name="grand_total"]').val());
                    $('input[name="paid_amount"]').val($('input[name="grand_total"]').val());
                }
            } else {
                $("#paying-amount").prop('required', false);
                $("#paid-amount").prop('required', false);
                $('input[name="paying_amount"]').val('');
                $('input[name="paid_amount"]').val('');
                $("#payment").hide();
            }
        });

        function hide() {
            $(".card-element").hide();
            $(".card-errors").hide();
            $(".cheque").hide();
            $(".gift-card").hide();
            $(".AmountPaidByCard").hide();
            $('input[name="cheque_no"]').attr('required', false);
        }

        function giftCard() {
            $(".gift-card").show();
            $.ajax({
                url: 'sales/get_gift_card',
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#add-payment select[name="gift_card_id_select"]').empty();
                    $.each(data, function(index) {
                        gift_card_amount[data[index]['id']] = data[index]['amount'];
                        gift_card_expense[data[index]['id']] = data[index]['expense'];
                        $('#add-payment select[name="gift_card_id_select"]').append('<option value="' +
                            data[index]['id'] + '">' + data[index]['card_no'] + '</option>');
                    });
                    $('.selectpicker').selectpicker('refresh');
                    $('.selectpicker').selectpicker();
                }
            });
            $(".card-element").hide();
            $(".card-errors").hide();
            $(".cheque").hide();
            $('input[name="cheque_no"]').attr('required', false);
        }

        function cheque() {
            $(".cheque").show();
            $('input[name="cheque_no"]').attr('required', true);
            $(".card-element").hide();
            $(".card-errors").hide();
            $(".gift-card").hide();
        }


        function deliveryaddress(address)

        {


            var len = $('#DeliveryAddress').val().length;
            if (len > 0) {
                $('input[name="shipping_cost"]').val(150);
                $('#DriverName').removeClass('d-none');

                calculateGrandTotal();
            } else {
                $('input[name="shipping_cost"]').val(0);
                $('#DriverName').addClass('d-none');

                calculateGrandTotal();
            }
        }

        function chequeAndCard() {
            $(".cheque").show();
            $(".AmountPaidByCard").show();
            $('input[name="cheque_no"]').attr('required', true);
            $('input[name="AmountPaidByCard"]').attr('required', true);
            $(".card-element").hide();
            $(".card-errors").hide();
            $(".gift-card").hide();
        }

        function creditCard() {
            var base_url = "{{ asset('vendor/stripe/checkout.js') }}";
            $.getScript(base_url);
            $(".card-element").show();
            $(".card-errors").show();
            $(".cheque").hide();
            $(".gift-card").hide();
            $('input[name="cheque_no"]').attr('required', false);
        }

        function deposits() {
            if ($('input[name="paid_amount"]').val() > deposit[$('#customer_id').val()]) {
                alert('Amount exceeds customer deposit! Customer deposit : ' + deposit[$('#customer_id').val()]);
            }
            $('input[name="cheque_no"]').attr('required', false);
            $('#add-payment select[name="gift_card_id_select"]').attr('required', false);
        }

        function cancel(rownumber) {
            while (rownumber >= 0) {
                product_price.pop();
                product_discount.pop();
                tax_rate.pop();
                tax_name.pop();
                tax_method.pop();
                unit_name.pop();
                unit_operator.pop();
                unit_operation_value.pop();
                $('table.order-list tbody tr:last').remove();
                rownumber--;
            }
            $('input[name="shipping_cost"]').val('');
            $('input[name="order_discount"]').val('');
            $('select[name="order_tax_rate_select"]').val(0);
            calculateTotal();
        }

        function confirmCancel() {
            var audio = $("#mysoundclip2")[0];
            audio.play();
            if (confirm("Are you sure want to cancel?")) {
                cancel($('table.order-list tbody tr:last').index());
            }
            return false;
        }

        $(document).on('submit', '.payment-form', function(e) {
            var rownumber = $('table.order-list tbody tr:last').index();
            if (rownumber < 0) {
                alert("Please insert product to order table!")
                e.preventDefault();
            } else if (parseFloat($('input[name="paying_amount"]').val()) < parseFloat($(
                    'input[name="paid_amount"]').val())) {
                alert('Paying amount cannot be bigger than recieved amount');
                e.preventDefault();
            }
            $('input[name="paid_by_id"]').val($('select[name="paid_by_id_select"]').val());
            $('input[name="future_paid_by_id"]').val($('select[name="future_paid_by_id_select"]').val());
            $('input[name="order_tax_rate"]').val($('select[name="order_tax_rate_select"]').val());
            $('input[name="order_tax_id"]').val($('#order-tax-rate-select').children('option:selected').data('id'));
        });



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
    </script>
    <script>
        $(document).ready(function() {
            $("#itemAdditionalForm").submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ url('addItemAdditional') }}",
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
                    // alert(selectedState);
                    localStorage.setItem('shipping-cost-val', selectedState);
                    $('input[name="shipping_cost"]').val(selectedState);

                    calculateGrandTotal();
                }
            });
            $('#delivery_state_shipping').change(function() {
                // alert('here');
                selectedState = $('#delivery_state_shipping').val();
                // alert(selectedState);
                localStorage.setItem('shipping-cost-val', selectedState);
                $('input[name="shipping_cost"]').val(selectedState);

                calculateGrandTotal();
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
