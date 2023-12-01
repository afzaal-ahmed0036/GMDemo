<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\KM;
use App\Http\Controllers\Accounts;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TeqPosController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\User;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Documents;
use App\Http\Controllers\DishController;
use App\Http\Controllers\AppointmentController;

use App\Http\Controllers\CouponController;
use App\Http\Controllers\CashRegisterController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\PartyController;

Route::get('/base1/', [KM::class, 'base1']);
Route::post('/base2/', [KM::class, 'base2']);

Route::get('/', [Accounts::class, 'Login']);
Route::get('/Login', [Accounts::class, 'Login']);
Route::post('/UserVerify', [Accounts::class, 'UserVerify']);
Route::group(['middleware' => ['CheckAdmin']], function () {
    Route::get('/Dashboard', [Accounts::class, 'Dashboard'])->name('kashif');
    Route::get('/Prayer/', [KM::class, 'Prayer']);
    Route::get('/Invoice', [Accounts::class, 'Invoice']);

    Route::get('/InvoiceCreate', [Accounts::class, 'InvoiceCreate']);
    Route::get('/ajax_invoice', [Accounts::class, 'ajax_invoice']);

    Route::post('/InvoiceSave', [Accounts::class, 'InvoiceSave']);
    route::get('/InvoiceEdit/{id}', [Accounts::class, 'InvoiceEdit']);
    route::get('/InvoicePDF/{id}', [Accounts::class, 'InvoicePDF']);
    route::get('/InvoiceView/{id}', [Accounts::class, 'InvoiceView']);

    Route::post('/InvoiceUpdate', [Accounts::class, 'InvoiceUpdate']);
    route::get('/InvoiceDelete/{id}', [Accounts::class, 'InvoiceDelete']);

    Route::post('/Ajax_Balance', [Accounts::class, 'Ajax_Balance']);
    Route::post('/Ajax_VHNO', [Accounts::class, 'Ajax_VHNO']);
    Route::post('/ajax_invoice_vhno', [Accounts::class, 'ajax_invoice_vhno']);


    Route::get('/Voucher', [Accounts::class, 'Voucher']);
    Route::get('/VoucherCreate/{vouchertype}', [Accounts::class, 'VoucherCreate']);
    Route::post('/VoucherSave', [Accounts::class, 'VoucherSave']);
    Route::get('/ajax_voucher', [Accounts::class, 'ajax_voucher']);
    Route::get('/VoucherEdit/{id}', [Accounts::class, 'VoucherEdit']);
    Route::post('/VoucherUpdate', [Accounts::class, 'VoucherUpdate']);
    Route::get('/VoucherDelete/{id}', [Accounts::class, 'VoucherDelete']);
    Route::get('/VoucherView/{id}', [Accounts::class, 'VoucherView']);

    Route::get('/JV/', [Accounts::class, 'JV']);
    Route::post('/JVSave/', [Accounts::class, 'JVSave']);


    Route::get('/Item', [ItemsController::class, 'Item']);
    Route::get('/Item/Create', [ItemsController::class, 'ItemCreate']);
    Route::post('/ItemSave', [ItemsController::class, 'ItemSave']);
    Route::get('/ItemEdit/{id}', [ItemsController::class, 'ItemEdit']);
    Route::post('/ItemUpdate/', [ItemsController::class, 'ItemUpdate']);
    Route::get('/ItemDelete/{id}', [ItemsController::class, 'ItemDelete']);
    Route::get('Items/generatecode', [ItemsController::class, 'generateCode'])->name('items.generatecode');




    Route::get('/User', [User::class, 'Show']);
    Route::post('/UserSave', [User::class, 'UserSave']);
    Route::get('/UserEdit/{id}', [User::class, 'UserEdit']);
    Route::post('/UserUpdate/', [User::class, 'UserUpdate']);
    Route::get('/UserDelete/{id}', [User::class, 'UserDelete']);



    Route::get('/Supplier', [Accounts::class, 'Supplier']);
    Route::post('/SaveSupplier', [Accounts::class, 'SaveSupplier']);
    Route::get('/SupplierEdit/{id}', [Accounts::class, 'SupplierEdit']);
    Route::post('/SupplierUpdate/', [Accounts::class, 'SupplierUpdate']);
    Route::get('/SupplierDelete/{id}', [Accounts::class, 'SupplierDelete']);


    Route::get('/Parties', [PartyController::class, 'Parties']);
    Route::get('/Create/Party', [PartyController::class, 'CreateParty']);
    Route::post('/SaveParties', [PartyController::class, 'SaveParties']);
    Route::get('/PartiesEdit/{id}', [PartyController::class, 'PartiesEdit']);
    Route::post('/PartiesUpdate/', [PartyController::class, 'PartiesUpdate']);
    Route::get('/PartiesDelete/{id}', [PartyController::class, 'PartiesDelete']);



    Route::get('/CheckUserRole1/{userid},{tablename},{action}', [Accounts::class, 'CheckUserRole1']);




    Route::get('/table', [Accounts::class, 'table']);
    Route::get('/datatable', [Accounts::class, 'datatable']);



    // Petty Cash

    Route::get('/PettyCashCreate', [Accounts::class, 'PettyCashCreate']);
    Route::get('/PettyCash', [Accounts::class, 'PettyCash']);
    Route::get('/ajax_pettycash', [Accounts::class, 'ajax_pettycash']);
    Route::post('/PettyCashSave', [Accounts::class, 'PettyCashSave']);
    route::get('/PettyCashEdit/{id}', [Accounts::class, 'PettyCashEdit']);
    Route::post('/PettyCashUpdate', [Accounts::class, 'PettyCashUpdate']);
    Route::post('/Ajax_PVHNO', [Accounts::class, 'Ajax_PVHNO']);


    Route::get('/ChartOfAcc/', [Accounts::class, 'ChartOfAcc']);
    route::post('/ChartOfAccountSave/', [Accounts::class, 'ChartOfAccountSave']);
    route::post('/ChartOfAccountSaveL3/', [Accounts::class, 'ChartOfAccountSaveL3']);
    route::get('/ChartOfAccountDelete/{ChartOfAccountID}', [Accounts::class, 'ChartOfAccountDelete']);
    route::get('/ChartOfAccountEdit/{id}', [Accounts::class, 'ChartOfAccountEdit']);
    route::post('/ChartOfAccountUpdate/', [Accounts::class, 'ChartOfAccountUpdate']);

    route::get('/PartyLedger/', [Accounts::class, 'PartyLedger']);
    route::post('/PartyLedger1/', [Accounts::class, 'PartyLedger1']);
    route::post('/PartyLedger1PDF/', [Accounts::class, 'PartyLedger1PDF']);

    route::post('/PartySalesLedger1PDF/', [Accounts::class, 'PartySalesLedger1PDF']);
    route::post('/PartyLedger2PDF/', [Accounts::class, 'PartyLedger2PDF']);
    route::post('/PartyLedgerAccount1PDF/', [Accounts::class, 'PartyLedgerAccount1PDF']);

    route::post('/PartySalesLedger2PDF/', [Accounts::class, 'PartySalesLedger2PDF']);



    route::get('/SupplierLedger/', [Accounts::class, 'SupplierLedger']);
    route::get('/AdjustmentBalance/', [Accounts::class, 'AdjustmentBalance']);
    route::post('/AdjustmentBalanceSave/', [Accounts::class, 'AdjustmentBalanceSave']);

    route::get('/SupplierBalance/', [Accounts::class, 'SupplierBalance']);
    route::post('/SupplierBalance1/', [Accounts::class, 'SupplierBalance1']);
    route::post('/SupplierBalance1PDF/', [Accounts::class, 'SupplierBalance1PDF']);


    route::get('/PartyList/', [Accounts::class, 'PartyList']);
    route::get('/PartyListPDF/', [Accounts::class, 'PartyListPDF']);
    route::get('/OutStandingInvoice/', [Accounts::class, 'OutStandingInvoice']);
    route::post('/OutStandingInvoice1/', [Accounts::class, 'OutStandingInvoice1']);
    route::post('/OutStandingInvoice1PDF/', [Accounts::class, 'OutStandingInvoice1PDF']);


    route::get('/PartyWiseSale/', [Accounts::class, 'PartyWiseSale']);
    route::post('/PartyWiseSale1/', [Accounts::class, 'PartyWiseSale1']);
    route::post('/PartyWiseSale1PDF/', [Accounts::class, 'PartyWiseSale1PDF']);

    route::get('/YearlyPartyBalance/', [Accounts::class, 'YearlyPartyBalance']);
    route::post('/YearlyPartyBalance1/', [Accounts::class, 'YearlyPartyBalance1']);




    route::get('/PartyBalance/', [Accounts::class, 'PartyBalance']);
    route::post('/PartyBalance1/', [Accounts::class, 'PartyBalance1']);
    route::post('/PartyBalance1PDF/', [Accounts::class, 'PartyBalance1PDF']);
    route::post('/PartyBalanceAreawise2PDF/', [Accounts::class, 'PartyBalanceAreawise2PDF']);

    route::get('/PartyYearlyBalance/', [Accounts::class, 'PartyYearlyBalance']);
    route::post('/PartyYearlyBalance1/', [Accounts::class, 'PartyYearlyBalance1']);
    route::post('/PartyYearlyBalance1PDF/', [Accounts::class, 'PartyYearlyBalance1PDF']);


    // supplier reports

    route::get('/SupplierLedger/', [Accounts::class, 'SupplierLedger']);
    route::post('/SupplierLedger1/', [Accounts::class, 'SupplierLedger1']);
    route::post('/SupplierLedger1PDF/', [Accounts::class, 'SupplierLedger1PDF']);
    route::post('/SupplierBillLedger2PDF/', [Accounts::class, 'SupplierBillLedger2PDF']);

    route::get('/SupplierWiseSale/', [Accounts::class, 'SupplierWiseSale']);
    route::post('/SupplierWiseSale1/', [Accounts::class, 'SupplierWiseSale1']);
    route::post('/SupplierWiseSale1PDF/', [Accounts::class, 'SupplierWiseSale1PDF']);

    route::get('/TaxReport/', [Accounts::class, 'TaxReport']);
    route::post('/TaxReport1/', [Accounts::class, 'TaxReport1']);
    route::post('/TaxReport1PDF/', [Accounts::class, 'TaxReport1PDF']);

    route::get('/SalemanReport/', [Accounts::class, 'SalemanReport']);
    route::post('/SalemanReport1/', [Accounts::class, 'SalemanReport1']);
    route::post('/SalemanReport1PDF/', [Accounts::class, 'SalemanReport1PDF']);

    route::get('/AirlineSummary/', [Accounts::class, 'AirlineSummary']);
    route::post('/AirlineSummary1/', [Accounts::class, 'AirlineSummary1']);
    route::post('/AirlineSummary1PDF/', [Accounts::class, 'AirlineSummary1PDF']);

    // accounts report

    route::get('/VoucherReport/', [Accounts::class, 'VoucherReport']);
    route::post('/VoucherReport1/', [Accounts::class, 'VoucherReport1']);
    route::post('/VoucherReport1PDF/', [Accounts::class, 'VoucherReport1PDF']);

    route::get('/CashbookReport/', [Accounts::class, 'CashbookReport']);
    route::post('/CashbookReport1/', [Accounts::class, 'CashbookReport1']);
    route::post('/CashbookReport1PDF/', [Accounts::class, 'CashbookReport1PDF']);

    route::get('/DaybookReport/', [Accounts::class, 'DaybookReport']);
    route::post('/DaybookReport1/', [Accounts::class, 'DaybookReport1']);
    route::post('/DaybookReport1PDF/', [Accounts::class, 'DaybookReport1PDF']);


    route::get('/GeneralLedger/', [Accounts::class, 'GeneralLedger']);
    route::post('/GeneralLedger1/', [Accounts::class, 'GeneralLedger1']);
    route::post('/GeneralLedger1PDF/', [Accounts::class, 'GeneralLedger1PDF']);

    route::get('/TrialBalance/', [Accounts::class, 'TrialBalance']);
    route::post('/TrialBalance1/', [Accounts::class, 'TrialBalance1']);
    route::post('/TrialBalance1PDF/', [Accounts::class, 'TrialBalance1PDF']);


    route::get('/TrialBalanceActivity/', [Accounts::class, 'TrialBalanceActivity']);
    route::post('/TrialBalanceActivity1/', [Accounts::class, 'TrialBalanceActivity1']);
    route::post('/TrialBalanceActivity1PDF/', [Accounts::class, 'TrialBalanceActivity1PDF']);

    route::get('/BalanceSheet/', [Accounts::class, 'BalanceSheet']);
    route::post('/BalanceSheet1/', [Accounts::class, 'BalanceSheet1']);
    route::post('/BalanceSheet1PDF/', [Accounts::class, 'BalanceSheet1PDF']);

    Route::get('/BalanceSheetDetail/{ChartOfAccountID}/{StartDat}/{EndDate}', [Accounts::class, 'BalanceSheetDetail']);
    Route::get('/JournalEntries/{ChartOfAccountID}/{StartDat}/{EndDate}', [Accounts::class, 'JournalEntries']);


    route::get('/TicketRegister/', [Accounts::class, 'TicketRegister']);
    route::post('/TicketRegister1/', [Accounts::class, 'TicketRegister1']);
    route::post('/TicketRegister1PDF/', [Accounts::class, 'TicketRegister1PDF']);

    route::get('/InvoiceSummary/', [Accounts::class, 'InvoiceSummary']);
    route::post('/InvoiceSummary1/', [Accounts::class, 'InvoiceSummary1']);
    route::post('/InvoiceSummary1PDF/', [Accounts::class, 'InvoiceSummary1PDF']);

    route::get('/ProfitAndLoss/', [Accounts::class, 'ProfitAndLoss']);
    route::post('/ProfitAndLoss1/', [Accounts::class, 'ProfitAndLoss1']);
    route::post('/ProfitAndLoss1PDF/', [Accounts::class, 'ProfitAndLoss1PDF']);




    route::get('/tmp/', [Accounts::class, 'tmp']);

    Route::get('/Logout', [Accounts::class, 'Logout']);




    route::get('/Role/{UserID}', [Accounts::class, 'Role']);
    route::post('/RoleSave', [Accounts::class, 'RoleSave']);
    route::get('/RoleView/{UserID}', [Accounts::class, 'RoleView']);
    route::post('/RoleUpdate', [Accounts::class, 'RoleUpdate']);

    route::get('/checkUserRole/{UserID}', [Accounts::class, 'checkUserRole']);


    route::get('/UserProfile', [Accounts::class, 'UserProfile']);
    route::get('/ChangePassword', [Accounts::class, 'ChangePassword']);
    route::post('/UpdatePassword', [Accounts::class, 'UpdatePassword']);



    route::get('/SalesInvoiceCreate/', [Accounts::class, 'SalesInvoiceCreate']);
    route::post('/SaleInvoiceSave/', [Accounts::class, 'SaleInvoiceSave']);
    route::get('/SaleInvoiceEdit/{id}', [Accounts::class, 'SaleInvoiceEdit']);
    route::post('/SaleInvoiceUpdate/', [Accounts::class, 'SaleInvoiceUpdate']);
    route::get('/SaleInvoiceDelete/{id}', [Accounts::class, 'SaleInvoiceDelete']);
    route::get('/SaleInvoiceView/{id}', [Accounts::class, 'SaleInvoiceView']);
    route::get('/SaleInvoiceViewPDF/{id}', [Accounts::class, 'SaleInvoiceViewPDF']);




    route::get('/DeliveryChallan/', [Accounts::class, 'DeliveryChallan']);


    route::get('/Payment/', [Accounts::class, 'Payment']);
    route::get('/ajax_payment', [Accounts::class, 'ajax_payment']);

    route::get('/PaymentCreate/', [Accounts::class, 'PaymentCreate']);

    Route::get('/Ajax_PartyInvoices/{id}', [Accounts::class, 'Ajax_PartyInvoices']);
    route::get('/PaymentViewPDF/{id}', [Accounts::class, 'PaymentViewPDF']);


    route::get('/DeliveryChallan/', [Accounts::class, 'DeliveryChallan']);
    route::get('/ajax_deliverychallan/', [Accounts::class, 'Ajax_DeliveryChallan']);
    route::get('/DeliveryChallanCreate/', [Accounts::class, 'DeliveryChallanCreate']);
    route::post('/DeliveryChallanSave/', [Accounts::class, 'DeliveryChallanSave']);
    route::get('/DeliveryChallanView/{id}', [Accounts::class, 'DeliveryChallanView']);
    route::get('/DeliveryChallanViewPDF/{id}', [Accounts::class, 'DeliveryChallanViewPDF']);
    route::get('/DeliveryChallanEdit/{id}', [Accounts::class, 'DeliveryChallanEdit']);
    route::post('/DeliveryChallanUpdate/', [Accounts::class, 'DeliveryChallanUpdate']);



    route::get('/DeliveryChallanDelete/{id}', [Accounts::class, 'DeliveryChallanDelete']);


    route::get('/PaymentCreate/', [Accounts::class, 'PaymentCreate']);
    route::post('/PaymentSave/', [Accounts::class, 'PaymentSave']);
    route::get('/PaymentDelete/{id}', [Accounts::class, 'PaymentDelete']);

    // bulk payment from parties

    route::get('/BulkPaymentCreate/', [Accounts::class, 'BulkPaymentCreate']);
    route::post('/BulkPaymentSearch/', [Accounts::class, 'BulkPaymentSearch']);
    route::post('/BulkPaymentSave/', [Accounts::class, 'BulkPaymentSave']);



    route::get('/CreditNote/', [Accounts::class, 'CreditNote']);
    route::get('/ajax_creditnote', [Accounts::class, 'ajax_creditnote']);

    route::get('/CreditNoteCreate', [Accounts::class, 'CreditNoteCreate']);
    route::post('/CreditNoteSave', [Accounts::class, 'CreditNoteSave']);
    route::get('/CreditNoteEdit/{id}', [Accounts::class, 'CreditNoteEdit']);
    route::post('/CreditNoteUpdate', [Accounts::class, 'CreditNoteUpdate']);
    route::get('/CreditNoteDelete/{id}', [Accounts::class, 'CreditNoteDelete']);
    route::get('/CreditNoteView/{id}', [Accounts::class, 'CreditNoteView']);
    route::get('/CreditNoteViewPDF/{id}', [Accounts::class, 'CreditNoteViewPDF']);



    // ..............Bill / Purchase.............
    route::get('/Bill/', [BillController::class, 'Bill']);
    route::get('/BillCreate/', [BillController::class, 'BillCreate']);
    route::post('/BillSave/', [BillController::class, 'BillSave']);
    route::get('/BillEdit/{id}', [BillController::class, 'BillEdit']);
    route::post('/BillUpdate/', [BillController::class, 'BillUpdate']);
    route::get('/BillDelete/{id}', [BillController::class, 'BillDelete']);
    route::get('/BillView/{id}', [BillController::class, 'BillView']);
    route::get('/BillViewPDF/{id}', [BillController::class, 'BillViewPDF']);

    // ..............Purchase Return .............
    route::get('/DebitNote/', [Accounts::class, 'DebitNote']);
    route::get('/ajax_debitnote/', [Accounts::class, 'ajax_debitnote']);
    route::get('/DebitNoteCreate/', [Accounts::class, 'DebitNoteCreate']);
    route::post('/DebitNoteSave/', [Accounts::class, 'DebitNoteSave']);
    route::get('/DebitNoteEdit/{id}', [Accounts::class, 'DebitNoteEdit']);
    route::post('/DebitNoteUpdate/', [Accounts::class, 'DebitNoteUpdate']);
    route::get('/DebitNoteDelete/{id}', [Accounts::class, 'DebitNoteDelete']);
    route::get('/DebitNoteView/{id}', [Accounts::class, 'DebitNoteView']);
    route::get('/DebitNoteViewPDF/{id}', [Accounts::class, 'DebitNoteViewPDF']);

    // ..............Estimate.............
    route::get('/Estimate/', [EstimateController::class, 'Estimate']);

    route::get('/EstimateCreate/', [EstimateController::class, 'EstimateCreate']);

    route::post('/EstimateSave/', [EstimateController::class, 'EstimateSave']);
    route::get('/ajax_estimate/', [EstimateController::class, 'ajax_estimate']);

    route::get('/EstimateDelete/{id}', [EstimateController::class, 'EstimateDelete']);
    route::get('/EstimateView/{id}', [EstimateController::class, 'EstimateView']);
    route::get('/EstimateEdit/{id}', [EstimateController::class, 'EstimateEdit']);
    route::post('/EstimateUpdate/', [EstimateController::class, 'EstimateUpdate']);
    route::get('/BlankReport/', [Accounts::class, 'BlankReport']);
    route::get('/EstimateViewPDF/{id}', [EstimateController::class, 'EstimateViewPDF']);


    //.............Complete Journal..............
    route::get('/completejournal', [ReportController::class, 'completejournal']);


    // ............Company............
    Route::get('/Company', [CompanyController::class, 'Company']);
    Route::post('/SaveCompany', [CompanyController::class, 'SaveCompany']);
    Route::get('/CompanyEdit/{id}', [CompanyController::class, 'CompanyEdit']);
    Route::post('/CompanyUpdate/', [CompanyController::class, 'CompanyUpdate']);
    Route::get('/CompanyDelete/{id}', [CompanyController::class, 'CompanyDelete']);

    // //................. PAYMENT FOR PURCHASES....................

    route::get('/PurchasePayment/', [Accounts::class, 'PurchasePayment']);
    route::get('/ajax_purchasepaymenttable', [Accounts::class, 'ajax_purchasepaymenttable']);
    route::get('/PurchasePaymentCreate/', [Accounts::class, 'PurchasePaymentCreate']);
    Route::POST('/Ajax_SupplierInvoices/', [Accounts::class, 'Ajax_SupplierInvoices']);

    route::post('/PurchasePaymentSave/', [Accounts::class, 'PurchasePaymentSave']);
    route::get('/PurchasePaymentDelete/{id}', [Accounts::class, 'PurchasePaymentDelete']);
    route::get('/PurchasePaymentView/{id}', [Accounts::class, 'PurchasePaymentView']);
    // // Ajax_SupplierInvoices


    //...................purchaseorder...........................
    route::get('/PurchaseOrder/', [PurchaseController::class, 'PurchaseOrder']);
    route::get('/ajax_purchaseorder/', [PurchaseController::class, 'ajax_purchaseorder']);
    route::get('/PurchaseOrderCreate/', [PurchaseController::class, 'PurchaseOrderCreate']);
    route::post('/PurchaseOrderSave/', [PurchaseController::class, 'PurchaseOrderSave']);
    route::get('/PurchaseOrderEdit/{id}', [PurchaseController::class, 'PurchaseOrderEdit']);
    route::post('/PurchaseOrderUpdate/', [PurchaseController::class, 'PurchaseOrderUpdate']);
    route::get('/PurchaseOrderDelete/{id}', [PurchaseController::class, 'PurchaseOrderDelete']);
    route::get('/PurchaseOrderView/{id}', [PurchaseController::class, 'PurchaseOrderView']);
    route::get('/PurchaseOrderViewPDF/{id}', [PurchaseController::class, 'PurchaseOrderViewPDF']);


    // ..............attachment iframe for all invoices ......
    route::get('/Attachment', [Accounts::class, 'Attachment']);
    Route::post('AttachmentSave', [Accounts::class, 'AttachmentSave']);
    Route::get('AttachmentDelete/{id}/{filename}', [Accounts::class, 'AttachmentDelete']);

    Route::get('AttachmentRead', [Accounts::class, 'AttachmentRead']);



    //  ................Trail Report.............
    route::get('/trialreportsearch', [ReportController::class, 'trialreportsearch']);
    route::post('/trialreport', [ReportController::class, 'trialreport']);


    // ..................journal report...................

    route::get('/generalReport', [ReportController::class, 'generalReport']);
    route::get('/showGeneralReport', [ReportController::class, 'showGeneralReport']);
    route::post('/searchjournal', [ReportController::class, 'searchByDate']);


    route::get('/DailyIncomeExpense/', [Accounts::class, 'DailyIncomeExpense']);
    route::post('/DailyIncomeExpense1PDF/', [Accounts::class, 'DailyIncomeExpense1PDF']);


    //  ............Payable..............
    route::get('/payablesearch', [ReportController::class, 'payablesearch']);
    route::post('/payable', [ReportController::class, 'payable']);


    //  ............Paymentsmade..............
    route::get('/paymentsmadesearch', [ReportController::class, 'paymentsmadesearch']);
    route::post('/paymentsmade', [ReportController::class, 'paymentsmade']);


    //  ............receiveabledetail..............
    route::get('/receiveabledetailsearch', [ReportController::class, 'receiveabledetailsearch']);
    route::post('/receiveabledetail', [ReportController::class, 'receiveabledetail']);

    //  ............receiveabledetailsummary..............
    route::get('/receiveabledetailsummarysearch', [ReportController::class, 'receiveabledetailsummarysearch']);
    route::post('/receiveabledetailsummary', [ReportController::class, 'receiveabledetailsummary']);

    //  ............Vendor Credits..............
    route::get('/vendorcreditsearch', [ReportController::class, 'vendorcreditsearch']);
    route::post('/vendorcredits', [ReportController::class, 'vendorcredits']);

    route::get('/kashif/', [Accounts::class, 'kashif']);
    route::get('/kupload/', [Accounts::class, 'kupload']);

    route::get('/ReconcileReport/', [Accounts::class, 'ReconcileReport']);
    route::post('/ReconcileReport1/', [Accounts::class, 'ReconcileReport1']);


    route::get('/ReconcileUpdate/{status}/{id}', [Accounts::class, 'ReconcileUpdate']);



    Route::get('/Inventory/', [Accounts::class, 'Inventory']);
    Route::post('/Inventory1/', [Accounts::class, 'Inventory1']);

    Route::post('/Inventory1PDF/', [Accounts::class, 'Inventory1PDF']);
    Route::get('/lnventoryDetail/{itemid}/{startdate}/{enddate}', [Accounts::class, 'lnventoryDetail']);

    route::get('/km/{id}', [Accounts::class, 'km']);


    // =====================================Expense Section=====================================
    Route::get('/Expense', [ExpenseController::class, 'Expense']);
    route::get('/ExpenseCreate/', [ExpenseController::class, 'ExpenseCreate']);

    // Route::get('/ajax_Expense', [Accounts::class, 'ajax_Expense']);

    Route::post('/ExpenseSave', [ExpenseController::class, 'ExpenseSave']);
    route::get('/ExpenseEdit/{id}', [ExpenseController::class, 'ExpenseEdit']);
    route::get('/ExpensePDF/{id}', [ExpenseController::class, 'ExpensePDF']);
    route::get('/ExpenseView/{id}', [ExpenseController::class, 'ExpenseView']);

    Route::post('/ExpenseUpdate', [ExpenseController::class, 'ExpenseUpdate']);
    route::get('/ExpenseDelete/{id}', [ExpenseController::class, 'ExpenseDelete']);

    route::get('/TaxReportSupplier/', [Accounts::class, 'TaxReportSupplier']);
    route::post('/TaxReportSupplier1/', [Accounts::class, 'TaxReportSupplier1']);
    route::post('/TaxReportSupplier1PDF/', [Accounts::class, 'TaxReportSupplier1PDF']);


    route::get('/TaxOverallReport/', [Accounts::class, 'TaxOverallReport']);
    route::post('/TaxOverallReport1/', [Accounts::class, 'TaxOverallReport1']);
    route::post('/TaxOverallReport1PDF/', [Accounts::class, 'TaxOverallReport1PDF']);


    // import item from excel
    route::post('/ItemImport/', [Accounts::class, 'ItemImport']);
    route::get('/base64/', [Accounts::class, 'base64']);



    Route::get('/PartyAgingPDF/', [Accounts::class, 'PartyAgingPDF']);




    // document category
    route::get('/DocumentCategory', [Documents::class, 'DocumentCategory']);
    route::Post('/DocumentCategorySave', [Documents::class, 'DocumentCategorySave']);
    route::get('/DocumentCategoryDelete/{id}', [Documents::class, 'DocumentCategoryDelete']);
    route::get('/DocumentCategoryEdit/{id}', [Documents::class, 'DocumentCategoryEdit']);
    route::post('/DocumentCategoryUpdate/', [Documents::class, 'DocumentCategoryUpdate']);


    //Document section
    route::get('/Document/{id?}', [Documents::class, 'Document']);
    route::post('/DocumentSave', [Documents::class, 'DocumentSave']);
    route::get('/DocumentDelete/{id}/{file}', [Documents::class, 'DocumentDelete']);



    Route::get('/DBDump/', [Accounts::class, 'DBDump']);




    Route::get('/show-invoice/{id}', [PosController::class, 'showInvoice'])->name('invoice.show');
    Route::get('/print-invoice/{id}', [PosController::class, 'printInvoice'])->name('invoice.print');
    Route::get('/print-voucher/{id}/{GiftInvoice?}', [PosController::class, 'printVoucher'])->name('voucher.print');

    Route::get('/invoice-listing', [PosController::class, 'invoiceListing'])->name('invoice.listing');
    Route::get('/cancelled-orders', [PosController::class, 'cancelledInvoiceListing'])->name('invoice.cancelled.listing');



    Route::get('/live-kitchen/', [PosController::class, 'liveKitchen'])->name('invoice.live-ktchen');

    Route::get('/invoice-live-kitchen/', [PosController::class, 'showInvoiceLiveKitchen'])->name('invoice.live.ktchen');

    Route::get('/invoice-live-kitchen/{id}', [PosController::class, 'invoiceLiveKitchenDetails'])->name('invoice.live.ktchen-details');

    Route::get('/invoice-change-status/{id}/{status}', [PosController::class, 'invoiceStatus'])->name('invoice.invoice-change-status');

    Route::get('/invoice-check-status/{id}', [PosController::class, 'invoiceCheckStatus'])->name('invoice.invoice-check-status');
    // ware house
    Route::get('/ware-house-list', [PosController::class, 'wareHouseList']);
    Route::post('/store-ware-house', [PosController::class, 'storeWareHouse']);
    Route::post('/get-warehouse-detail', [PosController::class, 'getWarehouseDetail']);
    Route::post('/update-ware-house', [PosController::class, 'updateWareHouse']);
    Route::get('/wareHouseDelete/{id}', [PosController::class, 'deleteWareHouse']);



    Route::get('/run-database-query', [PosController::class, 'runQuery'])->name('run-database-query');

    Route::group(['prefix' => 'warehouse'], function () {

        Route::get('/run-my-script', [PosController::class, 'runMyScript']);

        Route::get('/stock-warehouses-out', [PosController::class, 'WareHouseOut'])->name('warehouse.stock-warehouses-out');
        Route::get('/stock-warehouses-in', [PosController::class, 'WareHouseIn'])->name('warehouse.stock-warehouses-in');
        Route::get('/stock-warehouse-list', [PosController::class, 'ListWareHouseTransfers'])->name('warehouse.stock-warehouse-list');

        Route::get('/stock-warehouse-transfer', [PosController::class, 'stockWarehouseTransfer'])->name('warehouse.warehousestransfer');
        Route::get('/fetch-ware-houses/{id}', [PosController::class, 'fetchWareHouses'])->name('warehouse.fetchwarehouses');
        Route::get('/check-qty/{warehouseid}/{id}', [PosController::class, 'checkQty'])->name('warehouse.checkqty');
        Route::post('/stock-warehouse-transfer', [PosController::class, 'postStockWarehouseTransfer'])->name('warehouse.stock-warehouse-transfer');

        Route::get('/stock-warehouse-cards', [PosController::class, 'demoCards'])->name('warehouse.demo-cards');
        Route::get('/get-product-detais/{warehouseid}', [PosController::class, 'getProductDetais'])->name('warehouse.getproductdetais');
    });


    // brand
    Route::get('/brand-list', [PosController::class, 'brandList']);
    Route::post('/store-brand', [PosController::class, 'storeBrand']);
    Route::post('/get-brand-detail', [PosController::class, 'getBrandDetail']);
    Route::post('/update-brand', [PosController::class, 'updateBrand']);
    Route::get('/brandDelete/{id}', [PosController::class, 'deleteBrand']);

    // Party
    Route::post('/store-party', [PosController::class, 'storeParty'])->name('party.store');
    Route::get('/get-updated-party', [PosController::class, 'getUpdatedCustomers'])->name('get-updated-customers');


    // Unit
    Route::get('/unit-list', [PosController::class, 'unitList']);
    Route::post('/store-unit', [PosController::class, 'storeUnit']);
    Route::post('/get-unit-detail', [PosController::class, 'getUnitDetail']);
    Route::post('/update-unit', [PosController::class, 'updateUnit']);
    Route::get('/unitDelete/{id}', [PosController::class, 'deleteUnit']);

    // POS Setting
    Route::get('/pos-setting', [PosController::class, 'posSetting']);
    Route::post('/store-pos-setting', [PosController::class, 'storePosSetting'])->name('setting.posStore');

    // Tax
    Route::get('/tax-list', [PosController::class, 'taxList']);
    Route::post('/store-tax', [PosController::class, 'storeTax']);
    Route::post('/get-tax-detail', [PosController::class, 'getTaxDetail']);
    Route::post('/update-tax', [PosController::class, 'updateTax']);
    Route::get('/taxDelete/{id}', [PosController::class, 'deleteTax']);


    Route::get('/create-invoice', [TeqPosController::class, 'createTeqInvoice'])->name('invoice.create');
    Route::get('/create-voucher', [VoucherController::class, 'createVoucher'])->name('voucher.create');
    Route::post('/save-teq-invoice', [TeqPosController::class, 'storeInvoice']);
    Route::post('/save-voucher', [VoucherController::class, 'storeVoucher']);
    Route::get('/edit-teq-invoice/{id}', [TeqPosController::class, 'editTeqInvoice']);
    Route::post('/update-teq-invoice/{id}', [TeqPosController::class, 'update'])->name('teqInvoice.update');


    Route::get('sales/lims_product_search', [TeqPosController::class, 'limsProductSearch'])->name('product_sale.search');
    Route::get('sales/getproduct/{id}', [TeqPosController::class, 'getProduct'])->name('sale.getproduct');
    Route::get('sales/getproduct/{category_id}/{brand_id}', [TeqPosController::class, 'getProductByFilter']);

    Route::get('sales/getcustomergroup/{id}', [TeqPosController::class, 'getCustomerGroup'])->name('sale.getcustomergroup');

    Route::get('cash-register/check-availability/{warehouse_id}', [TeqPosController::class, 'checkAvailability'])->name('cashRegister.checkAvailability');





    Route::get('cash-register', [CashRegisterController::class, 'index'])->name('cashRegister.index');
    Route::get('cash-register/check-availability/{warehouse_id}', [CashRegisterController::class, 'checkAvailability'])->name('cashRegister.checkAvailability');
    Route::post('cash-register/store', [CashRegisterController::class, 'store'])->name('cashRegister.store');
    Route::get('cash-register/getDetails/{id}', [CashRegisterController::class, 'getDetails']);
    Route::get('cash-register/showDetails/{warehouse_id}', [CashRegisterController::class, 'showDetails']);
    Route::post('cash-register/close', [CashRegisterController::class, 'close'])->name('cashRegister.close');





    Route::get('sales/getfeatured', [TeqPosController::class, 'getFeatured'])->name('product_sale.getfeatured');

    Route::post('sales/add_payment', [TeqPosController::class, 'addPayment'])->name('sale.add-payment');
    Route::post('cancelOrder', [TeqPosController::class, 'cancelOrder'])->name('sale.cancelOrder');


    Route::get('products/gencode', [TeqPosController::class, 'generateCode'])->name('sale.gencode');

    Route::resource('sales', TeqPosController::class);
    //end TEQ POS

    //Extra tax for non filer
    Route::put('extra_tax', [TeqPosController::class, 'extra_tax_charged'])->name('admin.extra_tax');

    // Dish module Routes
    Route::get('/create-dish', [DishController::class, 'create']);
    Route::post('/saveDish', [DishController::class, 'store']);
    Route::get('/edit-dish/{dish}', [DishController::class, 'edit'])->name('dish.edit');
    Route::post('/updateDish/{dish}', [DishController::class, 'update'])->name('dish.update');
    Route::get('/dish-type/{dish}/{dish_type_id?}', [DishController::class, 'dishType'])->name('dish.type');
    Route::post('/storeDishType/{dish}', [DishController::class, 'storeDishType'])->name('dish.type.store');
    Route::get('/dish-image/{dish}', [DishController::class, 'dishImage'])->name('dish.image');
    Route::post('/storeDishImage/{dish}', [DishController::class, 'storeDishImage'])->name('dish.image.store');
    Route::get('/dish-recipe/{dish}/{dish_recipe_id?}', [DishController::class, 'dishRecipe'])->name('dish.recipe');
    Route::post('/storeDishRecipe/{dish}', [DishController::class, 'storeDishRecipe'])->name('dish.recipe.store');
    Route::get('/get-unit-of-item/{item_id}', [DishController::class, 'getItemUnit'])->name('item.unit');
    Route::get('/dishTypeDelete/{id}', [DishController::class, 'deleteDishType']);
    Route::get('/dishImageDelete/{id}', [DishController::class, 'deleteDishImage']);
    Route::get('/dishRecipeDelete/{id}', [DishController::class, 'deleteDishRecipe']);

    Route::get('/all-dishes', [DishController::class, 'index'])->name('dish.list');
    Route::get('/dishDelete/{dish}', [DishController::class, 'destroy']);

    Route::get('/create-dish-order', [DishController::class, 'createDishOrder']);
    Route::get('/invoice-dish-listing', [DishController::class, 'dishInvoices']);
    Route::get('/edit-invoice-dish/{id}', [DishController::class, 'editDishInvoice'])->name('dish.invoice.edit');
    Route::post('/get-dish-types', [DishController::class, 'getDishTypes']);
    Route::get('/get-dish-types-by-filter/{dish_id}', [DishController::class, 'getDishTypesByFilter']);
    Route::post('/get-dish-type-detail', [DishController::class, 'getDishTypeDetail']);
    Route::post('/saveOrderDish', [DishController::class, 'saveOrderDish']);
    Route::post('/updateDishOrder', [DishController::class, 'updateDishOrder']);

    // Routes for adding single dish
    Route::get('/add-dish', [DishController::class, 'addDish']);
    Route::post('/saveSingleDish', [DishController::class, 'saveSingleDish']);

    // Appointments
    Route::group(['prefix' => 'appointments'], function () {
        Route::get('system-calendar', [AppointmentController::class, 'systemCalander'])->name('appointments.systemCalander');
        Route::get('destroy/{id}', [AppointmentController::class, 'massDestroy'])->name('appointments.massDestroy');
    });
    Route::resource('appointments', AppointmentController::class);

    // Item Category
    Route::get('/item-category-list', [PosController::class, 'itemCategoryList']);
    Route::post('/get-item-category-detail', [PosController::class, 'getItemCategoryDetail']);
    Route::post('/store-item-category', [PosController::class, 'storeItemCategory']);
    Route::post('/update-item-category', [PosController::class, 'updateItemCategory']);
    Route::get('/itemCategoryDelete/{id}', [PosController::class, 'deleteItemCategory']);

    // Currency
    Route::get('/currency-list', [PosController::class, 'currencyList']);
    Route::get('/get-currency-data', [PosController::class, 'getCurrencyDetail']);
    Route::post('/store-currency', [PosController::class, 'storeCurrency']);
    Route::post('/update-currency', [PosController::class, 'updateCurrency']);
    Route::get('/currencyDelete/{id}', [PosController::class, 'deleteCurrency']);


    // Salesman
    Route::get('/biller-list', [PosController::class, 'billerList']);
    Route::post('/store-biller', [PosController::class, 'storeBiller']);
    Route::get('/get-biller-data', [PosController::class, 'getBillerData']);
    Route::post('/update-biller', [PosController::class, 'updateBiller']);
    Route::get('/billerDelete/{id}', [PosController::class, 'deleteBiller']);

    // Barcode
    Route::get('/print-barcode', [PosController::class, 'printBarcode']);
    Route::get('products/lims_product_search', [PosController::class, 'limsProductSearch'])->name('product.search');

    Route::get('/print-barcodes', [PosController::class, 'printBarcodes']);
    Route::get('products/lims_sticer_search', [PosController::class, 'limsStickerSearch'])->name('sticker.search');
    Route::get('products/lims_sticker_print', [PosController::class, 'limsStickerPrint'])->name('sticker.print');


    Route::get('/test-list', [PosController::class, 'limsStickerSearch']);


    Route::get('coupons/gencode', [CouponController::class, 'generateCode']);
    Route::post('coupons/deletebyselection', [CouponController::class, 'deleteBySelection']);
    Route::resource('coupons', CouponController::class);
    Route::get('/couponDelete/{id}', [CouponController::class, 'destroy']);
    Route::post('addItemAdditional', [ItemController::class, 'addItemAdditional']);
    Route::get('getItemAdditional/{id}/{invoiveNo}', [ItemController::class, 'getItemAdditional']);
    Route::get('check/item/availabilty/{code}/{invoice_no}', [ItemController::class, 'checkItemAvailabilty']);
    Route::get('daily/transactions', [ItemController::class, 'dailyTransactions']);
    Route::get('search/item/{code}', [ItemController::class, 'searchItem']);
    Route::get('delete/item/availabilty/{code}/{invoice_no}', [ItemController::class, 'deleteItemAvailabilty']);

    Route::post('finalize/draft/payment', [VoucherController::class, 'finalizeDraftPayment']);
    Route::post('add/partial/payment', [VoucherController::class, 'addPartialPayment']);

    Route::get('/SaleReport/', [DataController::class, 'SaleReport']);
    Route::post('/SaleReport1/', [DataController::class, 'SaleReport1']);
    Route::post('/saleReportPDF/', [DataController::class, 'saleReportPDF']);
    Route::post('/saleReportCSV/', [DataController::class, 'saleReportCSV']);
    Route::get('/ExpenseReport', [DataController::class, 'ExpenseReport']);
    Route::post('/ExpenseReport1', [DataController::class, 'ExpenseReport1']);
    Route::post('/ExpenseReportPDF', [DataController::class, 'ExpenseReportPDF']);
    Route::post('/add/item/stock/quantity', [ItemsController::class, 'addStockQuantity']);
    Route::get('itemCategories', [ItemsController::class, 'ItemCategories']);
    Route::get('itemBrands', [ItemsController::class, 'itemBrands']);

    Route::get('/ItemReport/', [DataController::class, 'ItemSaleReport']);
    Route::post('/ItemReportView/', [DataController::class, 'ItemSaleReport1']);
    Route::post('/ItemReportPDF/', [DataController::class, 'ItemSaleReportPDF']);
    Route::get('VatReport', [DataController::class, 'VatReport']);
    Route::post('VatReportPDF', [DataController::class, 'VatReportPDF']);
    Route::get('/ItemsPurchaseReport/', [DataController::class, 'ItemsPurchaseReport']);

});
