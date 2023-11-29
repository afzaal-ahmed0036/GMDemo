@extends('template.tmp')
@section('title', $pagetitle)
@push('before-styles')
    <style>
        #genbutton {
            cursor: pointer;

        }

        .blinking-icon {
            display: inline-block;
            animation: blink-animation 2s infinite;
            font-size: 1rem;
        }

        @keyframes blink-animation1 {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0;
                transform: scale(2);
            }

            51% {
                opacity: 0;
                transform: scale(0);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes blink-animation {
            0% {
                transform: rotate(0deg);
            }

            50% {
                transform: rotate(180deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }


        .blinking-icon:hover {
            -webkit-animation-play-state: paused;
            -moz-animation-play-state: paused;
            -o-animation-play-state: paused;
            animation-play-state: paused;
        }
    </style>
@endpush
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
                    <div class="col-12">
                        <form action="{{ URL('/ItemSave') }}" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    <h2>Item Create</h2>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3 row">
                                                <div class="col-sm-2">
                                                    <label class="col-form-label fw-bold" for="first-name">Type</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="form-check form-check-inline pt-2">
                                                        <input class="form-check-input" type="radio" name="ItemType"
                                                            id="inlineRadio1" value="Goods" checked
                                                            {{ old('ItemType') == 'Goods' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="inlineRadio1">Goods</label>
                                                    </div>

                                                    {{-- <div class="form-check form-check-inline pt-2">
                                                        <input class="form-check-input" type="radio" name="ItemType"
                                                            id="inlineRadio2" value="Service"
                                                            {{ old('ItemType') == 'Service' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="inlineRadio2">Service</label>
                                                    </div>

                                                    <div class="form-check form-check-inline pt-2">
                                                        <input class="form-check-input" type="radio" name="ItemType"
                                                            id="inlineRadio3" value="Restaurant"
                                                            {{ old('ItemType') == 'Restaurant' ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="inlineRadio3">Restaurant</label>
                                                    </div> --}}
                                                </div>
                                            </div>


                                            <div class="mb-3 row">
                                                <div class="col-sm-2">
                                                    <label class="col-form-label fw-bold" for="first-name">Name</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="text" id="first-name" class="form-control"
                                                        name="ItemName" placeholder="Item Name" required
                                                        value="{{ old('ItemName') }}">
                                                </div>
                                            </div>


                                            <div class="mb-3 row">
                                                <div class="col-sm-2">
                                                    <label class="col-form-label fw-bold" for="first-name">Item Code</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="input-group" id="datepicker21">
                                                        <input type="text" id="item_code" class="form-control"
                                                            name="ItemCode" placeholder="Item Code" required
                                                            value="{{ old('ItemCode') }}">
                                                        <span class="input-group-text" id="genbutton"
                                                            title="Click to generate random code"><i
                                                                class="blinking-icon mdi mdi-refresh"></i></span>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-sm-2">
                                                    <label class="col-form-label fw-bold" for="first-name">Category</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <select name="item_category_id" id="item_category_id"
                                                        class="form-select select2">
                                                        <option value="">Select Item Category</option>
                                                        @foreach ($item_categories as $category)
                                                            <option value="{{ $category->ItemCategoryID }}"
                                                                {{ old('item_category_id') == $category->ItemCategoryID ? 'selected' : '' }}>
                                                                {{ $category->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-1">
                                                    <button type="button" class="btn btn-sm btn-success mt-1"
                                                        data-bs-toggle="modal" data-bs-target="#addItemCategoryModal"><i
                                                            class="fa fa-plus"></i></button>
                                                </div>
                                            </div>

                                            {{-- <div class="mb-3 row">
                                                <div class="col-sm-2">
                                                    <label class="col-form-label fw-bold" for="first-name">Taxable</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <select name="Taxable" id="Taxable" class="form-select">
                                                        <option value="">Select</option>
                                                        <option value="No" selected
                                                            {{ old('Taxable') == 'No' ? 'selected' : '' }}>No</option>
                                                        <option value="Yes"
                                                            {{ old('Taxable') == 'Yes' ? 'selected' : '' }}>Yes</option>

                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="col-form-label fw-bold"
                                                        for="first-name">Percentage</label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="number" step="0.001" min="1" max="100"
                                                        id="Percentage" disabled="" class="form-control"
                                                        name="Percentage" value="{{ old('Percentage') }}">
                                                </div>
                                            </div> --}}

                                            {{-- <div class="mb-3 row">
                                                <div class="col-sm-2">
                                                    <label class="col-form-label fw-bold" for="stock-qty">Stock
                                                        Quantity</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="number" id="stockQty" class="form-control"
                                                        name="stockQty" value="{{ old('stockQty') }}" min="1">
                                                </div>
                                            </div> --}}

                                            {{-- <div class="mb-3 row">
                                                <div class="col-sm-2">
                                                    <label class="col-form-label  text-danger" for="first-name">Cost
                                                        Price</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="number" step="0.01" id="first-name"
                                                        class="form-control" name="CostPrice"
                                                        value="{{ old('CostPrice') }}">
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="col-form-label  text-danger" for="first-name">Selling
                                                        Price</label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="number" step="0.01" id="first-name"
                                                        class="form-control" name="SellingPrice" required
                                                        value="{{ old('SellingPrice') }}">
                                                </div>
                                            </div> --}}



                                            {{-- <div class="mb-3 row">
                                                <div class="col-sm-2">
                                                    <label class="col-form-label  " for="first-name">Cost Remarks</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <textarea name="CostDescription" id="" class="form-control" cols="43" rows="3">{{ old('CostDescription') }}</textarea>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <div class="col-sm-2">
                                                    <label class="col-form-label " for="first-name">Selling
                                                        Remarks</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <textarea name="SellingDescription" id="" class="form-control" cols="43" rows="3">{{ old('SellingDescription') }}</textarea>
                                                </div>
                                            </div> --}}

                                        </div>


                                        <div class="col-md-6">
                                            <div class="mb-3 mt-5 row">
                                                <div class="col-sm-2">
                                                    <label class="col-form-label fw-bold" for="first-name">Image</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="file" name="image" class="form-control"
                                                        accept="image/*">
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <div class="col-sm-2">
                                                    <label class="col-form-label fw-bold" for="first-name">Units</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <select name="unit_id" id="unit_id" class="form-select select2">
                                                        <option value="">Select</option>
                                                        @foreach ($units as $unit)
                                                            <option value="{{ $unit->id }}"
                                                                {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                                                {{ $unit->base_unit }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="mb-3 row">
                                                <div class="col-sm-2">
                                                    <label class="col-form-label fw-bold" for="first-name">Brand</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <select name="brand_id" id="brand" class="form-select select2">
                                                        <option value="">Select Brand</option>
                                                        @foreach ($lims_brand_all as $brand)
                                                            <option value="{{ $brand->id }}"
                                                                {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                                {{ $brand->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-1">
                                                    <button type="button" class="btn btn-sm btn-success mt-1"
                                                        data-bs-toggle="modal" data-bs-target="#addBrandModal"><i
                                                            class="fa fa-plus"></i></button>
                                                </div>
                                            </div>

                                            {{-- <div class="mb-3 row">
                                                <div class="col-sm-2">
                                                    <label class="col-form-label fw-bold"
                                                        for="first-name">Warehouse</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <select name="warehouse_id" id="warehouse_id" class="form-select">
                                                        @foreach ($lims_warehouse_list as $warehouse)
                                                            <option value="{{ $warehouse->id }}"
                                                                {{ $lims_pos_setting_data->warehouse_id == $warehouse->id ? 'selected' : '' }}>
                                                                {{ $warehouse->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div> --}}
                                            {{-- <div class="mb-3 row">
                                                <div class="col-sm-2">
                                                    <label class="col-form-label fw-bold" for="supplier">Supplier</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <select name="SupplierID" id="SupplierID" class="form-select">
                                                        @foreach ($supplier as $key => $value)
                                                            <option value="{{ $value->SupplierID }}"
                                                                {{ $lims_pos_setting_data->supplier_id == $value->SupplierID ? 'selected' : '' }}>
                                                                {{ $value->SupplierName }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div> --}}

                                            {{-- <div class="mb-3 row">
                                                <div class="col-sm-2">
                                                    <label class="col-form-label  fw-bold " for="first-name">Cost
                                                        Account</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <select name="CostChartofAccountID" class="select2 form-select">
                                                        @foreach ($chartofaccount as $value)
                                                            <option value="{{ $value->ChartOfAccountID }}">
                                                                {{ $value->ChartOfAccountID }}-{{ $value->ChartOfAccountName }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div> --}}

                                            {{-- <div class="mb-3 row">
                                                <div class="col-sm-2">
                                                    <label class="col-form-label fw-bold " for="first-name">Selling
                                                        Account</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <select name="SellingChartofAccountID" class="form-select select2">
                                                        @foreach ($chartofaccount as $value)
                                                            <option value="{{ $value->ChartOfAccountID }}">
                                                                {{ $value->ChartOfAccountID }}-{{ $value->ChartOfAccountName }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div> --}}
                                            {{-- <div class="mb-3 row">
                                                <div class="col-sm-2">
                                                    <label class="  fw-bold" for="first-name">Is Featured</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="checkbox" value="1" name="isFeatured" checked>
                                                    <label for="vehicle2"> Featured</label>
                                                </div>

                                                <div class="col-sm-2">
                                                    <label class="  fw-bold" for="first-name">Status</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="checkbox" name="isActive" value="1" checked>
                                                    <label for="active"> Active</label>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <div class="card-footer">

                                        <div><button type="submit" class="btn btn-success w-lg float-right">Save</button>
                                            {{-- <a href="{{ URL('/') }}"
                                                class="btn btn-secondary w-lg float-right">Cancel</a> --}}


                                        </div>
                                    </div>

                                </div>
                        </form>
                        {{-- ------------------Add Category Modal--------------- --}}
                        <div class="modal fade" id="addItemCategoryModal" tabindex="-1" role="dialog"
                            aria-labelledby="addItemCategoryModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addItemCategoryModalTitle">Add Item Category</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ url('store-item-category') }}" method="POST"
                                            enctype="multipart/form-data" id="categoryForm">
                                            @csrf
                                            <div class="row col-md-12">
                                                <input type="hidden" value="1" name="value_ajax">
                                                <div class="form-group col-md-6">
                                                    <label for="name">Name</label>
                                                    <input type="text" name="itemCategoryName" class="form-control"
                                                        placeholder="Item Category Name" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="name">Image</label>
                                                    <input type="file" name="categoryImage" accept="images/*"
                                                        class="form-control">
                                                </div>

                                            </div>
                                            <div class="row col-md-12 mt-3">
                                                <div class="form-group col-md-6">
                                                    <label for="name">Category Type</label>
                                                    <select name="type" class="form-control">
                                                        <option value="">Select Type</option>
                                                        <option value="POS" selected>POS</option>
                                                        <option value="RES">RES</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="name">Parent Category</label>
                                                    <select name="parent_id" class="form-control">
                                                        <option value="">No Parent Category</option>
                                                        @foreach ($item_categories as $category)
                                                            <option value="{{ $category->ItemCategoryID }}">
                                                                {{ $category->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="button" id="saveCategory"
                                                    class="btn btn-success">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- ------------------Add Brand Modal--------------- --}}

                        <div class="modal fade" id="addBrandModal" tabindex="-1" role="dialog"
                            aria-labelledby="addBrandModal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addBrandModalTitle">Add Brand</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ url('store-brand') }}" method="POST"
                                            enctype="multipart/form-data" id="brandForm">
                                            @csrf
                                            <div class="row col-md-12">
                                                <div class="form-group">
                                                    <input type="hidden" value="1" name="value_ajax">
                                                    <label for="title">Title</label>
                                                    <input type="text" name="title" class="form-control"
                                                        placeholder="Type Brand Title" required>
                                                </div>

                                            </div>
                                            <div class="row col-md-12 mt-3">
                                                <div class="form-group">
                                                    <label for="phone">Image</label>
                                                    <input type="file" name="image" id="brandImage"
                                                        class="form-control">
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="button" id="saveBrand"
                                                    class="btn btn-success">Save</button>
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
    @endsection

    @push('after-scripts')
        <script type="text/javascript">
            $(document).ready(function() {

                function delete_confirm2(url, id) {
                    url = "{{ URL::TO(' / ') }}/" + url + '/' + id;
                    jQuery('#staticBackdrop').modal('show', {
                        backdrop: 'static'
                    });
                    document.getElementById('delete_link').setAttribute('href', url);
                };
                $('.add_stockButton').click(function() {
                    $('#item_name').val('');

                    var id = $(this).data('id');
                    var itemName = $(this).data('name');

                    // alert(id);
                    $('#item_name').val(itemName);
                    $('#item_id').val(id);

                    $('#exampleModal').modal('show');
                });
                $('.close').click(function() {
                    $('#exampleModal').modal('hide');

                })
                $('#genbutton').on("click", function() {
                    var link = "{{ route('items.generatecode') }}";
                    $.get(link, function(data) {
                        $("input[name='ItemCode']").val(data);
                        $('.blinking-icon').removeClass('blinking-icon');
                    });
                });

                $(document).on('change ', '#Taxable', function() {
                    if ($('#Taxable').val() == 'Yes') {
                        $("#Percentage").prop("disabled", false);
                        $("#Percentage").focus();
                        $("#Percentage").attr("placeholder", "5").placeholder();

                    } else {
                        $("#Percentage").prop("disabled", true);
                        $("#Percentage").removeAttr("placeholder");
                    }
                });
                $('#student_table').DataTable();
                $('#saveCategory').click(function() {
                    var itemCategoryName = $("input[name='itemCategoryName']").val();
                    if (itemCategoryName == '') {
                        alert('Please Add Category Name');
                    } else {
                        var CatFormData = new FormData($('#categoryForm')[0]);

                        $.ajax({
                            type: 'POST',
                            url: '{{ url('store-item-category') }}',
                            data: CatFormData,
                            contentType: false,
                            processData: false,
                            success: function(data) {
                                alert(data.message);
                                $('#addItemCategoryModal').modal('hide');
                                $("input[name='itemCategoryName']").val('');
                                $("input[name='categoryImage']").val('');
                                $("input[name='itemCategoryName']").val('');
                                $('#item_category_id').empty();

                                var select = $('#item_category_id');
                                select.empty();

                                // Add a default option
                                $('#item_category_id').append($('<option>', {
                                    value: '',
                                    text: 'Select Item Category'
                                }));

                                $.get('{{ url('itemCategories') }}', function(response) {
                                    if (response.options && response.options.length > 0) {
                                        $.each(response.options, function(index, option) {
                                            $('#item_category_id').append($(
                                                '<option>', {
                                                    value: option.value,
                                                    text: option.text
                                                }));
                                        });
                                        $('#item_category_id').val(data.data
                                            .ItemCategoryID);

                                        // Trigger the change event to update the selectpicker if you're using it
                                        $('#item_category_id').trigger('change');

                                    }
                                });
                            },
                            error: function(data) {
                                // Handle errors here
                            }
                        });
                    }
                });

                $('#saveBrand').click(function() {
                    var itemBrandName = $("input[name='title']").val();
                    if (itemBrandName == '') {
                        alert('Please Add Brand Name');
                    } else {
                        var formData = new FormData($('#brandForm')[0]);
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('store-brand') }}',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(data) {
                                alert(data.message);
                                $('#addBrandModal').modal('hide');
                                $("input[name='title']").val('');
                                $("#brandImage").val('');

                                // $('#brand').empty();
                                var select = $('#brand');
                                select.empty();

                                // Add a default option
                                $('#brand').append($('<option>', {
                                    value: '',
                                    text: 'Select Brand'
                                }));

                                $.get('{{ url('itemBrands') }}', function(response) {

                                    if (response.options && response.options.length > 0) {
                                        $.each(response.options, function(index, option) {
                                            $('#brand').append($(
                                                '<option>', {
                                                    value: option.value,
                                                    text: option.text
                                                }));
                                        });
                                        $('#brand').val(data.data
                                            .id);

                                        // Trigger the change event to update the selectpicker if you're using it
                                        $('#brand').trigger('change');

                                    }
                                });
                            },
                            error: function(data) {
                                // Handle errors here
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
