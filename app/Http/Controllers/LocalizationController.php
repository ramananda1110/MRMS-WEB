<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    //
    public function switchLanguage(Request $request)
    {
        $lang = $request->lang;
        Session::put("locale", $lang);
        App::setlocale($lang);
        return redirect()->back();
    }
}
