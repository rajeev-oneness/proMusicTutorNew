<?php
    namespace App\Http\Controllers\Tutor;
    use Illuminate\Support\Facades\Route;

    Route::get('dashboard',function(){return view('tutor.dashboard');})->name('home');

    // Guitar Series and Their Lession
    Route::group(['prefix' => 'product/series'],function(){
        Route::get('/',[TutorController::class,'productSeriesView'])->name('tutor.product.series');
        Route::get('/create',[TutorController::class,'productSeriesCreate'])->name('tutor.product.series.create');
        Route::post('/save',[TutorController::class,'productSeriesSave'])->name('tutor.product.series.save');
        Route::get('/{id}/edit',[TutorController::class,'productSeriesEdit'])->name('tutor.product.series.edit');
        Route::post('/{id}/update',[TutorController::class,'productSeriesUpdate'])->name('tutor.product.series.update');
        Route::post('/{id}/delete',[TutorController::class,'productSeriesDelete'])->name('tutor.product.series.delete');

        Route::group(['prefix' => 'product/series/{productSeriesId}/lession'],function(){
            Route::get('/',[TutorController::class,'productSeriesLessionView'])->name('tutor.product.series.lession');
            Route::get('/create',[TutorController::class,'productSeriesLessionCreate'])->name('tutor.product.series.lession.create');
            Route::post('/save',[TutorController::class,'productSeriesLessionSave'])->name('tutor.product.series.lession.save');
            Route::get('/{id}/edit',[TutorController::class,'productSeriesLessionEdit'])->name('tutor.product.series.lession.edit');
            Route::post('/{id}/update',[TutorController::class,'productSeriesLessionUpdate'])->name('tutor.product.series.lession.update');
            Route::post('/{id}/delete',[TutorController::class,'productSeriesLessionDelete'])->name('tutor.product.series.lession.delete');
        });
    });
?>