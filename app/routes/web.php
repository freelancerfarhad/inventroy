<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SaleReportController;
use App\Http\Middleware\OtpVerificationMiddleware;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// API Route
Route::post('/user-login', [UserController::class, 'UserLogin']);
Route::post('/user-registration',[UserController::class ,'UserRegistration']);
Route::post('/send-otp-to-email',[UserController::class ,'SendOTPToEmail']);
Route::post('/otp-verify',[UserController::class ,'OTPVerify']);
Route::post('/reset-password',[UserController::class ,'ResetPassword'])->middleware(OtpVerificationMiddleware::class);

Route::get('/user-profile',[UserController::class,'UserProfile'])->middleware([OtpVerificationMiddleware::class]);
Route::post('/user-update',[UserController::class,'UpdateProfile'])->middleware([OtpVerificationMiddleware::class]);



// logout
Route::get('/logout', [UserController::class, 'UserLogout']);



// Page Route
Route::get('/RegistrationPage', [UserController::class, 'RegistrationPage']);
Route::get('/LoginPage', [UserController::class, 'LoginPage']);
Route::get('/SendOtpPage', [UserController::class, 'SendOtpPage']);
Route::get('/VerifyOtpPage', [UserController::class, 'VerifyOtpPage']);
Route::get('/ResetPasswordPage', [UserController::class, 'ResetPasswordPage'])->middleware(OtpVerificationMiddleware::class);
Route::get('/userProfile', [UserController::class, 'UserProfilePage'])->middleware(OtpVerificationMiddleware::class);
Route::get('/categoryPage', [CategoryController::class, 'CategoryPage'])->middleware(OtpVerificationMiddleware::class);
Route::get('/customerPage', [CustomerController::class, 'CustomerPage'])->middleware(OtpVerificationMiddleware::class);
Route::get('/productPage', [ProductController::class, 'productPage'])->middleware(OtpVerificationMiddleware::class);
Route::get('/invoicePage', [InvoiceController::class, 'InvoicePage'])->middleware(OtpVerificationMiddleware::class);
Route::get('/SalePage', [InvoiceController::class, 'SalePage'])->middleware(OtpVerificationMiddleware::class);
Route::get('/report-generator', [SaleReportController::class, 'ReportPage'])->middleware(OtpVerificationMiddleware::class);




// after authonction
Route::get('/dashboard',[DashboardController::class,'DashboardPage'])->name('dashboard')->middleware(OtpVerificationMiddleware::class);



// customer AP
Route::post('/create-customer', [CustomerController::class, 'CreateCustomer'])->middleware(OtpVerificationMiddleware::class);
Route::get('/list-customer', [CustomerController::class, 'ListCustomer'])->middleware(OtpVerificationMiddleware::class);
Route::post('/update-customer', [CustomerController::class, 'UpdateCustomer'])->middleware(OtpVerificationMiddleware::class);
Route::post('/delete-customer', [CustomerController::class, 'DeleteCustomer'])->middleware(OtpVerificationMiddleware::class);
Route::post("/customer-by-id",[CustomerController::class,'CustomerByID'])->middleware([OtpVerificationMiddleware::class]);

// category API
Route::post('/create-category', [CategoryController::class, 'CreateCategory'])->middleware(OtpVerificationMiddleware::class);
Route::get('/list-category', [CategoryController::class, 'ListCategory'])->middleware(OtpVerificationMiddleware::class);
Route::post('/update-category', [CategoryController::class, 'UpdateCategory'])->middleware(OtpVerificationMiddleware::class);
Route::post('/delete-category', [CategoryController::class, 'DeleteCategory'])->middleware(OtpVerificationMiddleware::class);
Route::post("/category-by-id",[CategoryController::class,'CategoryByID'])->middleware([OtpVerificationMiddleware::class]);

// product API
Route::post('/create-product', [ProductController::class, 'CreateProduct'])->middleware(OtpVerificationMiddleware::class);
Route::get('/list-product', [ProductController::class, 'ListProduct'])->middleware(OtpVerificationMiddleware::class);
Route::post('/update-product', [ProductController::class, 'UpdateProduct'])->middleware(OtpVerificationMiddleware::class);
Route::post('/delete-product', [ProductController::class, 'DeleteProduct'])->middleware(OtpVerificationMiddleware::class);
Route::post("/product-by-id",[ProductController::class,'ProductByID'])->middleware([OtpVerificationMiddleware::class]);

// dashboard  counter API
Route::get('/total-Summary', [DashboardController::class, 'Summary'])->name('total-Summary')->middleware(OtpVerificationMiddleware::class);

// Invoice API
Route::post('/create-invoice', [InvoiceController::class, 'invoiceCreate'])->middleware(OtpVerificationMiddleware::class);
Route::get('/list-invoice', [InvoiceController::class, 'ListInvoice'])->middleware(OtpVerificationMiddleware::class);
Route::post('/details-invoice', [InvoiceController::class, 'InvoiceDetails'])->middleware(OtpVerificationMiddleware::class);
Route::post('/delete-invoice', [InvoiceController::class, 'DeleteInvoice'])->middleware(OtpVerificationMiddleware::class);

// Report
Route::get("/sales-report/{FormDate}/{ToDate}",[SaleReportController::class,'SalesReport'])->middleware([OtpVerificationMiddleware::class]);
