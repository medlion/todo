<?php

namespace App\Http\Controllers;

use App\Thing;
use App\Ownership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function index(Request $request)
    {
        $highlighted = -1;
        if ($request->session()->has('postid')) {
            // Write validation
            $highlighted = $request->session()->get('postid', -2);
        }


        $listofthings = Ownership::where('user', '=', Auth::User()->id)->pluck('thing')->toArray();
        $thingstoshow = Thing::find($listofthings);


        return view('home', ['empty' => $thingstoshow->isEmpty(), 'things' => $thingstoshow, 'highlight' => $highlighted]);

    }

    public function customses(Request $request, $postid)
    {
        $request->session()->flash('postid', $postid);
        return redirect()->route('home');
    }


    public static function create(Request $data)
    {
        $thingy = new Thing;
        $thingy->description = $data->description;
        $thingy->save();

        $ownery = new Ownership;
        $user = Auth::User();
        $ownery->user = $user->id;
        $ownery->thing = $thingy->id;
        $ownery->save();

        return redirect()->route('home');
    }


    public function markinactive(Request $request)
    {
        $thingy = Thing::find($request->id);
        $thingy->completed = true;
        $thingy->save();

    }
}
