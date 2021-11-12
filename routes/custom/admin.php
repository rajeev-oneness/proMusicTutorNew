<?php

	namespace App\Http\Controllers\Admin;
	use Illuminate\Support\Facades\Route;
	use App\Http\Controllers\ReportController;

	Route::get('dashboard',[AdminController::class,'dashboard'])->name('home');

	Route::group(['prefix'=>'users'],function(){
		Route::get('/tutors',[CrudController::class,'getUsers'])->name('admin.users');
		Route::get('/students',[CrudController::class,'getStudents'])->name('admin.users.students');
		Route::get('/create',[CrudController::class,'createUser'])->name('admin.user.create');
		Route::post('/save',[CrudController::class,'saveUser'])->name('admin.user.save');
		// Route::get('/{id}/edit',[CrudController::class,'editUser'])->name('admin.user.edit');
		Route::get('/{id}/edit',[CrudController::class,'editUser'])->name('admin.user.edit');
		Route::post('/update',[CrudController::class,'updateUser'])->name('admin.user.update');
		Route::post('/manage',[CrudController::class,'manageUser'])->name('admin.user.manageUser');
	});

	Route::get('referred_to/user/{userId}',[CrudController::class,'getReferredToList'])->name('admin.referral.referred_to');
	Route::get('user/points/{userId}',[CrudController::class,'getUserPoints'])->name('admin.user.points');

	// Instruments
	Route::group(['prefix' => 'master/instrument'],function(){
		Route::get('/list',[CrudController::class,'instrument'])->name('admin.master.instrument.list');
		Route::get('/create',[CrudController::class,'instrumentCreate'])->name('admin.master.instrument.create');
		Route::post('/store',[CrudController::class,'instrumentStore'])->name('admin.master.instrument.save');
		Route::get('/{id}/edit',[CrudController::class,'instrumentEdit'])->name('admin.master.instrument.edit');
		Route::post('/{id}/update',[CrudController::class,'instrumentUpdate'])->name('admin.master.instrument.update');
		Route::post('/{id}/delete',[CrudController::class,'instrumentDelete'])->name('admin.master.instrument.delete');
	});

	// category
	Route::group(['prefix' => 'master/category'],function(){
		Route::get('/list',[CrudController::class,'category'])->name('admin.master.category.list');
		Route::get('/create',[CrudController::class,'categoryCreate'])->name('admin.master.category.create');
		Route::post('/store',[CrudController::class,'categoryStore'])->name('admin.master.category.save');
		Route::get('/{id}/edit',[CrudController::class,'categoryEdit'])->name('admin.master.category.edit');
		Route::post('/{id}/update',[CrudController::class,'categoryUpdate'])->name('admin.master.category.update');
		Route::post('/{id}/delete',[CrudController::class,'categoryDelete'])->name('admin.master.category.delete');
	});

	// Subscription
	Route::group(['prefix' => 'master/subscription'],function(){
		Route::get('list',[CrudController::class,'subscriptionList'])->name('admin.master.subscription.list');
		Route::get('create',[CrudController::class,'subscriptionCreate'])->name('admin.master.subscription.create');
		Route::post('store',[CrudController::class,'subscriptionStore'])->name('admin.master.subscription.save');
		Route::get('{id}/edit',[CrudController::class,'subscriptionEdit'])->name('admin.master.subscription.edit');
		Route::post('{id}/update',[CrudController::class,'subscriptionUpdate'])->name('admin.master.subscription.update');
		Route::post('delete',[CrudController::class,'subscriptionDelete'])->name('admin.master.subscription.delete');
	});

	// Offers
	Route::group(['prefix' => 'offers'],function(){
		Route::get('/list',[CrudController::class,'offersList'])->name('admin.offer.list');
		Route::get('/create',[CrudController::class,'offerCreate'])->name('admin.offer.create');
		Route::post('/store',[CrudController::class,'offerStore'])->name('admin.offer.save');
		Route::get('/{id}/edit',[CrudController::class,'offerEdit'])->name('admin.offer.edit');
		Route::post('/{id}/update',[CrudController::class,'offerUpdate'])->name('admin.offer.update');
		Route::post('delete',[CrudController::class,'offerDelete'])->name('admin.offer.delete');
	});

	// Genre
	Route::group(['prefix' => 'master/genre'],function() {
		Route::get('/list', [CrudController::class, 'genreIndex'])->name('admin.master.genre.list');
		Route::get('/create', [CrudController::class, 'genreCreate'])->name('admin.master.genre.create');
		Route::post('/save', [CrudController::class, 'genreSave'])->name('admin.master.genre.save');
		Route::get('/{id}/edit', [CrudController::class, 'genreEdit'])->name('admin.master.genre.edit');
		Route::post('/{id}/update', [CrudController::class, 'genreUpdate'])->name('admin.master.genre.update');
		Route::post('/{id}/delete', [CrudController::class, 'genreDelete'])->name('admin.master.genre.delete');
	});

	// Product Series and Their Lession
    Route::group(['prefix' => 'instrument/{instrumentId}/product/series'],function(){
        Route::get('/',[AdminController::class,'productSeriesList'])->name('admin.product.series.list');
        Route::get('/create',[AdminController::class,'productSeriesCreate'])->name('admin.product.series.create');
        Route::post('/save',[AdminController::class,'productSeriesSave'])->name('admin.product.series.save');
        Route::get('/{id}/edit',[AdminController::class,'productSeriesEdit'])->name('admin.product.series.edit');
        Route::post('/{id}/update',[AdminController::class,'productSeriesUpdate'])->name('admin.product.series.update');
        Route::post('/delete',[AdminController::class,'productSeriesDelete'])->name('admin.product.series.delete');

        Route::group(['prefix' => '{productSeriesId}/lession'],function(){
            Route::get('/',[AdminController::class,'productSeriesLessionList'])->name('admin.product.series.lession.list');
            Route::get('/create',[AdminController::class,'productSeriesLessionCreate'])->name('admin.product.series.lession.create');
            Route::post('/save',[AdminController::class,'productSeriesLessionSave'])->name('admin.product.series.lession.save');
            Route::get('/{id}/edit',[AdminController::class,'productSeriesLessionEdit'])->name('admin.product.series.lession.edit');
            Route::post('/{id}/update',[AdminController::class,'productSeriesLessionUpdate'])->name('admin.product.series.lession.update');
            Route::post('delete',[AdminController::class,'productSeriesLessionDelete'])->name('admin.product.series.lession.delete');
        });
    });

	// Reports
	Route::group(['prefix' => 'report'],function(){
		Route::get('contact-us',[CrudController::class,'contactUs'])->name('admin.report.contactus');
		Route::post('contact-us/remark/save',[CrudController::class,'saveRemarkOfContactUs'])->name('admin.report.contactUsSaveRemark');
		Route::any('sales/log',[ReportController::class,'transactionLog'])->name('admin.report.transaction');
		Route::any('best-seller',[ReportController::class,'bestSeller'])->name('admin.report.bestSeller');
		Route::any('most-viewed',[ReportController::class,'mostViewed'])->name('admin.report.mostViewed');
		Route::any('products-ordered',[ReportController::class,'productsOrdered'])->name('admin.report.productsOrdered');
		Route::any('wishlist',[ReportController::class,'wishlistCount'])->name('admin.report.wishlistReport');
		Route::any('user/notifications',[ReportController::class,'userNotification'])->name('admin.report.user.notification');
	});

	Route::group(['prefix' => 'blog/category'],function(){
		Route::get('list',[CrudController::class,'adminBlogCategory'])->name('admin.blog.category.list');
		Route::post('/save',[CrudController::class,'saveBlogCategory'])->name('admin.blog.category.save');
		Route::post('/update',[CrudController::class,'updateBlogCategory'])->name('admin.blog.category.update');
		Route::post('/{id}/delete', [CrudController::class,'deleteBlogCategory'])->name('admin.blog.category.delete');
	});

	Route::group(['prefix' => 'blog/tag'],function(){
		Route::get('list',[CrudController::class,'adminBlogsTag'])->name('admin.blog.tag.list');
		Route::post('/save',[CrudController::class,'saveBlogTag'])->name('admin.blog.tag.save');
		Route::post('/update',[CrudController::class,'updateBlogTag'])->name('admin.blog.tag.update');
		Route::post('/{id}/delete', [CrudController::class,'deleteBlogTag'])->name('admin.blog.tag.delete');
	});

	Route::group(['prefix' => 'blogs'],function(){
		Route::get('list',[CrudController::class,'adminBlogs'])->name('admin.blog.data.list');
		Route::get('create',[CrudController::class,'adminBlogsCreate'])->name('admin.blog.data.create');
		Route::post('create',[CrudController::class,'adminBlogsStore'])->name('admin.blog.data.save');
		Route::get('{blogId}/edit',[CrudController::class,'adminBlogsEdit'])->name('admin.blog.data.edit');
		Route::post('{blogId}/update',[CrudController::class,'adminBlogsUpdate'])->name('admin.blog.data.update');
		Route::post('{blogId}/delete',[CrudController::class,'adminBlogsDelete'])->name('admin.blog.data.delete');
		Route::get('{blogId}/comment',[CrudController::class, 'viewBlogComments'])->name('admin.blog.data.comment');
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
