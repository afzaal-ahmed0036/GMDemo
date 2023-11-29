@extends('template.tmp')
@section('title', $pagetitle)
@section('content')
    @if (session('error'))
        <div class="alert alert-{{ Session::get('class') }} p-1" id="success-alert">
            {{ Session::get('error') }}
        </div>
    @endif
    @if (count($errors) > 0)
        <div>
            <div class="alert alert-danger p-1   border-3">
                <p class="font-weight-bold"> There were some problems with your input.</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Daybook</h4>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <form action="{{ URL('/ItemSaleReport1') }}" method="post" name="form1" id="form1">
                        <div class="card-body">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="email-id">From Date</label>
                                    <div class="input-group" id="datepicker21">
                                        <input type="text" name="StartDate" autocomplete="off" class="form-control"
                                            placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" data-date-
                                            container="#datepicker21" data-provide="datepicker" data-date-autoclose="true"
                                            value="{{ date('Y-m-d') }}">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="email-id">To Date</label>
                                    <div class="input-group" id="datepicker22">
                                        <input type="text" name="EndDate" autocomplete="off" class="form-control"
                                            placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" data-date-
                                            container="#datepicker22" data-provide="datepicker" data-date-autoclose="true"
                                            value="{{ date('Y-m-d') }}">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <label class="col-form-label" for="email-id">Item</label>
                                    <select name="item_id" id="ItemID" class="form-control select2" required>
                                        <option value="">--Select Item--</option>
                                        @foreach ($items as $item)
                                            <option value="{{ $item->ItemID }}">{{ $item->ItemName }} ,
                                                ({{ $item->ItemCode }})</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <button type="button" class="btn btn-success w-lg float-right" id="online">Submit</button>
                            <button type="button" class="btn btn-primary w-lg float-right" id="pdf_submit">PDF</button>
                            {{-- <button type="button" class="btn btn-secondary w-lg float-right"
                                id="csv_submit">Export</button> --}}

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Handle the click event of the "PDF" button
            $("#pdf_submit").click(function() {
                var item_id = $('#ItemID').val();
                // alert(item_id);
                if (item_id == '') {
                    alert('Please Select an Item');
                } else {
                    $("#form1").attr("action", "{{ URL('/ItemReportPDF') }}");
                    $('#form1').attr('target', '_blank');
                    $('#form1').submit();
                    // Submit the form when the "PDF" button is clicked
                }

            });

            $("#online").click(function() {
                var item_id = $('#ItemID').val();
                // alert(item_id);
                if (item_id == '') {
                    alert('Please Select an Item');
                } else {
                    $("#form1").attr("action", "{{ URL('/ItemReportView') }}");
                    $('#form1').attr('target', '_blank');
                    $('#form1').submit();
                    // Submit the form when the "PDF" button is clicked
                }

            });
            $("#csv_submit").click(function() {
                $("#form1").attr("action", "{{ URL('/saleReportCSV') }}");
                $('#form1').attr('target', '_blank');
                $('#form1').submit();
                // Submit the form when the "PDF" button is clicked
            });
        });
    </script>
    <!-- END: Content-->
@endsection
