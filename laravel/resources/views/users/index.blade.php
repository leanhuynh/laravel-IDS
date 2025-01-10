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
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">Create New User</button>
        <!-- Modal -->
        <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">Create User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                @error('name')
                                    <div class='text-danger'>{{ $message }}</div>
                                @enderror
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email">Email</label>
                                @error('email')
                                    <div class='text-danger'>{{ $message }}</div>
                                @enderror
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password">Password</label>
                                @error('password')
                                    <div class='text-danger'>{{ $message }}</div>
                                @enderror
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success mt-3">Save User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
                    <tr id="tr-{{$user->id}}">
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal-{{$user->id}}">
                                Edit User
                            </button>                           
                            <!-- Modal -->
                            <div class="modal fade" id="editUserModal-{{$user->id}}" tabindex="-1" aria-labelledby="editUserModalLabel-{{$user->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
                                        <!-- <form method="POST"> -->
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
                                                    <input type="text" class="form-control" id="name-{{$user->id}}" name="name" value="{{ $user->name }}" required>
                                                </div>
                                                <!-- Email -->
                                                <div class="mb-3">
                                                    <label for="email">Email</label>
                                                    @error('email')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                    <input type="email" class="form-control" id="email-{{$user->id}}" name="email" value="{{ $user->email }}" required>
                                                </div>
                                                <!-- Password -->
                                                <div class="mb-3">
                                                    <label for="password">Password (Leave blank to keep current)</label>
                                                    @error('password')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                    <input type="password" class="form-control" id="password-{{$user->id}}" name="password">
                                                </div>
                                                <!-- Confirm password -->
                                                <div class="mb-3">
                                                    <label for="password_confirmation">Confirm Password</label>
                                                    <input type="password" class="form-control" id="password_confirmation-{{$user->id}}" name="password_confirmation">
                                                </div>
                                                <div style="display:none;">
                                                    <input type="text" class="form-control" id="user-{{$user->id}}" name="user-{{$user->id}}" value="{{$user->id}}">
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
                            
                            <form data-url="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            <!-- <form style="display:inline;"> -->
                                @csrf
                                <!-- @method('DELETE') -->
                                 <div style="display:none;">
                                    <input type="text" class="form-control" id="user-{{$user->id}}-delete" name="user-{{$user->id}}-delete" value="{{$user->id}}">
                                </div>
                                <button type="submit" class="btn btn-danger" data-id="{{$user->id}}">Delete</button>
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

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Lắng nghe sự kiện click trên nút "Submit" của tất cả các form
        $(document).on("click", ".btn.btn-danger", function (event) {
            event.preventDefault();
            var userId = $(this).data("id");
            var row = $("#tr-" + userId);
            var $form = $(this).closest("form"); // Lấy form cụ thể chứa nút được nhấn
            var url = $form.data("url");
            // var formData = $form.serialize(); // Lấy dữ liệu từ form đó
            var csrfToken = $form.find('input[name="_token"]').val();
            if (!confirm("Do you want to delete this user?")) {
                return;
            }

            $.ajax({
                url: url,
                method: "POST",
                data: { _token: csrfToken, _method: "DELETE" }, // Gửi CSRF token
                success: function (response) {
                    // thay đổi html
                    row.remove();
                    // Hiển thị thông báo thành công
                    alert("Success: " + response.message);
                },
                error: function (xhr) {
                    alert("Error: " + xhr.responseJSON.message); // Hiển thị lỗi
                }
            });
        });
    });
</script>