@extends('template.tmp')



@section('content')



<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-print-block d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Party Ledger</h4>


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

                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>DATE</th>
                                    <th>ACCOUNT</th>
                                    <th>TRANSACTION DETAILS</th>
                                    <th>TRANSACTIO TYPE</th>
                                    <th>TRANSACTION#</th>
                                    <th>REFERENCE#</th>
                                    <th>DEBIT</th>
                                    <th>CREDIT</th>
                                    <th>AMOUNT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sum_dr = 0;
                                $sum_cr = 0;
                                ?>
                                @foreach($joural as $result)
                                <tr>
                                    <td>{{$result->Date}}</td>
                                    <td>{{$result->ChartOfAccountName}}</td>
                                    <td>{{$result->JournalType}}</td>


                                    @if ($result->JournalType == 'BP')
                                    <td><a href="{{URL('/bankjournal/'.$result->VHNO)}}">{{$result->VHNO}}</a></td>
                                    @else
                                    <td>{{$result->VHNO}}</td>
                                    @endif
                                   



                                    <td>{{$result->PartyID}}</td>
                                    <td>{{$result->ChartOfAccountID}}</td>
                                    <td>{{$result->Dr}}</td>
                                    <td>{{$result->Cr}}</td>
                                    <td>Calculate</td>
                                    <?php
                                    $sum_dr += $result->Dr;
                                    $sum_cr += $result->Cr;
                                    ?>
                                </tr>
                                @endforeach
                                <tr>
                                    <th>Total</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><?php echo $sum_dr; ?></th>
                                    <th><?php echo $sum_cr; ?></th>
                                    <th></th>
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
<!-- END: Content-->

@endsection

@push('after-scripts')
<script>
    $(document).ready(function() {
        $("#go-btn").change(function() {

            $('form').submit();
        });
    });
</script>
@endpush