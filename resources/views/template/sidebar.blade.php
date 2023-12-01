<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">

                <li>
                    <a href="{{ URL('/Dashboard') }}" class="waves-effect">
                        <i class="mdi mdi-speedometer-slow mb-0"></i>

                        <span key="t-dashboards">Dashboard</span>
                    </a>

                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-basket"></i>
                        <span key="t-ecommerce">Items</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li> <a href="{{ URL('/Item') }}" key="t-products">Items List</a></li>

                        <li> <a href="{{ URL('/Item/Create') }}" key="t-products">Create</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-cart-outline"></i>
                        <span key="t-ecommerce">Sale</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li id="exp-cat-menu"><a href="{{ route('voucher.create') }}" key="t-products">Create
                                Invoice</a></li>
                        <li id="exp-list-menu"><a href="{{ route('invoice.listing') }}" key="t-products">Invoice
                                Listing</a></li>
                        <li id="exp-list-menu"><a href="{{ route('invoice.cancelled.listing') }}"
                                key="t-products">Cancelled Orders</a></li>

                        {{-- <li id="exp-list-menu"><a href="{{route('invoice.live-ktchen')}}" key="t-products">Live Kitchen Orders</a></li>
                        <li id="exp-list-menu"><a href="{{route('invoice.live.ktchen')}}" key="t-products">Manager Live Screen</a></li> --}}


                    </ul>
                </li>


                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-cart-outline"></i>
                        <span key="t-ecommerce">Sales</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">


                        <li> <a href="{{URL('/Parties')}}" key="t-products">Customers</a></li>
                        <li> <a href="{{URL('/DeliveryChallan')}}" key="t-products">Delivery Challans</a></li>
                        <li> <a href="{{URL('/Estimate')}}" key="t-products">Estimate</a></li>
                        <li> <a href="{{URL('/Invoice')}}" key="t-products">Invoices</a></li>
                        <li> <a href="{{URL('/Payment')}}" key="t-products">Payment Received</a></li>
                        <li> <a href="{{URL('/BulkPaymentCreate')}}" key="t-products">Bulk Payment Received</a></li>

                        <li> <a href="{{URL('/CreditNote')}}" key="t-products">Credit Notes</a></li>



                    </ul>
                </li> --}}



                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-shopping-outline"></i>
                        <span key="t-ecommerce">Purchases</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li> <a href="{{ URL('/Bill') }}" key="t-products">Purchase Invoice</a></li>
                        <li> <a href="{{ URL('/Expense') }}" key="t-products">Expense</a></li>

                        {{-- <li> <a href="{{URL('/Supplier')}}" key="t-products">Vendors</a></li> --}}

                        {{-- <li> <a href="{{URL('/PurchaseOrder')}}" key="t-products">Purchase Invoice</a></li> --}}
                        {{-- <li> <a href="{{URL('/PurchasePayment')}}" key="t-products">Payments Made</a></li> --}}
                        <!-- <li>  <a   href="{{ URL('/') }}" key="t-products" >Recurring Bills</a></li> -->
                        {{-- <li> <a href="{{URL('/DebitNote')}}" key="t-products">Debit Note Credit</a></li> --}}



                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-food"></i>
                        <span key="t-ecommerce">Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ URL('/SaleReport') }}" key="t-products">Sale Report</a></li>
                        <li><a href="{{ URL('/ItemReport') }}" key="t-products">Item Report</a></li>
                        <li><a href="{{ URL('/ExpenseReport') }}" key="t-products">Expense Report</a></li>
                        <li><a href="{{ URL('/DailyIncomeExpense') }}" key="t-products">Daily Income/Expense</a></li>
                        <li><a href="{{ URL('/VatReport') }}" key="t-products">VAT Report</a></li>
                        <li><a href="{{ URL('/ItemsPurchaseReport') }}" key="t-products">Items Purchase Report</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user"></i>
                        <span key="t-ecommerce">CRM</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li> <a href="{{ URL('/Parties') }}" key="t-products">Customers</a></li>
                        <li> <a href="{{ URL('/Create/Party') }}" key="t-products">Create New</a></li>

                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-hammer-wrench"></i>
                        <span key="t-ecommerce">POS Setting</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ URL('/item-category-list') }}" key="t-products">Item Categories</a></li>
                        <li><a href="{{ URL('/ware-house-list') }}" key="t-products">WareHouses</a></li>
                        {{-- <li><a href="{{route('warehouse.warehousestransfer')}}" key="t-products">Stock Adjustment</a></li>
                        <li><a href="{{route('warehouse.stock-warehouses-in')}}" key="t-products">WareHouse Stock In</a></li>
                        <li><a href="{{route('warehouse.stock-warehouses-out')}}" key="t-products">WareHouse Stock Out</a></li> --}}
                        <li><a href="{{ URL('/brand-list') }}" key="t-products">Brand</a></li>
                        <li><a href="{{ URL('/unit-list') }}" key="t-products">Unit</a></li>
                        <li><a href="{{ URL('/tax-list') }}" key="t-products">Tax</a></li>
                        <li><a href="{{ URL('/currency-list') }}" key="t-products">Currency</a></li>
                        <li><a href="{{ URL('/print-barcodes') }}" key="t-products">Print Barcode</a></li>
                        {{-- <li><a href="{{URL('/pos-setting')}}" key="t-products">POS Setting</a></li> --}}


                    </ul>
                </li>

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-food"></i>
                        <span key="t-ecommerce">Dish</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{URL('/create-dish')}}" key="t-products">Add Dish</a></li>
                        <li><a href="{{URL('/add-dish')}}" key="t-products">Add Single Dish</a></li>
                        <li><a href="{{URL('/all-dishes')}}" key="t-products">All Dishes</a></li>
                        <!--   <li><a href="{{URL('/create-dish-order')}}" key="t-products">Create Order</a></li>
                        <li><a href="{{URL('/invoice-dish-listing')}}" key="t-products">Dish Invoices</a></li> -->


                    </ul>
                </li> --}}

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-food"></i>
                        <span key="t-ecommerce">Appointment</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{route('appointments.index')}}" key="t-products">Appointment List</a></li>
                        <li><a href="{{route('appointments.create')}}" key="t-products">Add Appointment</a></li>
                    </ul>
                </li> --}}

                {{-- <li>
                    <a href="{{route('coupons.index')}}" class="waves-effect">
                        <i class="mdi mdi-receipt"></i>
                        <span key="t-calendar">Coupon List</span>
                    </a>
                </li> --}}


                {{-- <li>
                    <a href="{{URL('/Voucher')}}" class="waves-effect">
                        <i class="mdi mdi-receipt"></i>
                        <span key="t-calendar">Voucher</span>
                    </a>
                </li> --}}


                {{-- <li>
                    <a href="{{URL('/PettyCash')}}" class="waves-effect">
                        <i class="mdi mdi-account-cash-outline"></i>
                        <span key="t-calendar">PettyCash</span>
                    </a>
                </li> --}}
                {{-- <li>
                    <a href="{{URL('/AdjustmentBalance')}}" class="waves-effect">
                        <i class="mdi mdi-scale-balance"></i>
                        <span key="t-calendar">Adjustment Balance</span>
                    </a>
                </li> --}}

                {{-- <li>
                    <a href="{{URL('/ChartOfAcc')}}" class="waves-effect">
                        <i class="mdi mdi-text-box-check-outline"></i>
                        <span key="t-calendar">Chart of Account</span>
                    </a>
                </li> --}}



                <li>
                    <a href="{{ URL('/User') }}" class="waves-effect">
                        <i class="bx bxs-user-plus"></i>
                        <span key="t-calendar">Staff</span>
                    </a>
                </li>
                <li>
                    <a href="{{ URL('/Company') }}" class="waves-effect">
                        <i class="bx bxs-building"></i>
                        <span key="t-calendar">Company</span>
                    </a>
                </li>

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-finance"></i>
                        <span key="t-ecommerce">Party Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">


                        <li><a href="{{URL('/PartyLedger')}}" key="t-products">Party Ledger</a></li>
                        <li><a href="{{URL('/PartyBalance')}}" key="t-products">Party Balance</a></li>
                        <li><a href="{{URL('/PartyYearlyBalance')}}" key="t-products">Yearly Report</a></li>
                        <li><a href="{{URL('/PartyAgingPDF')}}" key="t-products">Aging Report</a></li>
                        <!-- <li><a href="#" key="t-products" >Party Analysis</a></li> -->
                        <li><a href="{{URL('/PartyList')}}" key="t-products">Party List</a></li>
                        <li><a href="{{URL('/PartyWiseSale')}}" key="t-products">Partywise Sale</a></li>
                        <li><a href="{{URL('/OutStandingInvoice')}}" key="t-products">Outstanding Invoices</a></li>
                        <li><a href="{{URL('/TaxReport')}}" key="t-products">Tax Report</a></li>


                    </ul>
                </li> --}}
                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-chart-areaspline"></i>
                        <span key="t-ecommerce">Supplier Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">


                        <li> <a href="{{URL('/SupplierLedger')}}" key="t-products">Supplier Ledger</a></li>
                        <li> <a href="{{URL('/SupplierBalance')}}" key="t-products">Supplier Balance</a></li>
                        <li> <a href="{{URL('/Invoice')}}" key="t-products">Sale Invoice</a></li>
                        <li> <a href="{{URL('/SalemanReport')}}" key="t-products">Sales Man Report</a></li>
                        <li> <a href="{{URL('/TaxReport')}}" key="t-products">Tax Report</a></li>
                        <li> <a href="{{URL('/SupplierWiseSale')}}" key="t-products">Sales Report</a></li>


                    </ul>
                </li> --}}
                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-chart-bell-curve-cumulative"></i>
                        <span key="t-ecommerce">Account Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">




                        <li><a key="t-products" href="{{URL('/DailyIncomeExpense')}}">Daily Income / Expense</a></li>


                        <li><a key="t-products" href="{{URL('/CashbookReport')}}">Cash Book</a></li>
                        <!--                  <li><a key="t-products" href="#">Sales man wise cash book</a></li>
                        -->
                        <li><a key="t-products" href="{{URL('/DaybookReport')}}">Day book</a></li>
                        <li><a key="t-products" href="{{URL('/GeneralLedger')}}">General Ledger</a></li>
                        <li><a key="t-products" href="{{URL('/TrialBalance')}}">Trial Balance</a></li>
                        <li><a key="t-products" href="{{URL('/TrialBalanceActivity')}}">Trial with Activity</a></li>
                        <li><a key="t-products" href="#">Yearly Summary</a></li>
                        <li><a key="t-products" href="{{URL('/ProfitAndLoss')}}">Profit & Loss</a></li>
                        <li><a key="t-products" href="{{URL('/BalanceSheet')}}">Balance Sheet</a></li>
                        <li><a key="t-products" href="{{URL('/PartyBalance')}}">party balance</a></li>
                        <!--   <li><a key="t-products" href="#">ageing report</a></li>
                        <li><a key="t-products" href="#">cash flow</a></li> -->
                        <li><a key="t-products" href="{{URL('/TaxOverallReport')}}">Tax Report</a></li>
                        <li><a key="t-products" href="{{URL('/ReconcileReport')}}">Bank Reconciliation</a>

                        <li><a key="t-products" href="{{URL('/InvoiceSummary')}}">Invoice Summary list</a></li>
                        <li><a key="t-products" href="{{URL('/Inventory')}}">Stock Inventory</a>
                            <!-- <li><a key="t-products" href="{{URL('/TicketRegister')}}">Invoice Detail</a></li> -->


                    </ul>
                </li> --}}

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-folder font-size-16 text-warning me-2"></i>
                        <span key="t-ecommerce">Documents</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">


                        <li><a href="{{URL('/DocumentCategory')}}" key="t-products">Make Folder</a></li>
                        <li><a href="{{URL('/Document')}}" key="t-products">Documents</a></li>


                    </ul>
                </li> --}}

                <li>
                    <a href="{{ URL('/Logout') }}" class="waves-effect">
                        <i class="bx bx-power-off"></i>
                        <span key="t-calendar">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
