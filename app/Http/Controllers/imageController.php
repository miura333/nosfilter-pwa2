<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Log;

class imageController extends Controller
{
    //
    public function filter(Request $request)
    {
        Log::debug('enter filter');

        $imageData = $request->imageData;

        return view('result')->with('imageData', $imageData)->render();
    }
}
