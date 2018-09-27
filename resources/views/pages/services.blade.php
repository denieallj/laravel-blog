@extends('layouts/app')

@section('content')
        <h1>{{ $title }} {{ Request::path() }}</h1>
        <p>{{ $desc }}</p>

        <ul class="list-group">
           @if (count($services) > 0)
                @foreach ($services as $service)
                    <li class="list-group-item">{{ $service }}</li>
                @endforeach
           @endif
        </ul>
@endsection

