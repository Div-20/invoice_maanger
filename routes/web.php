<?php

use App\Helpers\CustomServiceHelper;
use App\Helpers\SiteConstants;
use App\Http\Controllers\AdminControllers\LocationController;
use App\Http\Controllers\AdminControllers\AdminHomeController;
use App\Http\Controllers\AdminControllers\BrandController;
use App\Http\Controllers\AdminControllers\CategoryController;
use App\Http\Controllers\AdminControllers\CMSController;
use App\Http\Controllers\AdminControllers\FaqsController;
use App\Http\Controllers\AdminControllers\DynamicFormController;
use App\Http\Controllers\AdminControllers\LeadsController;
use App\Http\Controllers\AdminControllers\ManageCurrencyController;
use App\Http\Controllers\AdminControllers\UserController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\AdminControllers\AssetController;
use App\Http\Controllers\AdminControllers\AssetTypeController;
use App\Http\Controllers\AdminControllers\BuildingBlockController;
use App\Http\Controllers\AdminControllers\BuildingListController;
use App\Http\Controllers\AdminControllers\DepartmentListController;
use App\Http\Controllers\AdminControllers\FloorListController;
use App\Http\Controllers\AdminControllers\ProductController;
use App\Models\AssetType;
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
//return view('welcome');
    return redirect('/login');
});

Auth::routes();

/* admin routes */
Route::group(['prefix' => SiteConstants::URL_PREFIX_ADMIN_WEB], function () {
    Route::get('/', [AdminLoginController::class, 'login_from'])->name('admin.login_form');
    Route::post('login', [AdminLoginController::class, 'login'])->name('admin.login_submit');
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::post('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
        Route::match(['get','patch'],'profile', [AdminHomeController::class, 'admin_profile'])->name('admin.profile');
        Route::get('dashboard', [AdminHomeController::class, 'dashboard'])->name('admin.dashboard');

        /* Slider */
        Route::get('slider', [AdminHomeController::class, 'slider'])->name('admin.slider.index');
        Route::get('slider/manage/{slider?}', [AdminHomeController::class, 'slider_manage'])->name('admin.slider.manage');
        Route::post('slider/manage/{slider?}', [AdminHomeController::class, 'slider_update'])->name('admin.slider.update');
        Route::get('logs', [AdminHomeController::class, 'site_logs'])->name('admin.manage.logs');
        Route::get('update-table-request', [CustomServiceHelper::class, 'updateRequest'])->name('updateRequest');

        /* Manage currencies */
        Route::get('currencies/active/{id}', [ManageCurrencyController::class,'activate_currency'])->name('admin.currencies.make-active');
        Route::resource('currencies', ManageCurrencyController::class, ['as' => 'admin']);
        /* Manage Categories */
        Route::resource('category', CategoryController::class, ['as' => 'admin']);
        /* Manage Products */
        Route::resource('product', ProductController::class, ['as' => 'admin']);
        /* Manage Brand */
        Route::resource('brands', BrandController::class, ['as' => 'admin']);

        /* manage site leads */
        Route::get('contact-us', [LeadsController::class, 'contact_us'])->name('admin.lead.contact-us');
        Route::get('newsletter', [LeadsController::class, 'newsletter'])->name('admin.lead.newsletter');
        Route::get('lead/view/{lead_id}', [LeadsController::class, 'view_leads'])->name('admin.lead.view');

        /* manage Users */
        Route::get('users/block/{id}/{status}', [UserController::class, 'blockUser'])->name('admin.user.blockUser');
        Route::any('users/make-user-prime/{user}', [UserController::class, 'makeUserPrime'])->name('admin.user.make.prime');
        Route::resource('users', UserController::class, ['as' => 'admin']);

        /* Manage Faqs */
        // Route::get('faqs/final-layout/{parent?}', [FaqsController::class, 'final_layout'])->name('admin.faqs.final.layout');
        Route::get('faqs/create-faq/{parent?}', [FaqsController::class, 'create'])->name('admin.faqs.create-faq');
        Route::resource('faqs', FaqsController::class, ['as' => 'admin']);
        /* Manage CMS pages */
        Route::resource('cms', CMSController::class, ['as' => 'admin']);


        Route::get('order-form', [DynamicFormController::class, 'dynamic_form_page'])->name('admin.dynamic-form.index');
        Route::post('order-form/update-dynamic-form', [DynamicFormController::class, 'update_form'])->name('admin.dynamic-form.update');

        Route::patch('counter/update', [LocationController::class, 'update'])->name('admin.update.location');
        Route::get('location/show/{type}/{id}', [LocationController::class, 'show'])->name('show.location');
        Route::get('location/{type}', [LocationController::class, 'index'])->name('admin.locations')->where(['type' => 'country|state']);
        Route::get('location/city/{state_id}', [LocationController::class, 'city'])->name('get-cities');
        Route::post('location/store/', [LocationController::class, 'store'])->name('admin.location.store');
        Route::get('location/create/{type}/{id?}', [LocationController::class, 'create'])->name('admin.location.create');


        // Route::resource('building', BuildingListController::class, ['as' => 'admin']);
        // Route::resource('asset-type', AssetTypeController::class, ['as' => 'admin']); // Product Categories
        // Route::resource('departments', DepartmentListController::class, ['as' => 'admin']);
        // Route::resource('floors', FloorListController::class, ['as' => 'admin']);
        // Route::resource('building-block', BuildingBlockController::class, ['as' => 'admin']);
        // Route::resource('assets', AssetController::class, ['as' => 'admin']);
        // Route::any('asset/qrcode/{id}', [AssetController::class, 'qrcode'])->name('admin.assets.qrcode');
        // Route::any('asset/import', [AssetController::class, 'import_asset'])->name('admin.assets.import');
        // Route::any('asset/review-list', [AssetController::class, 'review_list'])->name('admin.review_list');
        // Route::any('update-asset-status', [AssetController::class, 'update_status'])->name('admin.update_status');


    });
});

Route::post('ajax/get-parent-category', [AjaxController::class, 'getParentCategory'])->name('ajax.get-parent-category');
Route::post('ajax/get-parent-brands', [AjaxController::class, 'getParentBrand'])->name('ajax.get-parent-brands');
Route::post('ajax/getDistrict', [AjaxController::class, 'getDistrict'])->name('getDistrict');
Route::post('ajax/getCity', [AjaxController::class, 'getCity'])->name('getCity');
Route::post('ajax/getRegion', [AjaxController::class, 'getRegion'])->name('getRegion');
Route::post('ajax/getArea', [AjaxController::class, 'getArea'])->name('getArea');

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::any('user/qrcode/{unique_id}', [UserController::class, 'qrcode'])->name('user.asset.qrcode');
    Route::any('review-asset', [UserController::class, 'review_asset'])->name('user.asset.review');
    Route::group(['middleware' => 'ProductAuth'], function () {
        Route::resource('assets', AssetController::class, ['as' => 'user']);
        Route::any('asset/qrcode/{id}', [AssetController::class, 'qrcode'])->name('user.assets.qrcode');
        Route::any('asset/import', [AssetController::class, 'import_asset'])->name('user.assets.import');

    });
});

Route::get(SiteConstants::URL_PREFIX_ADMIN_WEB . '/config-clear', function () {
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');
    \Artisan::call('config:cache');
    \Artisan::call('config:clear');
    \Artisan::call('cache:clear');
    echo "done";
});
