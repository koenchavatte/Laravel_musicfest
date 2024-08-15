@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $news->title }}</h1>
    <p><small>Published on {{ $news->published_at->format('M d, Y') }}</small></p>

    @if($news->cover_image)
        <img src="{{ asset('storage/' . $news->cover_image) }}" class="img-fluid mb-3" alt="{{ $news->title }}">
    @endif

    <p>{{ $news->content }}</p>

    <a href="{{ route('news.index') }}" class="btn btn-secondary">Back to News</a>
</div>
@endsection
