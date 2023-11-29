<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
// for API data receiving from http source
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
// use Datatables;
 use Yajra\DataTables\DataTables;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
// for excel export
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
// end for excel export

use Session;
use DB;
use URL;
use Image;
use Maatwebsite\Excel\Excel;
use File;
use PDF;

class Documents extends Controller
{
    public function DocumentCategory()
{   
    $document_category = DB::table('document_category')->get();
     return view ('documents.document_category',compact('document_category')); 
}

public function DocumentCategorySave(Request $request)
        {   

          ///////////////////////USER RIGHT & CONTROL ///////////////////////////////////////////    
          $allow= check_role(session::get('UserID'),session::get('BranchID'),'Job Title','Create/List');
          if($allow[0]->Allow=='N')
          {
            return redirect()->back()->with('error', 'You access is limited')->with('class','danger');
          }
          ////////////////////////////END SCRIPT ////////////////////////////////////////////////


          $this->validate($request, [
          'DocumentCategoryName' => 'required',
           ] );

             $data = array ( 
              "DocumentCategoryName" => $request->input('DocumentCategoryName'),
                            );
             $id= DB::table('document_category')->insertGetId($data);
            return redirect('DocumentCategory')->with('error','Saved Successfully')->with('class','success');
            
        }

 public function DocumentCategoryEdit($id)
    {   

      ///////////////////////USER RIGHT & CONTROL ///////////////////////////////////////////    
          $allow= check_role(session::get('UserID'),session::get('BranchID'),'Job Title','Update');
          if($allow[0]->Allow=='N')
          {
            return redirect()->back()->with('error', 'You access is limited')->with('class','danger');
          }
          ////////////////////////////END SCRIPT ////////////////////////////////////////////////
        
         $document_category = DB::table('document_category')->where('DocumentCategoryID',$id)->get();
        
        return view ('documents.document_category_edit',compact('document_category')); 
    }


        public function DocumentCategoryUpdate(Request $request)
        {   


          ///////////////////////USER RIGHT & CONTROL ///////////////////////////////////////////    
          $allow= check_role(session::get('UserID'),session::get('BranchID'),'Job Title','Update');
          if($allow[0]->Allow=='N')
          {
            return redirect()->back()->with('error', 'You access is limited')->with('class','danger');
          }
          ////////////////////////////END SCRIPT ////////////////////////////////////////////////
         $this->validate($request, [
          'DocumentCategoryName' => 'required',
           ] );

             $data = array ( 
              "DocumentCategoryName" => $request->input('DocumentCategoryName'),
                            );
 
        $id= DB::table('document_category')->where('DocumentCategoryID' , $request->DocumentCategoryID)->update($data);

            return redirect('DocumentCategory')->with('error','Saved Successfully')->with('class','success');
        }

         public function DocumentCategoryDelete($id)
        {   
            
            ///////////////////////USER RIGHT & CONTROL ///////////////////////////////////////////    
          $allow= check_role(session::get('UserID'),session::get('BranchID'),'Job Title','Delete');
          if($allow[0]->Allow=='N')
          {
            return redirect()->back()->with('error', 'You access is limited')->with('class','danger');
          }
          ////////////////////////////END SCRIPT ////////////////////////////////////////////////
            
            $id = DB::table('document_category')->where('DocumentCategoryID',$id)->delete();
            
            

            return redirect('/DocumentCategory')->with('error','Deleted Successfully')->with('class','success');
            
        }
    

 
  public  function Document($id=null)
    {

      $pagetitle='Document';
      
      if($id)
      {
        session::put('DocumentCategoryID',$id);
        $documents = DB::table('documents')->where('DocumentCategoryID',session::get('DocumentCategoryID'))->get();
      }
      else
      {
      $documents = DB::table('documents')->take(1)->get();
      // $documents = DB::table('documents')->take(1)->get();

      }

      $document_category = DB::table('document_category')->get();

 
      return view ('documents.document',compact('documents','pagetitle','document_category'));
    }


  public  function DocumentSave(request $request)
    {
           
              $size = formatBytes($request->file('FileUpload')->getSize());
                
              $MimeType = substr($request->file('FileUpload')->getMimeType(), 0, 5);
 

   if($request->hasFile('FileUpload'))

   { 
             $this->validate($request, [                 
                    'FileUpload' => 'required|image|mimes:jpeg,png,jpg,gif|max:20000',
                ] );

             $file = $request->file('FileUpload');
             $input['filename'] = time().'.'.$file->extension();

             $destinationPath = public_path('/documents');

             $file->move($destinationPath, $input['filename']);



                $data = array ( 
                  
                'FileName' => $request->FileName1,
                'DocumentCategoryID' => $request->DocumentCategoryID,
                
                  
                 'StartDate' => dateformatpc($request->StartDate),
                 'ExpiryDate' => dateformatpc($request->EndDate),
                'Cost' => $request->Cost,
                 
                 'File'=> $input['filename'],
                   'FileSize'=> $size,
                   'MimeType'=> $MimeType
                 
                                );
    

                
                DB::table('documents')->insertGetId($data);
                
                
           
  }


    


    return redirect ('Document')->with('error', 'Document Saved.')->with('class','success');
    }


  public  function DocumentDelete($id,$file)
    {
                
        $id = DB::table('documents')->where('DocumentID',$id)->delete();
        
    unlink('documents/'.$file);   

    return redirect()->back()->with('error', 'Deleted Successfully.')->with('class','success');
    }
}
