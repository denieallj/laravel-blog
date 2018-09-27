<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

// Bring in the model
use App\Post;

class PostsController extends Controller
{
    public function __construct()
    {
        // if not logged in send to login page except for some views
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        $posts->withPath('posts');
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // This will validate form input and send you back to the previous page
        $this->validate($request, [
            'title' => 'required',
            'bodyText' => 'required',
            'cover_image' => 'image|nullable|max:1999' // user can upload picture or not but size should be less than 2MB
        ]);

        // Handle file upload
        // Check if file has been uploaded or else set a default image
        if($request->hasFile('cover_image')) {

            // Get the exact name of the file including extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName(); 

            // Get only the filename
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            // Get only the extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            // File name to store - combine the filename with current timestamp and then the extension to make it unique
            $fileNameToStore = $filename . "_" . time() . "_" . $extension;

            // Upload the image --- will create the path if not existed
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);

            // Run this command first: php artisan storage:link
            // Images will be stored in public/storage/cover_images/
            // If have limit error over post size visit this link: 
            // https://stackoverflow.com/questions/11719495/php-warning-post-content-length-of-8978294-bytes-exceeds-the-limit-of-8388608-b

        } else {

            $fileNameToStore = 'noImage.png';

        }

        // Create post if didnt fail
        $post = new Post();
        $post->title = $request->input('title');
        $post->body = $request->input('bodyText');
        $post->user_id = auth()->user()->id; // get the currently logged in user id
        $post->cover_img = $fileNameToStore;
        $post->save();

        // Redirect to /posts and setting the session
        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        return view('posts/show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        // Check for the correct user
        if ($post->user_id == auth()->user()->id) {
            return view('posts.edit')->with('post', $post);
        } else {
            return redirect('/posts')->with('error', 'This post does not belong to you.');
        }
        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         // This will validate form input and send you back to the previous page
        $this->validate($request, [
            'title' => 'required',
            'bodyText' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        // Find the post with the id
        $post = Post::find($id);

        // Handle file upload
        // Check if file has been uploaded or else set a default image
        if($request->hasFile('cover_image')) {

            // Get the exact name of the file including extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName(); 

            // Get only the filename
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            // Get only the extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            // File name to store - combine the filename with current timestamp and then the extension to make it unique
            $fileNameToStore = $filename . "_" . time() . "_" . $extension;

            // Upload the image --- will create the path if not existed
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);

            // Run this command first: php artisan storage:link
            // Images will be stored in public/storage/cover_images/
            // If have limit error over post size visit this link: 
            // https://stackoverflow.com/questions/11719495/php-warning-post-content-length-of-8978294-bytes-exceeds-the-limit-of-8388608-b

        } else {

            $fileNameToStore = $post->cover_img;

        }

        // Update a post
        $post->title = $request->input('title');
        $post->body = $request->input('bodyText');
        $post->cover_img = $fileNameToStore;
        $post->save();

        // Redirect to /posts and setting the session
        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        // Check for the correct user
        if ($post->user_id == auth()->user()->id) {

            // Delete image if its not the default one
            if ($post->cover_img != 'noImage.png') {
                // Delete Image
                Storage::delete('public/cover_images/' . $post->cover_img);
            }

            $post->delete();
            return redirect('/posts')->with('success', 'Posts Updated');
        } else {
            return redirect('/posts')->with('error', 'This post does not belong to you.');
        }

        
    }
}
