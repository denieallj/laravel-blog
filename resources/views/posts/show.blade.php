@extends('layouts/app')

@section('content')
    <div class="show-post-header">
        <h1>{{ $post->title }}</h1>

        {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST']) !!}
             {{ Form::hidden('_method', 'DELETE') }}
            <div>
                {{-- if guest then hide button or else show --}}
                @if (!Auth::guest())
                    
                    {{-- Make sure button only appears when the post belongs to the particular user --}}
                    @if (Auth::user()->id == $post->user_id)
                        <a class="btn btn-md btn-warning" href="/posts/{{ $post->id }}/edit">Edit</a>

                        {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                    @endif

                @endif
                
                <a class="btn btn-md btn-primary" href="/posts">Go Back</a>
            </div>
        {!! Form::close() !!}
    </div>

    <br>

    @if($post->cover_img == "noImage.png") 
        <img src="/storage/cover_images/{{ $post->cover_img }}" alt="image">
    @else
        <img style="width: 100%" src="/storage/cover_images/{{ $post->cover_img }}" alt="image">
    @endif

    <br><br>

    {!! $post->body !!}

    <hr>

    <div class="post">
        <small class="created_at">Written on {{ $post->created_at }}, by {{ $post->user->name }}</small>
    </div>
@endsection