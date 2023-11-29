@extends('template.tmp')
@section('title', 'Dish Listing')
@section('content')
 <div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Dish Listing</h4>

                        <div class="page-title-right">
                             <a href="{{URL('/create-dish')}}"  class="btn btn-primary"><i class="bx bx-plus"></i> Add Dish</a>
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
                        <div >
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
                    <h4 class="card-title mb-4">Dish List</h4>


                    <table class="table datatable table-hover dt-responsive nowrap w-100 table-sm">
                        <thead>
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Status</th>
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
     $(document).ready(function(){

        $('.datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "pageLength":50,
            "ajax": "{{ url('all-dishes') }}",
            "columns":[
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable: false},
                { "data": "dish_img", name:"dish_img" },
                { "data": "name" },
                { "data": "status", name:"status" },
                { "data": "action" }
            ]
             
         });


     });
 </script>   
@endpush