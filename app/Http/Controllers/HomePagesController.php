<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePagesController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function about(){
        $title = 'About us';
        //return view('home.about')->with('title', $title);
        return view('auth.login');
    }

    public function pricing(){
        $title = 'Pricing';
        //return view('home.pricing')->with('title', $title);
        return view('auth.login');
    }
}
