@extends('template.tmp')

@section('title', $pagetitle)


@section('content')

<style>
  table,
  th,
  td {
    border: 1px solid black;
    border-collapse: collapse;
  }
</style>
<div class="main-content">

  <div class="page-content">
    <div class="container-fluid">
      <div class="row">

        <div class="row">
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
              <div class="card shadow-sm">
                <div class="card-header">
                  <h2>Recent Order On Kitchen Screen</h2>
                </div>
                <div class="row">
                  <div class="col-md-4">

                    <div class="card-body">
                      <h5 class="mb-3">Recent Orders </h5>
                      <div class="col-md-12 col-sm-12">
                        <div class="mb-3 row">
                          <table id="orders">

                          </table>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="col-md-8">
                    @if(!empty($invoice_dish_detail))
                    <div class="card-body" id="card-body">
                      <h5 class="mb-3">Detail of order : {{@$lims_sale_data->InvoiceNo}}</h5>
                      <div class="col-md-12 col-sm-12">
                        <div class="mb-3 row">
                          <table>
                            <tr>
                              <th>Dish</th>
                              <th>Type</th>
                              <th>Quantity</th>
                              <th>Price</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                            @foreach($invoice_dish_detail as $invoice_dish)
                            <tr>
                              <td><a href="">{{$invoice_dish->name}}</a></td>
                              <td>{{$invoice_dish->type}}</td>
                              <td>{{$invoice_dish->quantity}}</td>
                              <td>{{$invoice_dish->price}} </td>
                              <td>
                                <div class="col-md-4 form-group">
                                  <select class="form-select form-control-sm select2 dish_type_id" name="dish_type_id" id="dish_type_id">
                                    <option value='Processing' @if($invoice_dish->status == 'Processing') selected="selected" @endif data-value="{{$invoice_dish->id}}">Processing</option>
                                    <option value='Cancelled' @if($invoice_dish->status == 'Cancelled') selected="selected" @endif data-value="{{$invoice_dish->id}}">Cancelled</option>
                                    <option value='Completed' @if($invoice_dish->status == 'Completed') selected="selected" @endif data-value="{{$invoice_dish->id}}">Completed</option>
                                    <option value='Delivered' @if($invoice_dish->status == 'Delivered') selected="selected" @endif data-value="{{$invoice_dish->id}}">Delivered</option>
                                  </select>
                                </div>

                              </td>
                              <td> <a href="#" class="text-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove Order"><i class="mdi mdi-delete font-size-18" style="color: #f1734f;"></i></a></td>
                            </tr>
                            @endforeach
                          </table>
                        </div>
                      </div>
                    </div>

                    @endif


                  </div>
                </div>
              </div>
            </div>
          </div>

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
    <!-- END: Content-->
    <script type="text/javascript">
      $(document).ready(function() {
        $('.text-secondary').click(function(e) {
          e.preventDefault();
          $(this).closest("tr").remove();
        });


        $('.dish_type_id').change(function() {
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
          }).done(function(response) {
            console.log(response);
          }); // DONE ENDS HERE
        }
        var link = "{{route('invoice.live.ktchen')}}";
        refReshOrders(link);

        setInterval(function() {
          refReshOrders(link);
          var id = "{{$id}}";
          if (id != '') {
            invoiceCheckStatus(id);
          }

        }, 5000);


        setInterval(function() {
          refReshOrders(link); 

        }, 3000);

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
              $('#card-body').html('<h3>There are no pending orders</h3>');
              $('#orders').html(' ');
            } else {
              $('#orders').html(response);
            }
          }); // DONE ENDS HERE
        }

        function invoiceCheckStatus(url) {
          $.ajax({
            url: url,
            type: "GET",
            dataType: 'HTML',
            processData: false,
            contentType: false,
            beforeSend: function() {}
          }).done(function(response) {
            if(response == '0'){
              location.href="{{route('invoice.live.ktchen')}}";
            }
            
          
          }); // DONE ENDS HERE
        }



      });
    </script>
    @endsection