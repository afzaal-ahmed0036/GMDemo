<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\InvoiceDetail;
use App\Models\InvoiceItemAdditional;
use App\Models\InvoiceMaster;
use App\Models\Item;
use App\Models\Journal;
use App\Models\Payment;
use App\Models\TempInvoiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use PDF;

class ItemController extends Controller
{
    public function addItemAdditional(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {

            if ($request->has('ids')) {
                // dump($request->ids);
                InvoiceItemAdditional::where('InvoiceNo', $request->invoiceNumber)
                    ->where('ItemId', $request->itemId)
                    ->whereNotIn('id', $request->ids)
                    ->delete();
                // dd($data);
            } else {
                InvoiceItemAdditional::where('InvoiceNo', $request->invoiceNumber)
                    ->where('ItemId', $request->itemId)
                    ->delete();
            }
            // dd('done');
            if ($request->has('item_description')) {
                $descriptions = $request->item_description;
                $files = $request->item_file;
                $i = 0;
                foreach ($descriptions as $description) {
                    // dump($description);
                    if ($files != null && $i < count($files)) {
                        $image = $files[$i];
                        // dump($image);
                        $imageName = Str::random(10) . time() . '.' . $image->extension();
                        // dump($imageName);
                        $destinationPath = public_path('assets/images/items');
                        $image->move($destinationPath, $imageName);
                        // dump($files[$i]);
                        $data = [
                            'InvoiceNo' => $request->invoiceNumber,
                            'ItemId' => $request->itemId,
                            'description' => $description,
                            'file' => $imageName,
                        ];
                        InvoiceItemAdditional::create($data);
                    } else {
                        if ($description != null) {
                            $data = [
                                'InvoiceNo' => $request->invoiceNumber,
                                'ItemId' => $request->itemId,
                                'description' => $description,
                            ];
                            InvoiceItemAdditional::create($data);
                        }
                    }
                    $i++;
                }
            }
            DB::commit();
            return response()->json(['message' => 'Additional Information Saved']);
            // dd('done');
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            // dd($e->getMessage());
            return response()->json(['error' => $e->getMessage()]);

            // dd("error");
        }
    }
    public function getItemAdditional($id, $invoice_number)
    {
        $invoices = InvoiceItemAdditional::where('InvoiceNo', $invoice_number)->where('ItemId', $id)->get();
        return response()->json(['data' => $invoices]);
    }

    public function checkItemAvailabilty($code, $invoice_no)
    {
        $item = Item::where('ItemCode', $code)->first();
        $invoice_detail = TempInvoiceDetail::where('ItemID', $item->ItemID)->where('InvoiceNo', $invoice_no)->first();
        if (!$invoice_detail) {
            TempInvoiceDetail::create([
                'ItemID' => $item->ItemID,
                'InvoiceNo' => $invoice_no
            ]);
        }

        // dd($invoice_detail);
        return response()->json(['item' => $item, 'invoice_detail' => $invoice_detail]);
    }
    public function dailyTransactions()
    {
        try {
            $invoice_masters = InvoiceMaster::whereDate('Date', today())
                ->where('sale_status', '!=', 10)
                ->where('partyID', '!=', null)
                ->with('party')
                ->get();
            $company = Company::first();
            // dd($invoice_masters);
            $pdf = PDF::loadView('teq-invoice.dailyTransactions', compact('invoice_masters', 'company'));
            // return $pdf->download('pdfview.pdf');
            $pdf->setpaper('A4', 'portiate');
            return $pdf->stream();
            // return view('teq-invoice.dailyTransactions', compact('invoice_masters'));
        } catch (\Exception $e) {
            //throw $th;
            // dd('here');
            // DB::rollBack();
            return back()->with('message', $e->getMessage());
        }
    }
    public function searchItem($code)
    {
        $data = Item::where('ItemName', 'like', '%' . $code . '%')->orWhere('ItemCode', 'like', '%' . $code . '%')->get();
        // dd($data);
        return response()->json(['data' => $data]);
    }
    public function deleteItemAvailabilty($code, $invoice_no)
    {
        $item = Item::where('ItemCode', $code)->first();
        TempInvoiceDetail::where('ItemID', $item->ItemID)->where('InvoiceNo', $invoice_no)->delete();

        // dd($invoice_detail);
        return response()->json(['message' => 'done']);
    }
    
}
