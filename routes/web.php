<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::controller(MemberController::class)->group(function () {
        Route::prefix('member')->group(function () {
            Route::name('member.')->group(function () {
                Route::post('/create', 'create')->name('create');
                Route::get('/books', 'book')->name('book');
            });
        });
    });

Route::middleware(['admin'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::prefix('admin')->group(function () {
            Route::name('admin.')->group(function () {
                Route::get('/home', 'index')->name('home');
                Route::get('/books', 'books')->name('books');
                Route::post('/books', 'submit_book')->name('book.submit');
                Route::patch('/books/update', 'update_book')->name('book.update');
                Route::get('/ajaxadmin/dataBuku/{id}', 'getDataBuku');
                Route::delete('/books/delete/{id}', 'delete_book')->name('book.delete');
                Route::get('/print_books', 'print_books')->name('print.books');
                Route::get('/books/export', 'export')->name('book.export');
                Route::post('/books/import', 'import')->name('book.import');
                Route::get('/trash', 'trash')->name('trash');
                Route::delete('/books/empty/{id}', 'delete_force')->name('book.delete.force');
                Route::post('/books/restore/{id}', 'restore')->name('book.delete.force');
                Route::post('/restore/all', 'restoreAll')->name('book.restore');
                Route::post('/delete/all', 'deleteAll')->name('book.deleteAll');
            });
        });
    });
});

                                                                