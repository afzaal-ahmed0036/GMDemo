@extends('tmp')

@section('title', $pagetitle)
 

@section('content')

<div class="main-content">

 <div class="page-content">
 <div class="container-fluid">
<div class="row">
  <div class="col-12">
  
 @if (session('error'))

 <div class="alert alert-{{ Session::get('class') }} p-1" id="success-alert">
                    
                   {{ Session::get('error') }}  
                </div>

@endif

 @if (count($errors) > 0)
                                 
                            <div >
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
      <div class="card-body">
          <!-- enctype="multipart/form-data" -->
          <form action="{{URL('/searchjournal')}}" method="post" name="form1" id="form1"> {{csrf_field()}} 

 

<div class="row">
  <div class="col-md-4">      <label for="basicpill-firstname-input">Invoice Type</label>
             <div class="mb-1">
               <select id="go-btn" class="form-select" name="q_search">
                                            <option value="null" selected="">Choose...</option>
                                            <option value="today">Today</option>
                                            <option value="yesterday">Yesterday</option>
                                            <option value="this_week">This Week</option>
                                            <option value="this_month">This Month</option>
                                            <option value="this_quarter">This Quarter</option>
                                            <option value="this_year">This Year</option>
                                            <option value="previous_week">Previous Week</option>
                                            <option value="previous_quarter">Previous Quarter</option>
                                            <option value="previous_year">Previous Year</option>
                                            <option value="previous_month">Previous Month</option>
                                        </select>
              </div></div>
  <div class="col-md-4"> <label for="basicpill-firstname-input">Invoice Type</label>
             <div class="mb-1">
                    <div class="input-group" id="datepicker21">
  <input type="text" name="StartDate"  autocomplete="off" class="form-control" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" data-date-

container="#datepicker21" data-provide="datepicker" data-date-autoclose="true" value="2022-01-01">
  <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
    </div>
              </div></div>


                <div class="col-md-4"> <label for="basicpill-firstname-input">Invoice Type</label>
             <div class="mb-1">
                    <div class="input-group" id="datepicker21">
  <input type="text" name="StartDate"  autocomplete="off" class="form-control" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" data-date-

container="#datepicker21" data-provide="datepicker" data-date-autoclose="true" value="2022-01-01">
  <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
    </div>
              </div></div>


 
</div>

            
          
  
  <div class="row">
    <div class="card">
      <div class="scroll-y noscroll-x body scrollbox reports-home-container pt-7"> 
