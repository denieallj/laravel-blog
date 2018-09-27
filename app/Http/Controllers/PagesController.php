<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index() {
        $title = "Welcome to Laravel";

        // One of two to pass data into views
        // return view('pages.index', compact('title'));
        return view('pages.index')->with('title', $title);
        
    }

    public function about() {
        $title = "About Page";
        return view('pages.about')->with('title', $title);
    }

    public function services() {
        $data = [
            'title' => 'Services',
            'desc' => 'Something about our services',
            'services' => ['Web Design', ' Programming', 'SEO']
        ];

        return view('pages.services')->with($data);
    }
}
