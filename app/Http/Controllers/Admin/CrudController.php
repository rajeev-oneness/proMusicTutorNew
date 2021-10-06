<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User, App\Models\UserType;
use App\Models\ContactUs, App\Models\Faq;
use App\Models\Testimonial, App\Models\Setting;
use App\Models\Instrument, App\Models\Category;
use Carbon\Exceptions\Exception, Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash, App\Models\Genre;
use App\Models\SubscriptionPlan, App\Models\SubscriptionPlanFeature;
use App\Models\Offer;
use App\Models\OfferSeries;
use App\Models\ProductSeries;

class CrudController extends Controller
{
    /****************************** Users ******************************/
    public function getUsers(Request $req)
    {
        // $users = User::select('*')->where('user_type', '!=', 1)->orderBy('users.id', 'desc')->get();
        $users = User::select('*')->where('user_type', 2)->orderBy('users.id', 'desc')->get();
        return view('admin.user.index', compact('users'));
    }
    public function getStudents(Request $req)
    {
        $users = User::select('*')->where('user_type', 3)->orderBy('users.id', 'desc')->get();
        return view('admin.user.index', compact('users'));
    }

    public function manageUser(Request $req)
    {
        $rules = [
            'userId' => 'required|min:1|numeric',
            'action' => 'required|in:block,unblock,delete',
        ];
        $validator = validator()->make($req->all(), $rules);
        if (!$validator->fails()) {
            $user = User::find($req->userId);
            if ($user) {
                if ($req->action == 'block') {
                    $user->status = 0;
                    $user->save();
                } elseif ($req->action == 'unblock') {
                    $user->status = 1;
                    $user->save();
                } elseif ($req->action == 'delete') {
                    $user->delete();
                }
                return successResponse('status Updated Success', $user);
            }
            return errorResponse('Invalid User Id');
        }
        return errorResponse($validator->errors()->first());
    }

    public function createUser(Request $req)
    {
        $userType = UserType::orderBy('id', 'desc')->get();
        return view('admin.user.create', compact('userType'));
    }

    public function saveUser(Request $req)
    {
        $req->validate([
            'user_type' => 'required|min:1|numeric',
            'image' => '',
            'name' => 'required|max:255|string',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|digits:10|numeric',
            'referral' => 'string|nullable|exists:referrals,code',
        ]);
        DB::beginTransaction();
        try {
            $random = randomGenerator();
            $user = new User();
            $user->user_type = $req->user_type;
            $user->name = $req->name;
            $user->email = $req->email;
            $user->mobile = $req->mobile;
            if ($req->hasFile('image')) {
                $image = $req->file('image');
                $user->image = imageUpload($image);
            }
            $user->password = Hash::make($random);
            $user->save();
            $this->setReferralCode($user, $req->referral);
            DB::commit();
            // sendMail();
            return redirect(route('admin.users'))->with('Success', 'User Added SuccessFully');
        } catch (Exception $e) {
            DB::rollback();
            $errors['email'] = 'Something went wrong please try after sometime!';
            return back()->withErrors($errors)->withInput($req->all());
        }
    }

    /****************************** Contact Us ******************************/
    public function contactUs(Request $req)
    {
        $contactUs = ContactUs::where('id', '!=', 1)->orderBy('created_at', 'DESC')->get();
        return view('admin.reports.contact', compact('contactUs'));
    }

    public function saveRemarkOfContactUs(Request $req)
    {
        $req->validate([
            'contactUsId' => 'required|min:1|numeric',
            'remark' => 'required|max:200|string',
        ]);
        $contact = ContactUs::where('id', $req->contactUsId)->first();
        $contact->contactedBy = auth()->user()->id;
        $contact->remarks = $req->remark;
        $contact->save();
        return back()->with('Success', 'Remarks Saved Success');
    }

    /****************************** Referral List ******************************/
    public function getReferredToList(Request $req, $userId)
    {
        $user = User::findorFail($userId);
        return view('admin.referral.referred_to', compact('user'));
    }

    /****************************** User List ******************************/
    public function getUserPoints(Request $req, $userId)
    {
        $user = User::findorFail($userId);
        return view('auth.user.point_info', compact('user'));
    }

    /****************************** FAQ ******************************/
    public function faq(Request $req)
    {
        $faq = Faq::get();
        return view('admin.setting.faq.index', compact('faq'));
    }

