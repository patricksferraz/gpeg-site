<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    function home() {
        return view('welcome');
    }

    function searchHash(Request $request) {
        return redirect()->route('l.research_forms.index',
            ['schoolHash' => $request->input('shoolHash')]);
    }
}
