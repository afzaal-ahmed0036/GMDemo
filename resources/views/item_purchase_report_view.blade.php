@extends('template.tmp')

@section('title', 'Item Purchase Report')


@section('content')



    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-print-block d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Item Purchase Report</h4>
                            <strong class="text-end">{{ session::get('CompanyName') }}</strong>
                            {{-- From {{ request()->StartDate }} to {{ request()->EndDate }} --}}

                        </div>
                    </div>
                </div>
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
                <div class="card">
                    <div class="card-body">

                        @if (count($items) > 0)
                            <table class="table table-sm align-middle table-nowrap mb-0" id="Item_Table">
                                <tbody>
                                    <tr>
                                        <th scope="col">S.No</th>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Item Code</th>
                                        <th scope="col">Item Cost</th>
                                        <th scope="col">Item Value</th>
                                        <th scope="col">Purchased</th>
                                        <th scope="col">Sold</th>
                                        <th scope="col">Remaining</th>

                                        <th scope="col">Remaining Cost</th>
                                        <th scope="col">Remaining Value</th>
                                    </tr>
                                </tbody>
                                <tbody>
                                    @foreach ($items as $key => $value)
                                        @php
                                            $v_invoice_profit = App\Models\InvoiceMaster::where(function ($query) {
                                                $query->where('sale_status', '!=', 10)->orWhereNull('sale_status');
                                            })
                                                ->when($value->ItemID != null, function ($query) use ($value) {
                                                    $query->whereHas('invoiceDetails', function ($subquery) use ($value) {
                                                        $subquery
                                                            ->where('ItemID', $value->ItemID)
                                                            ->select('*', DB::raw('SUM(invoice_detail.Qty) as Qtys'), DB::raw('SUM(invoice_detail.Total) as Totals'))
                                                            ->groupBy('invoice_detail.ItemID');
                                                    });
                                                })
                                                ->with('invoiceDetails', function ($query) use ($value) {
                                                    $query->where('ItemID', $value->ItemID);
                                                    // ->groupBy('invoice_detail.ItemID');
                                                })
                                                ->orderBy('InvoiceMasterID')
                                                ->get();

                                            $purchases = $v_invoice_profit->filter(function ($item) {
                                                return Str::startsWith($item->InvoiceNo, 'BILL-');
                                            });
                                            $sales = $v_invoice_profit->filter(function ($item) {
                                                return Str::startsWith($item->InvoiceNo, 'INV-');
                                            });
                                            $P_sum = $purchases
                                                ->flatMap(function ($item) {
                                                    return $item->invoiceDetails->map(function ($detail) {
                                                        return $detail->Qty;
                                                    });
                                                })
                                                ->sum();
                                            $S_sum = $sales
                                                ->flatMap(function ($item) {
                                                    return $item->invoiceDetails->map(function ($detail) {
                                                        return $detail->Qty;
                                                    });
                                                })
                                                ->sum();
                                            $remaining_stock = $P_sum - $S_sum;
                                        @endphp
                                        <tr>
                                            <td class="col-md-1">{{ $key + 1 }}</td>
                                            <td class="col-md-1">{{ $value->ItemName }}</td>
                                            <td class="col-md-1">{{ $value->ItemCode }}</td>
                                            <td class="col-md-1">{{ $value->CostPrice }}</td>
                                            <td class="col-md-1">{{ $value->SellingPrice }}</td>
                                            <td class="col-md-1">{{ $P_sum }}</td>
                                            <td class="col-md-1">{{ $S_sum }}</td>
                                            <td class="col-md-1">{{ $remaining_stock }}</td>
                                            <td class="col-md-1">{{ $remaining_stock * $value->CostPrice }}</td>
                                            <td class="col-md-1">{{ $remaining_stock * $value->SellingPrice }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        @else
                            <p class=" text-danger">No data found</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
