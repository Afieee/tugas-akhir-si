<?php

use App\Http\Controllers\KuisionerController;
use App\Http\Controllers\Management\DosenController;
use App\Http\Controllers\Management\MahasiswaController;
use App\Http\Controllers\Management\SekretariatController;
use App\Http\Controllers\Masterdata\JurusanController;
use App\Http\Controllers\Masterdata\KuisionerController as MasterdataKuisionerController;
use App\Http\Controllers\Masterdata\ResponKuisionerController as MasterdataResponKuisionerController;
use App\Http\Controllers\Masterdata\MatakuliahController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PerwalianController;
use App\Http\Controllers\VerifikasiPerwalianController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::post('/audit-trail', [App\Http\Controllers\HomeController::class, 'auditTrail'])->name('audit-trail');

Route::middleware('role:mahasiswa')->group(function () {
    Route::post('/trend-nilai', [App\Http\Controllers\HomeController::class, 'trendNilai'])->name('trend-nilai');
    Route::prefix('perwalian')->name('perwalian.')->group(function () {
        Route::get('/', [PerwalianController::class, 'index'])->name('index');
        Route::post('/kirim', [PerwalianController::class, 'kirim'])->name('kirim');
        Route::delete('/matkul/delete/{id}', [PerwalianController::class, 'deleteMatkul'])->name('delete.matkul');
    });
    Route::prefix('nilai')->name('nilai.')->group(function () {
        Route::get('/', [PenilaianController::class, 'indexMahasiswa'])->name('index');
    });
    Route::prefix('kuisioner')->name('kuisioner.')->group(function () {
        Route::get('/', [KuisionerController::class, 'indexMahasiswa'])->name('index');
        Route::post('/json', [KuisionerController::class, 'indexJson'])->name('json');
        Route::get('/pengisian/{id}', [KuisionerController::class, 'pengisian'])->name('pengisian');
        Route::post('/kirim/{id}', [KuisionerController::class, 'kirim'])->name('kirim');
    });
});

