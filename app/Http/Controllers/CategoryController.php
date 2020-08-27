<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Filesystem\Filesystem;
use DB;
use App\Podcast;
use File;
class CategoryController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorys = Category::orderBy('created_at','desc')->paginate(6);
        return view('pages.category')->with('categorys', $categorys);
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
            'category_image' => 'image|nullable|max:1999',
        ]);
        $idc=DB::table('categories')->max('id')+1;
 // Handle File Upload
 if($request->hasFile('category_image')){
    // Get filename with the extension
    $filenameWithExt = $request->file('category_image')->getClientOriginalName();
    // Get just filename
    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
    // Get just ext
    $extension = $request->file('category_image')->getClientOriginalExtension();
    // Filename to store
    $fileNameToStore= $filename.'_'.time().'.'.$extension;
    // Upload Image

    $path = $request->file('category_image')->storeAs('public/category/'.$idc, $fileNameToStore);

// make thumbnails
/*                                                                {{ Form::hidden('id',$Category->id) }}
$thumbStore = 'thumb.'.$filename.'_'.time().'.'.$extension;
    $thumb = Image::make($request->file('post_image')->getRealPath());
    $thumb->resize(80, 80);
    $thumb->save('storage/post_image/'.$thumbStore);*/

} else {
    $fileNameToStore = 'noimage.jpg';
}

         // Create Post
         $post = new Category;
         $post->id=$idc;
         $post->title = $request->input('title');
         $post->color = $request->input('item_id');
         $post->URLi = $fileNameToStore;
         $post->save();
         return redirect('/category');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $podcasts=Podcast::where('idcategory', $id)->paginate(6);
        $Category=Category::find( $id);
        $Categorys=Category::All();
       // {{ Form::hidden('id',$Category->id) }}
        return view('pages.feature')->with('Category', $Category)->with('podcasts', $podcasts)->with('Categorys', $Categorys);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $post=Category::find($id);
        //Check if post exists before deleting
        if (!isset($post)){
            return redirect('/category');
        }

        // Check for correct user
       /* if(auth()->user()->id !==$post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }*/
          File::deleteDirectory(public_path('storage/category/'.$post->id));
            //DB::delete('delete from podcasts');
            DB::table('podcasts')->where('idcategory',$post->id)->delete();
        $post->delete();
        return redirect('/category');

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
        $post = Podcast::find($id);
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
    $path = $request->file('podcast_image')->storeAs('public/category/'.$request->input('item_idp').'/podcast_image', $fileNameToStore);
} else {
    Storage::move('public/category/'.$post->idcategory.'/podcast_image/'.$post->URLi, 'public/category/'.$request->input('item_idp').'/podcast_image/'.$post->URLi);
  //  $path = $request->file('public/category/'.$post->idcategory.'/podcast_image/'.$post->URLi)->storeAs('public/category/'.$request->input('item_idp').'/podcast_image', $post->URLi);
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
    $path = $request->file('podcast_file')->storeAs('public/category/'.$request->input('item_idp').'/podcast_file', $fileNameToStorea);

} else {
    Storage::move('public/category/'.$post->idcategory.'/podcast_file/'.$post->URLa, 'public/category/'.$request->input('item_idp').'/podcast_file/'. $post->URLa);
}


         $post->title = $request->input('title');
         $post->body = $request->input('body');
         $post->idcategory = $request->input('item_idp');
         if($request->hasFile('podcast_image')){
            $post->URLi = $fileNameToStore;
        }
        if($request->hasFile('podcast_file')){
            $post->URLa = $fileNameToStorea;
        }
         $post->save();
         return redirect('/category/'.$request->input('item_idp'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Podcast::find($id);

        //Check if post exists before deleting
        if (!isset($post)){
            return redirect('/category');
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
            Storage::delete('public/category/'.$post->idcategory.'/podcast_image/'.$post->URLi);
        }
        if($post->URLa != 'test.mp3'){
            Storage::delete('public/category/'.$post->idcategory.'/podcast_file/'.$post->URLa);
        }

        $post->delete();
        return redirect('/category/'.$post->idcategory);
    }
     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatecaCategory(Request $request,$id)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);
        $post=Category::find( $id);
 // Handle File Upload
 if($request->hasFile('category_image')){
    // Get filename with the extension
    $filenameWithExt = $request->file('category_image')->getClientOriginalName();
    // Get just filename
    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
    // Get just ext
    $extension = $request->file('category_image')->getClientOriginalExtension();
    // Filename to store
    $fileNameToStore= $filename.'_'.time().'.'.$extension;
    // Upload Image

    $path = $request->file('category_image')->storeAs('public/category/'.$post->id, $fileNameToStore);

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
         $post->title = $request->input('title');
         $post->color = $request->input('item_idc');
         if($request->hasFile('category_image')){
         $post->URLi = $fileNameToStore;
         }
         $post->save();
         return redirect('/category');
    }
}
