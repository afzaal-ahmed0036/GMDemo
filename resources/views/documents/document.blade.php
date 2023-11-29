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
                                    <h4 class="mb-sm-0 font-size-18">Documents</h4>

                                    <div class="page-title-right">
                                        <div class="page-title-right">
                                         <!-- button will appear here -->
                                    </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

 @if (session('error'))

<div class="alert alert-{{ Session::get('class') }} p-3"  id="success-alert">
                    
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


<style>
        
        .card {
    min-height: 270px;
}


</style>
               

           

<div class="d-xl-flex">
<div class="w-100">
<div class="d-md-flex">
<div class="card filemanager-sidebar me-md-2">
<div class="card-body">

<div class="d-flex flex-column h-100">
<div class="mb-4">
<div class="mb-3">
<div class="dropdown">
<button class="btn btn-light dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<i class="mdi mdi-plus me-1"></i> Create New
</button>
<div class="dropdown-menu">
<a class="dropdown-item" href="{{URL('/DocumentCategory')}}"><i class="bx bx-folder me-1"></i> Folder</a>
<!-- <a class="dropdown-item" href="#"><i class="bx bx-file me-1"></i> File</a> -->
</div>
</div>
</div>
<ul class="list-unstyled categories-list">
@foreach($document_category as $value)
<?php 

 $total = DB::table('documents')->where('DocumentCategoryID',$value->DocumentCategoryID)->get();

 ?>
<li>
<a href="{{URL('/Document/'.$value->DocumentCategoryID)}}" class="text-body d-flex align-items-center">
<i class="mdi mdi-folder font-size-16 text-warning me-2"></i> <span class="me-auto">{{$value->DocumentCategoryName}} ({{count($total)}})</span> 
</a>
</li>
@endforeach
</ul>
</div>
</div>
</div>
</div>
                                    <!-- filemanager-leftsidebar -->
        
  <div class="w-100">
<div class="card">
<div class="card-body">
<div>
<div class="row mb-3">
 
 
  </div>
    </div>

        <div>
                                                     
   </div>
        
    <div class="mt-4">
      <div class="d-flex flex-wrap">
       <h5 class="font-size-16 me-3">
        <?php if(session::get('DocumentCategoryID')) {
                

                $document_category = DB::table('document_category')->where('DocumentCategoryID',session::get('DocumentCategoryID')
        )->get();

echo $document_category[0]->DocumentCategoryName;
                }
                else
                {
                        echo 'Recent Files';
                }
                ?>


                </h5>
        
      <!--   <div class="ms-auto">
       <a href="javascript: void(0);" class="fw-medium text-reset">View All</a>
            </div> -->
           </div>
          <hr class="mt-2">
        
            <div >


         @if(count($documents)>0)       
       <table class="table table-sm align-middle table-nowrap table-hover mb-0">
      <thead>
                      <tr>
<th scope="col">FILE NAME</th>
<th scope="col">UPLOADED ON</th>
<th scope="col">START DATE</th>
<th scope="col">END DATE</th>
<th scope="col">COST</th>
<th scope="col" colspan="2">SIZE</th>
     </tr>
       </thead>
       <tbody>
                                                                
   @foreach($documents as $value)
  <tr>
<td><a href="javascript: void(0);" class="text-dark fw-medium"><i class="mdi mdi-text-box font-size-16 align-middle text-muted me-2"></i> {{$value->FileName}}</a></td>
<td>{{$value->eDate}}</td>

<td>{{dateformatman($value->StartDate)}}</td>
<td>{{dateformatman($value->ExpiryDate)}}</td>
<td>{{$value->Cost}}</td>
<td>{{$value->FileSize}}</td>
<td>
<div class="dropdown">
<a class="font-size-16 text-muted dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
<i class="mdi mdi-dots-horizontal"></i>
</a>

<div class="dropdown-menu dropdown-menu-end">
<a class="dropdown-item" href="{{URL('/documents/'.$value->File)}}" target="_blank">Open</a>
<!-- <a class="dropdown-item" href="{{URL('/DocumentEdit/'.$value->DocumentID)}}">Edit</a> -->
<!-- <div class="dropdown-divider"></div> -->
<a class="dropdown-item" href="{{URL('/DocumentDelete/'.$value->DocumentID.'/'.$value->File)}}">Remove</a>
</div>
   </div>
     </td>
    </tr>
                                                                
    @endforeach
     </tbody>
     </table>
     @else
<p>No record found</p>
     @endif
       </div>
       </div>
       </div>
       </div>
       <!-- end card -->
       </div>
       <!-- end w-100 -->
</div>
                            </div>

                          

            
                     
                        
                    </div> <!-- container-fluid -->

                </div>

 
<div class="row m-2">
    
          <div class="card">
         <div class="card-header bg-transparent border-bottom">
                            Add Document
           </div>
   <div class="card-body">
                                              <!-- enctype="multipart/form-data" -->
    <form action="{{URL('/DocumentSave')}}" method="post" enctype="multipart/form-data"> 

    {{csrf_field()}} 


 

   <div class="row">


 <div class="col-md-4">
 <div class="mb-3">
    <label for="basicpill-firstname-input">Section</label>
     <select name="DocumentCategoryID" id="DocumentCategoryID" class="form-select" required="">
    <option value="">Select</option>
    
     @foreach($document_category as $value)
      <option value="{{$value->DocumentCategoryID}}" {{(old('DocumentCategoryID')== $value->DocumentCategoryID) ? 'selected=selected': '' }}>{{$value->DocumentCategoryName}}</option>
     @endforeach
    
   </select>
  </div>
   </div>





      <div class="col-md-4">
    <div class="mb-3">
    <label for="basicpill-firstname-input">File Name*</label>
    <input type="text" class="form-control" name="FileName1"   required="">
    </div>
    </div>


   
   
     <div class="col-md-4">
              <div class="mb-3">
                <label for="basicpill-firstname-input">Start Date*</label>
                    <input name="StartDate" id="input-date1" class="form-control input-mask" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="dd/mm/yyyy" value="{{old('StartDate')}}" im-insert="false">
                    <span class="text-muted">e.g "dd/mm/yyyy"</span>
           </div>
       </div> 
   
    
   
    
    
    

<!-- ///////// -->

   </div>

<div class="row">
    
 <div class="col-md-4">
              <div class="mb-3">
                <label for="basicpill-firstname-input">End Date*</label>
                    <input name="EndDate" id="input-date1" class="form-control input-mask" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="dd/mm/yyyy" value="{{old('EndDate')}}" im-insert="false">
                    <span class="text-muted">e.g "dd/mm/yyyy"</span>
           </div>
       </div> 

    <div class="col-md-4">
  <div class="mb-3">
  <label for="basicpill-firstname-input">Cost </label>
  <input type="text" class="form-control" name="Cost" value="{{old('Cost')}} ">
  </div>
  </div>
  
    
<div class="col-md-4"><div class="mb-3"><label for="basicpill-firstname-input">Upload File</label><br><input type="file" name="FileUpload" id="FileUpload" required=""></div></div>
    
    
</div>
  
  
<div><button type="submit" class="btn btn-success w-lg float-right">Save / Update</button>
<a href="{{URL('/')}}" class="btn btn-secondary w-lg float-right">Cancel</a>
         </div>

                                              </form></div>
</div>
            
</div>  

  @endsection