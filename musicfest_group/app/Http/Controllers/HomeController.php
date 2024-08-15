<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News; 

class HomeController extends Controller
{
    /**
     * Show the application dashboard with the latest news.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $newsItems = News::orderBy('published_at', 'desc')->get();
        return view('home', compact('newsItems'));
    }
}