    public function createFaq(Request $req)
    {
        return view('admin.setting.faq.create');
    }

    public function saveFaq(Request $req)
    {
        $req->validate([
            'title' => 'required|max:200',
            'description' => 'required',
        ]);
        $faq = new Faq();
        $faq->title = $req->title;
        $faq->description = $req->description;
        $faq->save();
        return redirect(route('admin.faq'))->with('Success', 'Faq Added SuccessFully');
    }

    public function editFaq(Request $req, $id)
    {
        $faq = Faq::findOrFail($id);
        return view('admin.setting.faq.edit', compact('faq'));
    }

    public function updateFaq(Request $req)
    {
        $req->validate([
            'faqId' => 'required|min:1|numeric',
            'title' => 'required|max:200',
            'description' => 'required',
        ]);
        $faq = Faq::find($req->faqId);
        $faq->title = $req->title;
        $faq->description = $req->description;
        $faq->save();
        return redirect(route('admin.faq'))->with('Success', 'Faq Updated SuccessFully');
    }

    public function deleteFaq(Request $req)
    {
        $rules = [
            'id' => 'required|numeric|min:1',
        ];
        $validator = validator()->make($req->all(), $rules);
        if (!$validator->fails()) {
            $faq = Faq::find($req->id);
            if ($faq) {
                $faq->delete();
                return successResponse('Faq rfcd Success');
            }
            return errorResponse('Invalid Faq Id');
        }
        return errorResponse($validator->errors()->first());
    }

    /****************************** Testimonials ******************************/
    public function testimonials(Request $req)
    {
        $testimonials = Testimonial::get();
        return view('admin.setting.testimonials.index', compact('testimonials'));
    }

    public function createTestimonial(Request $req)
    {
        return view('admin.setting.testimonials.create');
    }

