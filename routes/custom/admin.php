<?php

	namespace App\Http\Controllers\Admin;
	use Illuminate\Support\Facades\Route;

	Route::get('dashboard',function(){
		return view('admin.dashboard');
	})->name('home');

	Route::group(['prefix'=>'users'],function(){
		Route::get('/',[CrudController::class,'getUsers'])->name('admin.users');
		Route::get('/create',[CrudController::class,'createUser'])->name('admin.user.create');
		Route::post('/save',[CrudController::class,'saveUser'])->name('admin.user.save');
		Route::post('/manage',[CrudController::class,'manageUser'])->name('admin.user.manageUser');
	});

	Route::get('referred_to/user/{userId}',[CrudController::class,'getReferredToList'])->name('admin.referral.referred_to');
	Route::get('user/points/{userId}',[CrudController::class,'getUserPoints'])->name('admin.user.points');

	// Instruments
	Route::group(['prefix' => 'instrument'],function(){
		Route::get('/',[CrudController::class,'instrument'])->name('admin.instrument');
		Route::get('/create',[CrudController::class,'instrumentCreate'])->name('admin.instrument.create');
		Route::post('/store',[CrudController::class,'instrumentStore'])->name('admin.instrument.save');
		Route::get('/{id}/edit',[CrudController::class,'instrumentEdit'])->name('admin.instrument.edit');
		Route::post('/{id}/update',[CrudController::class,'instrumentUpdate'])->name('admin.instrument.update');
		Route::post('/{id}/delete',[CrudController::class,'instrumentDelete'])->name('admin.instrument.delete');
	});

	// Guitar category
	Route::group(['prefix' => 'guitar/category'],function(){
		Route::get('/',[CrudController::class,'guitarCategory'])->name('admin.guitar.category');
		Route::get('/create',[CrudController::class,'guitarCategoryCreate'])->name('admin.guitar.category.create');
		Route::post('/store',[CrudController::class,'guitarCategoryStore'])->name('admin.guitar.category.save');
		Route::get('/{id}/edit',[CrudController::class,'guitarCategoryEdit'])->name('admin.guitar.category.edit');
		Route::post('/{id}/update',[CrudController::class,'guitarCategoryUpdate'])->name('admin.guitar.category.update');
		Route::post('/{id}/delete',[CrudController::class,'guitarCategoryDelete'])->name('admin.guitar.category.delete');
	});

	// Genre
	Route::group(['prefix' => 'genre'],function(){
		Route::get('/',[CrudController::class, 'genreIndex'])->name('admin.genre');
		Route::get('/create',[CrudController::class, 'genreCreate'])->name('admin.genre.create');
		Route::post('/save',[CrudController::class, 'genreSave'])->name('admin.genre.save');
		Route::get('/{id}/edit',[CrudController::class, 'genreEdit'])->name('admin.genre.edit');
		// Route::get('/create',[CrudController::class,'guitarCategoryCreate'])->name('admin.guitar.category.create');
		// Route::post('/store',[CrudController::class,'guitarCategoryStore'])->name('admin.guitar.category.save');
		// Route::get('/{id}/edit',[CrudController::class,'guitarCategoryEdit'])->name('admin.guitar.category.edit');
		// Route::post('/{id}/update',[CrudController::class,'guitarCategoryUpdate'])->name('admin.guitar.category.update');
		// Route::post('/{id}/delete',[CrudController::class,'guitarCategoryDelete'])->name('admin.guitar.category.delete');
	});

	// Guitar Series and Their Lession
	Route::group(['prefix' => 'guitar/series'],function(){
		Route::get('/list',[AdminController::class,'guitarSeriesList'])->name('admin.guitar.series.view');
		Route::group(['prefix' => '{seriesId}/lession'],function(){
			Route::get('/list',[AdminController::class,'guitarLessionList'])->name('admin.guitar.series.lession.view');
		});
	});

	// Reports
	Route::group(['prefix' => 'report'],function(){
		Route::get('contact-us',[CrudController::class,'contactUs'])->name('admin.report.contactus');
		Route::post('contact-us/remark/save',[CrudController::class,'saveRemarkOfContactUs'])->name('admin.report.contactUsSaveRemark');
	});

	// Testimonials
	Route::group(['prefix'=>'testimonial'],function(){
		Route::get('/',[CrudController::class,'testimonials'])->name('admin.testimonial');
		Route::get('/create',[CrudController::class,'createTestimonial'])->name('admin.testimonial.create');
		Route::post('/save', [CrudController::class,'saveTestimonial'])->name('admin.testimonial.save');
		Route::get('/{id}/edit',[CrudController::class,'editTestimonial'])->name('admin.testimonial.edit');
		Route::post('/update',[CrudController::class,'updateTestimonial'])->name('admin.testimonial.update');
		Route::post('/{id}/delete', [CrudController::class,'deleteTestimonial'])->name('admin.testimonial.delete');
	});

	// Faqs
	Route::group(['prefix' => 'faq'],function(){
		Route::get('/',[CrudController::class,'faq'])->name('admin.faq');
		Route::get('/create',[CrudController::class,'createFaq'])->name('admin.faq.create');
		Route::post('/save', [CrudController::class,'saveFaq'])->name('admin.faq.save');
		Route::get('/{id}/edit',[CrudController::class,'editFaq'])->name('admin.faq.edit');
		Route::post('/update',[CrudController::class,'updateFaq'])->name('admin.faq.update');
		Route::post('/{id}/delete', [CrudController::class,'deleteFaq'])->name('admin.faq.delete');
	});

	// Setting
	Route::group(['prefix' => 'setting'],function(){
		Route::get('policy',[CrudController::class,'policyData'])->name('admin.setting.policy');
		Route::get('policy/{policyId}/edit',[CrudController::class,'policyDataEdit'])->name('admin.setting.policy.edit');
		Route::post('policy/{policyId}/update',[CrudController::class,'policyDataUpdate'])->name('admin.setting.policy.update');
		Route::get('contact-us',[CrudController::class,'contactUsSetting'])->name('admin.setting.contact');
		Route::post('contact-us/{contactId}/update',[CrudController::class,'contactUsSettingUpdate'])->name('admin.setting.contact.update');
		Route::get('about-us',[CrudController::class,'aboutUsSetting'])->name('admin.setting.aboutus');
		Route::post('about-us/{settingId}/update',[CrudController::class,'aboutUsSettingUpdate'])->name('admin.setting.aboutus.update');
		Route::get('how-It-Works',[CrudController::class,'howItWorksSetting'])->name('admin.setting.howitWorks');
		Route::get('how-It-Works/{settingId}/edit',[CrudController::class,'howItWorksDataEdit'])->name('admin.setting.howitWorks.edit');
		Route::post('how-It-Works/{settingId}/update',[CrudController::class,'howItWorksSettingUpdate'])->name('admin.setting.howitWorks.update');
	});
	
?>