<?php

use App\Events\NewMessagePosted;

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


Route::post('ipnpaypal', 'Users\AddFundController@ipnpaypal')->name('ipn.paypal');
Route::post('ipnperfect', 'Users\AddFundController@ipnperfect')->name('ipn.perfect');
Route::post('ipnstripe', 'Users\AddFundController@ipnstripe')->name('ipn.stripe');
Route::post('ipncoinGate', 'Users\AddFundController@coinGateIPN')->name('ipn.coinGate');
Route::get('/ipnbtc', 'Users\AddFundController@ipnbtc')->name('ipn.btc');
Route::post('/ipncoin', 'Users\AddFundController@ipncoin')->name('ipn.coinPay');
Route::get('/ipnblock', 'Users\AddFundController@blockIpn')->name('ipn.block');	


Route::get('/test', 'TestController@test')->name('test');

Route::get('event', function() {
	event(new NewMessagePosted);
})->name('chatEvent');

Route::get('listen', function() {
	return view('listenBroadcast');
});

Route::group(['middleware' => 'guest'], function() {
	Route::get('/refer/{username}/register', 'Auth\RegisterController@showRegistrationForm')->name('users.refer.register');

	Route::get('/showEmailForm', 'Users\ForgotPasswordController@showEmailForm')->name('users.showEmailForm');
	Route::post('/sendResetPassMail', 'Users\ForgotPasswordController@sendResetPassMail')->name('users.sendResetPassMail');
	Route::get('/reset/{code}', 'Users\ForgotPasswordController@resetPasswordForm')->name('users.resetPasswordForm');
	Route::post('/resetPassword', 'Users\ForgotPasswordController@resetPassword')->name('users.resetPassword');
});

#=========== User Routes =============#
Route::get('/', 'Users\HomeController@home')->name('users.home');
Route::get('/searchServices', 'Users\HomeController@searchServices')->name('users.searchServices');
Route::get('/servicesAccoordingToCategory/{catID}', 'Users\HomeController@servicesAccoordingToCat')->name('users.servicesAccoordingToCat');
Auth::routes();
Route::get('/profile/{id}', 'Users\ProfileController@profile')->name('users.profile');
Route::get('/services/show/{service}/{userId}', 'Users\ServiceController@show')->name('services.show');
Route::post('/services/deleteServiceImage', 'Users\ServiceController@deleteServiceImage')->name('sevices.deleteServiceImage');

