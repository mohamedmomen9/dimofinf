<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function setLang($lang){
        if(auth()->user()){
            $user = auth()->user();
            $user->lang = $lang;
            $user->save();
        }else{
            if(session()->has('lang')){
                session()->forget('lang');
            }
            session()->put('lang', $lang);
        }
        return back();
    }

    public function listLangs(){
        $languages = Language::all();
        return $languages; 
    }
}
