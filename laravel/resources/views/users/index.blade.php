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
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal">
                                Edit User
                            </button>                           
                            <!-- Modal -->
                            <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Name -->
                                                <div class="mb-3">
                                                    <label for="name">Name</label>
                                                    @error('name')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                                                </div>
                                                <!-- Email -->
                                                <div class="mb-3">
                                                    <label for="email">Email</label>
                                                    @error('email')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                                                </div>
                                                <!-- Password -->
                                                <div class="mb-3">
                                                    <label for="password">Password (Leave blank to keep current)</label>
                                                    @error('password')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                    <input type="password" class="form-control" id="password" name="password">
                                                </div>
                                                <!-- Confirm password -->
                                                <div class="mb-3">
                                                    <label for="password_confirmation">Confirm Password</label>
                                                    @error('password')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
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
