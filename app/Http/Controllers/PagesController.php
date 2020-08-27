<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Podcast;
use App\event;
class PagesController extends Controller
{



    public function home(){
        return view('pages.home');
    }

    public function audio(){

      //  $podcasts = Podcast::orderBy('created_at','desc')->paginate(6);
      //  return view('pages.feature')->with('podcasts', $podcasts);
    }
    public function feature(){
        return view('pages.feature');
    }
    public function contact(){

        $events = event::All();
        return view('pages.contact')->with('events', $events);
    }


}
