@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <form action="{{ route('admin.promote', $user) }}" method="POST">
                    @csrf
                    <button type="submit">Promote to Admin</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
