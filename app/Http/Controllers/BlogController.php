<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $blogs = Blog::paginate(10);
        // return view('dashboard', ['blogs' => $blogs]);

        return redirect('/dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.blogs.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $publish = 0;
        if (isset($request->publish)) {
            $publish = 1;
        } else {
            $publish = 0;
        }

        $validated_data = $request->validate([
            'title' => 'required|unique:blogs',
            'excerpt' => 'required',
            'blog-body' => 'required',
            'thumbnail' => 'required|mimes:png,jpg,jpeg|max:5000',
        ]);

        $newFileName = $this->upload_image($request);

        Blog::create([
            'title' => $validated_data['title'],
            'excerpt' => $validated_data['excerpt'],
            'body' => $validated_data['blog-body'],
            'thumbnail' => $newFileName,
            'published' => $publish
        ]);

        return redirect('/dashboard')->with('success', 'blog added to the database');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blog = Blog::find($id);

        return view('show', ['blog' => $blog]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::find($id);

        return view('admin.blogs.edit', ['blog' => $blog]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->thumbnail == null) {
            $validated_data = $request->validate([
                'title' => 'required',
                'excerpt' => 'required',
                'blog-body' => 'required'
            ]);

            Blog::where('id', $id)->update([
                'title' => $validated_data['title'],
                'excerpt' => $validated_data['excerpt'],
                'body' => $validated_data['blog-body']
            ]);
        } else {
            $image = Blog::select('thumbnail')->find($id)->thumbnail;
            unlink(public_path("front-end/blog_images/$image"));

            $validated_data = $request->validate([
                'title' => 'required',
                'excerpt' => 'required',
                'blog-body' => 'required',
                'thumbnail' => 'required|mimes:png,jpg,jpeg|max:5000',
            ]);

            $newFileName = $this->upload_image($request);

            Blog::where('id', $id)->update([
                'title' => $validated_data['title'],
                'excerpt' => $validated_data['excerpt'],
                'body' => $validated_data['blog-body'],
                'thumbnail' => $newFileName,
            ]);
        }


        return redirect('/dashboard')->with('success', 'data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $image = Blog::select('thumbnail')->find($id)->thumbnail;

        unlink(public_path("front-end/blog_images/$image"));

        Blog::destroy($id);
        return redirect('/dashboard')->with('success', 'data deleted successfully');
    }


    public function upload_image($request)
    {
        $newFileName = time() . '.' . $request->thumbnail->extension();
        $request->thumbnail->move(public_path('/front-end/blog_images'), $newFileName);

        return $newFileName;
    }
}
