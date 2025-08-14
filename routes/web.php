<?php

use App\Http\Controllers\AccountContrller;
use App\Http\Controllers\BrokerController;
use App\Http\Controllers\ClearingAgentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GatePassController;
use App\Http\Controllers\ModuleControllers;
use App\Http\Controllers\ShippingContrller;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LabourChargesController;
use App\Http\Controllers\LifterChargesController;
use App\Http\Controllers\LocalChargesController;
use App\Http\Controllers\OtherChargesController;
use App\Http\Controllers\PartyCommissionChargesController;
use App\Http\Controllers\TrackerChargesController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FuelController;
use App\Http\Controllers\LedgerController;
use App\Models\Account;

Route::get('/', function () {
   return redirect()->route('login');
});


Route::get("register" , [UserController::class, 'create'])->name('register');
Route::post("register" , [UserController::class, 'store'])->name('auth.register');

Route::get("login" , [UserController::class, 'login'])->name('login');
Route::post("login" , [UserController::class, 'authenticate'])->name('auth.login');

Route::middleware(['auth', 'setSessionData'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData']);


    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile.index');
    Route::post('/profile', [ProfileController::class, 'profileUpdate'])->name('user.profile.update');

    // Change Password routes
    Route::get('/change/password', [ProfileController::class, 'changePasswordForm'])->name('user.change_password_form');
    Route::post('/change/password', [ProfileController::class, 'changePassword'])->name('user.change_password');
    // Border routes
    Route::resource('brokers', BrokerController::class);

    Route::resource('contacts', ContactController::class);

    Route::resource('shippings', ShippingContrller::class);
    Route::post('/shippings/invoice/{shipment_id}', [ShippingContrller::class, 'invoice'])->name('shippings.invoice');
    Route::get('/shippings/receipt/{shipment_id}', [ShippingContrller::class, 'printReceipt'])->name('shippings.receipt');

    Route::resource('gatepasses', GatePassController::class);

    Route::resource('clearingagents', ClearingAgentController::class);

    Route::resource('customers', CustomerController::class);
      Route::resource('fuels', FuelController::class);


    Route::resource('lifterCharges', LifterChargesController::class);

    Route::resource('labourCharges', LabourChargesController::class);
    Route::resource('localCharges', LocalChargesController::class);
    Route::resource('otherCharges', OtherChargesController::class);
    Route::resource('partyCommissionCharges', PartyCommissionChargesController::class);
    Route::resource('trackerCharges', TrackerChargesController::class);
    // Route::resource('yarnUnloading', YarnUnloadingController::class);

    Route::post('/module/brokers' , [ModuleControllers::class, 'brokerModule'])->name('module.brokers');
    Route::post('/module/gate-pass' , [ModuleControllers::class, 'gatePassModule'])->name('module.gatePass');
    Route::post('/module/clearing-agent' , [ModuleControllers::class, 'clearingAgentModule'])->name('module.clearingagent');
    Route::post('/module/sendar' , [ModuleControllers::class, 'sendarModule'])->name('module.sendar');
    Route::post('/module/recipients' , [ModuleControllers::class, 'recipientModule'])->name('module.sendar');
    Route::post('/module/lifter-charges' , [ModuleControllers::class, 'lifterChargesModule'])->name('module.lifter_charges');

    Route::post('/module/labour-charges' , [ModuleControllers::class, 'labourChargesModule'])->name('module.labour_charges');
    Route::post('/module/local-charges' , [ModuleControllers::class, 'localChargesModule'])->name('module.local_charges');

    Route::post('/module/party-commission-charges' , [ModuleControllers::class, 'partyCommisionChargesModule'])->name('module.party_commission_charges');

     Route::post('/module/tracker-charges' , [ModuleControllers::class, 'trackerChargesModule'])->name('module.tracker_charges');

    Route::post('/module/other-charges' , [ModuleControllers::class, 'otherChargesModule'])->name('module.other_charges');
    Route::post('/module/customers' , [ModuleControllers::class, 'customerModule'])->name('module.customer');


    // Ledger routes

    Route::get('ledger', [LedgerController::class , 'index'])->name('ledger.index');
    Route::post('ledger/store', [LedgerController::class , 'store'])->name('ledger.store');
    Route::get('ledger/type-names', [LedgerController::class, 'getTypeNames'])->name('ledger.type.names');


    // Accounts routes
    Route::resource('accounts', AccountContrller::class);

    Route::get('accounts/details/{id}', [AccountContrller::class, 'accountDetails'])->name('accounts.details');


    Route::get('accounts/details/datatable/{id}', [AccountContrller::class, 'getAccountTransactions'])->name('accounts.transactions');

});
