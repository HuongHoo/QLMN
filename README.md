# HỆ THỐNG QUẢN LÝ MẦM NON

## Giới thiệu

Hệ thống Quản lý Mầm non là một ứng dụng web được xây dựng trên nền tảng Laravel, hỗ trợ toàn diện các hoạt động quản lý và điều hành trường mầm non. Dự án được phát triển nhằm số hóa và tối ưu hóa quy trình quản lý, giúp nhà trường, giáo viên và phụ huynh dễ dàng tương tác và theo dõi quá trình học tập, phát triển của trẻ.

## Tính năng chính

### 1. Quản lý thông tin cơ bản
- **Quản lý học sinh**: Lưu trữ và quản lý thông tin chi tiết của học sinh
- **Quản lý lớp học**: Phân chia và tổ chức các lớp học
- **Quản lý giáo viên**: Quản lý thông tin giáo viên và phân công giảng dạy
- **Quản lý phụ huynh**: Lưu trữ thông tin liên hệ và mối quan hệ với học sinh

### 2. Hoạt động hàng ngày
- **Điểm danh**: Theo dõi tình trạng đi học của học sinh hàng ngày
- **Đánh giá**: Ghi nhận và đánh giá quá trình học tập, phát triển của trẻ
- **Sức khỏe**: Theo dõi tình trạng sức khỏe, cân nặng, chiều cao của học sinh
- **Hoạt động hàng ngày**: Ghi chép các hoạt động và sự kiện trong ngày
- **Hoạt động và ảnh hoạt động**: Lưu trữ thông tin và hình ảnh các hoạt động ngoại khóa

### 3. Quản lý tài chính
- **Học phí**: Quản lý thu chi học phí, theo dõi tình trạng thanh toán

### 4. Thông báo và tương tác
- **Hệ thống thông báo**: Gửi thông báo đến phụ huynh và giáo viên
- **Chatbot AI tích hợp Gemini**: Hỗ trợ tư vấn và trả lời câu hỏi tự động thông qua Google Gemini API

## Công nghệ sử dụng

- **Framework**: Laravel (PHP)
- **Frontend**: Vite.js, JavaScript
- **Database**: MySQL/MariaDB
- **AI Integration**: Google Gemini API cho chatbot
- **Authentication**: Laravel Authentication
- **File Upload**: Hỗ trợ upload và quản lý hình ảnh

## Cấu trúc dự án

```
app/
├── Models/          # Các model dữ liệu
├── Http/
│   ├── Controllers/ # Controllers xử lý logic
│   └── Middleware/  # Middleware xử lý request
├── Helpers/         # Helper functions
└── View/            # View components

database/
├── migrations/      # Database migrations
└── seeders/         # Database seeders

resources/
├── views/           # Blade templates
├── css/             # Stylesheets
└── js/              # JavaScript files

routes/
└── web.php          # Web routes
```

## Cài đặt

1. Clone repository
```bash
git clone [repository-url]
cd QLMN
```

2. Cài đặt dependencies
```bash
composer install
npm install
```

3. Cấu hình môi trường
```bash
cp .env.example .env
php artisan key:generate
```

4. Cấu hình database trong file `.env`

5. Chạy migrations
```bash
php artisan migrate
```

6. Build assets
```bash
npm run build
```

7. Khởi động server
```bash
php artisan serve
```

## Tài liệu bổ sung

- [CHATBOT_README.md](CHATBOT_README.md) - Hướng dẫn sử dụng chatbot
- [CHATBOT_HUONGDAN.md](CHATBOT_HUONGDAN.md) - Hướng dẫn chi tiết chatbot
- [GEMINI_API_SETUP.md](GEMINI_API_SETUP.md) - Cấu hình Gemini API

## License

Dự án được phát triển cho mục đích học tập và nghiên cứu.
