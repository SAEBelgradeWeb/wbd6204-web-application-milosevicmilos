<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

final class ApplicationController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('pages.application');
    }
}
