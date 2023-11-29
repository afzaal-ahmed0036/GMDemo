@extends('template.tmp')

@section('title', 'HR')
 

@section('content')
 
 <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Document Category</h4>

                                    <div class="page-title-right">
                                        <div class="page-title-right">
                                         <!-- button will appear here -->
                                    </div>
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
                                        <h4 class="card-title mb-4"></h4>

                                        <form action="{{URL('/DocumentCategorySave')}}" method="post" enctype="multipart/form-data">

                                         {{csrf_field()}} 

                                         <div class="row">
                                           <div class="col-md-4">
                                         <div class="mb-3">
                                         <label for="basicpill-firstname-input">Document Type *</label>
                                         <input type="text" class="form-control" name="DocumentCategoryName" value="{{old('DocumentCategoryName')}} ">
                                         </div>
                                         </div>
                                         

                                        

                                         	<div><button type="submit" class="btn btn-success w-lg float-right">Save</button>
                                         	     
                                         	</div>
                                         	
                                         
                                         </div>
                                         
                                     
                                         
                                         
                                         
                                         
                                         
                                         

                                     </form>

                                        
                                    </div>
                                    <!-- end card body -->
                                </div> 

                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">List of document types</h4>


                                               @if(count($document_category) >0) 
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped align-middle table-nowrap mb-0">
                                                <tbody>
                                                    <thead>
                                                    <th scope="col" >S.No</th>
                                                    <th scope="col">Document Types</th>
                                                    
                                                    <th scope="col">Action</th>
                                                  </thead>
                                                </tbody><tbody>
                                               <?php $i=1; ?>
                                               @foreach($document_category as $value)
                                                    <tr>
                                                        <td class="col-md-1">{{$i}}.</td>
                                                         
                                                        <td class="col-md-10">
                                                            {{$value->DocumentCategoryName}}
                                                             
                                                         
                                                        <td class="col-md-1"><a href="{{URL('/DocumentCategoryEdit/'.$value->DocumentCategoryID)}}"><i class="bx bx-pencil align-middle me-1"></i></a> <a href="{{URL('/DocumentCategoryDelete/'.$value->DocumentCategoryID)}}"><i class="bx bx-trash  align-middle me-1"></i></a></td>
                                                        <td>
                                                            
                                                        </td>
                                                    </tr>
                                                   <?php $i++; ?>
                                                    @endforeach

                                                     

                                                   
                                                </tbody>
                                            </table>
                                            
                                              
                                        </div>
                                        @endif

                                          @if(count($document_category) ==0) 
                                        <p class="text-danger h6">No record to display</p>

                                        @endif
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