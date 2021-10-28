<?php
    namespace App\Http\Controllers\Tutor;
    use Illuminate\Support\Facades\Route;

    Route::any('dashboard',[TutorController::class,'dashboard'])->name('home');

    // Product Series and Their Lession
    Route::group(['prefix' => 'instrument/{instrumentId}/product/series'],function(){
        Route::get('/',[ProductController::class,'productSeriesView'])->name('tutor.product.series.list');
        Route::get('/create',[ProductController::class,'productSeriesCreate'])->name('tutor.product.series.create');
        Route::post('/save',[ProductController::class,'productSeriesSave'])->name('tutor.product.series.save');
        Route::get('/{id}/edit',[ProductController::class,'productSeriesEdit'])->name('tutor.product.series.edit');
        Route::post('/{id}/update',[ProductController::class,'productSeriesUpdate'])->name('tutor.product.series.update');
        Route::post('/delete',[ProductController::class,'productSeriesDelete'])->name('tutor.product.series.delete');

        Route::group(['prefix' => '{productSeriesId}/lession'],function(){
            Route::get('/',[ProductController::class,'productSeriesLessionView'])->name('tutor.product.series.lession.list');
            Route::get('/create',[ProductController::class,'productSeriesLessionCreate'])->name('tutor.product.series.lession.create');
            Route::post('/save',[ProductController::class,'productSeriesLessionSave'])->name('tutor.product.series.lession.save');
            Route::get('/{id}/edit',[ProductController::class,'productSeriesLessionEdit'])->name('tutor.product.series.lession.edit');
            Route::post('/{id}/update',[ProductController::class,'productSeriesLessionUpdate'])->name('tutor.product.series.lession.update');
            Route::post('delete',[ProductController::class,'productSeriesLessionDelete'])->name('tutor.product.series.lession.delete');
        });
    });

    // Offers
    Route::group(['prefix' => 'offers'],function(){
        Route::get('/list',[TutorController::class,'offersList'])->name('tutor.offer.list');
        Route::get('/create',[TutorController::class,'offerCreate'])->name('tutor.offer.create');
        Route::post('/store',[TutorController::class,'offerStore'])->name('tutor.offer.save');
        Route::get('/{id}/edit',[TutorController::class,'offerEdit'])->name('tutor.offer.edit');
        Route::post('/{id}/update',[TutorController::class,'offerUpdate'])->name('tutor.offer.update');
        Route::post('delete',[TutorController::class,'offerDelete'])->name('tutor.offer.delete');
    });
?>