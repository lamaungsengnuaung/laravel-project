<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    //api posting
    public function posting(Request $request)
    {
        return response()->json($request->name, 200);
    }
}
