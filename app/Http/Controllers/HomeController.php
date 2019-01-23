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
            $highlighted = $request->session()->get('postid', -2);
            $highlighteddes = Thing::find($highlighted)->description;
        }


        $listofthings = Ownership::where('user', '=', Auth::User()->id)->pluck('thing')->toArray();
        $thingstoshow = Thing::find($listofthings)->where('completed', '=', false)->where('parent', '=', -1);
        $sideboardtoshow = Thing::all()->where('completed', '=', false)->where('parent', '=', $highlighted);


        return view('home', ['empty' => $thingstoshow->isEmpty(), 'things' => $thingstoshow, 'highlight' => $highlighted, 'highdes' => $highlighteddes, 'sideboard'=> $sideboardtoshow]);

    }

    public function customses(Request $data, $postid)
    {
        if (Ownership::where('thing', $postid)->where('user', Auth::User()->id)->exists())
        {
            $data->session()->flash('postid', $postid);
            return redirect()->route('home', ['request' => $data]);
        }
        else return redirect()->route('home')->with('error','You have no permission for this page!');

    }


    public function create(Request $data)
    {
        if($data->has('postid'))
        {
            if($data->has('description'))
            {
                modifyEntry::dispatch($data);
                return redirect()->route('home')->with('success','Entry Successfully Modified');
            }
            else if($data->has('owner'))
            {
                if (User::where('email', $data->owner) -> exists())
                {
                    if (Ownership::where('thing', $data->postid) -> where('user', User::where('email', $data->owner)->first()->id) -> exists())
                    {
                        return redirect()->route('home')->with('error',$data->owner . 'is already a contributor to this entry');
                    }
                    else
                    {
                        addContributor::dispatch($data);
                        return redirect()->route('home')->with('success',$data->owner . ' added as contributor on this entry');
                    }
                }
                else return redirect()->route('home')->with('error',$data->owner . ' does not exist on this system');
            }
            else
            {
                markCompleted::dispatch($data);
                if(Thing::find($data->postid)->parent > -1)
                    $data->session()->flash('postid', Thing::find($data->postid)->parent);
                return redirect()->route('home')->with('success','Entry Removed');
            }
        }
        else 
        {
            if($data->has('parent'))
            {
                addSubEntry::dispatch($data);
                $data->session()->flash('postid', $data->parent);
            }
            else if($data->has('description'))
            {
                createNewEntry::dispatch($data);
                return redirect()->route('home')->with('success','New Entry Successfully Added');
            }
        }
        return redirect()->route('home');
    }
}
