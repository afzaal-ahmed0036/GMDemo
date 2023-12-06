<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
          $allow= check_role(Session::get('UserID'),Session::get('BranchID'),'Job Title','Create/List');
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
            return redirect('DocumentCategory')->with('success','Saved Successfully');

        }

 public function DocumentCategoryEdit($id)
    {

      ///////////////////////USER RIGHT & CONTROL ///////////////////////////////////////////
          $allow= check_role(Session::get('UserID'),Session::get('BranchID'),'Job Title','Update');
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
          $allow= check_role(Session::get('UserID'),Session::get('BranchID'),'Job Title','Update');
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

            return redirect('DocumentCategory')->with('success','Saved Successfully');
        }

         public function DocumentCategoryDelete($id)
        {

            ///////////////////////USER RIGHT & CONTROL ///////////////////////////////////////////
          $allow= check_role(Session::get('UserID'),Session::get('BranchID'),'Job Title','Delete');
          if($allow[0]->Allow=='N')
          {
            return redirect()->back()->with('error', 'You access is limited')->with('class','danger');
          }
          ////////////////////////////END SCRIPT ////////////////////////////////////////////////

            $id = DB::table('document_category')->where('DocumentCategoryID',$id)->delete();



            return redirect('/DocumentCategory')->with('success','Deleted Successfully');

        }



  public  function Document($id=null)
    {

      $pagetitle='Document';

      if($id)
      {
        Session::put('DocumentCategoryID',$id);
        $documents = DB::table('documents')->where('DocumentCategoryID',Session::get('DocumentCategoryID'))->get();
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





    return redirect ('Document')->with('success', 'Document Saved.');
    }


  public  function DocumentDelete($id,$file)
    {

        $id = DB::table('documents')->where('DocumentID',$id)->delete();

    unlink('documents/'.$file);

    return redirect()->back()->with('success', 'Deleted Successfully.');
    }
}
