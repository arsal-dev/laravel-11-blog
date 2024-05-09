<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function home()
    {
        $blogs = Blog::latest()->where('published', 1)->paginate(5);
        return view('welcome', ['blogs' => $blogs]);
    }
}
