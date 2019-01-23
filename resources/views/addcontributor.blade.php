<div id="addcontributor" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            <form method="post" action="{{ route('create') }}">
                <div class="form-group">
                @csrf
                <label for="name">Email address of contributor account</label>
                <input type="text" class="form-control" name="owner"/>
                <input type="hidden" value="{{ $highlight }}" name="postid"/>
                </div>
            <button type="submit" class="btn btn-primary">Add</button>
            </form>
            </div>
        </div>
    </div>
</div>