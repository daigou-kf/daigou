<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PublicController extends Controller
{
    public function about_us(){
        return view('public.about_us');
    }

    public function contact_us(){
        return view('public.contact_us');
    }
}
