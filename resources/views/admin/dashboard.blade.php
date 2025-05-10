<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Thêm CSRF token vào dashboard -->
    <!-- trong <head> của dashboard.blade.php -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #5a4432;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        h2 {
            margin: 0;
            padding: 10px;
            font-size: 24px;
        }

        nav {
            background-color: #bc9669;
            padding: 15px;
            display: flex;
            justify-content: space-around;
            position: sticky;
            top: 0;
            z-index: 1000;
            margin-bottom: 20px;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #795d47;
            transition: background-color 0.3s ease;
        }

        nav a:hover,
        nav a.active {
            background-color: #5a4432;
        }

        .container {
            margin: auto;
        }

        button {
            padding: 10px 20px;
            background-color: #5a4432;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #5a4432;
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 2000;
        }

        .modal-box {
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .modal-box button {
            margin: 10px;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #confirmLogout {
            background-color: #d9534f;
            color: white;
        }

        #cancelLogout {
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>

<body>
    <nav>
        <a href="#" data-url="{{ route('admin.orders.index') }}">Quản lý đơn hàng</a>
        <a href="#" data-url="{{ route('admin.users') }}">Quản lý người dùng</a>
        <a href="#" data-url="{{ route('addcake.index') }}">Quản lý sản phẩm</a>
        <form action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </nav>

    <div id="content" class="content">
        <!-- Nội dung của các trang sẽ được tải và hiển thị ở đây -->
    </div>

    <div id="logoutModal" style="display:none;" class="modal-overlay">
        <div class="modal-box">
            <p>Bạn có chắc chắn muốn đăng xuất không?</p>
            <button id="confirmLogout">Đăng xuất</button>
            <button id="cancelLogout">Hủy</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const links = document.querySelectorAll('nav a[data-url]');
            const contentDiv = document.getElementById('content');

            // Thêm class 'active' cho menu được chọn và tải nội dung tương ứng
            links.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();

                    // Xóa class 'active' khỏi tất cả các liên kết
                    links.forEach(l => l.classList.remove('active'));

                    // Thêm class 'active' vào liên kết được nhấp
                    this.classList.add('active');

                    // Lấy URL từ data-url và tải nội dung
                    const url = this.getAttribute('data-url');
                    loadContent(url);
                });
            });

            // Hàm tải nội dung từ URL tương ứng
            function loadContent(url) {
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        // Chèn HTML vào contentDiv
                        contentDiv.innerHTML = html;

                        // Tìm và thực thi các script trong nội dung được tải
                        const scripts = contentDiv.getElementsByTagName('script');
                        for (let script of scripts) {
                            const newScript = document.createElement('script');
                            newScript.textContent = script.textContent;
                            document.body.appendChild(newScript);
                        }
                    })
                    .catch(error => console.error('Error loading content:', error));
            }

            // Tải nội dung mặc định (ví dụ: Quản lý bánh) khi trang được tải
            const defaultLink = links[0];
            defaultLink.classList.add('active');
            loadContent(defaultLink.getAttribute('data-url'));
        });

        const logoutForm = document.querySelector('form[action="{{ route('admin.logout') }}"]');
        const logoutModal = document.getElementById('logoutModal');
        const confirmBtn = document.getElementById('confirmLogout');
        const cancelBtn = document.getElementById('cancelLogout');

        logoutForm.addEventListener('submit', function (e) {
            e.preventDefault(); // Chặn submit mặc định
            logoutModal.style.display = 'flex'; // Hiện modal
        });

        // Xác nhận logout
        confirmBtn.addEventListener('click', () => {
            logoutForm.submit(); // Gửi form khi xác nhận
        });

        // Hủy logout
        cancelBtn.addEventListener('click', () => {
            logoutModal.style.display = 'none'; // Ẩn modal
        });
    </script>
</body>

</html>