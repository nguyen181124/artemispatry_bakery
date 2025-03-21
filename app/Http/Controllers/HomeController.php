<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cake;

class HomeController extends Controller
{
    public function view_home()
    {
        $list_cake = Cake::inRandomOrder()->limit(4)->get();
        $new_products = Cake::orderBy('name', 'desc')->limit(4)->get();
        return view('home', compact('list_cake', 'new_products'));
    }

    public function list_all()
    {
        $all_cake = Cake::all();
        return view('all', compact('all_cake'));
    }

    public function list_birthday_cake()
    {
        $birthday_cake = Cake::all();
        return view('banhsinhnhat', compact('birthday_cake'));
    }

    public function list_cake()
    {
        $cakes = Cake::all();
        return view('banhle', compact('cakes'));
    }

    public function list_drink()
    {
        $drink = Cake::all();
        return view('douong', compact('drink'));
    }

    public function list_giftset()
    {
        $giftset = Cake::all();
        return view('giftset', compact('giftset'));
    } 
}