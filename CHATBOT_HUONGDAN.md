# HƯỚNG DẪN SỬ DỤNG CHATBOT GEMINI

## Tổng quan
Chatbot Gemini đã được tích hợp vào trang home (dành cho khách chưa đăng nhập) tại route `/`. Chatbot sử dụng Google Gemini AI để trả lời các câu hỏi của khách hàng tiềm năng về trường mầm non.

## Các tính năng chính

### 1. Trả lời thông minh với Gemini AI
- Chatbot sử dụng Google Gemini Pro API để trả lời câu hỏi
- Có khả năng hiểu ngữ cảnh và trả lời linh hoạt
- Đọc dữ liệu thực từ database (lớp học, giáo viên, hoạt động)

### 2. Giao diện thân thiện
- Widget floating ở góc phải dưới màn hình
- Có thể thu gọn/mở rộng
- Giao diện hiện đại, responsive trên mobile
- Có animation mượt mà

### 3. Quick Replies
- 4 nút câu hỏi nhanh: Học phí, Giờ học, Liên hệ, Đăng ký
- Giúp người dùng nhanh chóng truy cập thông tin quan trọng

## Cài đặt

### Bước 1: Lấy Gemini API Key
1. Truy cập: https://aistudio.google.com/app/apikey
2. Đăng nhập bằng tài khoản Google
3. Nhấn "Create API Key" để tạo key mới
4. Copy API key

### Bước 2: Cấu hình .env
Mở file `.env` và cập nhật:

```env
GEMINI_API_KEY=YOUR_ACTUAL_API_KEY_HERE
```

**LƯU Ý:** Thay `YOUR_ACTUAL_API_KEY_HERE` bằng API key thật của bạn

### Bước 3: Khởi động server
```bash
php artisan serve
```

### Bước 4: Truy cập trang home
Mở trình duyệt và truy cập: `http://localhost:8000`

## Cách sử dụng

### Cho người dùng cuối:
1. Truy cập trang chủ của trường
2. Nhìn xuống góc phải dưới, thấy icon chatbot màu xanh
3. Click vào icon để mở cửa sổ chat
4. Gõ câu hỏi hoặc click vào nút Quick Reply
5. Chatbot sẽ trả lời trong vài giây

### Ví dụ câu hỏi:
- "Học phí lớp mầm bao nhiêu?"
- "Trường có mấy lớp?"
- "Giáo viên của trường như thế nào?"
- "Thời gian học là mấy giờ?"
- "Tôi muốn đăng ký cho con học, cần những gì?"
- "Trường có hoạt động ngoại khóa gì không?"

## Kiến trúc kỹ thuật

### Files đã chỉnh sửa:

1. **`.env`**
   - Thêm `GEMINI_API_KEY`

2. **`app/Http/Controllers/ChatbotController.php`**
   - Method `chat()`: Xử lý tin nhắn từ user
   - Method `getSchoolData()`: Lấy dữ liệu từ database
   - Method `buildContextPrompt()`: Tạo context cho Gemini
   - Method `callGeminiAPI()`: Gọi API của Gemini
   - Method `quickReply()`: Xử lý quick replies

3. **`resources/views/parent/home.blade.php`**
   - Thêm HTML structure cho chatbot widget
   - Thêm CSS styling
   - Thêm JavaScript xử lý giao diện và gọi API

4. **`routes/web.php`** (đã có sẵn)
   - Route `POST /chatbot/send` - Gửi tin nhắn
   - Route `POST /chatbot/quick` - Quick reply

### Luồng hoạt động:

```
User nhập câu hỏi
    ↓
JavaScript gọi POST /chatbot/send
    ↓
ChatbotController::chat()
    ↓
getSchoolData() - Lấy dữ liệu từ DB
    ↓
buildContextPrompt() - Tạo context
    ↓
callGeminiAPI() - Gọi Gemini với context + câu hỏi
    ↓
Gemini trả về câu trả lời
    ↓
Trả JSON về client
    ↓
JavaScript hiển thị câu trả lời
```

### Database Models được sử dụng:
- `LopHoc` - Thông tin các lớp học
- `GiaoVien` - Thông tin giáo viên
- `HoatDong` - Các hoạt động của trường

## Tùy chỉnh

