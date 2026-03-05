<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NFCController extends Controller
{
    public function claim(Request $request)
    {
        return response()->json(['message' => 'claim']);
    }
}
