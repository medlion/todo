<?php

namespace App\Jobs;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Thing;
use App\Ownership;

class createNewEntry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Request $data)
    {
        //
        $thingy = new \App\Thing;
        $thingy->description = $data->description;
        $thingy->save();

        $ownery = new \App\Ownership;
        $user = Auth::User();
        $ownery->user = $user->id;
        $ownery->thing = $thingy->id;
        $ownery->save();
    }
}
