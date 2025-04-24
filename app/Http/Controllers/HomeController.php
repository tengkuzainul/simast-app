<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('home')],
            ['label' => 'Home']
        ];

        return view('home', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Dashboard'
        ]);
    }
}
