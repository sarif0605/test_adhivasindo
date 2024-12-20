<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class CalenderController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date') ? Carbon::parse($request->get('date')) : Carbon::now();

        return view('calender.index', compact('date'));
    }
}