Route::group(['middleware' => 'auth'], function() {
	Route::get('/editProfile', 'Users\ProfileController@editProfile')->name('editProfile');
	Route::put('/updateProfile', 'Users\ProfileController@updateProfile')->name('updateProfile');
	Route::get('/changePassword', 'Users\ProfileController@editPassword')->name('editPassword');
	Route::put('/updatePassword', 'Users\ProfileController@updatePassword')->name('updatePassword');

	Route::get('/service/create', 'Users\ServiceController@create')->name('services.create');
	Route::post('/service/store', 'Users\ServiceController@store')->name('services.store');
	Route::get('/services/index', 'Users\ServiceController@index')->name('services.index');
	Route::post('/services/statusUpdate', 'Users\ServiceController@statusUpdate')->name('services.statusUpdate');
	Route::get('/services/edit/{service}', 'Users\ServiceController@edit')->name('services.edit');
	Route::post('/services/update', 'Users\ServiceController@update')->name('services.update');



	Route::get('/addFund', 'Users\AddFundController@index')->name('addFund');
	Route::post('/deposit', 'Users\AddFundController@depositPreview')->name('depositPreview');
	Route::get('/deposit/confirm', 'Users\AddFundController@depositConfirm')->name('deposit.confirm');
	Route::get('/coin-gate', 'Users\AddFundController@coingatePayment')->name('coinGate');
	Route::get('addFund/success', 'Users\AddFundController@success')->name('addFund.success');


	Route::post('/posts/store', 'Users\PostController@store')->name('posts.store');
	Route::post('/posts/update', 'Users\PostController@update')->name('posts.update');
	Route::post('/posts/edit', 'Users\PostController@edit')->name('posts.edit');
	Route::post('/posts/delete', 'Users\PostController@delete')->name('posts.delete');

	Route::post('/comments/store', 'Users\CommentController@store')->name('comments.store');
	Route::post('/comments/edit', 'Users\CommentController@edit')->name('comments.edit');
	Route::post('/comments/update', 'Users\CommentController@update')->name('comments.update');
	Route::post('/comments/delete', 'Users\CommentController@delete')->name('comments.delete');

	Route::get('/buyer/myShopping', 'Users\ShoppingController@myShopping')->name('buyer.myShopping');
	Route::get('/buyer/buyerToSellerMessages/', function() {})->name('buyer.contactOrder');
	Route::get('/buyer/buyerToSellerMessages/{order}', 'Users\ShoppingController@buyerToSellerMessages')->name('buyer.buyerToSellerMessages');
	Route::post('/buyer/buyerToSellerMessage', 'Users\ShoppingController@storeBuyerMessage')->name('buyer.messageStore');
	Route::post('/buyer/rateProject', 'Users\ShoppingController@rateProject')->name('buyer.rateProject');
	Route::post('/buyer/rejectDelivery', 'Users\ShoppingController@rejectDelivery')->name('buyer.rejectDelivery');

	Route::get('/seller/manageSales', 'Users\ManageSalesController@index')->name('seller.manageSales');
	Route::get('/seller/sellerToBuyerMessages/{order?}', 'Users\ManageSalesController@sellerToBuyerMessages')->name('seller.sellerToBuyerMessages');
	Route::post('/seller/sellerToBuyerMessage', 'Users\ManageSalesController@storeSellerMessage')->name('seller.messageStore');
	Route::post('/seller/acceptProject', 'Users\ManageSalesController@accpetProject')->name('seller.acceptProject');
	Route::post('/seller/rejectProject', 'Users\ManageSalesController@rejectProject')->name('seller.rejectProject');
	Route::post('/seller/revisionAccpet', 'Users\ManageSalesController@revisionAccepted')->name('seller.revisionAccepted');
	Route::post('/seller/revisionReject', 'Users\ManageSalesController@revisionRejected')->name('seller.revisionRejected');

	Route::post('/buyer/placeOrder', 'Users\OrderController@placeOrder')->name('buyer.placeOrder');

	Route::get('/withdrawMoney', 'Users\WithdrawMoneyController@withdrawMoney')->name('withdrawMoney');
	Route::post('/withdrawRequest/store', 'Users\WithdrawMoneyController@store')->name('withdrawRequest.store');

	Route::post('/checkEmailVerification', 'Users\VerificationController@emailVerification')->name('checkEmailVerification');
	Route::post('/checkSmsVerification', 'Users\VerificationController@smsVerification')->name('checkSmsVerification');

});


