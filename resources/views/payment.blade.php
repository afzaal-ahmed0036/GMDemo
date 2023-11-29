@extends('template.tmp')
@section('title', $pagetitle)

@section('content')

<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <!-- start page title -->
      <div class="row">
        <div class="col-12">
          <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Voucher</h4>
            <div class="page-title-right ">
              
              <div class="btn-group  shadow-sm dropstart">
                <button type="button" class="btn btn-primary waves-effect waves-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-chevron-left"></i> Add New
                </button>
                <div class="dropdown-menu" style="margin: 0px;">
                  <a class="dropdown-item" href="{{URL('/VoucherCreate/BP')}}">BP-Bank Payment</a>
                  <a class="dropdown-item" href="{{URL('/VoucherCreate/BR')}}">BR-Bank Receipt</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{URL('/VoucherCreate/CP')}}">CP-Cash Payment</a>
                  <a class="dropdown-item" href="{{URL('/VoucherCreate/CR')}}">CR-Cash Receipt</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{URL('/JV')}}">Journal Voucher</a>
                </div>
              </div>
            </div>
            
            
            
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          
          @if (session('error'))
          <div class="alert alert-{{ Session::get('class') }} p-1" id="success-alert">
            
            {{ Session::get('error') }}
          </div>
          @endif
          @if (count($errors) > 0)
          
          <div >
            <div class="alert alert-danger pt-3 pl-0   border-3">
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
              <table id="student_table" class="table table-striped table-sm " style="width:100%">
                <thead>
                  <tr>
                    <th>Voucher#</th>
                    <th>Voucher</th>
                    <th>Type</th>
                    <th>Dat</th>
                    <th class="col-md-5">Narration</th>
                    
                    <th>Action</th>
                  </tr>
                </thead>
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
<script type="text/javascript">
$(document).ready(function() {
$('#student_table').DataTable({
"processing": true,
"serverSide": true,
"ajax": "{{ url('ajax_kashif') }}",
"columns":[
{ "data": "VoucherMstID" },
{ "data": "Voucher" },
{ "data": "VoucherTypeName" },
{ "data": "Date" },
{ "data": "Narration" },

{ "data": "action" },
]
});
});
</script>
@endpush