<hr>
        <h5>  <i class="bx bx-pencil align-middle me-1"></i> My Favorites </h5> <h6 class="text-uppercase text-muted letter-space-1 mb-3 mt-6" style="font-weight: 500;">Standard Reports</h6> <div class="my-favorites"><div class="nav row"> <div class="nav-item col-lg-4"><a id="ember1043" class="ember-view report-section nav-link" href="#/reports/balancesheet"><div id="ember1044" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1045="1045"> <span>    </span> 

              <span class=" pl-2">Balance Sheet</span> <!----></span></div></a></div><div class="nav-item col-lg-4"><a id="ember1046" class="ember-view report-section nav-link" href="#/reports/journals"><div id="ember1047" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1048="1048"> <span>    </span> 

                <span class=" pl-2">Journal Report</span> <!----></span></div></a></div> </div></div><!----><div class="row"> <div class="col-lg-4"><div class="report-section">

          <h5>  <img src = "{{asset('assets/svg/buidling.svg')}}" height="15px;" class="mb-2" />
 Business Overview</h5> <div class="nav flex-column"> <div class="nav-item"><a id="ember1049" class="ember-view nav-link" href="#/reports/profitandloss"><div id="ember1050" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1051="1051"> <span>    </span> 

                <span class=" pl-2">Profit and Loss</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1052" class="ember-view nav-link" href="#/reports/cfstatement"><div id="ember1053" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1054="1054"> <span>    </span> 

                  <span class=" pl-2">Cash Flow Statement</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1055" class="ember-view nav-link" href="#/reports/balancesheet"><div id="ember1056" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1057="1057"> <span>    </span> 

                  <span class=" pl-2">Balance Sheet</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1058" class="ember-view nav-link" href="#/reports/businessperformanceratio"><div id="ember1059" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1060="1060"> <span>     </span> 

                  <span class=" pl-2">Business Performance Ratios</span> <span></span></span></div></a></div><div class="nav-item"><a id="ember1061" class="ember-view nav-link" href="#/reports/movementofequity"><div id="ember1062" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1063="1063"> <span>    </span> 

                  <span class=" pl-2">Movement of Equity</span> <span></span></span></div></a></div> </div></div></div><div class="col-lg-4"><div class="report-section">

          <h5>   <img src = "{{asset('assets/svg/sale.svg')}}" height="15px;" class="mb-2 mr-2" /> Sales</h5> <div class="nav flex-column"> <div class="nav-item"><a id="ember1064" class="ember-view nav-link" href="#/reports/salesbycustomer"><div id="ember1065" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1066="1066"> <span>     </span> 

                <span class=" pl-2">Sales by Customer</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1067" class="ember-view nav-link" href="#/reports/salesbyitem"><div id="ember1068" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1069="1069"> <span>   </span> 

                  <span class=" pl-2">Sales by Item</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1070" class="ember-view nav-link" href="#/reports/salesbysp"><div id="ember1071" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1072="1072"> <span>   </span> 

                  <span class=" pl-2">Sales by Sales Person</span> <!----></span></div></a></div> </div></div></div><div class="col-lg-4"><div class="report-section">

          <h5>    <img src = "{{asset('assets/svg/rece.svg')}}" height="15px;" class="mb-2 mr-2" />  Receivables</h5> <div class="nav flex-column"> <div class="nav-item"><a id="ember1073" class="ember-view nav-link" href="#/reports/customerbalances"><div id="ember1074" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1075="1075"> <span>   </span> 

                <span class=" pl-2">Customer Balances</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1076" class="ember-view nav-link" href="#/reports/invoiceaging"><div id="ember1077" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1078="1078"> <span>   </span> 

                  <span class=" pl-2">AR Aging Summary</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1079" class="ember-view nav-link" href="#/reports/invoiceaging/details"><div id="ember1080" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1081="1081"> <span>   </span> 

                  <span class=" pl-2">AR Aging Details</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1082" class="ember-view nav-link" href="#/reports/invoicedetails"><div id="ember1083" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1084="1084"> <span>   </span> 

                  <span class=" pl-2">Invoice Details</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1085" class="ember-view nav-link" href="#/reports/dcdetails"><div id="ember1086" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1087="1087"> <span>   </span> 

                  <span class=" pl-2">Delivery Challan Details</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1088" class="ember-view nav-link" href="#/reports/quotesdetails"><div id="ember1089" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1090="1090"> <span>   </span> 

                  <span class=" pl-2">Estimate Details</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1091" class="ember-view nav-link" href="#/reports/receivablesummary"><div id="ember1092" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1093="1093"> <span>   </span> 

                  <span class=" pl-2">Receivable Summary</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1094" class="ember-view nav-link" href="#/reports/receivabledetails"><div id="ember1095" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1096="1096"> <span>   </span> 

                  <span class=" pl-2">Receivable Details</span> <!----></span></div></a></div> </div></div></div> </div><div class="row"> <div class="col-lg-4"><div class="report-section">

          <h5>   Payments Received</h5> <div class="nav flex-column"> <div class="nav-item"><a id="ember1097" class="ember-view nav-link" href="#/reports/paymentsreceived"><div id="ember1098" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1099="1099"> <span>   </span> 

                <span class=" pl-2">Payments Received</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1100" class="ember-view nav-link" href="#/reports/timetopay"><div id="ember1101" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1102="1102"> <span>   </span> 

                  <span class=" pl-2">Time to Get Paid</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1103" class="ember-view nav-link" href="#/reports/cndetails"><div id="ember1104" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1105="1105"> <span>   </span> 

                  <span class=" pl-2">Credit Note Details</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1106" class="ember-view nav-link" href="#/reports/refundhistory"><div id="ember1107" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1108="1108"> <span>   </span> 

                  <span class=" pl-2">Refund History</span> <!----></span></div></a></div> </div></div></div><div class="col-lg-4"><div class="report-section">

          <h5>   Recurring Invoices</h5> <div class="nav flex-column"> <div class="nav-item"><a id="ember1109" class="ember-view nav-link" href="#/reports/recurringinvoicedetails"><div id="ember1110" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1111="1111"> <span>   </span> 

                <span class=" pl-2">Recurring Invoice Details</span> <!----></span></div></a></div> </div></div></div><div class="col-lg-4"><div class="report-section">

          <h5>   Payables</h5> <div class="nav flex-column"> <div class="nav-item"><a id="ember1112" class="ember-view nav-link" href="#/reports/vendorbalances"><div id="ember1113" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1114="1114"> <span>   </span> 

                <span class=" pl-2">Vendor Balances</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1115" class="ember-view nav-link" href="#/reports/billsaging"><div id="ember1116" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1117="1117"> <span>   </span> 

                  <span class=" pl-2">AP Aging Summary</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1118" class="ember-view nav-link" href="#/reports/billsagingdetails"><div id="ember1119" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1120="1120"> <span>   </span> 

                  <span class=" pl-2">AP Aging Details</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1121" class="ember-view nav-link" href="#/reports/billsdetails"><div id="ember1122" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1123="1123"> <span>   </span> 

                  <span class=" pl-2">Bills Details</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1124" class="ember-view nav-link" href="#/reports/vendorcreditdetails"><div id="ember1125" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1126="1126"> <span>   </span> 

                  <span class=" pl-2">Vendor Credits Details</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1127" class="ember-view nav-link" href="#/reports/paymentsmade"><div id="ember1128" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1129="1129"> <span>   </span> 

                  <span class=" pl-2">Payments Made</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1130" class="ember-view nav-link" href="#/reports/vendorrefundhistory"><div id="ember1131" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1132="1132"> <span>   </span> 

                  <span class=" pl-2">Refund History</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1133" class="ember-view nav-link" href="#/reports/payablesummary"><div id="ember1134" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1135="1135"> <span>   </span> 

                  <span class=" pl-2">Payable Summary</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1136" class="ember-view nav-link" href="#/reports/payabledetails"><div id="ember1137" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1138="1138"> <span>   </span> 

                  <span class=" pl-2">Payable Details</span> <!----></span></div></a></div> </div></div></div> </div><div class="row"> <div class="col-lg-4"><div class="report-section">

          <h5>   Purchases and Expenses</h5> <div class="nav flex-column"> <div class="nav-item"><a id="ember1139" class="ember-view nav-link" href="#/reports/purchasesbyvendor"><div id="ember1140" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1141="1141"> <span>   </span> 

                <span class=" pl-2">Purchases by Vendor</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1142" class="ember-view nav-link" href="#/reports/purchasesbyitem"><div id="ember1143" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1144="1144"> <span>   </span> 

                  <span class=" pl-2">Purchases by Item</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1145" class="ember-view nav-link" href="#/reports/expensedetails"><div id="ember1146" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1147="1147"> <span>   </span> 

                  <span class=" pl-2">Expense Details</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1148" class="ember-view nav-link" href="#/reports/expbycategory"><div id="ember1149" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1150="1150"> <span>   </span> 

                  <span class=" pl-2">Expenses by Category</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1151" class="ember-view nav-link" href="#/reports/expbycustomer"><div id="ember1152" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1153="1153"> <span>   </span> 

                  <span class=" pl-2">Expenses by Customer</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1154" class="ember-view nav-link" href="#/reports/expensesbyproject"><div id="ember1155" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1156="1156"> <span>   </span> 

                  <span class=" pl-2">Expenses by Project</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1157" class="ember-view nav-link" href="#/reports/mileageexpensesbyemployee"><div id="ember1158" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1159="1159"> <span>   </span> 

                  <span class=" pl-2">Expenses by Employee</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1160" class="ember-view nav-link" href="#/reports/billableexpensedetails"><div id="ember1161" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1162="1162"> <span>   </span> 

                  <span class=" pl-2">Billable Expense Details</span> <!----></span></div></a></div> </div></div></div><div class="col-lg-4"><div class="report-section">

          <h5> <!----> Taxes</h5> <div class="nav flex-column"> <div class="nav-item"><a id="ember1163" class="ember-view nav-link" href="#/reports/uae-tax-return"><div id="ember1164" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1165="1165"> <span>   </span> 

                <span class=" pl-2">Tax Returns</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1166" class="ember-view nav-link" href="#/reports/gccvataudit"><div id="ember1167" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1168="1168"> <span>   </span> 

                  <span class=" pl-2">VAT Audit Report</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1169" class="ember-view nav-link" href="#/reports/uaeexciseaudit"><div id="ember1170" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1171="1171"> <span>   </span> 

                  <span class=" pl-2">Excise Tax Audit Report</span> <!----></span></div></a></div> </div></div></div><div class="col-lg-4"><div class="report-section">

          <h5>   Banking</h5> <div class="nav flex-column"> <div class="nav-item"><a id="ember1172" class="ember-view nav-link" href="#/reports/reconciliation-details"><div id="ember1173" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1174="1174"> <span>   </span> 

                <span class=" pl-2">Reconciliation Status</span> <!----></span></div></a></div> </div></div></div> </div><div class="row"> <div class="col-lg-4"><div class="report-section">

          <h5>   Projects and Timesheet</h5> <div class="nav flex-column"> <div class="nav-item"><a id="ember1175" class="ember-view nav-link" href="#/reports/timesheet"><div id="ember1176" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1177="1177"> <span>   </span> 

                <span class=" pl-2">Timesheet Details</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1178" class="ember-view nav-link" href="#/reports/timesheetprofitabilitysummary"><div id="ember1179" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1180="1180"> <span>   </span> 

                  <span class=" pl-2">Timesheet Profitability Summary</span> <span></span></span></div></a></div><div class="nav-item"><a id="ember1181" class="ember-view nav-link" href="#/reports/projectsummary"><div id="ember1182" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1183="1183"> <span>   </span> 

                  <span class=" pl-2">Project Summary</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1184" class="ember-view nav-link" href="#/reports/projectdetails"><div id="ember1185" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1186="1186"> <span>   </span> 

                  <span class=" pl-2">Project Details</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1187" class="ember-view nav-link" href="#/reports/projectcostsummary"><div id="ember1188" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1189="1189"> <span>   </span> 

                  <span class=" pl-2">Projects Cost Summary</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1190" class="ember-view nav-link" href="#/reports/projectrevenuesummary"><div id="ember1191" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1192="1192"> <span>   </span> 

                  <span class=" pl-2">Projects Revenue Summary</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1193" class="ember-view nav-link" href="#/reports/projectperformance"><div id="ember1194" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1195="1195"> <span>   </span> 

                  <span class=" pl-2">Projects Performance Summary</span> <!----></span></div></a></div> </div></div></div><div class="col-lg-4"><div class="report-section">

          <h5>  Accountant</h5> <div class="nav flex-column"> <div class="nav-item"><a id="ember1196" class="ember-view nav-link" href="#/reports/accounttxns"><div id="ember1197" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1198="1198"> <span>   </span> 

                <span class=" pl-2">Account Transactions</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1199" class="ember-view nav-link" href="#/reports/accounttypesummary"><div id="ember1200" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1201="1201"> <span>   </span> 

                  <span class=" pl-2">Account Type Summary</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1202" class="ember-view nav-link" href="#/reports/generalledger"><div id="ember1203" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1204="1204"> <span>   </span> 

                  <span class=" pl-2">General Ledger</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1205" class="ember-view nav-link" href="#/reports/detailedgeneralledger"><div id="ember1206" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1207="1207"> <span>   </span> 

                  <span class=" pl-2">Detailed General Ledger</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1208" class="ember-view nav-link" href="#/reports/journals"><div id="ember1209" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1210="1210"> <span>    </span> 

                  <span class=" pl-2">Journal Report</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1211" class="ember-view nav-link" href="#/reports/trialbalance"><div id="ember1212" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1213="1213"> <span>   </span> 

                  <span class=" pl-2">Trial Balance</span> <!----></span></div></a></div> </div></div></div><div class="col-lg-4"><div class="report-section">

          <h5>  Budgets</h5> <div class="nav flex-column"> <div class="nav-item"><a id="ember1214" class="ember-view nav-link" href="#/reports/budgetvsactuals?cash_based=false&amp;from_date=&amp;to_date="><div id="ember1215" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1216="1216"> <span>   </span> 

                <span class=" pl-2">Budget Vs Actuals</span> <!----></span></div></a></div> </div></div></div> </div><div class="row"> <div class="col-lg-4"><div class="report-section">

          <h5>   Currency</h5> <div class="nav flex-column"> <div class="nav-item"><a id="ember1217" class="ember-view nav-link" href="#/reports/realizedgl"><div id="ember1218" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1219="1219"> <span>   </span> 

                <span class=" pl-2">Realized Gain or Loss</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1220" class="ember-view nav-link" href="#/reports/unrealizedgl"><div id="ember1221" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1222="1222"> <span>   </span> 

                  <span class=" pl-2">Unrealized Gain or Loss</span> <!----></span></div></a></div> </div></div></div><div class="col-lg-4"><div class="report-section">

          <h5>  Activity</h5> <div class="nav flex-column"> <div class="nav-item"><a id="ember1223" class="ember-view nav-link" href="#/reports/systemmails"><div id="ember1224" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1225="1225"> <span>   </span> 

                <span class=" pl-2">System Mails</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1226" class="ember-view nav-link" href="#/reports/activitylogs"><div id="ember1227" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1228="1228"> <span>   </span> 

                  <span class=" pl-2">Activity Logs &amp; Audit Trail</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1229" class="ember-view nav-link" href="#/reports/exception"><div id="ember1230" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1231="1231"> <span>   </span> 

                  <span class=" pl-2">Exception Report</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1232" class="ember-view nav-link" href="#/reports/portalactivities"><div id="ember1233" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1234="1234"> <span>   </span> 

                  <span class=" pl-2">Portal Activities</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1235" class="ember-view nav-link" href="#/reports/clientreviews"><div id="ember1236" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1237="1237"> <span>   </span> 

                  <span class=" pl-2">Client Reviews</span> <!----></span></div></a></div><div class="nav-item"><a id="ember1238" class="ember-view nav-link" href="#/reports/apiusage"><div id="ember1239" class="ember-view"><span class="text-nowrap" data-ember-action="" data-ember-action-1240="1240"> <span>   </span> 

                  <span class=" pl-2">API Usage</span> <!----></span></div></a></div> </div></div></div> </div><!----> <hr> <div class="pt-3 pb-3"><div class="reports-analytics"><span class="integ-zapps-reports ml-n6 mt-n3"></span></div> <div><span class="font-xlarge" style="font-weight: 600;">Advanced Financial Analytics for Extensive Books</span>  <div><span class="text-muted ml-n2"> </span><span>Analyze and keep track of your key <b>financial metrics.</b></span></div> <div><span class="text-muted ml-n2"> </span><span>Create <b>reports from multiple organizations</b> of Extensive Books.</span></div></div></div></div>
    </div>
  </div>        


            
    
              
              
         
      </div>
      <div class="card-footer bg-light">
        <button type="submit" class="btn btn-success w-lg float-right">Submit</button>
                    <a href="{{URL('/')}}" class="btn btn-secondary w-lg float-right">Cancel</a>
      </div>
  </div>
   </form>
  </div>
</div>

        </div>
      </div>
    </div>
    <!-- END: Content-->


     

  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script>
  $('#pdf').click(function(){
     
   $('#form1').attr('action', '{{URL("/PartyWiseSale1PDF")}}');
   $('#form1').attr('target', '_blank');
   $('#form1').submit();

});


  $('#online').click(function(){
     
   $('#form1').attr('action', '{{URL("/PartyWiseSale1")}}');
    

});


</script>
  @endsection


  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function() {
    $("#go-btn").change(function(){
        
                $('form').submit();
        });
});
</script>