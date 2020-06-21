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

Route::get('/', function () {
    return view('welcome');
});


Route::get("/login", "AuthController@loginIndex");
Route::post("/login", "AuthController@login");
Route::get("/logout", "AuthController@logout");

Route::get('/order/number/{client_link}', "OrderController@show");
Route::get("/order/number/payment/{client_link}", "OrderController@showPayment");
Route::post("/order/diagnostics", "OrderController@getDiagnostics");
Route::post("/order/diagnostics/approved", "DiagnosticController@approveDiagnostic");

Route::post("/cart/store", "CheckoutController@cart");

Route::get("/checkout/{cartId}", "CheckoutController@initTransaction");
Route::post('/checkout/webpay/response', 'CheckoutController@response')->name('checkout.webpay.response');  
Route::post('/checkout/webpay/finish', 'CheckoutController@finish')->name('checkout.webpay.finish');

Route::get('/order/payment/{client_link}', "OrderController@confirmPayment");
Route::post("/order/payment/store", "OrderController@storePayment");

Route::get('/order/create', "OrderController@create")->name("order.create");
Route::get('/client/getClient/{rut}', "ClientController@getClient")->name('client.getClient');
Route::get('/car/getCar/{patent}', "CarController@getCar")->name('car.getCar');
Route::post("/order/store", "OrderController@store")->name('order.store');

Route::post("order/notificationCarProcess", "OrderController@notificationCarProcess")->name('admin.order.notificationCarProcess');

Route::get('/admin/dashboard', "DashboardController@index")->name("admin.dashboard.index");
Route::get('/admin/order/take', "DashboardController@take")->name("admin.dashboard.take");

Route::get('/admin/order/index', "OrderController@index")->name("admin.order.index");
Route::post("/admin/order/cancel", "OrderController@cancel")->name('admin.order.cancel');
Route::get("/admin/order/fetch/{page}", "OrderController@fetch")->name('admin.order.fetch');

Route::post("/admin/order/notificationCarOnDelivery", "OrderController@notificationCarOnDelivery")->name('admin.order.notificationCarOnDelivery');
Route::post("/admin/order/notificationFinish", "OrderController@notificationFinish")->name('admin.order.notificationFinish');

Route::get('/admin/order/diagnostic/{id}', "DiagnosticController@diagnostic");
Route::post('/admin/order/getAdminDiagnostic', "OrderController@getAdminDiagnostics")->name('admin.order.diagnostic.get');
Route::post('/admin/diagnostic/price/update', "DiagnosticController@update")->name('admin.diagnostic.price.update');

Route::get('/admin/order/search/{rut}', 'OrderController@search');

Route::get("/admin/client/index", "ClientController@index")->name('admin.client.index');
Route::get("/admin/client/edit/{id}", "ClientController@edit")->name('admin.client.edit');
Route::post("/admin/client/update", "ClientController@update")->name('admin.client.update');
Route::post("/admin/client/delete", "ClientController@delete")->name('admin.client.delete');
Route::get("/admin/client/fetch/{page}", "ClientController@fetch")->name('admin.client.fetch');

Route::get("/admin/car/index", "CarController@index")->name('admin.car.index');
Route::get("/admin/car/edit/{id}", "CarController@edit")->name('admin.car.edit');
Route::post("/admin/car/update", "CarController@update")->name('admin.car.update');
Route::post("/admin/car/delete", "CarController@delete")->name('admin.car.delete');
Route::get("/admin/car/fetch/{page}", "CarController@fetch")->name('admin.car.fetch');

Route::get('/admin/category/index', "CategoryController@index")->name("admin.category.index");
Route::post('/admin/category/store', "CategoryController@store")->name("admin.category.store");
Route::get('/admin/category/fetch/{page}', "CategoryController@fetch");
Route::get('/admin/category/all', "CategoryController@fetchAll");
Route::post('/admin/category/delete', "CategoryController@delete")->name("admin.category.delete");
Route::post('/admin/category/update', "CategoryController@update")->name("admin.category.update");

Route::get('/admin/service/index', "ServiceController@index")->name("admin.service.index");
Route::get('/admin/service/fetch/{page}', "ServiceController@fetch");
Route::post('/admin/service/store', "ServiceController@store")->name("admin.service.store");
Route::post('/admin/service/update', "ServiceController@update")->name("admin.service.update");
Route::post('/admin/service/delete', "ServiceController@delete")->name("admin.service.delete");
Route::get('/admin/service/fetchAll', "ServiceController@fetchAll");

Route::get('/admin/mechanic/index', "MechanicController@index")->name("admin.mechanic.index");
Route::get('/admin/mechanic/fetch/{page}', "MechanicController@fetch");
Route::post('/admin/mechanic/store', "MechanicController@store")->name("admin.mechanic.store");
Route::post('/admin/mechanic/update', "MechanicController@update")->name("admin.mechanic.update");
Route::get('/admin/mechanic/fetchAll', "MechanicController@fetchAll");
Route::post('/admin/mechanic/delete', "MechanicController@delete");

Route::get('/admin/delivery/index', "DeliveryController@index")->name("admin.delivery.index");
Route::get('/admin/delivery/fetch/{page}', "DeliveryController@fetch");
Route::post('/admin/delivery/store', "DeliveryController@store")->name("admin.delivery.store");
Route::post('/admin/delivery/update', "DeliveryController@update")->name("admin.delivery.update");
Route::get('/admin/delivery/fetchAll', "DeliveryController@fetchAll");
Route::post('/admin/delivery/delete', "DeliveryController@delete");

Route::get('/mechanic/index', "DashboardController@mechanicIndex")->name("mechanic.index");

Route::get('/mechanic/order/fetch/{page}', "OrderController@mechanicFetch");
Route::get('/mechanic/order/edit/{order_id}', "OrderController@mechanicEdit");
Route::get('/mechanic/order/services/{order_id}', "OrderController@mechanicServicesOrder");

Route::get('/delivery/index', "DashboardController@deliveryIndex")->name("delivery.index");

Route::get('/delivery/order/fetch/{page}', "OrderController@deliveryFetch");
Route::get('/delivery/order/edit/{order_id}', "OrderController@deliveryEdit");
Route::post('/delivery/order/revision', "OrderController@revision")->name('delivery.order.revision');

Route::get('/admin/email/index', "AdminEmailController@index")->name("admin.email.index");
Route::get('/admin/email/fetch', "AdminEmailController@fetch");
Route::post('/admin/email/store', "AdminEmailController@store")->name("admin.email.store");
Route::post('/admin/email/update', "AdminEmailController@update")->name("admin.email.update");
Route::post('/admin/email/delete', "AdminEmailController@delete");

//Route::get('/mechanic/order/fetch/{page}', "OrderController@mechanicFetch");
//

Route::get('/mechanic/diagnostic/check/{order_id}', "DiagnosticController@check");
Route::get('/mechanic/category/all/{order_id}', "CategoryController@mechanicFetchAll");
Route::post('/mechanic/diagnositc/store', "DiagnosticController@store");

/*Route::get('/pdf', function(){

    $order = App\Order::with('client', 'car', 'diagnostic')->where('orders.id', 19)->first();
    \PDF::loadView('admin.budget.pdf', ["order" =>$order])->save("order_test.pdf");

});*/