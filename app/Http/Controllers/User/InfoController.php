<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InfoController extends Controller
{
    public function questions(){
        $page = "dashboard";
        return view('home.info.questions',compact('page'));
    }

    public function about_us(){
        $page = "dashboard";
        return view('home.info.about_us',compact('page'));
    }

    public function contact_us(){
        $page = "dashboard";
        return view('home.info.contact_us',compact('page'));
    }

    public function coming_soon(){
        return view('home.info.coming_soon');
    }
}
