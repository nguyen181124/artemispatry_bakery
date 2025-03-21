<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PresentController extends Controller
{
    public function view_present()
    {
        return view('gioithieu');
    }
}
