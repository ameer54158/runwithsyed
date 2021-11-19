<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

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

//Get information after the payment request
Route::get('vipps/callbacks-for-payment-updates',function () {
    return view('privacy');
});

//Success or failed payment url
Route::get('/fallback-order-result-page/{order_id}',[\App\Http\Controllers\PaymentController::class,'vipps_capture_payment']);
//Payment status like completed or cancelled
Route::get('/payment/status/{status}',[\App\Http\Controllers\PaymentController::class,'payment_status_result_page'])->name('payment-status');
//Pay some amount using VIPPS
Route::get('payment/{amount}',[\App\Http\Controllers\PaymentController::class,'vipps_payment'])->name('payment');

Route::group(['middleware' => ['set-locale','is-status-active']], function () {
    //Change language type
    Route::get('change/lang/{lang_type?}', 'App\Http\Controllers\LocalizationController@lang_change')->name('change-lang');
    Auth::routes();
    //Home page
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Store Donations
    Route::post('donations', [App\Http\Controllers\DonationController::class, 'store'])->name('donations.store');

    //Privacy
    Route::multilingual('privacy', [App\Http\Controllers\HomeController::class, 'privacy'])->name('privacy');
    //Terms of sale
    Route::multilingual('terms-of-sale', [App\Http\Controllers\HomeController::class, 'terms_of_sale'])->name('terms-of-sale');
    //About us page
    Route::multilingual('about-us', [App\Http\Controllers\CommonController::class, 'about_us'])->name('about-us');
    //our ambassadors page
    Route::multilingual('our-ambassadors', [App\Http\Controllers\OurAmbassadorController::class, 'our_ambassadors'])->name('our-ambassadors');
    //Meet initiators page
    Route::multilingual('meet-initiators', [App\Http\Controllers\InitiatorController::class, 'list_initiators'])->name('meet-initiators');
    //List news page
    Route::multilingual('list-news', [App\Http\Controllers\NewsController::class, 'list_news'])->name('list-news');
    //Single news page
    Route::multilingual('single-news', [App\Http\Controllers\NewsController::class, 'single_news'])->name('single-news');
    //Show engage yourself page
    Route::multilingual('engage-yourself', [App\Http\Controllers\CommonController::class, 'engage_yourself'])->name('engage-yourself');
    //Show contact us page(form)
    Route::multilingual('contact-us', [App\Http\Controllers\ContactUsController::class, 'show_contact_us_page'])->name('contact-us');
    //Store contact us form data.
    Route::post('contact/us/store',[App\Http\Controllers\ContactUsController::class, 'store'])->name('contact-us-store');
    //All routes for auth user
    Route::group(['middleware' => 'auth'], function () {
        //Profile
        Route::multilingual('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::multilingual('/register-km', [ProfileController::class, 'register_km'])->name('register-km');
        Route::multilingual('/km-history', [ProfileController::class, 'km_history'])->name('km-history');
        Route::multilingual('/ambassador-payment-history', [ProfileController::class, 'ambassador_payment_history'])->name('ambassador-payment-history');
        Route::multilingual('/my-sponsors', [ProfileController::class, 'my_sponsors'])->name('my-sponsors');
        Route::multilingual('/sponsor-payment-history', [ProfileController::class, 'sponsor_payment_history'])->name('sponsor-payment-history');
        Route::multilingual('/my-ambassadors', [ProfileController::class, 'my_ambassadors'])->name('my-ambassadors');
        //Update user profile
        Route::patch('/profile/{id}', [ProfileController::class, 'update_profile'])->name('profile.update');
        //Show profile form
        Route::get('profile/{id}/edit', 'App\Http\Controllers\UserController@edit_profile')->name('edit-profile');
        //update user profile
        Route::put('profile/{id}/update', 'App\Http\Controllers\UserController@update_profile')->name('update-profile');
        //pay amount
        Route::post('ambassador/pay/amount', 'App\Http\Controllers\PaymentController@ambassador_pay_amount')->name('ambassador-pay-amount');
        Route::post('sponsor/pay/amount/{id}', 'App\Http\Controllers\PaymentController@sponsor_pay_amount')->name('sponsor-pay-amount');
        //Pay ambassador membership fee
        Route::get('pay/ambassador/membership/fee/{id}', 'App\Http\Controllers\PaymentController@paid_membership_fee')->name('pay-membership-fee');
        //Become sponsor of an ambassador
        Route::get('become-sponsor/{id}', [App\Http\Controllers\OurAmbassadorController::class, 'become_sponsor_of_ambassador'])->name('become-sponsor');
        //Remove sponsorship of an ambassador
        Route::get('remove-sponsorship/{id}', [App\Http\Controllers\OurAmbassadorController::class, 'remove_sponsor_of_ambassador'])->name('remove-sponsorship');
        //Single ambassador detail
        Route::multilingual('ambassador-detail', [App\Http\Controllers\OurAmbassadorController::class, 'view_ambassador'])->name('ambassador-detail');
        //Single ambassador detail for single month
        Route::multilingual('ambassador-detail-single-month-detail', [App\Http\Controllers\OurAmbassadorController::class, 'view_ambassador_single_month_runs'])->name('ambassador-detail-single-month-detail');
        Route::resources([
            'ambassador-runs'=>'App\Http\Controllers\AmbassadorRunController'
        ]);


        //Web routes for the admin user role
        Route::group(['prefix' => 'admin', 'as' => 'admin.','middleware' => 'admin_user'], function () {
            // You can leave off the ->middleware('auth') part for now if you don't want to bother with restricting access for now
            Route::get('instagram-get-auth', [App\Http\Controllers\InsatgramAuthController::class, 'show'])->name('instagram-get-auth');
            Route::get('instagram-auth-response', [App\Http\Controllers\InsatgramAuthController::class, 'complete']);
            Route::get('show-more-instagram-feed', [App\Http\Controllers\HomeController::class, 'show_more_instagram_feed'])->name('show-more-instagram-feed');
            //Admin dashboard
            Route::get('/dashboard','App\Http\Controllers\CommonController@admin_dashboard')->name('dashboard');
            //Edit our top ambassadors
            Route::get('/edit/our/top/ambassadors','App\Http\Controllers\UserController@edit_our_top_ambassadors')->name('edit-our-top-ambassadors');
            Route::post('/store/our/top/ambassadors','App\Http\Controllers\UserController@store_our_top_ambassadors')->name('store-our-top-ambassadors');
            // List Donations
            Route::get('/donations', [App\Http\Controllers\DonationController::class, 'index'])->name('donations.index');
            Route::get('donation/{id}/detail', [App\Http\Controllers\DonationController::class, 'show'])->name('donation-detail');
            //Open setting form
            Route::get('settings','App\Http\Controllers\SettingController@show_setting')->name('settings');
            //create or update setting
            Route::post('settings','App\Http\Controllers\SettingController@create_or_update')->name('update-settings');
            //Payment History admin_list_payments
            Route::get('payments','App\Http\Controllers\PaymentController@admin_list_payments')->name('payments');
            //View payment detail
            Route::get('payment/{id}/detail','App\Http\Controllers\PaymentController@view_payment_detail')->name('payment-detail');
            //Create custom payment for ambassador and sponsor user
            Route::get('create/payment','App\Http\Controllers\PaymentController@create_custom_payment')->name('create-custom-payment');
            //Store custom payment for ambassador and sponsor user
            Route::post('store/custom/payment','App\Http\Controllers\PaymentController@add_custom_payment')->name('store-custom-payment');
            //Admin route resources
            Route::resources([
                'initiators'=>'App\Http\Controllers\InitiatorController',
                'users'=>'App\Http\Controllers\UserController',
                'news'=>'App\Http\Controllers\NewsController',
                'contact-us'=>'App\Http\Controllers\ContactUsController',
            ]);
            //Store the news media uploaded/added from tinymce
            Route::post("news/save_media/", ['App\Http\Controllers\NewsController','save_media'])->name('news-save-media');
            // ambassador details
            Route::get('/ambassador-detail/{id}', ['App\Http\Controllers\UserController', 'ambassador_detail'])->name('ambassador.detail');
            // Sponsor details
            Route::get('/sponsor-detail/{id}', ['App\Http\Controllers\UserController', 'sponsor_detail'])->name('sponsor.detail');
            //Update the position of initiator order
            Route::post('initiator/order', 'App\Http\Controllers\InitiatorController@update_order')->name('update-initiator-order');
            //Change status of an record like users, news, initiators etc...
            Route::get('change-status', function (Request $request) {
                $class = $request->class_name;
                $column = $request->column_name;
                $obj = $class::find($request->id);
                $status = $request->status;
                if($obj){
                    $obj2 = $class::where('id',$obj->id)->update([
                        $column => $status
                    ]);
                }
                return json_encode('success');
                exit;
            })->name('change-status');
        });

        //Get sponsor user ambassador or get ambassador user paying month
        Route::get('/get-user-ambassador-or-paying-month',  function (Request $request) {
            $user = \App\Models\User::find($request->user_id);
            $options = $record_type = '';
            if ($user) {
                if($user->hasRole('ambassador')){
                    $not_paying_month_year = \App\Helpers\common::ambassador_not_paying_month($user);
                    if($not_paying_month_year->count()){
                        foreach ($not_paying_month_year as $key=>$not_paying_month_year_obj){
                            $options .= "<option value='".date('m-Y',strtotime($key))."' data-total_km='".$not_paying_month_year_obj->sum('distance')."'>".\App\Helpers\common::date_in_locale_lang($key,'M Y')."</option>";
                        }
                    }
                    $record_type = 'paying month';
                }

                if($user->hasRole('sponsor')){
                    if($user->ambassadors){
                        $options .= "<option value=".''.">Select ambassador</option>";
                        foreach ($user->ambassadors as $ambassador){
                            if($ambassador->ambassador_user){
                                $ambassador_user = $ambassador->ambassador_user;
                                $options .= "<option value='".$ambassador_user->id."'>".$ambassador_user->first_name." ".$ambassador_user->last_name." (".$ambassador_user->email.")</option>";
                            }
                        }
                    }
                    $record_type = 'user ambassadors';
                }
            }
            $response = array();
            $response['data'] = $options;
            $response['record_type'] = $record_type;
            return $response;
        });

        //Get user paying month that is pending from the user
        Route::get('/get-user-paying-month',  function (Request $request) {
            $ambassador_user = \App\Models\User::find($request->ambassador_id);
            $sponsor_id = Auth::user()->id;
            if($request->sponsor_id){
                $sponsor_id = $request->sponsor_id;
            }
            $sponsor_user = \App\Models\User::find($sponsor_id);
            $options = $record_type = '';
            if ($ambassador_user && $sponsor_user) {
                $not_paying_month_year = \App\Helpers\common::sponsor_not_paying_month($ambassador_user,($request->sponsor_id ? $request->sponsor_id : ''));
                if($not_paying_month_year->count()){
                    foreach ($not_paying_month_year as $key=>$not_paying_month_year_obj){
                        $options .= "<option value='".date('m-Y',strtotime($key))."' data-total_km='".$not_paying_month_year_obj->sum('distance')."'>".\App\Helpers\common::date_in_locale_lang($key,'M Y')."</option>";
                    }
                }
            }
            $response = array();
            $response['data'] = $options;
            return $response;
        });
    });
});

Route::fallback(function () {
    abort(404);
});