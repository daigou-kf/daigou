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

// others
Route::get('/coming_soon','GuestController@web_coming_soon')->name('coming_soon');
Route::get('pages/testing','GuestController@page_test');
Route::get('pages/ebay','AdminController@ebay')->middleware('admin');
Route::get('/test','GuestController@test')->middleware('admin');
Route::get('/test1','GuestController@test1')->middleware('admin');
Route::get('/g_code','GuestController@g_code')->middleware('admin');
Route::get('/pick_code','GuestController@pick_code')->middleware('admin');
Route::get('/send_sms/{phone}/{text}','AdminController@send_sms');
Route::get('/test2/{query}','GuestController@test2');

// public info page
Route::prefix('official')->group(function(){
    Route::get('about_us','PublicController@about_us');
    Route::get('contact_us','PublicController@contact_us');
});
// public coming soon page
Route::namespace('User')->prefix('others')->group(function(){
    Route::get('coming_soon','InfoController@coming_soon');
});

/**
 * Guest Routes
 */
Auth::routes();
Route::post('/send_code','GuestController@send_code');
Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@index')->name('index');
Route::get('mall/payment_result/{user_id}/{trade_id}', 'GuestController@payment_result');


/**
 * User routes
 */
/*
 * Organized User Routes
 */
Route::middleware(['mobile','not_staff'])->group(function(){
    /* related to user settings */
    Route::namespace('User')->middleware(['auth','not_staff'])->group(function(){
        Route::post('disable_welcome','UserController@disable_welcome')->name('users.disable_welcome');
        Route::post('disable_delivery_reminder','UserController@disable_delivery_reminder')->name('users.disable_delivery_reminder');

        /* edit password */
        Route::get('edit_password','UserController@edit_password')->name('home_edit_password');
        Route::post('change_password','UserController@change_password')->name('home_change_password');
    });

    /* Shopping Mall */
    Route::prefix('mall')->group(function(){
        Route::namespace('User')->group(function(){
            /* Main Tabs */
            Route::get('home', 'HomeController@home')->name('home_home');
            Route::get('products', 'HomeController@products')->name('home_products');
            Route::get('brands', 'HomeController@brands')->name('home_brands');
            Route::get('gift_center', 'HomeController@gift_center')->name('home_gift_center');
            Route::get('shopping_cart', 'HomeController@shopping_cart')->name('home_cart');
            Route::get('dashboard', 'HomeController@dashboard')->name('home_dashboard');

            /* shopping cart actions */
            Route::get('get_shopping_cart', 'CartController@get_cart_products');
            Route::post('add_to_cart','CartController@add_to_cart');
            Route::post('update_cart', 'CartController@update_cart');
            Route::delete('remove_from_cart','CartController@remove_from_cart');
            Route::delete('clear_cart', 'CartController@clear_cart');
            Route::get('select_package_method','CartController@select_package_method')->name('home_select_package_method')->middleware(['auth','not_staff']);
            Route::post('create_order', 'CartController@create_order')->name('home_create_order')->middleware(['auth','not_staff']);

            /* addresses */
            Route::middleware(['auth','not_staff'])->group(function(){
                Route::get('addresses', 'AddressController@address_index')->name('home_address_index');
                Route::get('get_sending_addresses', 'AddressController@get_sending_addresses');
                Route::post('addresses/new', 'AddressController@address_new');
                Route::delete('delete_sending_address', 'AddressController@delete_sending_address');
                Route::get('get_sender_addresses', 'AddressController@get_sender_addresses');
                Route::post('sender_addresses/new', 'AddressController@sender_address_new');
                Route::delete('delete_sender_address', 'AddressController@delete_sender_address');
            });

            /* orders */
            Route::middleware(['auth','not_staff'])->group(function(){
                Route::get('orders', 'OrderController@order_index')->name('home_order_index');
                Route::get('get_all_orders', 'OrderController@all_orders');
                Route::get('show_order/{id}', 'OrderController@order_show')->name('home_order_show');
                Route::get('get_unpaid_orders', 'OrderController@unpaid_orders');
                Route::get('get_paid_orders', 'OrderController@paid_orders');
                Route::get('get_sending_orders', 'OrderController@sending_orders');
                Route::get('get_completed_orders', 'OrderController@completed_orders');
                Route::post('confirm_order', 'OrderController@confirm_order');
                Route::post('create_transaction','OrderController@create_payment');
                Route::get('track_delivery/{delivery_no}','OrderController@track_delivery');
            });

            /* product page */
            Route::get('products/{id}', 'ProductController@product_show')->name('home_product_show');
            Route::get('get_product/{id}', 'ProductController@get_product');
            Route::get('products/detail/{id}','ProductController@product_detail');
            Route::post('search_products', 'ProductController@search_products')->name('home_search_products');
            Route::post('products/update_like', 'ProductController@update_like')->middleware(['auth','not_staff']);
            Route::get('favourites', 'ProductController@favourite_index')->name('home_favourite_index')->middleware(['auth','not_staff']);
            Route::get('get_fav', 'ProductController@get_fav')->middleware(['auth','not_staff']);

            /* collection page */
            Route::get('collections/{id}','CollectionController@collection_show')->name('home.collections.show');

            /* category page */
            Route::get('categories/{id}', 'CategoryController@category_show')->name('home_category_show');

            /* brand page */
            Route::get('brands/{id}', 'BrandController@brand_show')->name('home_brand_show');
            Route::get('get_other_brands','BrandController@get_other_brands');

            /* service page */
            Route::middleware(['auth','not_staff'])->group(function(){
                Route::get('services', 'ServiceController@service_index')->name('home_service_index');
                Route::get('services/create/{order_id}', 'ServiceController@service_create')->name('home_service_create');
                Route::post('services/store', 'ServiceController@service_store')->name('home_service_store');
                Route::get('services/{service_id}', 'ServiceController@service_show')->name('home_service_show');
            });
        });

        /* info routes */
        Route::namespace('User')->group(function(){
            Route::get('questions','InfoController@questions')->name('users.info.questions');
            Route::get('about_us','InfoController@about_us')->name('users.info.about_us');
            Route::get('contact_us','InfoController@contact_us')->name('users.info.contact_us');
        });

    });

    /* 银豹 stock */
    Route::get('/get_inventory_by_id/{id}','PospalController@get_inventory_by_id');
});



