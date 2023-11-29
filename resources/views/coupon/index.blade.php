@extends('template.tmp')

@section('title', 'Coupon List')
@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Coupon Listing</h4>

                        <div class="page-title-right">
                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#create-modal"><i class="dripicons-plus"></i> {{trans('file.Add Coupon')}}</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-xl-12">
                    @if (session('error'))
                    <div class="alert alert-{{ Session::get('class') }} p-3">

                        <strong>{{ Session::get('error') }} </strong>
                    </div>
                    @endif

                    @if (count($errors) > 0)
                    <div>
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
                        <div class="card-body">
                            <h4 class="card-title mb-4">Coupons</h4>


                            <table id="coupon-table" class="table sale-list datatable table-hover dt-responsive nowrap w-100 table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">S.No</th>
                                        <th scope="col">PartyName</th>
                                        <th scope="col">Coupon Code</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Minimum Amount</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Available</th>
                                        <th scope="col">Expired Date</th>
                                        <th scope="col">Created By</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach($lims_coupon_all as $key=>$coupon)
                                        <?php 
                                            $created_by = DB::table('user')->where('UserID',$coupon->user_id)->first();
                                            $party = DB::table('party')->where('PartyID',$coupon->PartyID)->first();
                                        ?>
                                        <tr data-id="{{$coupon->id}}">
                                            <td>{{$key}}</td>
                                            <td>{{$party->PartyName ?? ''}}</td>
                                            <td>{{ $coupon->code }}</td>
                                            @if($coupon->type == 'percentage')
                                            <td><div class="badge alert-primary">{{$coupon->type}}</div></td>
                                            @else
                                            <td><div class="badge alert-info">{{$coupon->type}}</div></td>
                                            @endif
                                            <td>{{ $coupon->amount }}</td>
                                            @if($coupon->minimum_amount)
                                            <td>{{ $coupon->minimum_amount }}</td>
                                            @else
                                            <td>N/A</td>
                                            @endif
                                            <td>{{ $coupon->quantity }}</td>
                                            @if($coupon->quantity - $coupon->used)
                                            <td class="text-center"><div class="badge alert-success">{{ $coupon->quantity - $coupon->used }}</div></td>
                                            @else
                                            <td class="text-center"><div class="badge alert-danger">{{ $coupon->quantity - $coupon->used }}</div></td>
                                            @endif
                                            @if($coupon->expired_date >= date("Y-m-d"))
                                              <td><div class="badge alert-success">{{date('d-m-Y', strtotime($coupon->expired_date))}}</div></td>
                                            @else
                                              <td><div class="badge alert-danger">{{date('d-m-Y', strtotime($coupon->expired_date))}}</div></td>
                                            @endif
                                            <td>{{ $created_by->FullName }}</td>
                                            <td>
                                                <a href="javascript:void(0)" class="edit-btn" data-id="{{$coupon->id}}" data-code="{{$coupon->code}}" data-type="{{$coupon->type}}" data-amount="{{$coupon->amount}}" data-minimum_amount="{{$coupon->minimum_amount}}" data-party_id="{{$coupon->PartyID}}" data-quantity="{{$coupon->quantity}}" data-expired_date="{{$coupon->expired_date}}"><i class="bx bx-pencil align-middle me-1"></i></a> <a href="#" onclick="delete_confirm2('couponDelete', '{{$coupon->id}}')"><i class="bx bx-trash  align-middle me-1"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
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


            <div id="create-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Add Coupon')}}</h5>
                            <button type="button" data-bs-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                        </div>
                        <div class="modal-body">
                            <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>

                            <form method="POST" action="{{route('coupons.store')}}">
                                @csrf
                             <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>{{trans('file.Coupon Code')}} *</label>
                                    <div class="input-group">
                                        <input type="text" name="code" id="code" required class="form-control">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-secondary genbutton">{{trans('file.Generate')}}</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Party *</label>
                                    <select class="form-control" name="PartyID">
                                        <option value="">Select Party</option>
                                        @foreach($parties as $party)
                                            <option value="{{$party->PartyID}}">{{$party->PartyName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group mt-3">
                                    <label>{{trans('file.Type')}} *</label>
                                    <select class="form-control" name="type">
                                        <option value="percentage">Percentage</option>
                                        <option value="fixed">Fixed Amount</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group minimum-amount mt-3">
                                    <label>{{trans('file.Minimum Amount')}} *</label>
                                    <input type="number" name="minimum_amount" step="any" class="form-control">
                                </div>
                                <div class="col-md-6 form-group mt-3">
                                    <label>{{trans('file.Amount')}} *</label>
                                    <div class="input-group">
                                        <input type="number" name="amount" step="any" required class="form-control">&nbsp;&nbsp;
                                        <div class="input-group-append mt-1">
                                            <span class="icon-text" style="font-size: 22px;"><strong>%</strong></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group mt-3">
                                    <label>Qty *</label>
                                    <input type="number" name="quantity" step="any" required class="form-control">
                                </div>


                                <div class="col-md-6 form-group mt-3">
                                    <label>{{trans('file.Expired Date')}}</label>
                                    <div class="input-group" id="datepicker21">
                                      <input type="text" name="expired_date"  autocomplete="off" class="form-control" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" data-date-container="#datepicker21" data-provide="datepicker" data-date-autoclose="true" value="{{date('Y-m-d')}}">
                                      <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>

                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">{{trans('file.submit')}}</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            </div>

            <div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Update Coupon')}}</h5>
                            <button type="button" data-bs-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                        </div>
                        <div class="modal-body">
                            <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                            
                            <form method="POST" action="{{route('coupons.update',1)}}">
                                @csrf
                            <input name="_method" type="hidden" value="PUT">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>{{trans('file.Coupon')}} {{trans('file.Code')}} *</label>
                                    <div class="input-group">
                                        <input type="hidden" name="coupon_id"> 
                                        <input type="text" name="code" id="code" required class="form-control">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-secondary genbutton">{{trans('file.Generate')}}</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Party *</label>
                                    <select class="form-control" name="PartyID">
                                        @foreach($parties as $party)
                                            <option value="{{$party->PartyID}}">{{$party->PartyName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group mt-3">
                                    <label>{{trans('file.Type')}} *</label>
                                    <select class="form-control" name="type">
                                        <option value="percentage">Percentage</option>
                                        <option value="fixed">Fixed Amount</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group minimum-amount mt-3">
                                    <label>{{trans('file.Minimum Amount')}} *</label>
                                    <input type="number" name="minimum_amount" step="any" class="form-control">
                                </div>
                                <div class="col-md-6 form-group mt-3">
                                    <label>{{trans('file.Amount')}} *</label>
                                    <div class="input-group">
                                        <input type="number" name="amount" step="any" required class="form-control">&nbsp;&nbsp;
                                        <div class="input-group-append mt-1">
                                            <span class="icon-text" style="font-size: 22px;"><strong>%</strong></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group mt-3">
                                    <label>Qty *</label>
                                    <input type="number" name="quantity" step="any" required class="form-control">
                                </div>

                                <div class="col-md-6 form-group mt-3">
                                    <label>{{trans('file.Expired Date')}}</label>
                                    <div class="input-group" id="datepicker22">
                                      <input type="text" name="expired_date"  autocomplete="off" class="form-control" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" data-date-container="#datepicker22" data-provide="datepicker" data-date-autoclose="true" value="{{date('Y-m-d')}}">
                                      <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">{{trans('file.submit')}}</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ADD PAYMENT MODAL ENDS HERE -->
        </div> <!-- container-fluid -->
    </div>
</div>


@endsection

@push('after-scripts')
<script type="text/javascript">
    $("ul#sale").siblings('a').attr('aria-expanded', 'true');
    $("ul#sale").addClass("show");
    $("ul#sale #coupon-menu").addClass("active");

    var coupon_id = [];
    var user_verified = <?php echo json_encode(env('USER_VERIFIED')) ?>;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // $("#create-modal .expired_date").val($.datepicker.formatDate('yy-mm-dd', new Date()));
    $(".minimum-amount").hide();

    $("#create-modal select[name='type']").on("change", function() {
        if ($(this).val() == 'fixed') {
            $("#create-modal .minimum-amount").show();
            $("#create-modal .minimum-amount").prop('required', true);
            $("#create-modal .icon-text").text('$');
        } else {
            $("#create-modal .minimum-amount").hide();
            $("#create-modal .minimum-amount").prop('required', false);
            $("#create-modal .icon-text").text('%');
        }
    });

    $(document).on("change", "#editModal select[name='type']", function() {
        alert('kire?');
        if ($(this).val() == 'fixed') {
            $("#editModal .minimum-amount").show();
            $("#editModal .minimum-amount").prop('required', true);
            $("#editModal .icon-text").text('$');
        } else {
            $("#editModal .minimum-amount").hide();
            $("#editModal .minimum-amount").prop('required', false);
            $("#editModal .icon-text").text('%');
        }
    });

    $(document).on("click", '#create-modal .genbutton', function() {
        $.get('coupons/gencode', function(data) {
            $("input[name='code']").val(data);
        });
    });

    $(document).on("click", '#editModal .genbutton', function() {
        $.get('coupons/gencode', function(data) {
            $("#editModal input[name='code']").val(data);
        });
    });

    $(document).on('click', '.edit-btn', function() {
        $("#editModal input[name='PartyID']").val($(this).data('party_id'));
        $("#editModal input[name='code']").val($(this).data('code'));
        $("#editModal select[name='type']").val($(this).data('type'));
        $("#editModal input[name='amount']").val($(this).data('amount'));
        $("#editModal input[name='minimum_amount']").val($(this).data('minimum_amount'));
        $("#editModal input[name='quantity']").val($(this).data('quantity'));
        $("#editModal input[name='expired_date']").val($(this).data('expired_date'));
        $("#editModal input[name='coupon_id']").val($(this).data('id'));
        if ($(this).data('type') == 'fixed') {
            $("#editModal .minimum-amount").show();
            $("#editModal .minimum-amount").prop('required', true);
            $("#editModal .icon-text").text('$');
        }
        // $('.selectpicker').selectpicker('refresh');
        $('#editModal').modal('show');
    });

    // var expired_date = $('.expired_date');
    // expired_date.datepicker({
    //     format: "yyyy-mm-dd",
    //     startDate: "<?php echo date('Y-m-d'); ?>",
    //     autoclose: true,
    //     todayHighlight: true
    // });

    function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
    }

    var table = $('#coupon-table').DataTable({
        responsive: true,
        fixedHeader: {
            header: true,
            footer: true
        },
        "order": [],
        'language': {
            'lengthMenu': '_MENU_ {{trans("file.records per page")}}',
            "info": '<small>{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)</small>',
            "search": '{{trans("file.Search")}}',
            'paginate': {
                'previous': '<i class="dripicons-chevron-left"></i>',
                'next': '<i class="dripicons-chevron-right"></i>'
            }
        },
        'columnDefs': [{
                "orderable": false,
                'targets': [0, 9]
            },
            {
                'render': function(data, type, row, meta) {
                    if (type === 'display') {
                        data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                    }

                    return data;
                },
                'checkboxes': {
                    'selectRow': true,
                    'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                },
                'targets': [0]
            }
        ],
        'select': {
            style: 'multi',
            selector: 'td:first-child'
        },
        'lengthMenu': [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        dom: '<"row"lfB>rtip',
        buttons: [{
                extend: 'pdf',
                text: '{{trans("file.PDF")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                }
            },
            {
                extend: 'csv',
                text: '{{trans("file.CSV")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                }
            },
            {
                extend: 'print',
                text: '{{trans("file.Print")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                }
            },
            {
                text: '{{trans("file.delete")}}',
                className: 'buttons-delete',
                action: function(e, dt, node, config) {
                    if (user_verified == '1') {
                        coupon_id.length = 0;
                        $(':checkbox:checked').each(function(i) {
                            if (i) {
                                coupon_id[i - 1] = $(this).closest('tr').data('id');
                            }
                        });
                        if (coupon_id.length && confirm("Are you sure want to delete?")) {
                            $.ajax({
                                type: 'POST',
                                url: 'coupons/deletebyselection',
                                data: {
                                    couponIdArray: coupon_id
                                },
                                success: function(data) {
                                    alert(data);
                                }
                            });
                            dt.rows({
                                page: 'current',
                                selected: true
                            }).remove().draw(false);
                        } else if (!coupon_id.length)
                            alert('No coupon is selected!');
                    } else
                        alert('This feature is disable for demo!');
                }
            },
            {
                extend: 'colvis',
                text: '{{trans("file.Column visibility")}}',
                columns: ':gt(0)'
            },
        ]
    });
</script>
@endpush