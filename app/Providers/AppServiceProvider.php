<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\ContactUs;
use App\Models\Notification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer('*', function ($view) {
            $notificationAppService = (object)[];
            $notificationAppService->totalNewNotificationCount = 0;
            $notificationAppService->limit_notification = [];
            if ($user = auth()->user()) {
                $view->with('user', $user);
                $notificationTableCheck = \Schema::hasTable('notifications');
                if($notificationTableCheck){
                    // $notificationAppService->limit_notification = Notification::select('*')->where('userId',$user->id)->latest()->limit(50)->get();
                    // $notificationAppService->totalNewNotificationCount = Notification::select('*')->where('userId',$user->id)->where('read',0)->latest()->count();
                }
            }
            $contactAppService = $this->contactData();
            $contactUsTableCheck = \Schema::hasTable('contact_us');
            if ($contactUsTableCheck) {
                $contactAppService = ContactUs::where('id', 1)->first();
                if (!$contactAppService) $contactAppService = $this->contactData();
            }
            $view->with('contact', $contactAppService);
            $view->with('notificationAppService',$notificationAppService);
        });
        Paginator::useBootstrap();
    }

    public function contactData()
    {
        $contact = (object)[];
        $contact->type = 1;
        $contact->name = "Headquarters";
        $contact->address = "5/13 Fielden Way, Port Kennedy,WA, 6172, Dummy location";
        $contact->phone = "[88] 657 524 332";
        $contact->email = "info@example.com";
        $contact->image = "design/img/pic-1.png";
        $contact->facebook = "https://www.facebook.com";
        $contact->linkedin = "https://www.linkedin.com";
        $contact->youtube = "https://www.youtube.com";
        return $contact;
    }
}