/**
 * Admin routes
 */
Route::middleware('admin')->group(function (){
    /* routes for user model */
    Route::resource('users', 'UserController');

    /* products */
    Route::prefix('products')->group(function(){
        Route::get('trashed','ProductController@index_trashed')->name('products.index_trashed');
        Route::post('restore/{id}','ProductController@restore')->name('products.restore');
        Route::get('sort/{order}','ProductController@sort')->name('products.sort');
    });
    Route::resource('products', 'ProductController');

    /* collections */
    Route::prefix('collections')->group(function(){
        Route::get('/','CollectionController@index')->name('collections.index');
        Route::get('show/{id}','CollectionController@show')->name('collections.show');
        Route::get('create','CollectionController@create')->name('collections.create');
        Route::post('store','CollectionController@store')->name('collections.store');
        Route::get('edit/{id}','CollectionController@edit')->name('collections.edit');
        Route::patch('update/{id}','CollectionController@update')->name('collections.update');
        Route::post('collections/update_products/{id}','CollectionController@update_products')->name('collections.update_products');

    });

    /* categories */
    Route::prefix('categories')->group(function(){
        Route::get('order','CategoryController@order')->name('categories.order');
    });
    Route::resource('categories', 'CategoryController');

    /* brands */
    Route::prefix('brands')->group(function (){
        Route::get('orders/show','BrandController@show_order')->name('brands.order');
        Route::post('orders/change','BrandController@change_order')->name('change_brand_order');
        Route::get('sort/{order}','BrandController@sort')->name('brands.sort');
    });
    Route::resource('brands', 'BrandController');

    /* routes for staff */
    Route::prefix('staffs')->group(function (){
        Route::get('/', 'UserController@staff_index')->middleware('admin')->name('staff_index');
        Route::get('create', 'UserController@staff_create')->middleware('admin')->name('staff_create');
        Route::post('store', 'UserController@staff_store')->middleware('admin')->name('staff_store');
    });

    /* others */
    Route::get('/report_tasks','AdminController@report_tasks')->name('report_tasks');
    Route::get('/fetch_pospal_uid','AdminController@fetch_pospal_uid');
    Route::get('pospal','AdminController@pospal_index')->name('pospal.index');
    Route::post('pospal/get_member_points','AdminController@pospal_get_member_points')->name('pospal.get_member_points');
    Route::post('pospal/edit_points','AdminController@pospal_change_points')->name('pospal.change_points');
});



/* routes for staff */
Route::namespace('Staff')->prefix('staff')->group(function (){
    Route::get('/','StaffController@admin_login')->middleware('guest');

    Route::middleware('staff')->group(function(){
        /*
         * for retail store staff
         */
        Route::get('home', 'StaffController@show')->name('staff_show');
        Route::get('order/{id}', function(){
            return redirect(route('staff_show'));
        });

        Route::post('upload_delivery_no', 'StaffController@upload_delivery_no')->name('staff_upload_deli_no');
        Route::post('upload_service', 'StaffController@upload_service')->name('staff_upload_service');
        Route::get('create_product','StaffController@create_product')->name('staff_create_product');
        Route::post('store_product','StaffController@store_product')->name('staff_store_product');
        Route::get('create_brand','StaffController@create_brand')->name('staff_create_brand');
        Route::post('store_brand','StaffController@store_brand')->name('staff_store_brand');
        Route::get('create_category','StaffController@create_category')->name('staff_create_category');
        Route::post('store_category','StaffController@store_category')->name('staff_store_category');
    });
});