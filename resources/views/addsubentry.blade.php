<div id="addsubentry" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            <form method="post" action="{{ route('create') }}">
                <div class="form-group">
                @csrf
                <label for="name">To Do Entry</label>
                <input type="text" class="form-control" name="description"/>
                <input type="hidden" value="{{ $highlight }}" name="parent"/>
                </div>
            <button type="submit" class="btn btn-primary">Add</button>
            </form>
            </div>
        </div>
    </div>
</div>