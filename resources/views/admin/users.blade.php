<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Người Dùng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: bold;
            display: block;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-add {
            background: green;
            color: white;
        }
        .btn-edit {
            background: orange;
            color: white;
        }
        .btn-delete {
            background: red;
            color: white;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f8f8f8;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Quản lý Người Dùng</h2>

    <!-- Form thêm người dùng -->
    <div class="form-group">
        <label for="userName">Tên:</label>
        <input type="text" id="userName" placeholder="Nhập tên">
    </div>
    <div class="form-group">
        <label for="userEmail">Email:</label>
        <input type="email" id="userEmail" placeholder="Nhập email">
    </div>
    <div class="form-group">
        <label for="userPassword">Mật khẩu:</label>
        <input type="password" id="userPassword" placeholder="Nhập mật khẩu (ít nhất 8 ký tự)">
    </div>
    <button class="btn btn-add" onclick="addUser()">Thêm Người Dùng</button>
    <div id="errorMessage" class="error"></div>

    <!-- Bảng danh sách người dùng -->
    <table id="userTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody id="userTableBody">
            @foreach ($users as $user)
                <tr data-id="{{ $user->id }}">
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <button class="btn btn-edit" onclick="editUser('{{ $user->id }}')">Sửa</button>
                        <button class="btn btn-delete" onclick="deleteUser('{{ $user->id }}')">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal để sửa người dùng -->
<div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5);">
    <div style="background: white; width: 400px; margin: 100px auto; padding: 20px; border-radius: 8px;">
        <h3>Sửa Người Dùng</h3>
        <div class="form-group">
            <label for="editName">Tên:</label>
            <input type="text" id="editName">
        </div>
        <div class="form-group">
            <label for="editEmail">Email:</label>
            <input type="email" id="editEmail">
        </div>
        <input type="hidden" id="editUserId">
        <button class="btn btn-edit" onclick="updateUser()">Lưu</button>
        <button class="btn" style="background: gray; color: white;" onclick="closeModal()">Hủy</button>
    </div>
</div>

<script>
    // Hiển thị thông báo lỗi
    function showError(message) {
        document.getElementById('errorMessage').textContent = message;
    }

    // Xóa form sau khi thêm
    function clearForm() {
        document.getElementById('userName').value = '';
        document.getElementById('userEmail').value = '';
        document.getElementById('userPassword').value = '';
    }

    // Thêm người dùng
    function addUser() {
        const name = document.getElementById('userName').value;
        const email = document.getElementById('userEmail').value;
        const password = document.getElementById('userPassword').value;

        if (!name || !email || !password) {
            showError('Vui lòng nhập đầy đủ thông tin!');
            return;
        }

        fetch('/users', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ name, email, password }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const tableBody = document.getElementById('userTableBody');
                const row = `
                    <tr data-id="${data.user.id}">
                        <td>${data.user.id}</td>
                        <td>${data.user.name}</td>
                        <td>${data.user.email}</td>
                        <td>
                            <button class="btn btn-edit" onclick="editUser('${data.user.id}')">Sửa</button>
                            <button class="btn btn-delete" onclick="deleteUser('${data.user.id}')">Xóa</button>
                        </td>
                    </tr>`;
                tableBody.innerHTML += row;
                clearForm();
                showError('');
            } else {
                showError(data.message);
            }
        })
        .catch(error => {
            showError('Lỗi: ' + error.message);
        });
    }

    // Mở modal để sửa người dùng
    function editUser(userId) {
        const row = document.querySelector(`tr[data-id="${userId}"]`);
        const name = row.children[1].textContent;
        const email = row.children[2].textContent;

        document.getElementById('editName').value = name;
        document.getElementById('editEmail').value = email;
        document.getElementById('editUserId').value = userId;
        document.getElementById('editModal').style.display = 'block';
    }

    // Đóng modal
    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    // Cập nhật người dùng
    function updateUser() {
        const userId = document.getElementById('editUserId').value;
        const name = document.getElementById('editName').value;
        const email = document.getElementById('editEmail').value;

        if (!name || !email) {
            showError('Vui lòng nhập đầy đủ thông tin!');
            return;
        }

        fetch(`/users/${userId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ name, email }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const row = document.querySelector(`tr[data-id="${userId}"]`);
                row.children[1].textContent = name;
                row.children[2].textContent = email;
                closeModal();
                showError('');
            } else {
                showError(data.message);
            }
        })
        .catch(error => {
            showError('Lỗi: ' + error.message);
        });
    }

    // Xóa người dùng
    function deleteUser(userId) {
        if (!confirm('Bạn có chắc chắn muốn xóa người dùng này?')) {
            return;
        }

        fetch(`/users/${userId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const row = document.querySelector(`tr[data-id="${userId}"]`);
                row.remove();
                showError('');
            } else {
                showError(data.message);
            }
        })
        .catch(error => {
            showError('Lỗi: ' + error.message);
        });
    }
</script>

</body>
</html>