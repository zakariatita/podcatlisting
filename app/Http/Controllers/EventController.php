<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\event;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use DB;
class EventController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'time' => 'required',
            'title' => 'required',
            'body' => 'required',
            'event_image' => 'max:1999',
        ]);

 // Handle File Upload
 if($request->hasFile('event_image')){
    // Get filename with the extension
    $filenameWithExt = $request->file('event_image')->getClientOriginalName();
    // Get just filename
    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
    // Get just ext
    $extension = $request->file('event_image')->getClientOriginalExtension();
    // Filename to store
    $fileNameToStore= $filename.'_'.time().'.'.$extension;
    // Upload Image
    $path = $request->file('event_image')->storeAs('public/event_image', $fileNameToStore);

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
         $post = new event;
         $post->time = $request->input('time');
         $post->body = $request->input('body');
         $post->title = $request->input('title');
         $post->color = $request->input('item_id');
         $post->day = $request->input('day');
         $post->URLi = $fileNameToStore;
         $post->save();
         return redirect('/contact');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $event=event::find($id);
        return view('posts.planning')->with('event', $event);

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
            'time' => 'required',
            'title' => 'required',
            'body' => 'required',
            'event_image' => 'max:1999',
        ]);
        $post = event::find($id);
        if($request->hasFile('event_image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('event_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('event_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('event_image')->storeAs('public/event_image', $fileNameToStore);

        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        // Update Post

        $post->time = $request->input('time');
         $post->body = $request->input('body');
         $post->title = $request->input('title');
         $post->color = $request->input('item_id');
         $post->day = $request->input('day');
         if($request->hasFile('event_image')){
            $post->URLi = $fileNameToStore;
        }
        $post->save();
        return redirect('/contact');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = event::find($id);

        //Check if post exists before deleting
        if (!isset($post)){
            return redirect('/contact');
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
            Storage::delete('public/event_image/'.$post->URLi);
        }

        $post->delete();
        return redirect('/contact');
    }
}
