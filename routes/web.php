<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\SoftDeletedRecordController;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(PageController::class)->group(function () {
    Route::get("/", "index")->name("index");
    Route::get("/article-detail/{slug}", "show")->name("detail");
    Route::get("/category/{slug}", "categorized")->name("categorized");


    Route::get("validate-test", 'validateTest')->name("validateTest");
    Route::post("validate-check", 'validateCheck')->name("validateCheck");
});
Route::resource("comment", CommentController::class)->only(["store", "update", "destroy"])->middleware("auth");

Auth::routes();

Route::middleware(['auth'])->prefix("dashboard")->group(function () {
    Route::resource("article", ArticleController::class);

    //soft delete and restore and force delete
    Route::get('soft-deleted-records', [SoftDeletedRecordController::class, 'index'])->name('soft-deleted-records.index');
    Route::get('soft-deleted-records/restore/one/{id}', [SoftDeletedRecordController::class, 'restore'])->name('soft-deleted-records.restore');
    Route::get('/soft-deleted-record-detail/{id}', [SoftDeletedRecordController::class, 'show'])->name('soft-deleted-record-detail.show');
    Route::get('restoreAll', [SoftDeletedRecordController::class, 'restoreAll'])->name('soft-deleted-records.restore.all');

    Route::delete("force-deleted-record/{id}", [SoftDeletedRecordController::class, "forceDelete"])->name("force-deleted-record");


    Route::resource("photo", PhotoController::class);
    Route::resource("category", CategoryController::class)->middleware("can:viewAny," . Category::class);
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/user-list', [HomeController::class, 'users'])->name('users')->can('admin-only');
});
