<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TrashController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\AktifasiController;
use App\Http\Controllers\ManageMemberController;
use App\Http\Controllers\PeminjamanController;

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
                Route::patch('/update', 'update')->name('update');
            });
        });
    });

Route::middleware(['admin'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::prefix('admin')->group(function () {
            Route::name('admin.')->group(function () {
                Route::delete('/books/gambar/delete/{id}', 'hapus_gambar')->name('hapus.gambar');
                Route::get('/home', 'index')->name('home');
                Route::get('/books', 'books')->name('books');
                Route::post('/books', 'submit_book')->name('book.submit');
                Route::patch('/books/update', 'update_book')->name('book.update');
                Route::get('/ajaxadmin/dataBuku/{id}', 'getDataBuku');
                Route::get('/gambar', 'gambar');
                Route::delete('/books/delete/{id}', 'delete_book')->name('book.delete');
                Route::get('/print_books', 'print_books')->name('print.books');
                Route::get('/books/export', 'export')->name('book.export');
                Route::post('/books/import', 'import')->name('book.import');
            });
        });
    });
});
Route::middleware(['admin'])->group(function () {
    Route::controller(TrashController::class)->group(function () {
        Route::prefix('trash')->group(function () {
            Route::name('trash.')->group(function () {
                Route::get('/', 'trash')->name('trash');
                Route::delete('/delete/{id}', 'delete')->name('delete');
                Route::post('/restore/{id}', 'restore')->name('restore');
                Route::post('/restore/all/data', 'restore_all')->name('restore.all');
                Route::delete('/delete/all/data', 'delete_all')->name('delete.all');
            });
        });
    });
});
Route::middleware(['admin'])->group(function () {
    Route::controller(ManageUserController::class)->group(function () {
        Route::prefix('admin')->group(function () {
            Route::name('admin.')->group(function () {
                Route::get('/manage-user', 'index')->name('manage-user');
                Route::delete('/manage-user/delete/{id}', 'delete')->name('manage-user.delete');
            });
        });
    });
});
Route::middleware(['admin'])->group(function () {
    Route::controller(AktifasiController::class)->group(function () {
        Route::prefix('admin')->group(function () {
            Route::name('admin.')->group(function () {
                Route::get('/aktifasi', 'index')->name('aktifasi');
                Route::patch('/aktifasi/akun', 'aktifkan')->name('aktifkan');
            });
        });
    });
});
Route::middleware(['admin'])->group(function () {
    Route::controller(ManageMemberController::class)->group(function () {
        Route::prefix('admin')->group(function () {
            Route::name('admin.')->group(function () {
                Route::get('/member', 'index')->name('member');
                Route::patch('/member/nonaktif', 'nonaktif')->name('nonaktif');
            });
        });
    });
});
Route::middleware(['admin'])->group(function () {
    Route::controller(PeminjamanController::class)->group(function () {
        Route::prefix('admin')->group(function () {
            Route::name('admin.')->group(function () {
                Route::get('/peminjaman', 'index')->name('peminjaman');
                Route::patch('/peminjaman/selesai', 'selesai')->name('selesai');
            });
        });
    });
});

                                                                