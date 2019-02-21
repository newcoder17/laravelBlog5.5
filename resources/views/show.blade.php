<!-- show.blade.php -->

@extends('layouts.app')
<style>
    .display-comment .display-comment {
        margin-left: 40px
    }
</style>
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <p><b>{{ ucfirst($post->title) }}</b></p>
                    <img src="{{ asset($post->image) }}" width="50%" height="50%" >
                    <p>
                        {{ ucfirst($post->body) }}
                    </p>
                    <hr />
                    <h4>Display Comments</h4>
                    @include('partials._comment_replies', ['comments' => $post->comments, 'post_id' => $post->id])
                    <hr />
                    <h4>Add comment</h4>
                    <form method="post" action="{{ route('comment.add') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <input type="text" name="comment_body" class="form-control" required/>
                            <div style="color: red">
                                {{ $errors->commentErrors->first('comment_body', ':message') }}
                            </div>
                            <input type="hidden" name="post_id" value="{{ $post->id }}" />
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-warning" value="Add Comment" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection