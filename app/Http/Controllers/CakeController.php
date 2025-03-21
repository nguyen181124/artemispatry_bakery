<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cake;

class CakeController extends Controller
{
    public function cake_detail($id)
    {
        $cake_detail = Cake::where('id', $id)->firstOrFail();
        return view('detail', compact('cake_detail'));
    }
    
}
