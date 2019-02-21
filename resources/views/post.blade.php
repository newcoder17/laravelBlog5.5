@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Post</div>

                @if (session()->has('error'))
                <div class="m-alert m-alert--icon alert alert-primary" role="alert">
                    <div class="m-alert__icon">
                        <i class="la la-warning"></i>
                    </div>
                    <div class="m-alert__text">
                        {!! session()->get('error') !!}
                    </div>
                    <div class="m-alert__close">
                        <button type="button" class="close" data-close="alert" aria-label="Close"></button>
                    </div>
                </div>
                @endif
                <div class="card-body">
                    <form method="post" action="{{ route('post.store') }}" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <label class="label" style="color: black">Post Title: </label>
                            <input type="text" name="title" class="form-control" required/>
                            <div style="color: red">
                                {{ $errors->postErrors->first('title', ':message') }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="label"  style="color: black">Post Body: </label>
                            <textarea name="body" rows="10" cols="30" class="form-control" required></textarea>
                            <div style="color: red">
                                {{ $errors->postErrors->first('body', ':message') }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="label"  style="color: black">Post Image: </label>
                            <input type="file" class="form-control" name="image" required/>
                            <div style="color: red">
                                {{ $errors->postErrors->first('image', ':message') }}
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection