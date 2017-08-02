<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/status', function (Request $request) {
    $commitHash = trim(exec('git log --pretty="%h" -n1 HEAD'));
    $commitDate = new \DateTime(trim(exec('git log -n1 --pretty=%ci HEAD')));
    $commitDate->setTimezone(new \DateTimeZone('UTC'));
    return response()->json([
        'version' => [
            'tag' => '1.0',
            'commit' => $commitHash,
            'date' => $commitDate
        ],
        'status:' => 'OK'
    ]);
});

Route::post('users/signin', 'Api\AuthController@signin');
Route::group(['middleware' => ['jwt.auth']], function () {
    Route::resource('users', 'Api\UserController');
    Route::resource('downloads', 'Api\DownloadController');
//    Route::get('downloads/search/{any?}', 'Api\DownloadController@search')->where('any', '.*');
//    Route::get('files/{any?}', 'Api\FileController@index')->where('any', '.*');
//    Route::delete('files/{any?}', 'Api\FileController@destroy')->where('any', '.*');
    Route::post('deploy', 'Api\SystemController@deploy');
});