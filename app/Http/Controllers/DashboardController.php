<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function index(Request $request)
    {
        $user = auth()->user();
        return view('dashboard', ['user' => $user]);
    }
}
