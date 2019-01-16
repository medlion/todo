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
                        @foreach ($things as $thing)
                            @if ($highlight == $thing->id)
                                <a type="button" href="{{ route('home') }}/{{ $thing->id }}" class="btn btn-primary btn-block" >{{ $thing->description }}</a>
                            @else
                                <a type="button" href="{{ route('home') }}/{{ $thing->id }}" class="btn btn-default btn-block" >{{ $thing->description }}</a>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            @if ( $highlight > 0)
            <div class="card">
                <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        <button type="button" class="btn btn-warning">Warning</button>
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