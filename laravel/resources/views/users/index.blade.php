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
                    id="searchInput"
                >
                <!-- value="{{ $search ?? '' }}" -->
                <button id="searchButton" type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <h1>Users</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">Create New User</button>
        
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr id="tr-{{$user->id}}">
                        @if ($user->avatar)
                            <td><img src="{{ asset('storage/' . $user->avatar) }}" alt="Uploaded Image" style="height:50px; width:50px"/></td>
                        @else 
                            <td>No Image</td>
                        @endif
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal" data-id="{{$user->id}}" data-name="{{$user->name}}" data-email="{{$user->email}}">
                                Edit User
                            </button>                           
                            
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
        
        <div id="pagination" style="width:50%; justify-content:center">
            <!-- Hiển thị các liên kết phân trang -->
           {{ $users->links() }}
        </div>
    </div>

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="createUserForm" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUserModalLabel">Create User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" data-></button>
                    </div>
                    <div class="modal-body">
                        <!-- avatar -->
                        <div class="mb-3">
                            <label for="avatar">Image</label>
                            <!-- @error('avatar')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror -->
                            <input type="file" class="form-control" name="avatar" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <!-- @error('name')
                                <div class='text-danger'>{{ $message }}</div>
                            @enderror -->
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <!-- @error('email')
                                <div class='text-danger'>{{ $message }}</div>
                            @enderror -->
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password">Password</label>
                            <!-- @error('password')
                                <div class='text-danger'>{{ $message }}</div>
                            @enderror -->
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

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editUserForm" action="{{ route('users.update', 'user_id') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- avatar -->
                        <div class="mb-3">
                            <label for="avatar">Image</label>
                            <!-- @error('avatar')
                                <div class="text-danger">{{ $message }} </div>
                            @enderror -->
                            <input type="file" class="form-control" name="avatar" accept="image/*">
                        </div>
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <!-- @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror -->
                            <input type="text" class="form-control" id="edit_name" name="name" value="{{ $user->name }}" required>
                        </div>
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <!-- @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror -->
                            <input type="email" class="form-control" id="edit_email" name="email" value="{{ $user->email }}" required>
                        </div>
                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password">Password (Leave blank to keep current)</label>
                            <!-- @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror -->
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
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // DELETE USER
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
                type: "DELETE",
                data: { _token: csrfToken }, // Gửi CSRF token
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

        // CREATE USER
        $('#createUserForm').on("submit", function(e) {
            e.preventDefault();
            
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    // $('#createUserModal').trigger('reset');
                    $('#createUserModal').modal('hide');

                    // thêm người dùng mới
                    let avatarHTML = response.user.avatar ? `<td><img src="/storage/${response.user.avatar}" alt="Uploaded Image" style="height:50px; width:50px"/></td>` : `<td>No Image</td>`;
                    let newUserRow = `
                        <tr id="tr-${response.user.id}">
                            ${avatarHTML}
                            <td>${response.user.name}</td>
                            <td>${response.user.email}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal" data-id="${response.user.id}" data-name="${response.user.name}" data-email="${response.user.email}">
                                    Edit User
                                </button>                           
                                
                                <form data-url="/users/${response.user.id}" method="POST" style="display:inline;">
                                    @csrf
                                    <div style="display:none;">
                                        <input type="text" class="form-control" id="user-${response.user.id}-delete" name="user-${response.user.id}-delete" value="${response.user.id}">
                                    </div>
                                    <button type="submit" class="btn btn-danger" data-id="${response.user.id}">Delete</button>
                                </form>
                            </td>
                        </tr>
                    `;

                    $('table tbody').append(newUserRow);
                    // hiện thị thông báo thành công
                    alert(response.message);
                },
                error: function(xhr) {
                    let errorMessage = 'Something went wrong!';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.status === 422) {
                        // Xử lý lỗi validation
                        let errors = xhr.responseJSON.errors;
                        errorMessage = Object.values(errors).flat().join('\n');
                    }
                    alert(errorMessage);
                }
            });
        });

        // EDIT USER
        $('#editUserModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var userId = button.data('id');
            var userName = button.data('name');
            var userEmail = button.data('email');

            var modal = $(this);
            modal.find('#edit_name').val(userName);
            modal.find('#edit_email').val(userEmail);

            var formAction = '{{ route('users.update', ':id') }}';
            formAction = formAction.replace(':id', userId);
            modal.find('form').attr('action', formAction);
        });

        $('#editUserForm').on('submit', function (event) {
            event.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    alert(response.message);
                    if (response.user) {
                        // $('#editUserModal')[0].reset();
                        $('#editUserModal').modal('hide');
                        
                        let avatarHTML = response.user.avatar ? `<td><img src="/storage/${response.user.avatar}" alt="Uploaded Image" style="height:50px; width:50px"/></td>` : `<td>No Image</td>`;
                        let updatedRow = `
                            <tr id="tr-${response.user.id}">
                                ${avatarHTML}
                                <td>${response.user.name}</td>
                                <td>${response.user.email}</td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal" data-id="${response.user.id}" data-name="${response.user.name}" data-email="${response.user.email}">
                                        Edit User
                                    </button>                           
                                    
                                    <form data-url="/users/${response.user.id}" method="POST" style="display:inline;">
                                        @csrf
                                        <div style="display:none;">
                                            <input type="text" class="form-control" id="user-${response.user.id}-delete" name="user-${response.user.id}-delete" value="${response.user.id}">
                                        </div>
                                        <button type="submit" class="btn btn-danger" data-id="${response.user.id}">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        `;

                        // tìm kiếm bên trong <tbody> sao cho button có data-id=response.user.id (nút delete)
                        let row = $('table tbody').find(`button[data-id="${response.user.id}"]`).closest('tr');
                        if (row.length) {
                            row.replaceWith(updatedRow);
                        } else {
                            $('table tbody').append(updatedRow);
                        }
                    }
                },
                error: function(xhr) {
                    alert("Error: " + xhr.responseJSON.message); // Hiển thị lỗi
                }
            });
        });

        // SEARCH USER
        $("#searchButton").on("click", function(event) {
            event.preventDefault();
            const query = $('#searchInput').val() ?? '';

            $.ajax({
                url: `{{ route('users.search') }}/search?keyword=${query}`,
                method: 'GET',
                success: function(response) {
                    $('#pagination').remove();
                    let searchUserHtml = '';
                    let avatarHTML = '';

                    for (let user of response.users) {
                        avatarHTML = user.avatar ? `<td><img src="/storage/${user.avatar}" alt="Uploaded Image" style="height:50px; width:50px"/></td>` : `<td>No Image</td>`;
                        searchUserHtml += `
                            <tr id="tr-${user.id}">
                                ${avatarHTML}
                                <td>${user.name}</td>
                                <td>${user.email}</td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal" data-id="${user.id}" data-name="${user.name}" data-email="${user.email}">
                                        Edit User
                                    </button>                           
                                    
                                    <form data-url="/users/${user.id}" method="POST" style="display:inline;">
                                        @csrf
                                        <div style="display:none;">
                                            <input type="text" class="form-control" id="user-${user.id}-delete" name="user-${user.id}-delete" value="${user.id}">
                                        </div>
                                        <button type="submit" class="btn btn-danger" data-id="${user.id}">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        `;
                    }

                    $('table tbody').html(searchUserHtml);
                    // $('pagination').html(response.users.)
                },
                error: function(xhr) {
                    alert("Error: " + xhr.responseJSON.message); // Hiển thị lỗi
                }
            });
        });
    });
</script>