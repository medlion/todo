@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Your To-do List</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($empty)
                        Nothing To Display
                    @else
                    <div class="list-group">
                        @foreach ($things as $thing)
                            @if ($highlight == $thing->id)
                                <a href="{{ route('home') }}/{{ $thing->id }}" class="list-group-item" data-toggle="tooltip" title="{{ $thing->description }}">{{ $thing->description }}</a>
                            @else
                                <a href="{{ route('home') }}/{{ $thing->id }}" class="list-group-item" data-toggle="tooltip" title="{{ $thing->description }}">{{ $thing->description }}</a>
                            @endif
                        @endforeach
                    @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            @if ( $highlight > 0)
            <div class="card">
                <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#deleteconfirm">Delete Entry</button>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modifymodal">Modify Entry</button>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addcontributor">Add Contributor</button>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addsubentry">Add Sub Entry</button>
                    @include('areyousure')
                    @include('modifything')
                    @include('addcontributor')
                    @include('addsubentry')
                    <ul class="list-group">
                    @foreach ($sideboard as $side)
                        <li class="list-group-item">{{$side->description}}
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#subconfirm">-</button>
                        </li>
                        @include('subconfirm')
                    @endforeach
                    </ul>
                    </div>
                </div>
            </div>
            @endif
        </div>


    </div>
</div>
@endsection


@section('createnewmodal')
    <!-- The Modal -->
      <!-- Modal Header -->
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
      <!-- Modal body -->
      <div class="modal-body">
      <form method="post" action="{{ route('create') }}">
        <div class="form-group">
            @csrf
            <label for="name">To Do Entry</label>
            <input type="text" class="form-control" name="description"/>
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
    </form>
      </div>
@endsection