<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhân viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 1300px;
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
        .form-group input, .form-group textarea, .form-group select {
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
        .error {
            color: red;
            margin-top: 10px;
        }
        /* Style cho bảng */
        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
            font-size: 16px;
            text-transform: uppercase;
        }
        td {
            font-size: 16px;
            color: #333;
        }
        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tbody tr:hover {
            background-color: #e9f5ff;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 id="form-title">Thêm nhân viên</h2>
    <div id="success-message" class="alert alert-success" style="display: none;"></div>
    <div id="error-message" class="error"></div>

    <form id="employee-form">
        <input type="hidden" name="id" id="id">

        <div class="form-group">
            <label>Tên nhân viên:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Số điện thoại:</label>
            <input type="text" name="phone" id="phone" class="form-control">
        </div>

        <div class="form-group">
            <label>Ngày sinh:</label>
            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control">
        </div>

        <div class="form-group">
            <label>Địa chỉ:</label>
            <textarea name="address" id="address" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label>Chức vụ:</label>
            <input type="text" name="position" id="position" class="form-control">
        </div>

        <div class="form-group">
            <label>Lương:</label>
            <input type="number" name="salary" id="salary" class="form-control" step="0.01">
        </div>

        <button type="submit" class="btn btn-add">Lưu nhân viên</button>
    </form>

    <h2 class="mt-5">Danh sách nhân viên</h2>
    <table id="employee-list">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Ngày sinh</th>
                <th>Địa chỉ</th>
                <th>Chức vụ</th>
                <th>Lương</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
            <tr data-id="{{ $employee->id }}">
                <td>{{ $employee->id }}</td>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->phone ?? 'N/A' }}</td>
                <td>{{ $employee->date_of_birth ?? 'N/A' }}</td>
                <td>{{ $employee->address ?? 'N/A' }}</td>
                <td>{{ $employee->position ?? 'N/A' }}</td>
                <td>{{ $employee->salary ? number_format($employee->salary, 2, ',', '.') : 'N/A' }} VND</td>
                <td>
                    <div class="button-group">
                        <button class="btn btn-edit" onclick="editEmployee('{{ $employee->id }}', '{{ $employee->name }}', '{{ $employee->email }}', '{{ $employee->phone }}', '{{ $employee->date_of_birth }}', '{{ $employee->address }}', '{{ $employee->position }}', '{{ $employee->salary }}')">Sửa</button>
                        <button class="btn btn-delete" onclick="deleteEmployee('{{ $employee->id }}')">Xóa</button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    // Hiển thị thông báo
    function showMessage(elementId, message, isSuccess = true) {
        const element = document.getElementById(elementId);
        element.textContent = message;
        element.style.display = 'block';
        if (isSuccess) {
            element.classList.remove('error');
            element.classList.add('alert', 'alert-success');
        } else {
            element.classList.remove('alert', 'alert-success');
            element.classList.add('error');
        }
    }

    // Xóa form sau khi thêm/sửa
    function clearForm() {
        document.getElementById('employee-form').reset();
        document.getElementById('id').value = '';
        document.getElementById('form-title').textContent = 'Thêm nhân viên';
    }

    // Xử lý form submit qua AJAX
    document.getElementById('employee-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const data = Object.fromEntries(formData);

        fetch('{{ route('admin.employees.storeOrUpdate') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('success-message', data.message);
                showMessage('error-message', '', false);

                const employeeList = document.querySelector('#employee-list tbody');
                const newEmployee = data.employee;
                const newRow = `
                    <tr data-id="${newEmployee.id}">
                        <td>${newEmployee.id}</td>
                        <td>${newEmployee.name}</td>
                        <td>${newEmployee.email}</td>
                        <td>${newEmployee.phone || 'N/A'}</td>
                        <td>${newEmployee.date_of_birth || 'N/A'}</td>
                        <td>${newEmployee.address || 'N/A'}</td>
                        <td>${newEmployee.position || 'N/A'}</td>
                        <td>${newEmployee.salary ? newEmployee.salary.toLocaleString('vi-VN') : 'N/A'} VND</td>
                        <td>
                            <div class="button-group">
                                <button class="btn btn-edit" onclick="editEmployee('${newEmployee.id}', '${newEmployee.name}', '${newEmployee.email}', '${newEmployee.phone}', '${newEmployee.date_of_birth}', '${newEmployee.address}', '${newEmployee.position}', '${newEmployee.salary}')">Sửa</button>
                                <button class="btn btn-delete" onclick="deleteEmployee('${newEmployee.id}')">Xóa</button>
                            </div>
                        </td>
                    </tr>`;

                if (data.isUpdate) {
                    const oldRow = employeeList.querySelector(`[data-id="${newEmployee.id}"]`);
                    if (oldRow) oldRow.outerHTML = newRow;
                } else {
                    employeeList.insertAdjacentHTML('afterbegin', newRow);
                }

                clearForm();
            } else {
                showMessage('error-message', data.message, false);
            }
        })
        .catch(error => {
            showMessage('error-message', 'Lỗi: ' + error.message, false);
        });
    });

    // Hàm chỉnh sửa nhân viên
    function editEmployee(id, name, email, phone, date_of_birth, address, position, salary) {
        document.getElementById('id').value = id;
        document.getElementById('name').value = name;
        document.getElementById('email').value = email;
        document.getElementById('phone').value = phone || '';
        document.getElementById('date_of_birth').value = date_of_birth || '';
        document.getElementById('address').value = address || '';
        document.getElementById('position').value = position || '';
        document.getElementById('salary').value = salary || '';
        document.getElementById('form-title').textContent = 'Chỉnh sửa Nhân viên';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Hàm xóa nhân viên
    function deleteEmployee(id) {
        if (!confirm('Bạn có chắc muốn xóa không?')) return;

        fetch(`/admin/employees/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('success-message', data.message);
                const employeeRow = document.querySelector(`[data-id="${id}"]`);
                if (employeeRow) employeeRow.remove();
            } else {
                showMessage('error-message', data.message, false);
            }
        })
        .catch(error => {
            showMessage('error-message', 'Lỗi: ' + error.message, false);
        });
    }
</script>

</body>
</html>