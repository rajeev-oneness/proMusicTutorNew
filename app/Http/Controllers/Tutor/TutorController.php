<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Instrument;

class TutorController extends Controller
{
    public function dashboard(Request $req)
    {
        $data = (object)[];
        $data->instrument = Instrument::get();
        return view('tutor.dashboard',compact('data'));
    }
}
