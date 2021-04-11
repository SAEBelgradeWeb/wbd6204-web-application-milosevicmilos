<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

final class ApplicationController extends Controller
{
    public function index(): View
    {
        Auth::loginUsingId(1); // TODO: Remove this!

        return view('pages.application');
    }
}
