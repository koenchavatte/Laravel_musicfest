@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h2>Create a New User or Admin</h2>
    <form action="{{ route('admin.create') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="role_toggle">Admin Account</label>
            <input type="checkbox" name="is_admin" id="role_toggle" class="form-check-input">
        </div>
        <button type="submit" class="btn btn-primary">Create Account</button>
    </form>

    <hr>

    <!-- Knop om de lijst met gebruikers te tonen/verbergen -->
    <button id="toggle-users" class="btn btn-secondary">Show/Hide Users</button>

    <div id="user-list" style="display:none;">
        <h2>Promote Users to Admin</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <form action="{{ route('admin.promote', $user) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Promote to Admin</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    // JavaScript om de lijst met gebruikers te tonen/verbergen
    document.getElementById('toggle-users').addEventListener('click', function() {
        var userList = document.getElementById('user-list');
        if (userList.style.display === 'none' || userList.style.display === '') {
            userList.style.display = 'block';
        } else {
            userList.style.display = 'none';
        }
    });
</script>
@endsection
