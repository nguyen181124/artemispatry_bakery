<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Thêm CSRF token vào dashboard -->
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #4CAF50;
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
            background-color: #333;
            padding: 15px;
            display: flex;
            justify-content: space-around;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #555;
            transition: background-color 0.3s ease;
        }

        nav a:hover, nav a.active {
            background-color: #4CAF50;
        }

        .container {
            margin: 20px;
        }

        button {
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #4CAF50;
        }

        .content {
            margin-top: 20px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

    <header>
        <h2>Chào Mừng</h2>
    </header>

    <nav>
        <a href="#" data-url="{{ route('addcake.index') }}">Quản lý bánh</a>
        <a href="#" data-url="{{ route('admin.orders.index') }}">Quản lý đơn hàng</a>
        <a href="#" data-url="{{ route('admin.employees') }}">Quản lý nhân viên</a>
        <a href="#" data-url="{{ route('admin.users') }}">Quản lý người dùng</a>
        <form action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </nav>

    <div class="container">
        <div id="content" class="content">
            <!-- Nội dung của các trang sẽ được tải và hiển thị ở đây -->
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
    </script>
</body>
</html>