Route::middleware('role:sekretariat')->group(function () {
    Route::post('/sync-semester', [MahasiswaController::class, 'syncSemester'])->name('syncSemester');
    Route::prefix('validasi-perwalian')->name('validasi-perwalian.')->group(function () {
        Route::get('/', [VerifikasiPerwalianController::class, 'index'])->name('index');
        Route::post('/json', [VerifikasiPerwalianController::class, 'indexJson'])->name('json');
        Route::post('/validasi/{id}', [VerifikasiPerwalianController::class, 'validasi'])->name('validasi');
        Route::post('/tolak/{id}', [VerifikasiPerwalianController::class, 'tolak'])->name('tolak');
    });

    Route::prefix('management')->name('management.')->group(function () {
        Route::prefix('sekretariat')->name('sekretariat.')->group(function () {
            Route::get('/', [SekretariatController::class, 'index'])->name('index');
            Route::get('/detail/{id}', [SekretariatController::class, 'detail'])->name('detail');
            Route::post('/json', [SekretariatController::class, 'json'])->name('json');
            Route::post('/update/{id}', [SekretariatController::class, 'update'])->name('update');
            Route::post('/store', [SekretariatController::class, 'store'])->name('store');
            Route::delete('/delete/{id}', [SekretariatController::class, 'delete'])->name('delete');
        });

        Route::prefix('dosen')->name('dosen.')->group(function () {
            Route::get('/', [DosenController::class, 'index'])->name('index');
            Route::get('/detail/{id}', [DosenController::class, 'detail'])->name('detail');
            Route::post('/json', [DosenController::class, 'json'])->name('json');
            Route::post('/update/{id}', [DosenController::class, 'update'])->name('update');
            Route::post('/store', [DosenController::class, 'store'])->name('store');
            Route::delete('/delete/{id}', [DosenController::class, 'delete'])->name('delete');
        });

        Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
            Route::get('/', [MahasiswaController::class, 'index'])->name('index');
            Route::get('/detail/{id}', [MahasiswaController::class, 'detail'])->name('detail');
            Route::post('/json', [MahasiswaController::class, 'json'])->name('json');
            Route::post('/update/{id}', [MahasiswaController::class, 'update'])->name('update');
            Route::post('/store', [MahasiswaController::class, 'store'])->name('store');
            Route::delete('/delete/{id}', [MahasiswaController::class, 'delete'])->name('delete');
        });
    });

    Route::prefix('masterdata')->name('masterdata.')->group(function () {
        Route::prefix('kuisioner')->name('kuisioner.')->group(function () {
            Route::get('/', [MasterdataKuisionerController::class, 'index'])->name('index');
            Route::get('/detail/{id}', [MasterdataKuisionerController::class, 'detail'])->name('detail');
            Route::post('/json', [MasterdataKuisionerController::class, 'json'])->name('json');
            Route::post('/update/{id}', [MasterdataKuisionerController::class, 'update'])->name('update');
            Route::post('/store', [MasterdataKuisionerController::class, 'store'])->name('store');
            Route::delete('/delete/{id}', [MasterdataKuisionerController::class, 'delete'])->name('delete');
        });

        Route::prefix('respon-kuisioner')->name('respon-kuisioner.')->group(function () {
            Route::get('/', [MasterdataResponKuisionerController::class, 'index'])->name('index');
            Route::get('/detail/{id}', [MasterdataResponKuisionerController::class, 'detail'])->name('detail');
            Route::post('/json', [MasterdataResponKuisionerController::class, 'json'])->name('json');
            Route::post('/update/{id}', [MasterdataResponKuisionerController::class, 'update'])->name('update');
            Route::post('/store', [MasterdataResponKuisionerController::class, 'store'])->name('store');
            Route::delete('/delete/{id}', [MasterdataResponKuisionerController::class, 'delete'])->name('delete');
        });

        Route::prefix('jurusan')->name('jurusan.')->group(function () {
            Route::get('/', [JurusanController::class, 'index'])->name('index');
            Route::get('/detail/{id}', [JurusanController::class, 'detail'])->name('detail');
            Route::post('/json', [JurusanController::class, 'json'])->name('json');
            Route::post('/update/{id}', [JurusanController::class, 'update'])->name('update');
            Route::post('/store', [JurusanController::class, 'store'])->name('store');
            Route::delete('/delete/{id}', [JurusanController::class, 'delete'])->name('delete');
        });

        Route::prefix('matakuliah')->name('matakuliah.')->group(function () {
            Route::get('/', [MatakuliahController::class, 'index'])->name('index');
            Route::get('/detail/{id}', [MatakuliahController::class, 'detail'])->name('detail');
            Route::post('/json', [MatakuliahController::class, 'json'])->name('json');
            Route::post('/update/{id}', [MatakuliahController::class, 'update'])->name('update');
            Route::post('/store', [MatakuliahController::class, 'store'])->name('store');
            Route::delete('/delete/{id}', [MatakuliahController::class, 'delete'])->name('delete');
        });
    });
});

Route::middleware('role:dosen')->group(function () {
    Route::prefix('penilaian')->name('penilaian.')->group(function () {
        Route::get('/', [PenilaianController::class, 'index'])->name('index');
        Route::get('/detail/{id}', [PenilaianController::class, 'detail'])->name('detail');
        Route::get('/detail-nilai/{id}', [PenilaianController::class, 'detailNilai'])->name('detail-nilai');
        Route::post('/json', [PenilaianController::class, 'json'])->name('json');
        Route::post('/submit/{id_detail_perwalian}', [PenilaianController::class, 'submit'])->name('submit');
    });
    Route::prefix('kuisioner')->name('kuisioner.')->group(function () {
        Route::get('/index-dosen', [KuisionerController::class, 'indexDosen'])->name('index-dosen');
        Route::get('/detail/{id}', [KuisionerController::class, 'detail'])->name('detail');
        Route::post('/index-dosen/json', [KuisionerController::class, 'indexDosenJson'])->name('index-dosen.json');
    });
});

Route::middleware('role:dosen,mahasiswa')->group(function () {
    Route::prefix('penilaian')->name('penilaian.')->group(function () {
        Route::get('/', [PenilaianController::class, 'index'])->name('index');
        Route::get('/detail/{id}', [PenilaianController::class, 'detail'])->name('detail');
        Route::get('/detail-nilai/{id}', [PenilaianController::class, 'detailNilai'])->name('detail-nilai');
        Route::post('/json', [PenilaianController::class, 'json'])->name('json');
        Route::post('/submit/{id_detail_perwalian}', [PenilaianController::class, 'submit'])->name('submit');
    });
    Route::prefix('kuisioner')->name('kuisioner.')->group(function () {
        Route::get('/detail/{id}', [KuisionerController::class, 'detail'])->name('detail');
    });
});
