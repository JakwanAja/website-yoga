<?php

namespace App\Http\Controllers;

class PublicController extends Controller
{
    public function landing()
    {
        return view('public.landing');
    }

    public function jadwal()
    {
        return view('public.jadwal');
    }

    public function booking()
    {
        return view('public.booking');
    }
}