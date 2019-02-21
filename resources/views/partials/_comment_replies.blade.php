<!-- _comment_replies.blade.php -->

@foreach($comments as $comment)
<div class="display-comment">
    <strong>{{ ucfirst($comment->user->name) }}</strong>
    <p>{{ $comment->body }}</p>
    <!--<a href="javascript:void(0);"><p class="reply">Reply</p></a>-->
    <input type="button" class="btn btn-sm reply" value="Reply" />

    <div class="reply_form" style="display:none; margin: 10px">
        <form method="post" action="{{ route('reply.add') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <input type="text" name="comment_body" class="form-control" required/>
            <div style="color: red">
                {{ $errors->replyErrors->first('comment_body', ':message') }}
            </div>
            <input type="hidden" name="post_id" value="{{ $post_id }}" />
            <input type="hidden" name="comment_id" value="{{ $comment->id }}" />
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Reply" />
        </div>
    </form>
    </div>
    @include('partials._comment_replies', ['comments' => $comment->replies])
</div>
@endforeach
@section('js')
<script type="text/javascript">
  $(document).ready(function() {
    $(document).on('click', '.reply', function(){
      $(this).next('.reply_form').toggle('swing');
    });
});
</script>
@endsection