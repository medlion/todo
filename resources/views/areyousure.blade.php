<div id="deleteconfirm" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            <form method="post" action="{{ route('create') }}">
                <div class="form-group">
                @csrf
                <label for="name">Are You Sure You Want To Delete This Entry?</label>
                <input type="hidden" value="{{ $highlight }}" name="postid"/>
            </div>
            <button type="submit" class="btn btn-primary">Yes, I'm sure</button>
            </form>
            </div>
        </div>
    </div>
</div>