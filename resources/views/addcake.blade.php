<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quản lý bánh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #bc9669;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-container {
            flex: 1;
            width: 100%;
            padding: 20px
        }

        .card img {
            object-fit: cover;
            height: 150px;
        }

        .btn-add,
        .btn-edit,
        .btn-delete {
            border-radius: 5px;
        }

        .btn-add {
            background: #5F4B3C;
            color: #fff;
        }

        .btn-edit {
            background: #5F4B3C;
            color: #fff;
        }

        .btn-delete {
            background: #dc3545;
            color: #fff;
        }

        .nav-link {
            color: #000
        }

        .nav-link:hover {
            color: #000
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.4);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .modal-box {
            background: white;
            padding: 20px 30px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .form-group {
            display: flex;
            justify-content: end;
            padding: 8px;
        }

        #searchInput {
            width: 15%;
            margin-right: 30px;
        }
    </style>
</head>

<body>
    <div class="form-group" style="background-color: #5F4B3C">
        <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm sản phẩm theo tên...">
    </div>

    <div class="main-container container-fluid">
        <div class="row g-4">
            <!-- Form Section -->
            <div class="col-12 col-lg-4">
                <div class="p-4 bg-white rounded shadow-sm">
                    <h4 id="form-title" class="mb-3 text-center">Thêm sản phẩm</h4>
                    <div id="success-message" class="alert alert-success d-none"></div>
                    <div id="error-message" class="alert alert-danger d-none"></div>
                    <form id="cake-form">
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="img" class="form-label">URL Ảnh</label>
                            <input type="url" id="img" name="img" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Giá (VNĐ)</label>
                            <input type="number" id="price" name="price" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="info" class="form-label">Thông tin</label>
                            <textarea id="info" name="info" rows="3" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Danh mục</label>
                            <select id="category" name="category" class="form-select" required>
                                <option value="1">Bánh sinh nhật</option>
                                <option value="2">Bánh lẻ</option>
                                <option value="3">Đồ uống</option>
                                <option value="4">Giftset</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-add w-100">Lưu sản phẩm</button>
                    </form>
                </div>
            </div>
            <!-- Products Section -->
            <div class="col-12 col-lg-8">
                <h4 class="mb-3">Danh sách sản phẩm</h4>
                <ul class="nav nav-tabs mb-3" id="categoryTabs" role="tablist">
                    @foreach([1 => 'cat1', 2 => 'cat2', 3 => 'cat3', 4 => 'cat4'] as $catId => $tabId)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if($loop->first) active @endif" id="tab-{{ $tabId }}"
                                data-bs-toggle="tab" data-bs-target="#{{ $tabId }}" type="button" role="tab"
                                aria-controls="{{ $tabId }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ ['Bánh sinh nhật', 'Bánh lẻ', 'Đồ uống', 'Giftset'][$catId - 1] }}
                            </button>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content" id="productTabs">
                    @foreach([1 => 'cat1', 2 => 'cat2', 3 => 'cat3', 4 => 'cat4'] as $catId => $tabId)
                        <div class="tab-pane fade @if($loop->first) show active @endif" id="{{ $tabId }}" role="tabpanel"
                            aria-labelledby="tab-{{ $tabId }}">
                            <div class="row g-3" id="list-{{ $tabId }}">
                                @foreach($cakes->where('category', $catId) as $cake)
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3" data-id="{{ $cake->id }}"
                                        data-name="{{ addslashes($cake->name) }}" data-img="{{ $cake->img }}"
                                        data-price="{{ $cake->price }}" data-info="{{ addslashes($cake->info) }}"
                                        data-category="{{ $cake->category }}">
                                        <div class="card h-100 shadow-sm">
                                            <img src="{{ $cake->img }}" class="card-img-top" alt="{{ $cake->name }}">
                                            <div class="card-body d-flex flex-column">
                                                <h6 class="card-title">{{ $cake->name }}</h6>
                                                <p class="mb-2 small">Giá: <strong>{{ number_format($cake->price) }}
                                                        VNĐ</strong></p>
                                                <p class="mb-3 text-truncate">{{ $cake->info }}</p>
                                                <div class="mt-auto d-flex gap-2">
                                                    <button class="btn btn-edit btn-sm flex-fill"
                                                        onclick="editCake(this)">Sửa</button>
                                                    <button class="btn btn-delete btn-sm flex-fill"
                                                        onclick="deleteCake('{{ $cake->id }}', '{{ $tabId }}')">Xóa</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showMessage(elementId, message, isSuccess = true) {
            const el = document.getElementById(elementId);
            el.textContent = message;
            el.classList.remove('d-none', isSuccess ? 'alert-danger' : 'alert-success');
            el.classList.add('alert', isSuccess ? 'alert-success' : 'alert-danger');
        }
        function clearForm() {
            document.getElementById('cake-form').reset();
            document.getElementById('id').value = '';
            document.getElementById('form-title').textContent = 'Thêm sản phẩm';
        }
        document.getElementById('cake-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const data = Object.fromEntries(new FormData(this));
            fetch('{{ route('addcake.storeOrUpdate') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: JSON.stringify(data)
            })
                .then(res => res.json())
                .then(resp => {
                    if (resp.success) {
                        showMessage('success-message', resp.message);
                        clearMessage('error-message');
                        updateCard(resp.cake);
                        clearForm();
                    } else showMessage('error-message', resp.message, false);
                })
                .catch(err => showMessage('error-message', 'Lỗi khi lưu: ' + err.message, false));
        });
        function editCake(btn) {
            const card = btn.closest('[data-id]');
            document.getElementById('id').value = card.dataset.id;
            document.getElementById('name').value = card.dataset.name;
            document.getElementById('img').value = card.dataset.img;
            document.getElementById('price').value = card.dataset.price;
            document.getElementById('info').value = card.dataset.info;
            document.getElementById('category').value = card.dataset.category;
            document.getElementById('form-title').textContent = 'Chỉnh sửa sản phẩm';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        function deleteCake(id, tabId) {
            if (!confirm('Bạn có chắc muốn xóa sản phẩm này không?')) return;
            fetch(`/addcake/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            })
                .then(res => res.json())
                .then(resp => {
                    if (resp.success) {
                        showMessage('success-message', resp.message);
                        document.querySelector(`#list-${tabId} [data-id="${id}"]`).remove();
                    } else showMessage('error-message', resp.message, false);
                })
                .catch(err => showMessage('error-message', 'Lỗi khi xóa: ' + err.message, false));
        }
        function updateCard(cake) {
            const tabId = 'cat' + cake.category;
            const container = document.getElementById('list-' + tabId);
            let card = container.querySelector(`[data-id="${cake.id}"]`);
            const html = `
    <div class="col-12 col-sm-6 col-md-4 col-lg-3" data-id="${cake.id}" data-name="${cake.name}" data-img="${cake.img}" data-price="${cake.price}" data-info="${cake.info}" data-category="${cake.category}">
        <div class="card h-100 shadow-sm">
            <img src="${cake.img}" class="card-img-top" alt="${cake.name}">
            <div class="card-body d-flex flex-column">
                <h6 class="card-title">${cake.name}</h6>
                <p class="mb-2 small">Giá: <strong>${numberWithCommas(cake.price)} VNĐ</strong></p>
                <p class="mb-3 text-truncate">${cake.info}</p>
                <div class="mt-auto d-flex gap-2">
                    <button class="btn btn-edit btn-sm flex-fill" onclick="editCake(this)">Sửa</button>
                    <button class="btn btn-delete btn-sm flex-fill" onclick="deleteCake('${cake.id}','${tabId}')">Xóa</button>
                </div>
            </div>
        </div>
    </div>`;
            if (card) card.outerHTML = html;
            else container.insertAdjacentHTML('afterbegin', html);
        }
        function numberWithCommas(x) { return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }
        function clearMessage(id) { const el = document.getElementById(id); el.textContent = ''; el.classList.add('d-none'); }



        document.getElementById('searchInput').addEventListener('input', function () {
            const keyword = this.value.toLowerCase();
            const tabPanes = document.querySelectorAll('.tab-pane');

            tabPanes.forEach(pane => {
                const columns = pane.querySelectorAll('.col-12');
                columns.forEach(col => {
                    const title = col.querySelector('.card-title').textContent.toLowerCase();
                    const match = title.includes(keyword);
                    col.classList.toggle('d-none', !match);
                });

                // Nếu muốn xếp các card khớp lên đầu
                const container = pane.querySelector('.row');
                const matching = Array.from(columns).filter(col =>
                    col.style.display !== 'none'
                );
                const nonMatching = Array.from(columns).filter(col =>
                    col.style.display === 'none'
                );

                container.innerHTML = '';
                matching.forEach(col => container.appendChild(col));
                nonMatching.forEach(col => container.appendChild(col));
            });
        });
    </script>
</body>

</html>