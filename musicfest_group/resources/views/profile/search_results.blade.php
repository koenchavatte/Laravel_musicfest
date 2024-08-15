@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Search Results</h1>

    @if($users->isEmpty())
        <p>No users found.</p>
    @else
        <ul>
            @foreach($users as $user)
                <li>
                    <a href="{{ route('profile.public.show', $user->name) }}">{{ $user->name }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