#=========== Admin Routes =============#
Route::group(['prefix' => 'admin'], function () {
	Route::get('/','AdminLoginController@index')->name('admin.loginForm');
	Route::post('/', 'AdminLoginController@authenticate')->name('admin.login');
});


Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin' , 'Demo']], function () {

	Route::get('/Dashboard', 'AdminController@dashboard')->name('admin.dashboard');

	Route::get('/GeneralSetting', 'GeneralSettingController@GenSetting')->name('admin.GenSetting');
	Route::post('/GeneralSetting', 'GeneralSettingController@UpdateGenSetting')->name('admin.UpdateGenSetting');
	Route::get('/EmailSetting', 'EmailSettingController@index')->name('admin.EmailSetting');
	Route::post('/EmailSetting', 'EmailSettingController@updateEmailSetting')->name('admin.UpdateEmailSetting');
  Route::get('/SmsSetting', 'SmsSettingController@index')->name('admin.SmsSetting');
  Route::post('/SmsSetting', 'SmsSettingController@updateSmsSetting')->name('admin.UpdateSmsSetting');

	Route::get('/ManageMac', 'MacController@allMacs')->name('show.mac');
	Route::post('/UpdateMac', 'MacController@UpdateMacs')->name('update.mac');

	Route::get('/AllUser', 'UserController@allUsers')->name('show.users');
	Route::get('/UserDetails/{id}', 'UserController@SingleUser')->name('user.details');

	Route::get('/gateways', 'GatewayController@index')->name('admin.gateways');
	Route::post('/gateway/update/{gatewayID}', 'GatewayController@update')->name('admin.gateway.update');

	Route::get('/logout', 'AdminController@logout')->name('admin.logout');

	Route::get('/depositLog', 'DepositLogController@depositLog')->name('admin.depositLog');

	Route::get('/withdrawLog', 'withdrawMoney\withdrawLogController@withdrawLog')->name('admin.withdrawLog');

	Route::get('/withdrawMethod', 'withdrawMoney\withdrawMethodController@withdrawMethod')->name('admin.withdrawMethod');
	Route::post('/withdrawMethod/store', 'withdrawMoney\withdrawMethodController@store')->name('withdrawMethod.store');
	Route::get('/withdrawMethod/edit', 'withdrawMoney\withdrawMethodController@edit')->name('withdrawMethod.edit');
	Route::post('/withdrawMethod/update', 'withdrawMoney\withdrawMethodController@update')->name('withdrawMethod.update');
	Route::post('/withdrawMethod/delete', 'withdrawMoney\withdrawMethodController@destroy')->name('withdrawMethod.destroy');
	Route::post('/withdrawMethod/enable', 'withdrawMoney\withdrawMethodController@enable')->name('withdrawMethod.enable');

	Route::get('/withdrawLog/{wID}', 'withdrawMoney\withdrawLogController@show')->name('withdrawLog.show');
	Route::post('/withdrawLog/message/store', 'withdrawMoney\withdrawLogController@storeMessage')->name('withdrawLog.message.store');

	Route::get('/successLog', 'withdrawMoney\successLogController@successLog')->name('admin.withdrawMoney.successLog');
	Route::get('/refundedLog', 'withdrawMoney\refundedLogController@refundedLog')->name('admin.withdrawMoney.refundedLog');
	Route::get('/pendingLog', 'withdrawMoney\pendingLogController@pendingLog')->name('admin.withdrawMoney.pendingLog');

	Route::get('/userManagement/allUsers', 'UserManagementController@allUsers')->name('admin.allUsers');
	Route::get('/userManagement/userDetails/{userID}', 'UserManagementController@userDetails')->name('admin.userDetails');
	Route::get('/userManagement/bannedUsers', 'UserManagementController@bannedUsers')->name('admin.bannedUsers');
	Route::get('/userManagement/verifiedUsers', 'UserManagementController@verifiedUsers')->name('admin.verifiedUsers');
	Route::get('/userManagement/mobileUnverifiedUsers', 'UserManagementController@mobileUnverifiedUsers')->name('admin.mobileUnverifiedUsers');
	Route::get('/userManagement/emailUnverifiedUsers', 'UserManagementController@emailUnverifiedUsers')->name('admin.emailUnverifiedUsers');
	Route::get('/userManagement/addSubtractBalance/{userID}', 'UserManagementController@addSubtractBalance')->name('admin.addSubtractBalance');
	Route::get('/userManagement/emailToUser/{userID}', 'UserManagementController@emailToUser')->name('admin.emailToUser');
	Route::post('/userManagement/updateUserBalance', 'UserManagementController@updateUserBalance')->name('admin.updateUserBalance');
	Route::post('/userManagement/sendEmailToUser', 'UserManagementController@sendEmailToUser')->name('admin.sendEmailToUser');
	Route::post('/userManagement/updateUserDetails', 'UserManagementController@updateUserDetails')->name('admin.updateUserDetails');
	Route::get('/userManagement/withdrawLog/{userID}', 'UserManagementController@withdrawLog')->name('admin.userManagement.withdrawLog');
	Route::get('/userManagement/depositLog/{userID}', 'UserManagementController@depositLog')->name('admin.userManagement.depositLog');

	Route::get('/gigManagement/allGigs', 'GigManagementController@allGigs')->name('gigManagement.allGigs');
	Route::post('/gigManagement/gigHide', 'GigManagementController@gigHide')->name('gigManagement.gigHide');
	Route::post('/gigManagement/gigShow', 'GigManagementController@gigShow')->name('gigManagement.gigShow');
	Route::post('/gigManagement/gigFeature', 'GigManagementController@changeFeatureStatus')->name('gigManagement.gigFeatureStatusChange');
	Route::get('/gigManagement/hiddenGigs', 'GigManagementController@hiddenGigs')->name('gigManagement.hiddenGigs');
	Route::get('/gigManagement/featuredGigs', 'GigManagementController@featuredGigs')->name('gigManagement.featuredGigs');

	Route::get('/profile/edit/{adminID}', 'ProfileController@editProfile')->name('admin.editProfile');
	Route::post('/profile/update/{adminID}', 'ProfileController@updateProfile')->name('admin.updateProfile');
	Route::get('profile/editPassword/', 'ProfileController@editPassword')->name('admin.editPassword');
	Route::post('/profile/updatePassword', 'ProfileController@updatePassword')->name('admin.updatePassword');

	Route::get('/interfaceControl/logoIcon/index', 'InterfaceControl\LogoIconController@index')->name('admin.logoIcon.index');
	Route::post('/interfaceControl/logoIcon/update', 'InterfaceControl\LogoIconController@update')->name('admin.logoIcon.update');
	Route::get('/interfaceControl/slider/index', 'InterfaceControl\SliderController@index')->name('admin.slider.index');
	Route::post('/interfaceControl/slider/store', 'InterfaceControl\SliderController@store')->name('admin.slider.store');
	Route::post('/interfaceControl/slider/delete', 'InterfaceControl\SliderController@delete')->name('admin.slider.delete');
	Route::get('/interfaceControl/footer/index', 'InterfaceControl\FooterController@index')->name('admin.footer.index');
	Route::post('/interfaceControl/footer/update', 'InterfaceControl\FooterController@update')->name('admin.footer.update');
	Route::get('/interfaceControl/support/index', 'InterfaceControl\HelpController@index')->name('admin.support.index');
	Route::post('/interfaceControl/support/store', 'InterfaceControl\HelpController@store')->name('admin.support.store');
	Route::post('/interfaceControl/support/delete', 'InterfaceControl\HelpController@delete')->name('admin.support.delete');
	Route::get('/interfaceControl/social/index', 'InterfaceControl\SocialController@index')->name('admin.social.index');
	Route::post('/interfaceControl/social/store', 'InterfaceControl\SocialController@store')->name('admin.social.store');
	Route::post('/interfaceControl/social/delete', 'InterfaceControl\SocialController@delete')->name('admin.social.delete');
	Route::get('/interfaceControl/contact/index', 'InterfaceControl\ContactController@index')->name('admin.contact.index');
	Route::post('/interfaceControl/contact/update', 'InterfaceControl\ContactController@update')->name('admin.contact.update');
	Route::get('/interfaceControl/Ad/index', 'InterfaceControl\AdController@index')->name('admin.ad.index');
	Route::get('/interfaceControl/Ad/create', 'InterfaceControl\AdController@create')->name('admin.ad.create');
	Route::post('/interfaceControl/Ad/store', 'InterfaceControl\AdController@store')->name('admin.ad.store');
	Route::get('/interfaceControl/Ad/showImage', 'InterfaceControl\AdController@showImage')->name('admin.ad.showImage');
	Route::post('/interfaceControl/Ad/delete', 'InterfaceControl\AdController@delete')->name('admin.ad.delete');
	Route::post('/interfaceControl/Ad/increaseAdView', 'InterfaceControl\AdController@increaseAdView')->name('admin.ad.increaseAdView');
	Route::get('/interfaceControl/fbComments/index', 'InterfaceControl\fdCommentController@index')->name('admin.fbComment.index');
	Route::post('/interfaceControl/fbComments/update', 'InterfaceControl\fdCommentController@update')->name('admin.fbComment.update');

	Route::get('/categoryManagement/index', 'CategoryManagementController@index')->name('admin.category.index');
	Route::post('/categoryManagement/store', 'CategoryManagementController@store')->name('admin.category.store');
	Route::post('/categoryManagement/update/{categoryID}', 'CategoryManagementController@update')->name('admin.category.update');
	Route::post('/categoryManagement/delete/{categoryID}', 'CategoryManagementController@delete')->name('admin.category.delete');

});
