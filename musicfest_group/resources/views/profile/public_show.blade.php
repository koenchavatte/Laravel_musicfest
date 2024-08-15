@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $user->name }}'s Profile</h1>

    <div class="form-group">
        <label for="bio">Bio</label>
        <p>{{ $user->bio }}</p>
    </div>

    <div class="form-group">
        <label for="birthdate">Birthdate</label>
        <p>{{ $user->birthdate }}</p>
    </div>

    <div class="form-group">
        <label for="avatar">Profile Picture</label>
        @if($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="mt-2" style="width: 150px;">
        @else
            <p>No profile picture.</p>
        @endif
    </div>
</div>
@endsection
