<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

final class ApplicationController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        setcookie('first_name', Auth::user()->first_name);
        setcookie('last_name', Auth::user()->last_name);
        setcookie('user_role', Auth::user()->role);

        return view('pages.application');
    }
}
