<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Post;
use App\Podcast;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use DB;

class PostsController extends Controller
{




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $posts = Post::orderBy('created_at','desc')->paginate(6);
        return view('pages.services')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'podcast_image' => 'image|nullable|max:10999',
            'podcast_file' => 'nullable|max:100999'
        ]);

 // Handle File Upload
 if($request->hasFile('podcast_image')){
    // Get filename with the extension
    $filenameWithExt = $request->file('podcast_image')->getClientOriginalName();
    // Get just filename
    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
    // Get just ext
    $extension = $request->file('podcast_image')->getClientOriginalExtension();
    // Filename to store
    $fileNameToStore= $filename.'_'.time().'.'.$extension;
    // Upload Image
    $path = $request->file('podcast_image')->storeAs('public/category/'.$request->input('category_id').'/podcast_image', $fileNameToStore);

// make thumbnails
/*
$thumbStore = 'thumb.'.$filename.'_'.time().'.'.$extension;
    $thumb = Image::make($request->file('podcast_image')->getRealPath());
    $thumb->resize(80, 80);
    $thumb->save('storage/podcast_image/'.$thumbStore);*/

} else {
    $fileNameToStore = 'noimage.jpg';
}

if($request->hasFile('podcast_file')){

    // Get filename with the extension
    $filenameWithExta = $request->file('podcast_file')->getClientOriginalName();
    echo '$filenameWithExta';
    // Get just filename
    $filename = pathinfo($filenameWithExta, PATHINFO_FILENAME);
    // Get just ext
    $extensiona = $request->file('podcast_file')->getClientOriginalExtension();
    // Filename to store
    $fileNameToStorea= $filename.'_'.time().'.'.$extensiona;
    // Upload Image
    $path = $request->file('podcast_file')->storeAs('public/category/'.$request->input('category_id').'/podcast_file', $fileNameToStorea);

} else {
    $fileNameToStorea = 'test.mp3';
}
         // Create Post

         $post = new Podcast;
         $post->title = $request->input('title');
         $post->body = $request->input('body');
         $post->idcategory = $request->input('category_id');
         $post->URLi = $fileNameToStore;
         $post->URLa = $fileNameToStorea;
         $post->save();
         return redirect('/category/'.$post->idcategory);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $post=Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);
        $post = Post::find($id);
        if($request->hasFile('post_image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('post_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('post_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('post_image')->storeAs('public/post_image', $fileNameToStore);

        // make thumbnails
        /*
        $thumbStore = 'thumb.'.$filename.'_'.time().'.'.$extension;
            $thumb = Image::make($request->file('post_image')->getRealPath());
            $thumb->resize(80, 80);
            $thumb->save('storage/post_image/'.$thumbStore);*/

        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        // Update Post
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->category = $request->input('item_id');
        if($request->hasFile('post_image')){
            $post->URLi = $fileNameToStore;
        }
        $post->save();

        return redirect('/posts/'.$post->id);


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

        //Check if post exists before deleting
        if (!isset($post)){
            return redirect('/posts');
        }

        // Check for correct user
       /* if(auth()->user()->id !==$post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }

        if($post->cover_image != 'noimage.jpg'){
            // Delete Image
            Storage::delete('public/cover_images/'.$post->cover_image);
        }*/
        if($post->URLi != 'noimage.jpg'){
            // Delete Image
            Storage::delete('public/post_image/'.$post->URLi);
        }

        $post->delete();
        return redirect('/posts');
    }


    public function storepost(Request $request)
    {


        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'post_image' => 'image|nullable|max:1999',
        ]);

 // Handle File Upload
 if($request->hasFile('post_image')){
    // Get filename with the extension
    $filenameWithExt = $request->file('post_image')->getClientOriginalName();
    // Get just filename
    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
    // Get just ext
    $extension = $request->file('post_image')->getClientOriginalExtension();
    // Filename to store
    $fileNameToStore= $filename.'_'.time().'.'.$extension;
    // Upload Image
    $path = $request->file('post_image')->storeAs('public/post_image', $fileNameToStore);

// make thumbnails
/*
$thumbStore = 'thumb.'.$filename.'_'.time().'.'.$extension;
    $thumb = Image::make($request->file('post_image')->getRealPath());
    $thumb->resize(80, 80);
    $thumb->save('storage/post_image/'.$thumbStore);*/

} else {
    $fileNameToStore = 'noimage.jpg';
}


         // Create Post
         $post = new Post;
         $post->title = $request->input('title');
         $post->body = $request->input('body');
         $post->category = $request->input('item_id');
         $post->URLi = $fileNameToStore;
         $post->save();
         return redirect('/posts');
    }

}
