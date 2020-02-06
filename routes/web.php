<?php
// Route::get('info', function () {
//     phpinfo();
// });
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
Route::get('/test/pay','TestController@alipay');        //去支付
Route::get('/test/alipay/return','Alipay\PayController@aliReturn');
Route::post('/test/alipay/notify','Alipay\PayController@notify');
Route::any('/text/text','Api\TextController@text');
Route::post('/login/login','Api\LoginController@login');
Route::post('/login/logon','Api\LoginController@logon');
Route::any('/login/list','Api\LoginController@list');
Route::any('/login/test','Api\LoginController@test');
Route::get('/work/jiami/','Api\Work1Controller@jiami');
Route::get('/work/jiemi','Api\Work1Controller@jiemi');
Route::get('/client/encrypt','Api\ClientController@encrypt');
Route::get('/client/encrypt2','Api\ClientController@encrypt2');
Route::get('/client/rsa1','Api\ClientController@rsa1');
Route::any('/client/curl1','Api\ClientController@curl1');
Route::any('/client/curl2','Api\ClientController@curl2');
Route::any('/client/curl3','Api\ClientController@curl3');
Route::any('/client/curl4','Api\ClientController@curl4');
Route::any('/client/sign1','Api\ClientController@sign1');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//解密数据
Route::get('/user/decrypt/data','User\IndexController@decrypt1');
Route::post('/user/decrypt/data','User\IndexController@decrypt2');

// 用户管理
Route::get('/user/addkey','User\IndexController@addSSHKey1');
Route::post('/user/addkey','User\IndexController@addSSHKey2');
//签名测试
Route::get('/sign1','TestController@sign1');
Route::get('/test/get/signonlie','Sign\IndexController@signOnline');
Route::post('/test/post/signonlie','Sign\IndexController@signOnline1');
Route::get('/test/get/sign1','Sign\IndexController@sign1');
Route::post('/test/post/sign2','Sign\IndexController@sign2');
Route::get('/sign/ymsign1','Sign\IndexController@ymsign1');
Route::get('/sign/ymsign2','Sign\IndexController@ymsign2');

Route::post('/login/register','Work\LoginController@register');//注册
Route::any('/login/login','Work\LoginController@login');//登录
Route::any('/login/getToken','Work\LoginController@getToken');//登录
Route::any('/login/showTime','Work\LoginController@showTime');//用户信息
Route::any('/login/auth','Work\LoginController@auth');//鉴权
Route::any('/login/getToken','Work\LoginController@getToken');//鉴权
Route::any('/login/auth','Work\LoginController@auth');//鉴权
Route::any('/login/token','Work\LoginController@token');
Route::any('/login/cattoken','Work\LoginController@cattoken');
Route::any('/login/inserttoken','Work\LoginController@inserttoken');
