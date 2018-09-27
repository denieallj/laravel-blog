@extends('layouts/app');

@section('content')
    @if (count($posts) == 0)
        <h1>Nothing to display</h1>
    @else
        @foreach ($posts as $post)
            <div class="well post">
                <div class="row">
                    <div class="col-md-4">
                        <img style="height: 200px; width: 100%" src="/storage/cover_images/{{ $post->cover_img }}" alt="image">
                    </div>

                    <div class="col-md-8">
                        <h3><a href="/posts/{{ $post->id }}">{{ $post->title }}</a></h3>
                        <small class="created_at">Written on {{ $post->created_at }}, by {{ $post->user->name }}</small>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="page">
            {{ $posts->links() }}
        </div>
        
    @endif
@endsection