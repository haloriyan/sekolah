<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\CopywritingController;
use App\Http\Controllers\EkskulController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SarprasController;
use App\Http\Controllers\SlideshowController;
use App\Http\Controllers\UnduhanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('index');
Route::get('sejarah', [PageController::class, 'sejarah'])->name('page.sejarah');
Route::get('unduhan', [PageController::class, 'unduhan'])->name('page.unduhan');
Route::post('unduhan/download', [UnduhanController::class, 'download'])->name('unduhan.download');
Route::get('sambutan-kepala-sekolah', [PageController::class, 'sambutanKepsek'])->name('page.sambutanKepsek');
Route::get('visi-misi', [PageController::class, 'visiMisi'])->name('page.visiMisi');
Route::get('jurusan/{slug}', [PageController::class, 'jurusan'])->name('page.jurusan');
Route::get('ekstrakurikuler/{slug}', [PageController::class, 'ekskul'])->name('page.ekskul');
Route::get('sarana-prasarana/{slug}', [PageController::class, 'sarpras'])->name('page.sarpras');
Route::get('guru-tenaga-kependidikan', [PageController::class, 'gtk'])->name('page.gtk');

// Route::get('install', [AdminController::class, 'install']);
Route::group(['prefix' => "install"], function () {
    Route::group(['prefix' => "{step}"], function () {
        Route::post('run', [InstallController::class, 'run'])->name('install.run');
        Route::get('/', [InstallController::class, 'render'])->name('install');
    });
    Route::get('/', function () {
        if (env('APP_INSTALLED')) {
            return redirect()->route('install', 'done');
        } else {
            return redirect()->route('install', 'start');
        }
    });
});

Route::get('berita', [PageController::class, 'news'])->name('page.news');
Route::get('berita/{slug}', [PageController::class, 'readNews'])->name('news.read');
Route::get('galeri', [PageController::class, 'galeri'])->name('page.galeri');
Route::get('galeri/{slug}', [PageController::class, 'galeriDetail'])->name('page.galeri.detail');
Route::get('unduhan', [PageController::class, 'unduhan'])->name('page.unduhan');
Route::get('alumni', [PageController::class, 'alumni'])->name('page.alumni');

