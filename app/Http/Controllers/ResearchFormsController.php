<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResearchFormsController extends Controller
{
    function index($schoolHash) {
        return view('research_forms.introduction')
            ->with(['shoolHash' => $schoolHash]);
    }

    function show($schoolHash, $page) {

    }

}
