<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ChartJSController extends Controller
{
    /**
     * Write code on Method
     *
     * @return View
     */
    public function index()
    {
        $users = User::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
                    ->whereYear('created_at', date('Y'))
                    ->groupBy(DB::raw("Month(created_at)"))
                    ->pluck('count', 'month_name');

        $labels = $users->keys();
        $data = $users->values();

        print($labels);

        //return view('chart', compact('labels', 'data'));
    }
}
