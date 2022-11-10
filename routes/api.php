<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
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
// Laravelデフォルトのルーター設定
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

// prefix webapi/ へ RouteServiceProviderで設定
// REST 定義
Route::get('/tasks', [TaskController::class, 'findAll']); // タスク一覧
Route::get('/tasks/{id}', [TaskController::class, 'findById']); // ID検索
Route::post('/tasks', [TaskController::class, 'post']); // 新規登録
Route::put('/tasks/{id}', [TaskController::class, 'put']); // 更新
Route::delete('/tasks/{id}', [TaskController::class, 'delete']); // 削除
