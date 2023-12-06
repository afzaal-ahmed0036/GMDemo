<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Validation\Rule;

use Illuminate\Http\Request;

use Datatables;

use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\Mail;

use App\Mail\SendMail;

// for excel export

use PhpOffice\PhpSpreadsheet\Spreadsheet;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PhpOffice\PhpSpreadsheet\Writer\Xls;

// end for excel export



use URL;

use Image;

use Excel;

use File;
use Illuminate\Support\Facades\DB;
use PDF;



class AutosearchController extends Controller

{

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function autosearch(Request $request)

    {

        if ($request->ajax()) {

            $data = DB::table('products')->where('name', 'LIKE', $request->name . '%')->get();

            $output = '';

            if (count($data) > 0) {

                $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1; overflow:scroll; height:250px;">';

                foreach ($data as $row) {

                    $output .= '<li class="list-group-item">' . $row->name . '</li>';
                }

                $output .= '</ul>';
            } else {

                $output .= '<li class="list-group-item">' . 'No Data Found' . '</li>';
            }

            return $output;
        }

        return view('purchase.k');
    }









    public  function kashif()

    {



        return view('purchase.kk');
    }
}
