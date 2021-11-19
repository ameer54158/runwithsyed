<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class LocalizationController extends Controller
{

    //User selection language stored in session
    public function lang_change($lang_type='')
    {
        if($lang_type){
            session()->put('locale', $lang_type);
        }
        return back();
    }

}
