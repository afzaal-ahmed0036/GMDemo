@extends('template.tmp')
@section('title', $pagetitle)
@push('after-styles')
<style>
  table,
  th,
  td {
    border: 1px solid black;
    border-collapse: collapse;
  }
</style>
@endpush
@section('content')

<div class="main-content">

  <div class="page-content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-12">
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
        </div>
      </div>
      <div class="card shadow-sm">
        <div class="card-header">
          <h2>Recent Order On Kitchen Screen</h2>
        </div>
        <div class="row">

          <div class="col-md-8">
            @if(!empty($invoice_dish_detail))
            <div class="card-body" id="card-body">
              <h5 class="mb-3">Detail of order : {{@$lims_sale_data->InvoiceNo}}</h5>

            </div>

            @endif


          </div>
        </div>



        <div class="row" id="kitchen">

          @if(!empty($invoice_dish_detail))
          @foreach($invoice_dish_detail as $invoice_dish)
          <div class="col-sm-3">
            <div class="card text-dark mb-3" style="width: 18rem;">
              <div class="card-header card-title">{{$invoice_dish->name}}</div>
              @if(!empty($invoice_dish->image_thumbnail) && !file_exists(public_path().'thumbnail/'.$invoice_dish->image_thumbnail))
              <img src="{{asset('thumbnail/'.$invoice_dish->image_thumbnail)}}" style="width: 18rem;">
              @else
              <img src="{{asset('assets/images/product/noimage.jpg')}}" style="width: 18rem;">
              @endif

              <div class="card-body">
                <p>{{$invoice_dish->type}}</p>
                <p>Quantity : {{$invoice_dish->quantity}}</p>
                <p> <select class="form-select form-control-sm select2 dish_type_id" name="dish_type_id" id="dish_type_id">
                    <option value='Processing' @if($invoice_dish->status == 'Processing') selected="selected" @endif data-value="{{$invoice_dish->id}}">Processing</option>
                    <option value='Cancelled' @if($invoice_dish->status == 'Cancelled') selected="selected" @endif data-value="{{$invoice_dish->id}}">Cancelled</option>
                    <option value='Completed' @if($invoice_dish->status == 'Completed') selected="selected" @endif data-value="{{$invoice_dish->id}}">Completed</option>
                    <option value='Delivered' @if($invoice_dish->status == 'Delivered') selected="selected" @endif data-value="{{$invoice_dish->id}}">Delivered</option>
                  </select></p>

              </div>
            </div>
          </div>
          @endforeach
          @endif

        </div>
      </div>



    </div>
    @php
    $id = '';
    if(!empty(request()->route('id'))){
    $id = request()->route('id');
    $id = route('invoice.invoice-check-status',['id'=>$id]);
    }

    @endphp


    @endsection
    @push('after-scripts')
    <!-- END: Content-->
    <script type="text/javascript">
      $(document).ready(function() {
        $(document).on('change', '.dish_type_id', function() {
          var status = $(this).val();
          var id = $(this).find(':selected').data('value');
          let url = "{{route('invoice.invoice-change-status',[':id',':status'])}}";
          route = url.replace(':id', id);
          route = route.replace(':status', status);
          changeStatus(route);
        });

        function changeStatus(route) {
          $.ajax({
            url: route,
            type: "GET",
            dataType: 'JSON',
            processData: false,
            contentType: false,
            beforeSend: function() {}
          }).done(function(response) {}); // DONE ENDS HERE
        }



        var link = "{{route('invoice.live-ktchen')}}";
        setInterval(function() {
          refReshOrders(link);

        }, 6000);

        function refReshOrders(route) {
          $.ajax({
            url: route,
            type: "GET",
            dataType: 'HTML',
            processData: false,
            contentType: false,
            beforeSend: function() {}
          }).done(function(response) {
            if (response == '0') {
              $('#kitchen').html('<h3>There are no pending orders</h3>');
            } else {
              $('#kitchen').html(response);
            }
          }); // DONE ENDS HERE
        }



      });
    </script>@endpush