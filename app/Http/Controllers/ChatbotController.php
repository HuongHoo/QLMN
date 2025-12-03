<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    /**
     * Danh sách câu trả lời thông minh
     */
    private $smartReplies = [
        // Chào hỏi
        'patterns' => [
            [
                'keywords' => ['xin chào', 'hello', 'hi', 'chào', 'hey'],
                'response' => 'Xin chào! 👋 Tôi là trợ lý ảo của Trường MN Ánh Sao. Tôi có thể giúp bạn tìm hiểu về trường, học phí, đăng ký nhập học và nhiều thông tin khác. Bạn cần hỗ trợ gì ạ?'
            ],
            // Học phí
            [
                'keywords' => ['học phí', 'phí', 'tiền', 'chi phí', 'giá', 'bao nhiêu tiền', 'đóng tiền'],
                'response' => '💰 **Học phí Trường MN Ánh Sao:**

• Lớp Mầm (3-4 tuổi): 2.500.000đ/tháng
• Lớp Chồi (4-5 tuổi): 2.800.000đ/tháng
• Lớp Lá (5-6 tuổi): 3.000.000đ/tháng

**Bao gồm:** Tiền ăn, đồ dùng học tập, bảo hiểm
**Ưu đãi:** Giảm 10% cho con thứ 2

📞 Liên hệ: 0123 456 789 để được tư vấn chi tiết!'
            ],
            // Giờ học
            [
                'keywords' => ['giờ học', 'thời gian', 'mấy giờ', 'giờ đón', 'giờ trả', 'lịch học', 'giờ làm việc'],
                'response' => '⏰ **Thời gian học:**

• Thứ 2 - Thứ 6: 7:00 - 17:30
• Thứ 7: 7:00 - 11:30
• Chủ nhật: Nghỉ

**Giờ đón trả:**
• Đón buổi sáng: 7:00 - 8:00
• Trả buổi chiều: 16:30 - 17:30

📞 Hotline: 0123 456 789'
            ],
            // Địa chỉ
            [
                'keywords' => ['địa chỉ', 'ở đâu', 'chỗ nào', 'đường', 'vị trí', 'location'],
                'response' => '📍 **Địa chỉ Trường MN Ánh Sao:**

123 Đường ABC, Phường XYZ, Quận 1, TP.HCM

🚗 Có bãi đậu xe rộng rãi
🚌 Gần trạm xe buýt số 01, 52

📞 Hotline: 0123 456 789
📧 Email: info@anhsao.edu.vn'
            ],
            // Đăng ký nhập học
            [
                'keywords' => ['đăng ký', 'nhập học', 'ghi danh', 'hồ sơ', 'thủ tục', 'xin học'],
                'response' => '📝 **Hồ sơ đăng ký nhập học:**

1. Đơn xin nhập học (theo mẫu)
2. Giấy khai sinh (bản sao công chứng)
3. Sổ hộ khẩu (bản sao)
4. 4 ảnh 3x4 của bé
5. Sổ tiêm chủng
6. Giấy khám sức khỏe

**Thời gian nhận hồ sơ:** Thứ 2 - Thứ 6

📞 Đặt lịch tư vấn: 0123 456 789'
            ],
            // Liên hệ
            [
                'keywords' => ['liên hệ', 'hotline', 'điện thoại', 'email', 'số điện thoại', 'gọi'],
                'response' => '📞 **Thông tin liên hệ:**

• Hotline: 0123 456 789
• Email: info@anhsao.edu.vn
• Zalo: 0123 456 789
• Facebook: fb.com/mnanhsao

⏰ Giờ làm việc: 7:00 - 17:30 (Thứ 2 - Thứ 7)'
            ],
            // Giáo viên
            [
                'keywords' => ['giáo viên', 'cô giáo', 'thầy', 'đội ngũ', 'giảng dạy'],
                'response' => '👩‍🏫 **Đội ngũ giáo viên:**

• 100% có bằng Sư phạm Mầm non
• Kinh nghiệm trung bình 5+ năm
• Được đào tạo phương pháp Montessori
• Yêu trẻ, tận tâm với nghề

Mỗi lớp có 2 cô phụ trách (1 cô chính + 1 cô phụ)

📞 Tham quan trường: 0123 456 789'
            ],
            // Chương trình học
            [
                'keywords' => ['chương trình', 'học gì', 'giáo án', 'nội dung', 'môn học', 'hoạt động'],
                'response' => '📚 **Chương trình học:**

• Phát triển ngôn ngữ & giao tiếp
• Toán học cơ bản
• Khám phá khoa học
• Nghệ thuật: Vẽ, nặn, thủ công
• Âm nhạc & vận động
• Tiếng Anh (Native Teacher)
• Kỹ năng sống

🎯 Theo chuẩn BGDĐT + phương pháp hiện đại'
            ],
            // Thực đơn / Ăn uống
            [
                'keywords' => ['thực đơn', 'ăn', 'bữa ăn', 'dinh dưỡng', 'ăn trưa', 'ăn sáng'],
                'response' => '🍎 **Chế độ dinh dưỡng:**

• 3 bữa/ngày: Sáng - Trưa - Xế
• Thực đơn do chuyên gia dinh dưỡng lên
• Thay đổi theo tuần
• Đảm bảo an toàn vệ sinh thực phẩm

**Đặc biệt:** Phục vụ chế độ ăn riêng cho bé dị ứng

📞 Xem thực đơn: 0123 456 789'
            ],
            // Cảm ơn
            [
                'keywords' => ['cảm ơn', 'thank', 'thanks', 'cám ơn'],
                'response' => 'Không có gì ạ! 😊 Rất vui được hỗ trợ bạn. Nếu có thêm câu hỏi, đừng ngại hỏi tôi nhé!

📞 Hotline: 0123 456 789'
            ],
            // Tạm biệt
            [
                'keywords' => ['tạm biệt', 'bye', 'goodbye', 'chào nhé'],
                'response' => 'Tạm biệt bạn! 👋 Chúc bạn một ngày tốt lành. Hẹn gặp lại tại Trường MN Ánh Sao! 🌟'
            ],
            // Sức khỏe
            [
                'keywords' => ['sức khỏe', 'y tế', 'bệnh', 'ốm', 'khám', 'thuốc'],
                'response' => '🏥 **Chăm sóc y tế:**

• Có phòng y tế riêng
• Nhân viên y tế trực thường xuyên
• Khám sức khỏe định kỳ 2 lần/năm
• Theo dõi chiều cao, cân nặng hàng tháng

**Khi bé ốm:** Cô sẽ liên hệ ngay phụ huynh

📞 Tư vấn: 0123 456 789'
            ],
        ]
    ];

    /**
     * Xử lý tin nhắn từ chatbot - Sử dụng local AI
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $request->input('message');

        // Tìm câu trả lời phù hợp nhất
        $response = $this->findBestResponse($userMessage);

        return response()->json([
            'success' => true,
            'message' => $response,
        ]);
    }

    /**
     * Tìm câu trả lời phù hợp nhất dựa trên keywords
     */
    private function findBestResponse($message)
    {
        $message = mb_strtolower($message, 'UTF-8');
        $message = $this->removeVietnameseTones($message);

        $bestMatch = null;
        $maxScore = 0;

        foreach ($this->smartReplies['patterns'] as $pattern) {
            $score = 0;
            foreach ($pattern['keywords'] as $keyword) {
                $keywordNormalized = $this->removeVietnameseTones(mb_strtolower($keyword, 'UTF-8'));
                if (str_contains($message, $keywordNormalized)) {
                    $score += strlen($keyword); // Ưu tiên keyword dài hơn
                }
            }

            if ($score > $maxScore) {
                $maxScore = $score;
                $bestMatch = $pattern['response'];
            }
        }

        // Nếu không tìm thấy match, trả về câu trả lời mặc định
        if (!$bestMatch) {
            $bestMatch = $this->getDefaultResponse($message);
        }

        return $bestMatch;
    }

    /**
     * Loại bỏ dấu tiếng Việt để so sánh tốt hơn
     */
    private function removeVietnameseTones($str)
    {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        return $str;
    }

    /**
     * Câu trả lời mặc định thông minh
     */
    private function getDefaultResponse($message)
    {
        // Kiểm tra nếu là câu hỏi
        if (str_contains($message, '?') || str_contains($message, 'gi') || str_contains($message, 'nao') || str_contains($message, 'sao')) {
            return '🤔 Cảm ơn bạn đã hỏi! Để trả lời chính xác nhất, vui lòng liên hệ trực tiếp với nhà trường:

📞 Hotline: 0123 456 789
📧 Email: info@anhsao.edu.vn
🏫 Địa chỉ: 123 Đường ABC, Quận XYZ, TP.HCM

Hoặc bạn có thể hỏi tôi về:
• Học phí
• Giờ học
• Đăng ký nhập học
• Chương trình học
• Thực đơn dinh dưỡng';
        }

        return '😊 Cảm ơn bạn đã nhắn tin! Tôi có thể giúp bạn tìm hiểu về:

• 💰 Học phí các lớp
• ⏰ Giờ học, giờ đón trả
• 📝 Thủ tục đăng ký nhập học
• 📍 Địa chỉ trường
• 👩‍🏫 Đội ngũ giáo viên
• 📚 Chương trình học
• 🍎 Thực đơn dinh dưỡng

Hãy nhập câu hỏi của bạn nhé! 🌟';
    }

    /**
     * Quick reply cho các button
     */
    public function quickReply(Request $request)
    {
        $type = $request->input('type', '');

        $quickReplies = [
            'tuition' => '💰 **Học phí Trường MN Ánh Sao:**

• Lớp Mầm (3-4 tuổi): 2.500.000đ/tháng
• Lớp Chồi (4-5 tuổi): 2.800.000đ/tháng
• Lớp Lá (5-6 tuổi): 3.000.000đ/tháng

**Bao gồm:** Tiền ăn, đồ dùng học tập, bảo hiểm
**Ưu đãi:** Giảm 10% cho con thứ 2

📞 Liên hệ: 0123 456 789',

            'schedule' => '⏰ **Thời gian học:**

• Thứ 2 - Thứ 6: 7:00 - 17:30
• Thứ 7: 7:00 - 11:30
• Chủ nhật: Nghỉ

📞 Hotline: 0123 456 789',

            'contact' => '📞 **Thông tin liên hệ:**

• Hotline: 0123 456 789
• Email: info@anhsao.edu.vn
• Địa chỉ: 123 Đường ABC, Q.XYZ, TP.HCM

⏰ Giờ làm việc: 7:00 - 17:30',

            'register' => '📝 **Đăng ký nhập học:**

Hồ sơ cần có:
1. Giấy khai sinh (bản sao)
2. Sổ hộ khẩu (bản sao)
3. 4 ảnh 3x4 của bé
4. Sổ tiêm chủng

📞 Đặt lịch: 0123 456 789',
        ];

        $response = $quickReplies[$type] ?? 'Vui lòng liên hệ hotline: 0123 456 789';

        return response()->json([
            'success' => true,
            'message' => $response,
        ]);
    }
}
