<?php

namespace App\Http\Controllers;

final class ApplicationController extends Controller
{
    public function index()
    {
        return view('application');
    }
}
