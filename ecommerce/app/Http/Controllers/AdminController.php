<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //
    public function dashboard(){
        return view('admin.dashboard');
    }
}
