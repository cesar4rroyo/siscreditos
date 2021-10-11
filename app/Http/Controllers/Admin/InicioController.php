<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function index()
    {
        // return view('welcome');
        return redirect('/auth/logout');
    }
}
