# 🤖 Chatbot Gemini - Trường Mầm Non Ánh Sao

Chatbot AI thông minh được tích hợp vào trang home để hỗ trợ phụ huynh và khách hàng tiềm năng tìm hiểu về trường.

## ✨ Tính năng

- ✅ Trả lời thông minh bằng Google Gemini AI
- ✅ Đọc dữ liệu thực từ database (lớp học, giáo viên, hoạt động)
- ✅ Giao diện đẹp, responsive
- ✅ Quick replies cho câu hỏi phổ biến
- ✅ Xử lý lỗi thông minh với fallback

## 🚀 Cài đặt nhanh

### 1. Lấy Gemini API Key
Truy cập: https://aistudio.google.com/app/apikey

### 2. Cấu hình .env
```bash
GEMINI_API_KEY=your-api-key-here
```

### 3. Chạy server
```bash
php artisan serve
```

### 4. Truy cập
Mở: http://localhost:8000

Chatbot sẽ xuất hiện ở góc phải dưới màn hình! 🎉

## 📁 Files chính

- `app/Http/Controllers/ChatbotController.php` - Logic chatbot
- `resources/views/parent/home.blade.php` - Giao diện chatbot
- `.env` - Cấu hình API key
- `routes/web.php` - Routes (đã có sẵn)

## 💡 Ví dụ câu hỏi

- "Học phí lớp mầm bao nhiêu?"
- "Trường có mấy lớp?"
- "Thời gian học là mấy giờ?"
- "Tôi muốn đăng ký cho con học"
- "Thực đơn của trường như thế nào?"

## 📖 Tài liệu đầy đủ

Xem file `CHATBOT_HUONGDAN.md` để biết chi tiết về:
- Kiến trúc hệ thống
- Tùy chỉnh chatbot
- Xử lý lỗi
- FAQ

## ⚠️ Lưu ý quan trọng

1. **PHẢI** cấu hình `GEMINI_API_KEY` trong file `.env`
2. **KHÔNG** commit API key lên Git
3. Free tier: 60 requests/phút

## 🎨 Demo

```
Khách: Học phí bao nhiêu?
Bot: 💰 Học phí Trường MN Ánh Sao:
     • Lớp Mầm (3-4 tuổi): 2.500.000đ/tháng
     • Lớp Chồi (4-5 tuổi): 2.800.000đ/tháng
     • Lớp Lá (5-6 tuổi): 3.000.000đ/tháng
     
     Bao gồm: Tiền ăn, đồ dùng học tập, bảo hiểm
     Ưu đãi: Giảm 10% cho con thứ 2
     
     Bạn còn cần biết thêm gì nữa không ạ? 😊
```

---

Made with ❤️ by GitHub Copilot