### Thay đổi thông tin trường:
Mở `app/Http/Controllers/ChatbotController.php`, tìm method `buildContextPrompt()` và sửa:
- Tên trường
- Địa chỉ
- Hotline
- Email
- Học phí
- Chương trình học
- Thực đơn
- Hồ sơ nhập học

### Thay đổi giao diện:
Mở `resources/views/parent/home.blade.php`, tìm phần `<!-- Chatbot Styles -->` để sửa:
- Màu sắc (gradient, background)
- Kích thước widget
- Vị trí hiển thị
- Animation

### Thay đổi Quick Replies:
Mở `app/Http/Controllers/ChatbotController.php`, method `quickReply()` để sửa nội dung.

Mở `resources/views/parent/home.blade.php`, tìm `chatbot-quick-replies` để sửa text/icon của button.

## Xử lý lỗi

### Lỗi: "Gemini API key chưa được cấu hình"
**Nguyên nhân:** Chưa set GEMINI_API_KEY trong .env hoặc vẫn để giá trị mặc định

**Giải pháp:**
1. Mở file `.env`
2. Tìm dòng `GEMINI_API_KEY=`
3. Thay bằng API key thật của bạn
4. Khởi động lại server: `php artisan serve`

### Lỗi: API timeout
**Nguyên nhân:** Gemini API phản hồi chậm hoặc không kết nối được

**Giải pháp:**
- Kiểm tra kết nối internet
- Kiểm tra API key còn hạn sử dụng không
- Chatbot sẽ tự động fallback về thông báo lỗi thân thiện

### Lỗi: Không hiển thị câu trả lời
**Nguyên nhân:** Có thể do lỗi JavaScript hoặc CSRF token

**Giải pháp:**
- Mở Console (F12) để xem lỗi
- Kiểm tra CSRF token có hợp lệ không
- Clear cache trình duyệt

## Bảo mật

### API Key:
- **KHÔNG BAO GIỜ** commit file `.env` lên Git
- Đã có `.gitignore` bảo vệ file `.env`
- Không share API key cho người khác
- Có thể set quota limit trên Google Cloud Console

### CSRF Protection:
- Tất cả request đều có CSRF token
- Laravel tự động validate

## Giới hạn

### Gemini API Free Tier:
- 60 requests/phút
- Nếu vượt quota, chatbot sẽ báo lỗi tạm thời

### Độ dài câu hỏi:
- Tối đa 1000 ký tự (đã validate trong controller)

### Timeout:
- Request timeout sau 30 giây

## FAQ

**Q: Chatbot có hoạt động offline không?**
A: Không, cần internet để gọi Gemini API.

**Q: Tôi có thể thay Gemini bằng ChatGPT không?**
A: Có, bạn cần sửa method `callGeminiAPI()` để gọi OpenAI API thay vì Gemini.

**Q: Chatbot có nhớ được lịch sử hội thoại không?**
A: Hiện tại chưa. Mỗi câu hỏi được xử lý độc lập. Để thêm memory, cần lưu conversation history.

**Q: Làm sao để chatbot xuất hiện ở trang khác?**
A: Copy phần HTML/CSS/JS của chatbot từ `home.blade.php` sang trang khác, hoặc tạo component blade riêng.

**Q: Chi phí sử dụng Gemini API?**
A: Free tier: 60 requests/phút. Nếu cần nhiều hơn, xem pricing tại: https://ai.google.dev/pricing

## Liên hệ hỗ trợ

Nếu gặp vấn đề, vui lòng kiểm tra:
1. Log file: `storage/logs/laravel.log`
2. Browser console (F12)
3. Network tab để xem API response

## Tính năng tương lai (có thể phát triển thêm)

- [ ] Lưu lịch sử hội thoại (conversation memory)
- [ ] Tích hợp voice input/output
- [ ] Multi-language support
- [ ] Analytics: theo dõi câu hỏi phổ biến
- [ ] Admin panel để quản lý câu hỏi/trả lời
- [ ] Tự động học từ feedback của user
- [ ] Tích hợp với CRM để lưu thông tin khách hàng tiềm năng

---

**Phiên bản:** 1.0  
**Ngày cập nhật:** 20/12/2024  
**Người tạo:** GitHub Copilot
