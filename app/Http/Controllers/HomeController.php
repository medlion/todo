<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Jobs\createNewEntry;
use App\Jobs\modifyEntry;
use App\Jobs\markCompleted;
use App\Jobs\addContributor;
use App\Jobs\addSubEntry;
use App\Thing;
use App\Ownership;
use App\User;

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
        $highlighteddes = "";
        if ($request->session()->has('postid')) {
            // Write validation

            if (Ownership::where('thing', $request->session()->get('postid'))->where('user', Auth::User()->id)-> exists())
            {
                $highlighted = $request->session()->get('postid', -2);
                $highlighteddes = Thing::find($highlighted)->description;
            }
        }


        $listofthings = Ownership::where('user', '=', Auth::User()->id)->pluck('thing')->toArray();
        $thingstoshow = Thing::find($listofthings)->where('completed', '=', false)->where('parent', '=', -1);
        $sideboardtoshow = Thing::all()->where('completed', '=', false)->where('parent', '=', $highlighted);


        return view('home', ['empty' => $thingstoshow->isEmpty(), 'things' => $thingstoshow, 'highlight' => $highlighted, 'highdes' => $highlighteddes, 'sideboard'=> $sideboardtoshow]);

    }

    public function customses(Request $request, $postid)
    {
        $request->session()->flash('postid', $postid);
        return redirect()->route('home');
    }


    public function create(Request $data)
    {
        if($data->has('id'))
        {
            if($data->has('description'))
            {
                modifyEntry::dispatch($data);
                return redirect()->route('post', $data->id);
            }
            else if($data->has('owner'))
            {
                if (User::where('email', $data->owner) -> exists())
                {
                    addContributor::dispatch($data);
                }
                return redirect()->route('post', $data->id);
            }
            else
            {
                markCompleted::dispatch($data);
                if(Thing::find($data->id)->parent > -1)
                {
                    return redirect()->route('post', Thing::find($data->id)->parent);
                }
            }
        }
        else 
        {
            if($data->has('parent'))
            {
                addSubEntry::dispatch($data);
                return redirect()->route('post', $data->parent); 
            }
            else createNewEntry::dispatch($data);
        }

        return redirect()->route('home');
    }
}
