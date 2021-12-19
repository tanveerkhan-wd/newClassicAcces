<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/clear', function() {
   Artisan::call('config:clear');
   Artisan::call('cache:clear');
   Artisan::call('config:cache');
   Artisan::call('view:clear');
   return "Cleared!";
});
Route::get('/cache', function() {
   
   return "Cached!";
});


/* ADMIN ROUTES */
Route::get('login/', function(){
	return redirect()->route('adminLoginForm');
});
Route::get('/', function(){
	return redirect()->route('adminLoginForm');
});
Route::group(['middleware' => ['prevent-back-history','guest']],function(){
	Route::get('login','UserController@index')->name('adminLoginForm');
	Route::post('/loginPost','UserController@loginPost')->name('adminLoginFormPost');
	Route::get('forgotPassword','UserController@forgotPassword')->name('forgotPassword');
	Route::post('forgotPasswordPost','UserController@forgotPasswordPost')->name('forgotPasswordPost');
	Route::get('/verifyOtp/{id}', 'UserController@getVerifyOtp')->name('getVerifyOtp');
	Route::post('/verifyOtpPost', 'UserController@verifyOtpPost')->name('verifyOtpPost');
	Route::get('/resetPassword/{token}', 'UserController@resetPassword')->name('resetPassword');
	Route::post('/resetPasswordPost', 'UserController@resetPasswordPost')->name('resetPasswordPost');
});

Route::get('logout','UserController@logout')->name('adminLogout');
Route::post('/changePasswordPost', 'UserController@changePasswordPost');
Route::get('/setPassword/{token}', 'UserController@setPassword')->name('setPassword');


Route::prefix('admin')->namespace('Admin')->group(function () {
	
	Route::group(['middleware'=>'auth'],function(){
		
		Route::group(['middleware'=>'admin'],function(){
	
			/*====== Base Routes =======*/
			Route::get('/dashboard','DashboardController@dashboard')->name('adminDashboard');
			Route::get('/profile', 'DashboardController@profile')->name('adminProfile');
			Route::post('/editProfile', 'DashboardController@editProfile');
			Route::post('/changePasswordPost', 'DashboardController@changePasswordPost');
			
			/* ======== Routes For Admin Products ========== */
			Route::get('/product','ProductController@index');
			Route::post('/product','ProductController@get');
			Route::get('/product/add','ProductController@add');
			Route::get('/product/edit/{id}','ProductController@edit');
			Route::post('/product/add','ProductController@addPost');
			Route::post('/product/status','ProductController@status');
			Route::post('/product/destroy','ProductController@destroy');

			/* ======== Routes For Admin Customer ========== */
			Route::get('/customer','CustomerController@index');
			Route::post('/customer','CustomerController@get');
			Route::get('/customer/add','CustomerController@add');
			Route::get('/customer/edit/{id}','CustomerController@edit');
			Route::post('/customer/add','CustomerController@addPost');
			Route::post('/customer/status','CustomerController@status');
			Route::post('/customer/destroy','CustomerController@destroy');
			Route::get('/customer/download/{id}','CustomerController@allBill');


			/* ======== Routes For Admin Bills ========== */
			Route::get('/bill','BillController@index');
			Route::post('/bill','BillController@get');
			Route::get('/bill/add','BillController@add');
			Route::get('/bill/edit/{id}','BillController@edit');
			Route::post('/bill/add','BillController@addPost');
			Route::post('/bill/status','BillController@status');
			Route::post('/bill/destroy','BillController@destroy');
			Route::get('/customer/download/singlebill/{id}','BillController@downloadBill');

			/* ======== Routes For Admin All Bills ========== */
			Route::get('/bills','BillsController@index');
			Route::post('/bills','BillsController@get');
			Route::get('/bills/download','BillsController@downloadBill');

			/* ======== Routes For Admin Settings ========== */
			Route::get('/settings','SettingController@index');
			Route::post('/setting/update','SettingController@updateSetting');

		});

	});

});