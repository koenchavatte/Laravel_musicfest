@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>

            <!-- Sectie voor Nieuwsberichten -->
            <div class="card">
                <div class="card-header">{{ __('Latest News') }}</div>

                <div class="card-body">
                    @if($newsItems->isEmpty())
                        <p>No news available.</p>
                    @else
                        @foreach($newsItems as $news)
                            <div class="card mb-3">
                                @if($news->cover_image)
                                    <img src="{{ asset('storage/' . $news->cover_image) }}" class="card-img-top" alt="{{ $news->title }}">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $news->title }}</h5>
                                    <p class="card-text">{{ Str::limit($news->content, 150) }}</p>
                                    <p class="card-text"><small class="text-muted">Published on {{ $news->published_at->format('M d, Y') }}</small></p>
                                    <!-- Link naar volledige nieuwsbericht -->
                                    <a href="{{ route('news.show', $news) }}" class="btn btn-primary">Read More</a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
