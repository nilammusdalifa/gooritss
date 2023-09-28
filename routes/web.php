<?php

use App\Http\Controllers\ComponentMaterialController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductionPlanController;
use Illuminate\Support\Facades\Route;

use function Termwind\render;

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

Route::get('/', [PageController::class, 'componentsAndMaterials']);

Route::controller(PageController::class)->group(function () {
    Route::name('page-')->group(function () {
        Route::prefix('page')->group(function () {
            Route::get('/component-raw-material', 'componentsAndMaterials')->name('component-raw-material');
            Route::get('/production-planning', 'productionPlanning')->name('production-planning');
        });
    });
});

Route::controller(ComponentMaterialController::class)->group(function () {
    Route::name('cm-')->group(function () {
        Route::prefix('cm')->group(function () {
            Route::get('/get-material', 'getMaterial')->name('get-material');
            Route::post('/insert-component', 'insertComponent')->name('insert-component');
            Route::post('/insert-material', 'insertMaterial')->name('insert-material');
        });
    });
});

Route::controller(ProductionPlanController::class)->group(function () {
    Route::name('pp-')->group(function () {
        Route::prefix('pp')->group(function () {
            Route::get('/get-car-components', 'getCarComponents')->name('get-car-components');
        });
    });
});