Route::group(['prefix' => "admin"], function () {
    Route::match(['get', 'post'], 'login', [AdminController::class, 'login'])->name('admin.login');
    Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::middleware(['admin'])->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('backup', [BackupController::class, 'backup'])->name('admin.backup');
        Route::post('restore', [BackupController::class, 'restore'])->name('admin.restore');

        Route::group(['prefix' => "copywriting"], function () {
            Route::post('update', [CopywritingController::class, 'update'])->name('admin.copywriting.update');
        });

        Route::group(['prefix' => "berita"], function () {
            Route::get('/', [AdminController::class, 'news'])->name('admin.content.news');
            Route::get('tulis', [NewsController::class, 'create'])->name('admin.content.news.create');
            Route::post('store', [NewsController::class, 'store'])->name('admin.content.news.store');
            Route::get('/{id}/edit', [NewsController::class, 'edit'])->name('admin.content.news.edit');
            Route::post('/{id}/update', [NewsController::class, 'update'])->name('admin.content.news.update');
            Route::post('delete', [NewsController::class, 'delete'])->name('admin.content.news.delete');
        });

        Route::group(['prefix' => "content"], function () {
            Route::get('visi-misi', [AdminController::class, 'visiMisi'])->name('admin.content.visiMisi');
            Route::get('sejarah', [AdminController::class, 'sejarah'])->name('admin.content.sejarah');
            Route::get('sambutan-kepala-sekolah', [AdminController::class, 'sambutanKepsek'])->name('admin.content.sambutanKepsek');
        });

        Route::group(['prefix' => "guru"], function () {
            Route::post('store', [GuruController::class, 'store'])->name('admin.master.guru.store');
            Route::post('update', [GuruController::class, 'update'])->name('admin.master.guru.update');
            Route::post('delete', [GuruController::class, 'delete'])->name('admin.master.guru.delete');
            Route::get('/', [AdminController::class, 'guru'])->name('admin.master.guru');
        });
        Route::group(['prefix' => "alumni"], function () {
            Route::post('store', [AlumniController::class, 'store'])->name('admin.master.alumni.store');
            Route::post('update', [AlumniController::class, 'update'])->name('admin.master.alumni.update');
            Route::post('delete', [AlumniController::class, 'delete'])->name('admin.master.alumni.delete');
            Route::get('/', [AdminController::class, 'alumni'])->name('admin.master.alumni');
        });
        Route::group(['prefix' => "ekstrakurikuler"], function () {
            Route::get('create', [EkskulController::class, 'create'])->name('admin.master.ekskul.create');
            Route::post('store', [EkskulController::class, 'store'])->name('admin.master.ekskul.store');
            Route::get('{id}/edit', [EkskulController::class, 'edit'])->name('admin.master.ekskul.edit');
            Route::post('{id}/update', [EkskulController::class, 'update'])->name('admin.master.ekskul.update');
            Route::post('delete', [EkskulController::class, 'delete'])->name('admin.master.ekskul.delete');
            Route::get('/', [AdminController::class, 'ekskul'])->name('admin.master.ekskul');
        });
        Route::group(['prefix' => "jurusan"], function () {
            Route::get('create', [JurusanController::class, 'create'])->name('admin.master.jurusan.create');
            Route::post('store', [JurusanController::class, 'store'])->name('admin.master.jurusan.store');
            Route::get('{id}/edit', [JurusanController::class, 'edit'])->name('admin.master.jurusan.edit');
            Route::post('{id}/update', [JurusanController::class, 'update'])->name('admin.master.jurusan.update');
            Route::post('delete', [JurusanController::class, 'delete'])->name('admin.master.jurusan.delete');
            Route::get('/', [AdminController::class, 'jurusan'])->name('admin.master.jurusan');
        });
        Route::group(['prefix' => "sarana-prasarana"], function () {
            Route::get('create', [SarprasController::class, 'create'])->name('admin.master.sarpras.create');
            Route::post('store', [SarprasController::class, 'store'])->name('admin.master.sarpras.store');
            Route::get('{id}/edit', [SarprasController::class, 'edit'])->name('admin.master.sarpras.edit');
            Route::post('{id}/update', [SarprasController::class, 'update'])->name('admin.master.sarpras.update');
            Route::post('delete', [SarprasController::class, 'delete'])->name('admin.master.sarpras.delete');
            Route::get('/', [AdminController::class, 'sarpras'])->name('admin.master.sarpras');
        });

        Route::group(['prefix' => "unduhan"], function () {
            Route::post('store', [UnduhanController::class, 'store'])->name('admin.master.unduhan.store');
            Route::post('update', [UnduhanController::class, 'update'])->name('admin.master.unduhan.update');
            Route::post('delete', [UnduhanController::class, 'delete'])->name('admin.master.unduhan.delete');
            Route::get('/', [AdminController::class, 'unduhan'])->name('admin.master.unduhan');
        });

        Route::group(['prefix' => "galeri"], function () {
            Route::post('store', [GalleryController::class, 'store'])->name('admin.master.galeri.store');
            
            Route::group(['prefix' => "image"], function () {
                Route::post('store', [GalleryController::class, 'storeImage'])->name('admin.master.galeri.storeImage');
                Route::get('delete/{imageID}', [GalleryController::class, 'deleteImage'])->name('admin.master.galeri.deleteImage');
            });

            Route::post('delete', [GalleryController::class, 'delete'])->name('admin.master.galeri.delete');
            Route::group(['prefix' => "{id}"], function () {
                Route::get('detail', [GalleryController::class, 'detail'])->name('admin.master.galeri.detail');
            });
            Route::get('/', [AdminController::class, 'galeri'])->name('admin.master.galeri');
        });

        Route::group(['prefix' => "admin"], function () {
            Route::post('store', [AdminController::class, 'store'])->name('admin.master.admin.store');
            Route::post('update', [AdminController::class, 'update'])->name('admin.master.admin.update');
            Route::post('delete', [AdminController::class, 'delete'])->name('admin.master.admin.delete');
            Route::get('/', [AdminController::class, 'admin'])->name('admin.master.admin');
        });

        Route::group(['prefix' => "settings"], function () {
            Route::get('basic', [AdminController::class, 'basicSettings'])->name('admin.settings.basic');
            Route::post('basic/save', [AdminController::class, 'saveBasicSettings'])->name('admin.settings.basic.save');
            Route::get('backup', [AdminController::class, 'backup'])->name('admin.settings.backup');
            
            Route::group(['prefix' => "slideshow"], function () {
                Route::post('store', [SlideshowController::class, 'store'])->name('admin.settings.slideshow.store');
                Route::post('update', [SlideshowController::class, 'update'])->name('admin.settings.slideshow.update');
                Route::post('delete', [SlideshowController::class, 'delete'])->name('admin.settings.slideshow.delete');
                Route::get('{id}/priority/{action}', [SlideshowController::class, 'priority'])->name('admin.settings.slideshow.priority');
                Route::get('/', [AdminController::class, 'slideshow'])->name('admin.settings.slideshow');
            });
        });
    });
});