    public function saveTestimonial(Request $req)
    {
        $req->validate([
            'name' => 'required|max:200',
            'address' => 'required|string|max:200',
            'quote' => 'required',
            'image' => '',
        ]);
        $testimonial = new Testimonial();
        $testimonial->name = $req->name;
        $testimonial->quote = $req->quote;
        $testimonial->address = $req->address;
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $testimonial->image = imageUpload($image);;
        }
        $testimonial->save();
        return redirect(route('admin.testimonial'))->with('Success', 'Testimonial Added SuccessFully');
    }

    public function editTestimonial(Request $req, $id)
    {
        $testimonial = Testimonial::where('id', $id)->first();
        return view('admin.setting.testimonials.edit', compact('testimonial'));
    }

    public function updateTestimonial(Request $req)
    {
        $req->validate([
            'testimonialId' => 'required|numeric|min:1',
            'name' => 'required|max:200',
            'address' => 'required|string|max:200',
            'quote' => 'required',
            'image' => '',
        ]);
        $testimonial = Testimonial::find($req->testimonialId);
        $testimonial->name = $req->name;
        $testimonial->quote = $req->quote;
        $testimonial->address = $req->address;
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $testimonial->image = imageUpload($image);
        }
        $testimonial->save();
        return redirect(route('admin.testimonial'))->with('Success', 'Testimonial Updated SuccessFully');
    }

    public function deleteTestimonial(Request $req)
    {
        $rules = [
            'id' => 'required|numeric|min:1',
        ];
        $validator = validator()->make($req->all(), $rules);
        if (!$validator->fails()) {
            $testimonial = Testimonial::find($req->id);
            if ($testimonial) {
                $testimonial->delete();
                return successResponse('Testimonial Deleted Success');
            }
            return errorResponse('Invalid Testimonial Id');
        }
        return errorResponse($validator->errors()->first());
    }

    /********************************** Policy Setting ***************************************/
    public function policyData(Request $req)
    {
        $policy = Setting::whereIn('key', ['refundPolicy', 'termsCondition', 'privacyPolicy'])->get();
        return view('admin.setting.policy.index', compact('policy'));
    }

    public function policyDataEdit(Request $req, $settingId)
    {
        $policy = Setting::where('id', $settingId)->first();
        return view('admin.setting.policy.edit', compact('policy'));
    }

    public function policyDataUpdate(Request $req, $settingId)
    {
        $req->validate([
            'settingId' => 'required|numeric|min:1|in:' . $settingId,
            'heading' => 'required|string|max:200',
            'description' => 'required|string',
            'image' => '',
        ]);
        $setting = Setting::where('id', $req->settingId)->first();
        if ($setting) {
            $setting->heading = $req->heading;
            $setting->description = $req->description;
            if ($req->hasFile('image')) {
                $image = $req->file('image');
                $setting->image = imageUpload($image);
            }
            $setting->save();
            return redirect(route('admin.setting.policy'))->with('Success', 'Policy: ' . $req->heading . ' Updated SuccessFully');
        }
        return errorResponse('Invalid Setting Detected');
    }

    public function contactUsSetting(Request $req)
    {
        return view('admin.setting.contactusSetting');
    }

    public function contactUsSettingUpdate(Request $req, $contactId)
    {
        $req->validate([
            'contactId' => 'required|min:1|numeric|in:' . $contactId,
            'email' => 'required|email',
            'facebook' => 'required|url',
            'image' => '',
        ]);
        $contact = ContactUs::where('id', $contactId)->first();
        $contact->email = $req->email;
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $contact->image = imageUpload($image);
        }
        $contact->facebook = $req->facebook;
        $contact->save();
        return back()->with('Success', 'Contact us Setting Updated SuccessFully');
    }

    public function aboutUsSetting(Request $req)
    {
        $aboutUs = Setting::where('key', 'aboutus')->first();
        return view('admin.setting.aboutusSetting', compact('aboutUs'));
    }

    public function aboutUsSettingUpdate(Request $req, $settingId)
    {
        $req->validate([
            'settingId' => 'required|min:1|numeric|in:' . $settingId,
            'heading' => 'required|string|max:200',
            'description' => 'required',
            'description' => 'required',
            'description2' => 'nullable',
            'image' => '',
        ]);
        $aboutUs = Setting::where('id', $settingId)->where('key', 'aboutus')->first();
        $aboutUs->heading = $req->heading;
        $aboutUs->description = $req->description;
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $aboutUs->image = imageUpload($image);
        }
        $aboutUs->description2 = emptyCheck($req->description2);
        $aboutUs->save();
        return back()->with('Success', 'About us Setting Updated SuccessFully');
    }

    public function howItWorksSetting(Request $req)
    {
        $howitswork = Setting::whereIn('key', ['howitworkMain', 'howitworkChild'])->get();
        return view('admin.setting.howitswork.index', compact('howitswork'));
    }

    public function howItWorksDataEdit(Request $req, $settingId)
    {
        $howitswork = Setting::where('id', $settingId)->first();
        return view('admin.setting.howitswork.edit', compact('howitswork'));
    }

    public function howItWorksSettingUpdate(Request $req, $settingId)
    {
        $req->validate([
            'settingId' => 'required|numeric|min:1|in:' . $settingId,
            'heading' => 'required|string|max:200',
            'description' => 'required|string',
            'image' => '',
        ]);
        $setting = Setting::where('id', $req->settingId)->first();
        if ($setting) {
            $setting->heading = $req->heading;
            $setting->description = $req->description;
            if ($req->hasFile('image')) {
                $image = $req->file('image');
                $setting->image = imageUpload($image);
            }
            $setting->save();
            return redirect(route('admin.setting.howitWorks'))->with('Success', 'How-its-work: ' . $req->heading . ' Updated SuccessFully');
        }
        return errorResponse('Invalid Setting Detected');
    }

    /******************************* Instrument ********************************/
    public function instrument(Request $req)
    {
        $instrument = Instrument::get();
        return view('admin.master.instrument.index', compact('instrument'));
    }

    public function instrumentCreate(Request $req)
    {
        return view('admin.master.instrument.create');
    }

    public function instrumentStore(Request $req)
    {
        $req->validate([
            'image' => 'required',
            'name' => 'required|string|max:200',
        ]);
        $new = new Instrument();
        $new->name = strtoupper($req->name);
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $new->image = imageUpload($image);
        }
        $new->save();
        return redirect(route('admin.master.instrument.list'))->with('Success', 'Instrument Added SuccessFully');
    }

    public function instrumentEdit(Request $req, $instrumentId)
    {
        $instrument = Instrument::where('id', $instrumentId)->first();
        return view('admin.master.instrument.edit', compact('instrument'));
    }

    public function instrumentUpdate(Request $req, $instrumentId)
    {
        $req->validate([
            'instrumentId' => 'required|min:1|numeric|in:' . $instrumentId,
            'image' => '',
            'name' => 'required|string|max:200',
        ]);
        $update = Instrument::where('id', $instrumentId)->first();
        $update->name = strtoupper($req->name);
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $update->image = imageUpload($image);
        }
        $update->save();
        return redirect(route('admin.master.instrument.list'))->with('Success', 'Instrument Updated SuccessFully');
    }

    public function instrumentDelete(Request $req)
    {
        $rules = [
            'id' => 'required|numeric|min:1',
        ];
        $validator = validator()->make($req->all(), $rules);
        if (!$validator->fails()) {
            $instrument = Instrument::find($req->id);
            if ($instrument) {
                $instrument->delete();
                return successResponse('Instrument Deleted Success');
            }
            return errorResponse('Invalid Instrument Id');
        }
        return errorResponse($validator->errors()->first());
    }

    /*********************************** Guitar category ****************************/
    public function category(Request $req)
    {
        $category = Category::get();
        return view('admin.master.category.index', compact('category'));
    }

    public function categoryCreate(Request $req)
    {
        $instrument = Instrument::get();
        return view('admin.master.category.create', compact('instrument'));
    }

    public function categoryStore(Request $req)
    {
        $req->validate([
            'image' => 'required',
            'instrument' => 'required|min:1|numeric',
            'name' => 'required|string|max:200',
        ]);
        $new = new Category();
        $new->instrumentId = $req->instrument;
        $new->name = strtoupper($req->name);
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $new->image = imageUpload($image);
        }
        $new->save();
        return redirect(route('admin.master.category.list'))->with('Success', 'Category Added SuccessFully');
    }

    public function categoryEdit(Request $req, $categoryId)
    {
        $category = Category::where('id', $categoryId)->first();
        $instrument = Instrument::get();
        return view('admin.master.category.edit', compact('category', 'instrument'));
    }

    public function categoryUpdate(Request $req, $categoryId)
    {
        $req->validate([
            'categoryId' => 'required|min:1|numeric|in:' . $categoryId,
            'instrument' => 'required|min:1|numeric',
            'image' => '',
            'name' => 'required|string|max:200',
        ]);
        $update = Category::where('id', $categoryId)->first();
        $update->name = strtoupper($req->name);
        $update->instrumentId = $req->instrument;
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $update->image = imageUpload($image);
        }
        $update->save();
        return redirect(route('admin.master.category.list'))->with('Success', 'Category Updated SuccessFully');
    }

    public function categoryDelete(Request $req)
    {
        $rules = [
            'id' => 'required|numeric|min:1',
        ];
        $validator = validator()->make($req->all(), $rules);
        if (!$validator->fails()) {
            $category = Category::find($req->id);
            if ($category) {
                $category->delete();
                return successResponse('Category Deleted Success');
            }
            return errorResponse('Invalid Category Id');
        }
        return errorResponse($validator->errors()->first());
    }

    /*********************************** Genre ****************************/

    public function genreIndex()
    {
        $genre = Genre::get();
        return view('admin.master.genre.index', compact('genre'));
    }

    public function genreCreate()
    {
        return view('admin.master.genre.create');
    }

    public function genreSave(Request $request)
    {
        $request->validate([
            'name' => 'required|min:1|max:200|string'
        ]);

        $genre = new Genre();
        $genre->name = $request->name;
        $genre->save();
        return redirect()->route('admin.master.genre.list')->with('Success', 'Genre added sucessfully');
    }

    public function genreEdit($id)
    {
        $genre = Genre::where('id', $id)->first();
        return view('admin.master.genre.edit', compact('genre'));
    }

    public function genreUpdate(Request $request, $id)
    {
        $request->validate([
            'genreId' => 'required|numeric|min:1|in:' . $id,
            'name' => 'required|string|max:200',
        ]);

        $genre = Genre::where('id', $id)->first();
        $genre->name = $request->name;
        $genre->save();
        return redirect(route('admin.master.genre.list'))->with('Success', 'Genre updated successfully');
    }

    public function genreDelete(Request $request)
    {
        $rules = [
            'id' => 'required|numeric|min:1',
        ];
        $validator = validator()->make($request->all(), $rules);
        if (!$validator->fails()) {
            $genre = Genre::find($request->id);
            if ($genre) {
                $genre->delete();
                return successResponse('Genre Deleted Success');
            }
            return errorResponse('Invalid Genre Id');
        }
        return errorResponse($validator->errors()->first());
    }

    public function offersList(Request $req)
    {
        $offers = Offer::get();
        return view('admin.offer.list', compact('offers'));
    }

    public function offerCreate(Request $req)
    {
        $series = ProductSeries::get();
        return view('admin.offer.create', compact('series'));
    }

    public function offerStore(Request $req)
    {
        $req->validate([
            'image' => 'required',
            'title' => 'required|string|max:255',
            'price_gbp' => 'required|numeric|min:1',
            'price_usd' => 'required|numeric|min:1',
            'price_eur' => 'required|numeric|min:1',
            'description' => 'required',
            'offer_description' => 'required',
            'seriesId' => 'required|array',
            'seriesId.*' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();

        try {
            $offers = new Offer();
            if ($req->hasFile('image')) {
                $image = $req->file('image');
                $offers->image = imageUpload($image, 'offer');
            }
            $offers->title = $req->title;
            $offers->price_usd = $req->price_usd;
            $offers->price_euro = $req->price_eur;
            $offers->price_gbp = $req->price_gbp;
            $offers->description = $req->description;
            $offers->offer_description = $req->offer_description;
            $offers->save();

            if (!empty($req->seriesId) && count($req->seriesId) > 0) {
                foreach ($req->seriesId as $key => $series) {
                    $offerSeries = new OfferSeries();
                    $offerSeries->offer_id = $offers->id;
                    $offerSeries->series_id = $series;
                    $offerSeries->save();
                }
            }

            DB::commit();
            return redirect()->route('admin.offer.list')->with('Success', 'Offer Added successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            $errors['title'] = 'Something went wrong please try after sometime';
            return back()->withInput($req->all())->withErrors($errors);
        }
    }

    public function offerEdit(Request $req, $id)
    {
        $offer = Offer::findOrFail($id);
        $series = ProductSeries::get();
        return view('admin.offer.edit', compact('series', 'offer'));
    }

    public function offerUpdate(Request $req, $offerId)
    {
        $req->validate([
            'image' => 'nullable',
            'title' => 'required|string|max:255',
            'price_gbp' => 'required|numeric|min:1',
            'price_usd' => 'required|numeric|min:1',
            'price_eur' => 'required|numeric|min:1',
            'description' => 'required',
            'offer_description' => 'required',
            'seriesId' => 'required|array',
            'seriesId.*' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();

        try {
            $offers = Offer::findOrfail($offerId);
            if ($req->hasFile('image')) {
                $image = $req->file('image');
                $offers->image = imageUpload($image, 'offer');
            }
            $offers->title = $req->title;
            $offers->price_usd = $req->price_usd;
            $offers->price_euro = $req->price_eur;
            $offers->price_gbp = $req->price_gbp;
            $offers->description = $req->description;
            $offers->offer_description = $req->offer_description;
            $offers->save();
            if (!empty($req->seriesId) && count($req->seriesId) > 0) {
                OfferSeries::where('offer_id', $offers->id)->delete();
                foreach ($req->seriesId as $key => $series) {
                    $offerSeries = new OfferSeries();
                    $offerSeries->offer_id = $offers->id;
                    $offerSeries->series_id = $series;
                    $offerSeries->save();
                }
            }
            DB::commit();
            return redirect()->route('admin.offer.list')->with('Success', 'Offer Updated successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            $errors['title'] = 'Something went wrong please try after sometime';
            return back()->withInput($req->all())->withErrors($errors);
        }
    }

    public function offerDelete(Request $req)
    {
        $rules = [
            'id' => 'required|numeric|min:1',
        ];
        $validator = validator()->make($req->all(), $rules);
        if (!$validator->fails()) {
            $offer = Offer::find($req->id);
            if ($offer) {
                $offer->delete();
                return successResponse('Offer Plan Deleted');
            }
            return errorResponse('Invalid Offer Id');
        }
        return errorResponse($validator->errors()->first());
    }

    public function subscriptionList(Request $req)
    {
        $subscription = SubscriptionPlan::select('*')->get();
        return view('admin.subscription.list', compact('subscription'));
    }

    public function subscriptionCreate(Request $req)
    {
        return view('admin.subscription.create');
    }

    public function subscriptionStore(Request $req)
    {
        $req->validate([
            'image' => 'required',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'valid' => 'required|numeric|min:1',
            'features_title' => 'nullable|array',
            'features_title.*' => 'required|string|max:255',
        ]);
        DB::beginTransaction();
        try {
            $newSubscription = new SubscriptionPlan();
            $newSubscription->title = $req->title;
            if ($req->hasFile('image')) {
                $image = $req->file('image');
                $newSubscription->image = imageUpload($image, 'subscription');
            }
            $newSubscription->price = $req->price;
            $newSubscription->currencyId = 3;
            $newSubscription->valid_for = $req->valid;
            $newSubscription->save();
            if (!empty($req->features_title) && count($req->features_title) > 0) {
                foreach ($req->features_title as $key => $featured) {
                    $newPlanFeature = new SubscriptionPlanFeature();
                    $newPlanFeature->subscriptionPlanId = $newSubscription->id;
                    $newPlanFeature->title = $featured;
                    $newPlanFeature->save();
                }
            }
            DB::commit();
            return redirect(route('admin.master.subscription.list'))->with('Success', 'Subscription Plan Added sucecss');
        } catch (Exception $e) {
            DB::rollback();
            $errors['title'] = 'Something went wrong please try after sometime';
            return back()->withInput($req->all())->withErrors($errors);
        }
    }

    public function subscriptionEdit(Request $req, $subscriptionId)
    {
        $subscription = SubscriptionPlan::findorFail($subscriptionId);
        return view('admin.subscription.edit', compact('subscription'));
    }

    public function subscriptionUpdate(Request $req, $subscriptionId)
    {
        $req->validate([
            'image' => 'nullable',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'valid' => 'required|numeric|min:1',
            'features_title' => 'nullable|array',
            'features_title.*' => 'required|string|max:255',
        ]);
        DB::beginTransaction();
        try {
            $subscription = SubscriptionPlan::findorFail($subscriptionId);
            $subscription->title = $req->title;
            if ($req->hasFile('image')) {
                $image = $req->file('image');
                $subscription->image = imageUpload($image, 'subscription');
            }
            $subscription->price = $req->price;
            $subscription->currencyId = 3;
            $subscription->valid_for = $req->valid;
            $subscription->save();
            if (!empty($req->features_title) && count($req->features_title) > 0) {
                SubscriptionPlanFeature::where('subscriptionPlanId', $subscription->id)->delete();
                foreach ($req->features_title as $key => $featured) {
                    $newPlanFeature = new SubscriptionPlanFeature();
                    $newPlanFeature->subscriptionPlanId = $subscription->id;
                    $newPlanFeature->title = $featured;
                    $newPlanFeature->save();
                }
            }
            DB::commit();
            return redirect(route('admin.master.subscription.list'))->with('Success', 'Subscription Plan Updated sucecss');
        } catch (Exception $e) {
            DB::rollback();
            $errors['title'] = 'Something went wrong please try after sometime';
            return back()->withInput($req->all())->withErrors($errors);
        }
    }

    public function subscriptionDelete(Request $req)
    {
        $rules = [
            'id' => 'required|numeric|min:1',
        ];
        $validator = validator()->make($req->all(), $rules);
        if (!$validator->fails()) {
            $SubscriptionPlan = SubscriptionPlan::find($req->id);
            if ($SubscriptionPlan) {
                $SubscriptionPlan->delete();
                return successResponse('Subscription Plan Success');
            }
            return errorResponse('Invalid Subscription Plan Id');
        }
        return errorResponse($validator->errors()->first());
    }

    // public function guitarCategoryDelete(Request $req)
    // {
    //     $rules = [
    //         'id' => 'required|numeric|min:1',
    //     ];
    //     $validator = validator()->make($req->all(),$rules);
    //     if(!$validator->fails()){
    //         $category = Category::find($req->id);
    //         if($category){
    //             $category->delete();
    //             return successResponse('Category Deleted Success');  
    //         }
    //         return errorResponse('Invalid Category Id');
    //     }
    //     return errorResponse($validator->errors()->first());
    // }
}
