@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Profile</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="form-group">
            <label for="bio">Bio</label>
            <textarea name="bio" class="form-control">{{ $user->bio }}</textarea>
        </div>

        <div class="form-group">
            <label for="birthdate">Birthdate</label>
            <input type="date" name="birthdate" class="form-control" value="{{ $user->birthdate }}">
        </div>

        <div class="form-group">
            <label for="avatar">Profile Picture</label>
            <input type="file" name="avatar" class="form-control">
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="mt-2" style="width: 150px;">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>
@endsection
