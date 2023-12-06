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
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Items</h4>
                            <a href="{{ URL('/Item/Create') }}" class="btn btn-primary w-md float-right "><i
                                    class="bx bx-plus"></i> Add New</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <!-- card end here -->

                        <div class="card">
                            <div class="card-body">
                                @if (count($item) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped  table-sm  m-0" id="student_table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">S.No</th>
                                                    <th scope="col">Item Code</th>
                                                    <th scope="col">Type</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Unit</th>
                                                    <th scope="col">Price</th>
                                                    {{-- <th scope="col">Taxable</th>
                                                    <th scope="col">Tax %</th> --}}
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($item as $key => $value)
                                                    <tr>
                                                        <td class="col">{{ $key + 1 }}</td>
                                                        <td class="col">{{ $value->ItemCode }}</td>
                                                        <td class="col">{{ $value->ItemType }}</td>
                                                        <td class="col-5">{{ $value->ItemName }}</td>
                                                        <td class="col">
                                                            {{ $value->unit ? $value->unit->base_unit : 'N/A' }}</td>
                                                        <td class="col">{{ $value->SellingPrice }}</td>
                                                        {{-- <td class="col-md-1">{{ $value->Taxable }}</td>
                                                        <td class="col-md-1">
                                                            {{ $value->Percentage != null ? $value->Percentage : '0.00' }}
                                                        </td> --}}
                                                        @php
                                                            $inv_details = App\Models\InvoiceDetail::where('ItemID', $value->ItemID)
                                                                ->where('InvoiceNo', 'like', '%INV-%')
                                                                ->get();
                                                            // dd(count($inv_details));
                                                        @endphp
                                                        <td class="col-2">
                                                            <a class="btn btn-sm btn-secondary"
                                                                href="{{ URL('/ItemEdit/' . $value->ItemID) }}"><i
                                                                    class="bx bx-pencil"></i></a>
                                                            @if (count($inv_details) == 0)
                                                                <a href="#"
                                                                    onclick="delete_confirm2('ItemDelete',{{ $value->ItemID }})"><i
                                                                        class="btn btn-danger bx bx-trash"></i></a>
                                                            @endif

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class=" text-danger">No data found</p>
                                @endif
                            </div>
                        </div>

                        {{-- <div class="card">
                            <div class="card-header bg-secondary bg-soft">Import Bulk Data</div>
                            <div class="card-body">
                                <form method="post" enctype="multipart/form-data" action="{{ url('/ItemImport') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <table class="table">
                                            <tr>
                                                <td width="40%" align="right"><label>Select File for Upload</label>
                                                </td>
                                                <td width="30">
                                                    <input type="file" name="file1" class="form-control" required>
                                                </td>
                                                <td width="30%" align="left">
                                                    <input type="submit" name="upload" class="btn btn-primary"
                                                        value="Upload">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="40%" align="right"></td>
                                                <td width="30"><span class="text-muted">.xls, .xslx</span></td>
                                                <td width="30%" align="left"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        </div> --}}



                    </div>

                </div>
            </div>
        </div>
        <!-- END: Content-->
        <!-- my own model -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center">Are you sure to delete this information ?</p>
                        <p class="text-center">
                            <a href="#" class="btn btn-danger " id="delete_link">Delete</a>
                            <button type="button" class="btn btn-info" data-bs-dismiss="modal">Cancel</button>
                        </p>
                    </div>

                </div>
            </div>
        </div>
        <!-- end of my own model -->
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
                $('.close').click(function() {
                    $('#exampleModal').modal('hide');

                })
                $('#student_table').DataTable();
            });
        </script>
    @endpush
