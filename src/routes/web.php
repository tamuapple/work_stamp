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

// 認証系
Route::group(['middleware' => ['guest']], function(){
  Route::namespace('Auth')->group(function(){
    Route::get('/register', function(){ return view('auth.register'); })
    ->name('register.form');
    Route::post('/register', 'RegisterController@register')
    ->name('register');
    Route::get('/login', function(){ return view('auth.login'); })
    ->name('login.form');
    Route::post('/login', 'LoginController@login')
    ->name('login');
    // 認証画面に遷移
    Route::get('auth/line', 'LineLoginController@redirectToProvider')->name('line.login');
    Route::get('auth/line/callback', 'LineLoginController@handleProviderCallback');
    Route::get('auth/{provider}', 'SnsLoginController@redirectToProvider')->name('redirect.to.provider');
    Route::get('auth/{provider}/callback', 'SnsLoginController@handleProviderCallback');
  });
  Route::fallback(function(){ return redirect()->route('login.form'); });
});

Route::group(['middleware' => ['auth']], function(){
  // ホーム
  Route::redirect('/', 'home');
  Route::get('/home', 'UsersController@show')->name('home');

  // ユーザー
  Route::resource('user', 'UsersController');

  // attendance
  Route::resource('attendance', 'AttendancesController', ['except' => ['show', 'edit', 'destroy']]);
  Route::get('attendance/{user}', 'AttendancesController@show');

  // シフト
  Route::resource('shift', 'ShiftsController', ['except' => ['show']]);
  Route::get('shift/{user}/{date?}', 'ShiftsController@show')
  ->where(['date' => '[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])'])
  ->name('shift.show');
  Route::post('shift/approve/{shift}', 'ShiftsController@shiftApprove');
  Route::post('shift/many/approve', 'ShiftsController@shiftApproveMany');

  // 打刻
  Route::resource('work_stamp', 'WorkStampsController', ['except' => ['show']]);
  Route::post('/work_stamp/approve/{work_stamp}', 'WorkStampsController@workStampApprove');
  Route::post('/work_stamp/many/approve', 'WorkStampsController@workStampApproveMany');
  Route::get('work_stamp/stamping', 'WorkStampsController@stamping');
  Route::post('work_stamp/stamping', 'WorkStampsController@stampingStore');
  Route::get('/work_stamp/{user}/{date?}', 'WorkStampsController@show')
  ->where(['date' => '[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])'])
  ->name('work_stamp.show');

  // 早出
  Route::resource('earlytime', 'EarlytimesController', ['except' => ['show']]);
  Route::post('earlytime/approve/{earlytime}', 'EarlytimesController@earlyTimeApprove');
  Route::post('/earlytime/many/approve', 'EarlytimesController@earlyTimeApproveMany');
  Route::get('earlytime/{user}/{date?}', 'EarlytimesController@show')
  ->where(['date' => '[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])'])
  ->name('earlytime.show');

  // 残業
  Route::resource('overtime', 'OvertimesController', ['except' => ['show']]);
  Route::post('overtime/approve/{overtime}', 'OvertimesController@overtimeApprove');
  Route::post('/overtime/many/approve', 'OvertimesController@overtimeApproveMany');
  Route::get('overtime/{user}/{date?}', 'OvertimesController@show')
  ->where(['date' => '[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])'])
  ->name('overtime.show');

  // ログアウト
  Route::get('/logout', 'Auth\LoginController@logout');
  Route::fallback(function(){ return redirect()->route('user.show', Auth::id()); });
});
