@extends('../template.tmp')




@section('content')



<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-print-block d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Receiveable Detail Report</h4>


                    </div>
                </div>
            </div>
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




            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4"></h4>
                    <form class="repeater" action="{{URL('/receiveabledetailsummary')}}" method="post">
                        {{csrf_field()}}
                        <div>
                            <div data-repeater-item="" class="row">
                                <div class="mb-4 col-lg-4">
                                    <div class="mb-3">
                                        <label for="formrow-inputState" class="form-label">State</label>
                                        <select id="go-btn" class="form-select" name="q_search">
                                            <option value="null" selected="">Choose...</option>
                                            <option value="today">Today</option>
                                            <option value="yesterday">Yesterday</option>
                                            <option value="this_week">This Week</option>
                                            <option value="this_month">This Month</option>
                                            <option value="this_quarter">This Quarter</option>
                                            <option value="this_year">This Year</option>
                                            <option value="previous_week">Previous Week</option>
                                            <option value="previous_quarter">Previous Quarter</option>
                                            <option value="previous_year">Previous Year</option>
                                            <option value="previous_month">Previous Month</option>
                                        </select>
                                    </div>
                                </div>
                           

                                <div class="mb-3 col-lg-3">

                                    <label>From</label>
                                    <div class="input-group" id="datepicker2">
                                        <input value="2022-01-01" type="text" name="from" class="form-control" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" data-provide="datepicker" data-date-autoclose="true">

                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>

                                <div class="mb-3 col-lg-3">

                                    <label>To</label>
                                    <div class="input-group" id="datepicker2">
                                        <input value="2023-01-01" type="text" name="to" class="form-control" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" data-provide="datepicker" data-date-autoclose="true">

                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>

                                <div class="mb-2 col-lg-2 align-self-center">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                                    </div>
                                </div>


                            </div>

                        </div>

                    </form>
                </div>


            </div>
        </div>

    </div>
</div>
</div>
<!-- END: Content-->

@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function() {
    $("#go-btn").change(function(){
        
                $('form').submit();
        });
});
</script>