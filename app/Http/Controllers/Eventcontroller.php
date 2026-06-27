<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        // Replace 'events.index' with the actual name of your view file
        return view('events.index');
    }
}