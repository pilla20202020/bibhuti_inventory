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
    return redirect(route('login'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/birthday', [App\Http\Controllers\HomeController::class, 'birthdayNotification'])->name('birthday');

Route::group(['as' => 'user.','namespace' => 'App\Http\Controllers', 'prefix' => 'user',], function () {
    Route::get('forget-password', 'User\UserController@forgetPassword')->name('forgetPassword');
    Route::post('update-password', 'User\UserController@updatePassword')->name('updatePassword');

});

Route::group(['middleware' => 'auth','namespace' => 'App\Http\Controllers'], function () {
    Route::get('/dashboard','Dashboard\DashboardController@index')->name('dashboard');




    /*
    |--------------------------------------------------------------------------
    | User CRUD
    |--------------------------------------------------------------------------
    |
    */

    Route::group(['as' => 'user.', 'prefix' => 'user',], function () {
        Route::get('', 'User\UserController@index')->name('index')->middleware('permission:user-index');
        Route::get('user-data', 'User\UserController@getAllData')->name('data')->middleware('permission:user-data');
        Route::get('create', 'User\UserController@create')->name('create')->middleware('permission:user-create');
        Route::post('', 'User\UserController@store')->name('store')->middleware('permission:user-store');
        Route::get('{user}/edit', 'User\UserController@edit')->name('edit')->middleware('permission:user-edit');
        Route::put('{user}', 'User\UserController@update')->name('update')->middleware('permission:user-update');
        Route::get('user/{id}/destroy', 'User\UserController@destroy')->name('destroy')->middleware('permission:user-delete');
        Route::get('update-profile', 'User\UserController@profileUpdate')->name('profileUpdate');
        Route::post('update-profile/{id}', 'User\UserController@profileUpdateStore')->name('updateProfile');

    });

    /*
    |--------------------------------------------------------------------------
    | Role CRUD
    |--------------------------------------------------------------------------
    |
    */

    Route::group(['as' => 'role.', 'prefix' => 'role',], function () {
        Route::get('', 'Role\RoleController@index')->name('index')->middleware('permission:role-index');
        Route::get('role-data', 'Role\RoleController@getAllData')->name('data')->middleware('permission:role-data');
        Route::get('create', 'Role\RoleController@create')->name('create')->middleware('permission:role-create');
        Route::post('', 'Role\RoleController@store')->name('store')->middleware('permission:role-store');
        Route::get('{role}/edit', 'Role\RoleController@edit')->name('edit')->middleware('permission:role-edit');
        Route::put('{role}', 'Role\RoleController@update')->name('update')->middleware('permission:role-update');
        Route::get('role/{id}/destroy', 'Role\RoleController@destroy')->name('destroy')->middleware('permission:role-delete');
    });

    /*
    |--------------------------------------------------------------------------
    | Permission CRUD
    |--------------------------------------------------------------------------
    |
    */

    Route::group(['as' => 'permission.', 'prefix' => 'permission',], function () {
        Route::get('', 'Permission\PermissionController@index')->name('index')->middleware('permission:role-index');
        Route::get('permission-data', 'Permission\PermissionController@getAllData')->name('data')->middleware('permission:role-data');
        Route::get('create', 'Permission\PermissionController@create')->name('create')->middleware('permission:permission-create');
        Route::post('', 'Permission\PermissionController@store')->name('store')->middleware('permission:role-store');
        Route::get('{permission}/edit', 'Permission\PermissionController@edit')->name('edit')->middleware('permission:permission-edit');
        Route::put('{permission}', 'Permission\PermissionController@update')->name('update')->middleware('permission:role-update');
        Route::get('permission/{id}/destroy', 'Permission\PermissionController@destroy')->name('destroy')->middleware('permission:permission-delete');
    });


    Route::group(['as'=>'common.', 'prefix'=>'common'], function(){
        Route::post('provinces', 'Common\CommonController@getProvincesByCountryId')->name('province.countryId');
        Route::post('districts', 'Common\CommonController@getDistrictsByProvinceId')->name('district.provinceId');
    });

    /*
    |--------------------------------------------------------------------------
    | Brand CRUD
    |--------------------------------------------------------------------------
    |
    */

    Route::group(['as' => 'brand.', 'prefix' => 'brand',], function () {
        Route::get('', 'Brand\BrandController@index')->name('index');
        Route::get('brand-data', 'Brand\BrandController@getAllData')->name('data');
        Route::get('create', 'Brand\BrandController@create')->name('create');
        Route::post('', 'Brand\BrandController@store')->name('store');
        Route::get('{brand}/edit', 'Brand\BrandController@edit')->name('edit');
        Route::put('{brand}', 'Brand\BrandController@update')->name('update');
        Route::get('brand/{id}/destroy', 'Brand\BrandController@destroy')->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Category CRUD
    |--------------------------------------------------------------------------
    |
    */

    Route::group(['as' => 'category.', 'prefix' => 'category',], function () {
        Route::get('', 'Category\CategoryController@index')->name('index');
        Route::get('category-data', 'Category\CategoryController@getAllData')->name('data');
        Route::get('create', 'Category\CategoryController@create')->name('create');
        Route::post('', 'Category\CategoryController@store')->name('store');
        Route::get('{category}/edit', 'Category\CategoryController@edit')->name('edit');
        Route::put('{category}', 'Category\CategoryController@update')->name('update');
        Route::get('category/{id}/destroy', 'Category\CategoryController@destroy')->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Product CRUD
    |--------------------------------------------------------------------------
    |
    */

    Route::group(['as' => 'product.', 'prefix' => 'product',], function () {
        Route::get('', 'Product\ProductController@index')->name('index');
        Route::get('product-data', 'Product\ProductController@getAllData')->name('data');
        Route::get('create', 'Product\ProductController@create')->name('create');
        Route::post('', 'Product\ProductController@store')->name('store');
        Route::get('{product}/edit', 'Product\ProductController@edit')->name('edit');
        Route::put('{product}', 'Product\ProductController@update')->name('update');
        Route::get('product/{id}/destroy', 'Product\ProductController@destroy')->name('destroy');
        Route::post('productcategory', 'Product\ProductController@categoryProductAjax')->name('categoryproductajax');

    });

    /*
    |--------------------------------------------------------------------------
    | Supplier CRUD
    |--------------------------------------------------------------------------
    |
    */

    Route::group(['as' => 'supplier.', 'prefix' => 'supplier',], function () {
        Route::get('', 'Supplier\SupplierController@index')->name('index');
        Route::get('supplier-data', 'Supplier\SupplierController@getAllData')->name('data');
        Route::get('create', 'Supplier\SupplierController@create')->name('create');
        Route::post('', 'Supplier\SupplierController@store')->name('store');
        Route::get('{supplier}/edit', 'Supplier\SupplierController@edit')->name('edit');
        Route::put('{supplier}', 'Supplier\SupplierController@update')->name('update');
        Route::get('supplier/{id}/destroy', 'Supplier\SupplierController@destroy')->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Branch CRUD
    |--------------------------------------------------------------------------
    |
    */

    Route::group(['as' => 'branch.', 'prefix' => 'branch',], function () {
        Route::get('', 'Branch\BranchController@index')->name('index');
        Route::get('branch-data', 'Branch\BranchController@getAllData')->name('data');
        Route::get('create', 'Branch\BranchController@create')->name('create');
        Route::post('', 'Branch\BranchController@store')->name('store');
        Route::get('{branch}/edit', 'Branch\BranchController@edit')->name('edit');
        Route::put('{branch}', 'Branch\BranchController@update')->name('update');
        Route::get('branch/{id}/destroy', 'Branch\BranchController@destroy')->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Unit CRUD
    |--------------------------------------------------------------------------
    |
    */

    Route::group(['as' => 'unit.', 'prefix' => 'unit',], function () {
        Route::get('', 'Unit\UnitController@index')->name('index');
        Route::get('unit-data', 'Unit\UnitController@getAllData')->name('data');
        Route::get('create', 'Unit\UnitController@create')->name('create');
        Route::post('', 'Unit\UnitController@store')->name('store');
        Route::get('{unit}/edit', 'Unit\UnitController@edit')->name('edit');
        Route::put('{unit}', 'Unit\UnitController@update')->name('update');
        Route::get('unit/{id}/destroy', 'Unit\UnitController@destroy')->name('destroy');
        Route::post('unitstore', 'Unit\UnitController@unitStore')->name('unitStore');

    });

    /*
    |--------------------------------------------------------------------------
    | Price CRUD
    |--------------------------------------------------------------------------
    |
    */

    Route::group(['as' => 'price.', 'prefix' => 'price',], function () {
        Route::get('', 'Price\PriceController@index')->name('index');
        Route::get('price-data', 'Price\PriceController@getAllData')->name('data');
        Route::get('create', 'Price\PriceController@create')->name('create');
        Route::post('', 'Price\PriceController@store')->name('store');
        Route::get('{price}/edit', 'Price\PriceController@edit')->name('edit');
        Route::put('{price}', 'Price\PriceController@update')->name('update');
        Route::get('price/{id}/destroy', 'Price\PriceController@destroy')->name('destroy');
        Route::post('productprice', 'Price\PriceController@productPriceAjax')->name('productpriceajax');
    });

    /*
    |--------------------------------------------------------------------------
    | Customer CRUD
    |--------------------------------------------------------------------------
    |
    */

    Route::group(['as' => 'customer.', 'prefix' => 'customer',], function () {
        Route::get('', 'Customer\CustomerController@index')->name('index');
        Route::get('customer-data', 'Customer\CustomerController@getAllData')->name('data');
        Route::get('create', 'Customer\CustomerController@create')->name('create');
        Route::post('', 'Customer\CustomerController@store')->name('store');
        Route::get('{customer}/edit', 'Customer\CustomerController@edit')->name('edit');
        Route::put('{customer}', 'Customer\CustomerController@update')->name('update');
        Route::get('customer/{id}/destroy', 'Customer\CustomerController@destroy')->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | PurchaseOrder CRUD
    |--------------------------------------------------------------------------
    |
    */

    Route::group(['as' => 'purchaseorder.', 'prefix' => 'purchaseorder',], function () {
        Route::get('', 'PurchaseOrder\PurchaseOrderController@index')->name('index');
        Route::get('purchaseorder-data', 'PurchaseOrder\PurchaseOrderController@getAllData')->name('data');
        Route::get('create', 'PurchaseOrder\PurchaseOrderController@create')->name('create');
        Route::post('', 'PurchaseOrder\PurchaseOrderController@store')->name('store');
        Route::get('{purchaseorder}/edit', 'PurchaseOrder\PurchaseOrderController@edit')->name('edit');
        Route::put('{purchaseorder}', 'PurchaseOrder\PurchaseOrderController@update')->name('update');
        Route::get('purchaseorder/{id}/destroy', 'PurchaseOrder\PurchaseOrderController@destroy')->name('destroy');
        Route::post('quntitycheckajax', 'Purchase\PurchaseOrderController@quantityCheckAjax')->name('quntitycheckajax');
    });

    /*
    |--------------------------------------------------------------------------
    | PurchaseEntry CRUD
    |--------------------------------------------------------------------------
    |
    */

    Route::group(['as' => 'purchase_entry.', 'prefix' => 'purchase-entry',], function () {
        Route::get('', 'PurchaseEntry\PurchaseEntryController@index')->name('index');
        Route::get('purchase-data', 'PurchaseEntry\PurchaseEntryController@getAllData')->name('data');
        Route::get('create', 'PurchaseEntry\PurchaseEntryController@create')->name('create');
        Route::post('', 'PurchaseEntry\PurchaseEntryController@store')->name('store');
        Route::get('{purchase}/edit', 'PurchaseEntry\PurchaseEntryController@edit')->name('edit');
        Route::put('{purchase}', 'PurchaseEntry\PurchaseEntryController@update')->name('update');
        Route::get('purchase/{id}/destroy', 'PurchaseEntry\PurchaseEntryController@destroy')->name('destroy');
        Route::get('getproductorder', 'PurchaseEntry\PurchaseEntryController@getProductOrder')->name('getproductorder');
    });

    /*
    |--------------------------------------------------------------------------
    | Sale CRUD
    |--------------------------------------------------------------------------
    |
    */

    Route::group(['as' => 'sale.', 'prefix' => 'sale',], function () {
        Route::get('', 'Sale\SaleController@index')->name('index');
        Route::get('sale-data', 'Sale\SaleController@getAllData')->name('data');
        Route::get('{id}/show', 'Sale\SaleController@show')->name('show');
        Route::get('create', 'Sale\SaleController@create')->name('create');
        Route::post('', 'Sale\SaleController@store')->name('store');
        Route::get('{sale}/edit', 'Sale\SaleController@edit')->name('edit');
        Route::put('{sale}', 'Sale\SaleController@update')->name('update');
        Route::get('sale/{id}/destroy', 'Sale\SaleController@destroy')->name('destroy');
    });


});
