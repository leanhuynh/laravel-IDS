@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Search Users</h1>

        <!-- Thanh tìm kiếm -->
        <form action="{{ route('users.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Search by name or email"
                    value="{{ $search ?? '' }}"
                >
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <h1>Users</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary">Create New User</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="width:50%; justify-content:center">
            <!-- Hiển thị các liên kết phân trang -->
           {{ $users->links() }}
        </div>
    </div>
@endsection
