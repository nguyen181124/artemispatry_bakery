<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Thêm CSRF token -->
    <title>Quản lý bánh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Giữ nguyên CSS của bạn */
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
        .card {
            margin-bottom: 15px;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .card-body img {
            margin-top: 10px;
        }
        .button-group {
            display: flex;
            flex-direction: row;
            gap: 10px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 id="form-title">Thêm sản phẩm</h2>
    <div id="success-message" class="alert alert-success" style="display: none;"></div>
    <div id="error-message" class="error"></div>

    <form id="cake-form">
        <input type="hidden" name="id" id="id">

        <div class="form-group">
            <label>Tên sản phẩm:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>URL Ảnh:</label>
            <input type="text" name="img" id="img" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Giá:</label>
            <input type="number" name="price" id="price" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Thông tin:</label>
            <textarea name="info" id="info" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label>Danh mục:</label>
            <select name="category" id="category" class="form-control" required>
                <option value="1">Bánh sinh nhật</option>
                <option value="2">Bánh lẻ</option>
                <option value="3">Đồ uống</option>
                <option value="4">Giftset</option>
            </select>
        </div>

        <button type="submit" class="btn btn-add">Lưu sản phẩm</button>
    </form>

    <h2 class="mt-5">Danh sách sản phẩm</h2>
    <div id="cake-list">
        @foreach($cakes as $cake)
        <div class="card mb-3" data-id="{{ $cake->id }}">
            <div class="card-body">
                <h5 class="card-title">{{ $cake->name }}</h5>
                <img src="{{ $cake->img }}" class="img-fluid" style="max-width: 200px;">
                <p>Giá: {{ $cake->price }} VNĐ</p>
                <p>{{ $cake->info }}</p>
                <div class="button-group">
                    <button class="btn btn-edit" onclick="editCake('{{ $cake->id }}', '{{ $cake->name }}', '{{ $cake->img }}', '{{ $cake->price }}', '{{ $cake->info }}', '{{ $cake->category }}')">Sửa</button>
                    <button class="btn btn-delete" onclick="deleteCake('{{ $cake->id }}')">Xóa</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
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
        document.getElementById('cake-form').reset();
        document.getElementById('id').value = '';
        document.getElementById('form-title').textContent = 'Thêm sản phẩm';
    }

    // Xử lý form submit qua AJAX
    document.getElementById('cake-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const data = Object.fromEntries(formData);

        fetch('{{ route('addcake.storeOrUpdate') }}', {
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

                const cakeList = document.getElementById('cake-list');
                const newCake = data.cake;
                const newCard = `
                    <div class="card mb-3" data-id="${newCake.id}">
                        <div class="card-body">
                            <h5 class="card-title">${newCake.name}</h5>
                            <img src="${newCake.img}" class="img-fluid" style="max-width: 200px;">
                            <p>Giá: ${newCake.price} VNĐ</p>
                            <p>${newCake.info}</p>
                            <div class="button-group">
                                <button class="btn btn-edit" onclick="editCake('${newCake.id}', '${newCake.name}', '${newCake.img}', '${newCake.price}', '${newCake.info}', '${newCake.category}')">Sửa</button>
                                <button class="btn btn-delete" onclick="deleteCake('${newCake.id}')">Xóa</button>
                            </div>
                        </div>
                    </div>`;

                if (data.isUpdate) {
                    const oldCard = cakeList.querySelector(`[data-id="${newCake.id}"]`);
                    if (oldCard) oldCard.outerHTML = newCard;
                } else {
                    cakeList.insertAdjacentHTML('afterbegin', newCard);
                }

                clearForm();
            } else {
                showMessage('error-message', data.message, false);
            }
        })
        .catch(error => {
            showMessage('error-message', 'Lỗi khi lưu: ' + error.message, false);
        });
    });

    // Hàm chỉnh sửa bánh
    function editCake(id, name, img, price, info, category) {
        document.getElementById('id').value = id;
        document.getElementById('name').value = name;
        document.getElementById('img').value = img;
        document.getElementById('price').value = price;
        document.getElementById('info').value = info;
        document.getElementById('category').value = category;
        document.getElementById('form-title').textContent = 'Chỉnh sửa Bánh';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Hàm xóa bánh (Đã sửa)
    function deleteCake(id) {
        if (!confirm('Bạn có chắc muốn xóa sản phẩm này không?')) return;

        fetch(`/addcake/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Lỗi server: ${response.status} - ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showMessage('success-message', data.message);
                const cakeCard = document.querySelector(`[data-id="${id}"]`);
                if (cakeCard) cakeCard.remove();
            } else {
                showMessage('error-message', data.message, false);
            }
        })
        .catch(error => {
            showMessage('error-message', 'Không thể xóa sản phẩm: ' + error.message, false);
            console.error('Lỗi:', error);
        });
    }
</script>

</body>
</html>