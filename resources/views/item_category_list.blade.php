@extends('template.tmp')
@section('title', 'Item Category Listing')
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
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Item Category Listing</h4>

                            <div class="page-title-right">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addItemCategoryModal">Add Item Category</button>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-xl-12">
                        <!-- Add Modal -->
                        <div class="modal fade" id="addItemCategoryModal" tabindex="-1" role="dialog"
                            aria-labelledby="addItemCategoryModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addItemCategoryModalTitle">Add Item Category</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ url('store-item-category') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row col-md-12">
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
                                                <button type="sumbit" class="btn btn-success">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Edit Modal -->
                        <div class="modal fade" id="editItemCategoryModal" tabindex="-1" role="dialog"
                            aria-labelledby="editItemCategoryModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editItemCategoryModalTitle">Edit Item Category</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ url('update-item-category') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="itemCategoryId" value=""
                                                id="itemCategoryId">
                                            <div class="row col-md-12">
                                                <div class="form-group col-md-6">
                                                    <label for="name">Name</label>
                                                    <input type="text" name="editItemCategoryName"
                                                        id="editItemCategoryName" class="form-control" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="name">Image</label>
                                                    <input type="file" name="editCategoryImage" id="editCategoryImage"
                                                        accept="images/*" class="form-control">
                                                </div>

                                            </div>
                                            <div class="row col-md-12 mt-3">
                                                <div class="form-group col-md-6">
                                                    <label for="name">Category Type</label>
                                                    <select name="edit_type" id="edit_type" class="form-control">
                                                        <option value="">Select Type</option>
                                                        <option value="POS">POS</option>
                                                        <option value="RES">RES</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="name">Parent Category</label>
                                                    <select name="edit_parent_id" id="edit_parent_id"
                                                        class="form-control">
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
                                                <button type="sumbit" class="btn btn-success">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Item Categories</h4>


                                <table class="table datatable table-hover dt-responsive nowrap w-100 table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col">S.No</th>
                                            <th scope="col">Image</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Parent Category</th>
                                            <th scope="col">No of Products</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>


                                    <tbody>

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
            </div> <!-- container-fluid -->
        </div>

    @endsection

    @push('after-scripts')
        <script type="text/javascript">
            $(document).ready(function() {

                $('.datatable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "pageLength": 50,
                    "ajax": "{{ url('item-category-list') }}",
                    "columns": [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            "data": "image",
                            name: "image"
                        },
                        {
                            "data": "title"
                        },
                        {
                            "data": "parent_cat",
                            name: "parent_cat"
                        },
                        {
                            "data": "number_of_product",
                            name: "number_of_product"
                        },
                        {
                            "data": "action"
                        }
                    ]

                });

                $(document.body).on('click', '.edit_category', function() {
                    var cat_id = $(this).data('id');
                    $.ajax({
                        url: "{{ url('get-item-category-detail') }}",
                        dataType: 'JSON',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            cat_id: cat_id,
                        },
                        success: function(data) {
                            if (data) {
                                console.log(data);
                                $('#itemCategoryId').val(data.lims_category_data.ItemCategoryID);
                                $("#editItemCategoryName").val(data.lims_category_data.title);
                                // $("#editCategoryImage").val(data.lims_category_data.image);
                                $("#edit_parent_id").val(data.parent_id);
                                $("#edit_type").val(data.lims_category_data.type);
                                $('#editItemCategoryModal').modal('show');
                            }
                        }
                    });
                });



            });
        </script>
    @endpush
