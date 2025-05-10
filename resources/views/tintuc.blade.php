@extends('layout.master')
@section('maincontent')
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artemis Pastry - Tin Tức</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            line-height: 1.6;
        }

        .container-news {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .news-title {
            color: #8B4513;
            font-size: 28px;
            text-align: left;
            margin-bottom: 40px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding-top: 50px
        }

        .news-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            flex-grow: 1;
            margin-bottom: 250px; /* Tăng khoảng cách với phần dưới lên 100px */
        }

        .news-card {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .news-card:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .news-card a {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .image-container {
            width: 100%;
            height: 600px;
            overflow: hidden;
            position: relative;
        }

        .news-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .news-card:hover .news-image {
            transform: scale(1.1);
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 30px;
        }

        .overlay-top h3 {
            font-size: 18px;
            color: #8B4513;
            margin-bottom: 10px;
            font-weight: 500;
            text-transform: uppercase;
        }

        .overlay-top h1 {
            font-size: 36px;
            color: #DDA0DD;
            margin: 15px 0;
            font-weight: 700;
            line-height: 1.2;
        }

        .overlay-top h1 span {
            color: #FF69B4;
            font-style: italic;
        }

        .overlay-top p, .overlay-bottom p {
            font-size: 15px;
            color: #8B4513;
            margin: 8px 0;
            font-weight: 400;
        }

        .overlay-bottom {
            text-align: left;
        }

        .overlay-bottom p {
            font-size: 14px;
            color: #8B4513;
            margin: 0;
        }

        .footer-text {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: #fff;
            padding: 10px;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }

        .footer-text p {
            margin: 0;
            font-size: 14px;
            color: #8B4513;
        }

        .footer-text .icon {
            font-size: 20px;
            color: #666;
        }

        /* Phần chi tiết bài viết */
        .detail-container {
            display: none; /* Ẩn mặc định, sẽ hiển thị khi điều kiện đúng */
        }

        .detail-container.active {
            display: block;
        }

        .breadcrumb {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }

        .breadcrumb a {
            color: #8B4513;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb a:hover {
            color: #FF69B4;
        }

        .breadcrumb span {
            color: #666;
        }

        .article-title {
            color: #333;
            font-size: 36px;
            text-align: left;
            margin-bottom: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .article-meta {
            font-size: 14px;
            color: #999;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .article-meta .icon {
            margin-right: 5px;
        }

        .article-content {
            font-size: 16px;
            color: #333;
            margin-bottom: 300px;
            
        }

        .article-content h3 {
            color: #8B4513;
            font-size: 20px;
            margin: 20px 0 10px;
            font-weight: 600;
        }

        .article-content p {
            margin: 10px 0;
            line-height: 1.8;
        }

        .article-content .emoji {
            font-size: 20px;
            margin-left: 5px;
        }

        .article-link {
            font-size: 14px;
            color: #FF69B4;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            transition: color 0.3s ease;
        }

        .article-link:hover {
            color: #DDA0DD;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .news-grid {
                grid-template-columns: 1fr;
            }

            .image-container {
                height: 400px;
            }

            .overlay-top h1 {
                font-size: 28px;
            }

            .overlay {
                padding: 20px;
            }

            .container-news {
                padding: 20px 10px;
                justify-content: flex-start;
            }

            .news-grid {
                margin-bottom: 60px;
            }

            .article-title {
                font-size: 28px;
            }

            .article-content {
                font-size: 14px;
            }

            .article-content h3 {
                font-size: 18px;
            }
        }

        .imgtintuc {
                padding: 5px;
                width: 50%;
                height: auto;
            }
    </style>
</head>
<body>
    <div class="container-news">
        <!-- Hiển thị danh sách tin tức mặc định -->
        <h2 class="news-title">TIN TỨC</h2>
        <div class="news-grid" id="news-grid">
            <!-- Phần Bloom with Purity -->
            <div class="news-card">
                <a href="{{ route('tintuc', ['detail' => 'bloom-with-purity']) }}">
                    <div class="image-container">
                        <img src="https://file.hstatic.net/200000247827/article/tivi_nguynhu_08.03_d2198b1ae030423a92f09590dd0bb546_master.png"
                            alt="Bloom with Purity Cakes" class="news-image">

                    </div>
                </a>
                <div class="footer-text">
                    <p>BLOOM WITH PURITY - "CHẤM HOA KHOE SẮC" 25/02/25</p>
                    <span class="icon">🗓️</span>
                    <span class="icon">💬</span>
                </div>
            </div>

            <!-- Phần A Piece of Eternity -->
            <div class="news-card">
                <a href="{{ route('tintuc', ['detail' => 'a-piece-of-eternity']) }}">
                    <div class="image-container">
                        <img src="https://file.hstatic.net/200000247827/article/poster_tivi-01_6045a613c5344dd89b79ad2d0c2546db_master.jpg"
                            alt="A Piece of Eternity Cakes" class="news-image">

                    </div>
                </a>
                <div class="footer-text">
                    <p>A PIECE OF ETERNITY - MẶN GHÉP ĐẶC BIỆT DIP VALENTINE 05/02/25</p>
                    <span class="icon">🗓️</span>
                    <span class="icon">💬</span>
                </div>
            </div>

            <!-- Phần Bánh Sẻ Chia -->
            <div class="news-card">
                <a href="{{ route('tintuc', ['detail' => 'banh-se-chia']) }}">
                    <div class="image-container">
                        <img src="https://file.hstatic.net/200000247827/article/bsn_1_ecc6b3a06b6e4fd6acffbbf90b7cf23f_master.jpg"
                            alt="Bánh Sẻ Chia" class="news-image">

                    </div>
                </a>
                <div class="footer-text">
                    <p>BÁNH SẺ CHIA, VUI ĐÓN TẾT!</p>
                    <span class="icon">🗓️</span>
                    <span class="icon">💬</span>
                </div>
            </div>

            <div class="news-card">
                <a href="{{ route('tintuc', ['detail' => 'safari']) }}">
                    <div class="image-container">
                        <img src="https://file.hstatic.net/200000247827/article/post_tong_hop_1.6_1__1__a5cbd2a9b2b54a5694615ed58801b849_master.png"
                            alt="Safari-Go" class="news-image">

                    </div>
                </a>
                <div class="footer-text">
                    <p>Safari Gooo! - Hành trình thám hiểm khu rừng kỳ thú nhân ngày 1/6</p>
                    <span class="icon">🗓️</span>
                    <span class="icon">💬</span>
                </div>
            </div>
        </div>

        <!-- Phần chi tiết bài viết -->
        <div class="detail-container" id="bloom-with-purity-detail">
            <!-- Breadcrumb -->
            <div class="breadcrumb">
                <a href="{{ route('tintuc') }}">Trang chủ</a> <span>/</span>
                <a href="{{ route('tintuc') }}">Tin tức</a> <span>/</span>
                <span>Bloom With Purity – "Chấm hoa" khoe sắc</span>
            </div>

            <!-- Tiêu đề bài viết -->
            <h1 class="article-title">BLOOM WITH PURITY – "CHẤM HOA" KHOE SẮC</h1>

            <!-- Ngày đăng bài -->
            <div class="article-meta">
                <span class="icon">🗓️</span>
                <span>25/02/25</span>
            </div>

            <!-- Nội dung bài viết -->
            <div class="article-content">
                <h3>Bloom with Purity <span class="emoji">🌸</span></h3>
                <p>
                    "Chấm hoa" Khoe sắc
                </p>
                <p>
                    Phụ nữ – những đóa hoa, mỗi người mang một sắc hương riêng biệt. Lấy cảm hứng từ sự thanh khiết và
                    tinh tế ấy, Artemis Pastry ra mắt bộ sưu tập bánh ngọt đặc biệt mang tên "Bloom with Purity". Bộ sưu
                    tập là lời tôn vinh đến vẻ đẹp thuần khiết, thanh tao và truyền tải sự sống của những người phụ nữ
                    "self care – self love" tồn tại độc lập và đầy kiêu hãnh.
                </p>
                <p>
                    "Bloom with Purity" được trang trí với vẻ ngoài tinh tế mà hết sức dịu dàng bởi những màu hoa socola
                    thú vị cộng thêm chút sắc xanh lá cây. Artemis Pastry hy vọng, bộ sưu tập "Bloom with Purity" không
                    chỉ là món quà ý nghĩa dành tặng những người phụ nữ ta thương, mà còn là món quà tự tặng đầy ý nghĩa
                    cho chính mình.
                </p>
                <p>
                    Inbox cho chúng tớ ngay để "đặt bánh – chấm hoa bạn nhé! <span class="emoji">🌷</span>
                </p>
            </div>


        </div>

        <div class="detail-container" id="a-piece-of-eternity-detail">
            <!-- Breadcrumb -->
            <div class="breadcrumb">
                <a href="{{ route('tintuc') }}">Trang chủ</a> <span>/</span>
                <a href="{{ route('tintuc') }}">Tin tức</a> <span>/</span>
                <span>A Piece of Eternity – Mặn ghép đặc biệt Dip Valentine</span>
            </div>

            <!-- Tiêu đề bài viết -->
            <h1 class="article-title">A PIECE OF ETERNITY – MẶN GHÉP ĐẶC BIỆT DIP VALENTINE</h1>

            <!-- Ngày đăng bài -->
            <div class="article-meta">
                <span class="icon">🗓️</span>
                <span>05/02/25</span>
            </div>

            <!-- Nội dung bài viết -->
            <div class="article-content">
                <h3>A Piece of Eternity <span class="emoji">❤️</span></h3>
                <p>
                    "Mặn ghép" Khoe sắc
                </p>

                <img src="https://file.hstatic.net/200000247827/file/1._thumb_fb_1e2eb6119321464799634a2699c3341b_grande.png" style="width: 50%">
                <p>
                    Nhân dịp Valentine 2025, Artemis Pastry giới thiệu bộ sưu tập "A Piece of Eternity", mang đến những
                    chiếc bánh đặc biệt dành cho các cặp đôi. Với thiết kế tinh tế và hương vị ngọt ngào mặn mà, mỗi
                    chiếc bánh là một mảnh ghép vĩnh cửu trong tình yêu.
                </p>
                <p>
                    Bộ sưu tập này kết hợp hoàn hảo giữa socola và các nguyên liệu đặc trưng, tạo nên một trải nghiệm ẩm
                    thực độc đáo. "A Piece of Eternity" chính thức mở bán từ ngày 10/02/2025 tại tất cả cửa hàng Artemis
                    Pastry.
                </p>
                <p>
                    Đặt hàng ngay để chia sẻ khoảnh khắc yêu thương với người thân yêu! <span class="emoji">💕</span>
                </p>
            </div>

            <!-- Liên kết cuối bài -->

        </div>

        <div class="detail-container" id="banh-se-chia-detail">
            <!-- Breadcrumb -->
            <div class="breadcrumb">
                <a href="{{ route('tintuc') }}">Trang chủ</a> <span>/</span>
                <a href="{{ route('tintuc') }}">Tin tức</a> <span>/</span>
                <span>BÁNH SẺ CHIA, VUI ĐÓN TẾT!</span>
            </div>

            <!-- Tiêu đề bài viết -->
            <h1 class="article-title"> BÁNH SẺ CHIA, VUI ĐÓN TẾT!</h1>

            <!-- Ngày đăng bài -->
            <div class="article-meta">
                <span class="icon">🗓️</span>
                <span>09/01/25</span>
            </div>

            <!-- Nội dung bài viết -->
            <div class="article-content">
                <h3>BÁNH SẺ CHIA, VUI ĐÓN TẾT!</h3>
                <p>
                    Mừng Xuân Ất Tỵ 2025 🎊
                </p>
                <img class="imgtintuc"
                    src="https://file.hstatic.net/200000247827/file/bsn_1_728027805a7c4d6c9c021681e9446710_grande.jpg">
                <p>
                    Mùa xuân đã về, mang theo làn gió mới mẻ. Trong không khí rộn ràng đón Tết Ất Tỵ 2025, Artemis
                    Pastry xin gửi tặng bạn BST “Chưng Mai Tài Lộc”! 🧧🎊
                </p>
                <p>Tết là dịp chúng ta quây quần bên gia đình, bạn bè, là thời điểm để khởi đầu những hành trình mới và
                    dự định mới. Thông qua BST đặc biệt, Artemis Pastry muốn gửi gắm niềm vui, sự thịnh vượng và hy vọng
                    về một năm 2025 tràn đầy hứa hẹn tới bạn.
                </p>
                <p>
                    Với hương vị độc đáo, cùng Artemis sẻ chia niềm vui dịp Tết này qua BST “Chưng Mai Tài Lộc” bạn nhé!
                    🥰
                <p>
                <p>
                    Đặt hàng ngay để chia sẻ khoảnh khắc yêu thương với người thân yêu! <span class="emoji">💕</span>
                </p>
            </div>

            <!-- Liên kết cuối bài -->


            <div class="detail-container" id="safari-detail">
                <!-- Breadcrumb -->
                <div class="breadcrumb">
                    <a href="{{ route('tintuc') }}">Trang chủ</a> <span>/</span>
                    <a href="{{ route('tintuc') }}">Tin tức</a> <span>/</span>
                    <span>Safari Gooo!</span>
                </div>
            
                <!-- Tiêu đề bài viết -->
                <h1 class="article-title">Safari Gooo! - Hành trình thám hiểm khu rừng kỳ thú</h1>
            
                <!-- Ngày đăng bài -->
                <div class="article-meta">
                    <span class="icon">🗓️</span>
                    <span>01/06/25</span>
                </div>

                <!-- Nội dung bài viết -->
                <div class="article-content">
                    <h3>Safari Gooo! - Hành trình thám hiểm khu rừng kỳ thú nhân</h3>
                    <p>
                        Khu rừng tuổi thơ đang gọi tên những nhà thám hiểm tí hon!
                    </p>
                    
                    <p>
                        Ngày 1/6 này, ba mẹ hãy tắt công việc – bật chế độ phiêu lưu, cùng bé bắt đầu hành trình thám
                        hiểm Safari Gooo! để khám phá những cá tính ẩn trong khu rừng nhà Artemis qua Giftset 4 bánh
                        entremet đáng yêu:
                    </p>
                    <img class="imgtintuc"
                        src="https://file.hstatic.net/200000247827/file/bsn_1_728027805a7c4d6c9c021681e9446710_grande.jpg">
                    <p>🦁 Mạnh mẽ như Sư Tử Tiên Phong - bánh entremet Tropical Coconut với Dứa tươi mới.
                    </p>
                    <p>🦓 Gần gũi như Ngựa Vằn Thân Thiện - bánh entremet Tiramisu thơm lừng vị Cà phê.
                    </p>
                    <p>🦉 Ham học hỏi như Cô Cú Thông Thái - bánh entremet Burnt Caramel Signature đậm đà.
                    </p>
                    <p>🐒 Quan tâm như Bác Khỉ Ân Cần - bánh gato Creamy Choco ngọt êm.
                    <p>Mỗi chiếc bánh là một mảnh ghép cá tính đang chờ bé khám phá. Dưới lớp mousse mềm mịn và cốt bánh
                        thơm ngậy là cả một thế giới vị giác phong phú, như hành trình lớn khôn mà bé đang đi qua mỗi
                        ngày. Từ Sư Tử Tiên Phong, Ngựa Vằn Thân Thiện tới Cô Cú Thông Thái và Bác Khỉ Ân Cần – bé sẽ
                        lựa chọn cá tính yêu thích nào cho mình?
                    </p>
                    <p>
                        Hành trình khám phá thế giới bắt đầu từ chiếc bánh nhỏ và lớn dần lên trong trái tim con. Còn
                        rất nhiều điều kỳ diệu trong khu rừng Safari Gooo! và những phần quà giới hạn đang chờ bé khám
                        phá.
                    </p>
                    <p>
                        Đặt trước Giftset Safari Gooo! từ ngay hôm nay ba mẹ nhé!
                    </p>
                </div>

                <!-- Liên kết cuối bài -->

            </div>
        </div>
    </div>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const detail = urlParams.get('detail');

        const newsGrid = document.getElementById('news-grid');
        const bloomDetail = document.getElementById('bloom-with-purity-detail');
        const eternityDetail = document.getElementById('a-piece-of-eternity-detail');
        const banhsechiaDetail = document.getElementById('banh-se-chia-detail');
        const safariDetail = document.getElementById('safari-detail');
       
        if (detail === 'bloom-with-purity') {
            newsGrid.style.display = 'none';
            bloomDetail.classList.add('active');
        } else if (detail === 'a-piece-of-eternity') {
            newsGrid.style.display = 'none';
            eternityDetail.classList.add('active');
        } else if (detail === 'banh-se-chia') {
            newsGrid.style.display = 'none';
            banhsechiaDetail.classList.add('active');
        } else if (detail === 'safari') {
            newsGrid.style.display = 'none';
            safariDetail.classList.add('active');
        }
    </script>
</body>
</html>
@endsection