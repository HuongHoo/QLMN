<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\LopHoc;
use App\Models\HoatDong;
use App\Models\GiaoVien;
use App\Models\HocSinh;
use App\Models\HocPhi;

class ChatbotController extends Controller
{
    /**
     * Xử lý tin nhắn từ chatbot - SỬ DỤNG GEMINI API
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $request->input('message');

        try {
            // Lấy dữ liệu thực tế từ database
            $schoolData = $this->getSchoolData();

            // Tạo context cho Gemini
            $contextPrompt = $this->buildContextPrompt($schoolData);

            // Gọi Gemini API
            $response = $this->callGeminiAPI($userMessage, $contextPrompt);

            return response()->json([
                'success' => true,
                'message' => $response,
            ]);
        } catch (\Exception $e) {
            Log::error('Chatbot Gemini Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            // Trả về lỗi chi tiết để debug
            return response()->json([
                'success' => false,
                'message' => "❌ Lỗi: " . $e->getMessage() . "\n\n" .
                    "📝 Hướng dẫn:\n" .
                    "1. Lấy Gemini API key tại: https://aistudio.google.com/app/apikey\n" .
                    "2. Mở file .env\n" .
                    "3. Tìm dòng: GEMINI_API_KEY=your-gemini-api-key-here\n" .
                    "4. Thay bằng API key thật của bạn\n" .
                    "5. Khởi động lại server: php artisan serve\n\n" .
                    "📞 Hoặc liên hệ: 0123 456 789",
            ]);
        }
    }

    /**
     * Lấy dữ liệu thực tế về trường từ database
     */
    private function getSchoolData()
    {
        $data = [];

        try {
            // Lấy thông tin các lớp học
            $lopHocs = LopHoc::with('giaovien')->get();
            $data['classes'] = $lopHocs->map(function ($lop) {
                return [
                    'id' => $lop->id,
                    'name' => $lop->tenlop ?? 'Chưa có tên',
                    'age_group' => $lop->nhomtuoi ?? 'Không xác định', // Sửa từ 'tuoi' thành 'nhomtuoi'
                    'capacity' => $lop->siso ?? 'Không giới hạn',
                    'teacher' => $lop->giaovien ? $lop->giaovien->tengiaovien : 'Chưa có giáo viên',
                    'teacher_phone' => $lop->giaovien ? ($lop->giaovien->sdt ?? 'N/A') : 'N/A',
                ];
            })->toArray();

            // Lấy số lượng giáo viên
            $data['teacher_count'] = GiaoVien::count();

            // Lấy số lượng học sinh từ database thật
            $data['student_count'] = HocSinh::where('trangthai', 'đang học')->count();
            $data['total_students'] = HocSinh::count();

            // Lấy danh sách giáo viên
            $giaoViens = GiaoVien::all();
            $data['teachers'] = $giaoViens->map(function ($gv) {
                return [
                    'name' => $gv->tengiaovien ?? 'N/A',
                    'email' => $gv->email ?? 'N/A',
                    'phone' => $gv->sdt ?? 'N/A',
                    'position' => $gv->chucvu ?? 'N/A',
                ];
            })->toArray();

            // Lấy dữ liệu học phí thật từ database
            $hocPhis = HocPhi::select('hocphi', 'tienansang', 'tienantrua', 'tienxebus', 'phikhac')
                ->distinct()
                ->get();
            $data['tuition_data'] = $hocPhis->toArray();

            // Lấy các hoạt động nổi bật
            $hoatDongs = HoatDong::where('hienthi', 1)
                ->orderBy('ngay', 'desc')
                ->take(5)
                ->get();
            $data['activities'] = $hoatDongs->map(function ($hd) {
                return [
                    'name' => $hd->ten ?? 'N/A',
                    'description' => $hd->mota ?? '',
                    'date' => $hd->ngay ? $hd->ngay->format('d/m/Y') : null,
                ];
            })->toArray();
        } catch (\Exception $e) {
            Log::error('Error loading school data: ' . $e->getMessage());
            // Trả về dữ liệu rỗng nếu có lỗi
            $data = [
                'classes' => [],
                'teacher_count' => 0,
                'teachers' => [],
                'activities' => [],
            ];
        }

        return $data;
    }

    /**
     * Xây dựng context prompt cho Gemini
     */
    private function buildContextPrompt($schoolData)
    {
        $prompt = "Bạn là trợ lý ảo của Trường Mầm Non Ánh Sao, một trường mầm non uy tín và chất lượng cao tại Việt Nam. ";
        $prompt .= "Nhiệm vụ của bạn là trả lời các câu hỏi của phụ huynh và khách hàng tiềm năng một cách thân thiện, chuyên nghiệp và chi tiết.\n\n";

        $prompt .= "=== THÔNG TIN VỀ TRƯỜNG (DỮ LIỆU THẬT TỪ HỆ THỐNG) ===\n\n";

        // Thông tin cơ bản
        $prompt .= "**Tên trường:** Trường Mầm Non Ánh Sao\n";
        $prompt .= "**Địa chỉ:** 123 Đường ABC, Phường XYZ, Quận 1, TP.HCM\n";
        $prompt .= "**Hotline:** 0123 456 789\n";
        $prompt .= "**Email:** info@anhsao.edu.vn\n";
        $prompt .= "**Thời gian làm việc:** Thứ 2 - Thứ 6: 7:00 - 17:30, Thứ 7: 7:00 - 11:30\n\n";

        // Thông tin lớp học từ database (DỮ LIỆU THẬT)
        if (!empty($schoolData['classes']) && count($schoolData['classes']) > 0) {
            $prompt .= "**CÁC LỚP HỌC HIỆN CÓ (DỮ LIỆU THẬT TỪ HỆ THỐNG - TỔNG " . count($schoolData['classes']) . " LỚP):**\n";
            foreach ($schoolData['classes'] as $class) {
                $prompt .= "• Lớp: {$class['name']}\n";
                if ($class['age_group'] && $class['age_group'] !== 'Không xác định') {
                    $prompt .= "  - Độ tuổi: {$class['age_group']}\n";
                }
                $prompt .= "  - Sĩ số tối đa: {$class['capacity']} học sinh\n";
                $prompt .= "  - Giáo viên chủ nhiệm: {$class['teacher']}\n";
                if ($class['teacher_phone'] !== 'N/A') {
                    $prompt .= "  - Số điện thoại GV: {$class['teacher_phone']}\n";
                }
                $prompt .= "\n";
            }
        } else {
            $prompt .= "**LƯU Ý:** Hiện chưa có dữ liệu lớp học trong hệ thống.\n\n";
        }

        // Thông tin giáo viên (DỮ LIỆU THẬT)
        if ($schoolData['teacher_count'] > 0) {
            $prompt .= "**ĐỘI NGŨ GIÁO VIÊN (DỮ LIỆU THẬT - TỔNG {$schoolData['teacher_count']} GIÁO VIÊN):**\n";
            if (!empty($schoolData['teachers'])) {
                foreach ($schoolData['teachers'] as $teacher) {
                    $prompt .= "• {$teacher['name']}";
                    if ($teacher['email'] !== 'N/A') {
                        $prompt .= " - Email: {$teacher['email']}";
                    }
                    if ($teacher['phone'] !== 'N/A') {
                        $prompt .= " - SĐT: {$teacher['phone']}";
                    }
                    $prompt .= "\n";
                }
            }
            $prompt .= "- 100% có bằng Sư phạm Mầm non\n";
            $prompt .= "- Giàu kinh nghiệm và tận tâm\n\n";
        }

        // Hoạt động (DỮ LIỆU THẬT)
        if (!empty($schoolData['activities']) && count($schoolData['activities']) > 0) {
            $prompt .= "**CÁC HOẠT ĐỘNG GẦN ĐÂY (DỮ LIỆU THẬT TỪ HỆ THỐNG):**\n";
            foreach ($schoolData['activities'] as $activity) {
                $prompt .= "• {$activity['name']}";
                if ($activity['date']) {
                    $prompt .= " (Ngày: {$activity['date']})";
                }
                if ($activity['description']) {
                    $prompt .= "\n  Mô tả: {$activity['description']}";
                }
                $prompt .= "\n";
            }
            $prompt .= "\n";
        }

        // Học phí (từ database thật)
        $prompt .= "**HỌC PHÍ (DỮ LIỆU THẬT TỪ HỆ THỐNG):**\n";
        if (!empty($schoolData['tuition_data']) && count($schoolData['tuition_data']) > 0) {
            $tuition = $schoolData['tuition_data'][0];
            $prompt .= "📊 **Cấu trúc học phí thật từ database:**\n";
            if (isset($tuition['hocphi']) && $tuition['hocphi'] > 0) {
                $prompt .= "- Học phí cơ bản: " . number_format($tuition['hocphi']) . "đ/tháng\n";
            }
            if (isset($tuition['tienansang']) && $tuition['tienansang'] > 0) {
                $prompt .= "- Tiền ăn sáng: " . number_format($tuition['tienansang']) . "đ/tháng\n";
            }
            if (isset($tuition['tienantrua']) && $tuition['tienantrua'] > 0) {
                $prompt .= "- Tiền ăn trưa: " . number_format($tuition['tienantrua']) . "đ/tháng\n";
            }
            if (isset($tuition['tienxebus']) && $tuition['tienxebus'] > 0) {
                $prompt .= "- Tiền xe bus: " . number_format($tuition['tienxebus']) . "đ/tháng\n";
            }
            if (isset($tuition['phikhac']) && $tuition['phikhac'] > 0) {
                $prompt .= "- Phí khác: " . number_format($tuition['phikhac']) . "đ/tháng\n";
            }
        } else {
            $prompt .= "- Liên hệ 0123 456 789 để biết học phí chi tiết\n";
        }
        $prompt .= "- Ưu đãi: Giảm 10% cho con thứ 2\n\n";

        // Thông tin học sinh (DỮ LIỆU THẬT)
        $prompt .= "**SỐ LƯỢNG HỌC SINH (DỮ LIỆU THẬT):**\n";
        $prompt .= "- Học sinh đang học: {$schoolData['student_count']} em\n";
        $prompt .= "- Tổng số học sinh: {$schoolData['total_students']} em\n\n";

        // Chương trình học
        $prompt .= "**CHƯƠNG TRÌNH HỌC:**\n";
        $prompt .= "- Phát triển ngôn ngữ & giao tiếp\n";
        $prompt .= "- Toán học cơ bản\n";
        $prompt .= "- Khám phá khoa học\n";
        $prompt .= "- Nghệ thuật: Vẽ, nặn, thủ công\n";
        $prompt .= "- Âm nhạc & vận động\n";
        $prompt .= "- Tiếng Anh (Native Teacher)\n";
        $prompt .= "- Kỹ năng sống\n\n";

        // Thực đơn
        $prompt .= "**CHÉ ĐỘ DINH DƯỠNG:**\n";
        $prompt .= "- 3 bữa/ngày: Sáng - Trưa - Xế\n";
        $prompt .= "- Thực đơn do chuyên gia dinh dưỡng lên\n";
        $prompt .= "- Phục vụ chế độ ăn riêng cho bé dị ứng\n\n";

        // Hồ sơ nhập học
        $prompt .= "**HỒ SƠ NHẬP HỌC:**\n";
        $prompt .= "1. Đơn xin nhập học (theo mẫu)\n";
        $prompt .= "2. Giấy khai sinh (bản sao công chứng)\n";
        $prompt .= "3. Sổ hộ khẩu (bản sao)\n";
        $prompt .= "4. 4 ảnh 3x4 của bé\n";
        $prompt .= "5. Sổ tiêm chủng\n";
        $prompt .= "6. Giấy khám sức khỏe\n\n";

        $prompt .= "=== HƯỚNG DẪN TRẢ LỜI ===\n";
        $prompt .= "- Trả lời bằng tiếng Việt, thân thiện và nhiệt tình\n";
        $prompt .= "- Sử dụng emoji phù hợp (🌟 📚 👶 💰 📞 ⏰ etc.)\n";
        $prompt .= "- Trả lời ngắn gọn, rõ ràng, dễ hiểu (tối đa 200 từ)\n";
        $prompt .= "- ƯU TIÊN sử dụng DỮ LIỆU THẬT từ hệ thống ở trên\n";
        $prompt .= "- Khi hỏi về lớp học, giáo viên: PHẢI dùng tên thật từ database\n";
        $prompt .= "- Luôn kết thúc bằng câu hỏi gợi ý để tiếp tục hội thoại\n\n";

        return $prompt;
    }

    /**
     * Gọi Gemini API
     */
    private function callGeminiAPI($userMessage, $contextPrompt)
    {
        try {
            $apiKey = env('GEMINI_API_KEY');

            // Kiểm tra API key
            if (!$apiKey || $apiKey === 'your-gemini-api-key-here') {
                throw new \Exception("Gemini API key chưa được cấu hình!\n\nVui lòng:\n1. Lấy API key miễn phí tại: https://aistudio.google.com/app/apikey\n2. Mở file .env\n3. Tìm dòng: GEMINI_API_KEY=your-gemini-api-key-here\n4. Thay bằng API key thật\n5. Restart server");
            }

            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}";

            $response = Http::timeout(30)->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $contextPrompt . "\n\n=== CÂU HỎI CỦA KHÁCH HÀNG ===\n" . $userMessage
                            ]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 1024,
                ],
                'safetySettings' => [
                    [
                        'category' => 'HARM_CATEGORY_HARASSMENT',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ],
                    [
                        'category' => 'HARM_CATEGORY_HATE_SPEECH',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ],
                    [
                        'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ],
                    [
                        'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ],
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    return $data['candidates'][0]['content']['parts'][0]['text'];
                }

                throw new \Exception('Gemini API trả về dữ liệu không hợp lệ. Response: ' . json_encode($data));
            }

            $errorData = $response->json();
            $errorMessage = $errorData['error']['message'] ?? 'Unknown error';
            $errorStatus = $response->status();

            throw new \Exception("Gemini API error (HTTP {$errorStatus}): {$errorMessage}");
        } catch (\Exception $e) {
            // Nếu Gemini lỗi, fallback về smart mode nhưng vẫn đọc database
            Log::warning('Gemini API failed, using fallback: ' . $e->getMessage());
            return $this->smartFallbackResponse($userMessage);
        }
    }

    /**
     * Fallback thông minh khi Gemini API lỗi
     * Vẫn đọc database thật và trả lời dựa trên từ khóa
     */
    private function smartFallbackResponse($userMessage)
    {
        $message = strtolower($userMessage);
        $schoolData = $this->getSchoolData(); // Vẫn đọc database thật

        // Trả lời về lớp học từ database thật
        if (str_contains($message, 'lớp') || str_contains($message, 'class')) {
            if (!empty($schoolData['classes']) && count($schoolData['classes']) > 0) {
                $response = "🏫 **Các lớp học hiện có tại Trường MN Ánh Sao** (Dữ liệu thật từ database):\n\n";
                foreach ($schoolData['classes'] as $class) {
                    $response .= "• **{$class['name']}**\n";
                    if ($class['age_group'] !== 'Không xác định') {
                        $response .= "  - Độ tuổi: {$class['age_group']}\n";
                    }
                    $response .= "  - Sĩ số: {$class['capacity']} học sinh\n";
                    $response .= "  - Giáo viên: {$class['teacher']}\n\n";
                }
                return $response . "📞 Liên hệ: 0123 456 789";
            } else {
                return "🏫 Hiện trường đang cập nhật thông tin lớp học. Vui lòng liên hệ hotline 0123 456 789 để được tư vấn chi tiết!";
            }
        }

        // Trả lời về giáo viên từ database thật
        if (str_contains($message, 'giáo viên') || str_contains($message, 'teacher') || str_contains($message, 'cô') || str_contains($message, 'thầy')) {
            if ($schoolData['teacher_count'] > 0) {
                $response = "👩‍🏫 **Đội ngũ giáo viên Trường MN Ánh Sao** (Dữ liệu thật - {$schoolData['teacher_count']} giáo viên):\n\n";
                if (!empty($schoolData['teachers'])) {
                    foreach ($schoolData['teachers'] as $teacher) {
                        $response .= "• **{$teacher['name']}**";
                        if ($teacher['phone'] !== 'N/A') {
                            $response .= " - SĐT: {$teacher['phone']}";
                        }
                        $response .= "\n";
                    }
                }
                $response .= "\n✅ 100% có bằng Sư phạm Mầm non\n";
                $response .= "✅ Giàu kinh nghiệm và tận tâm với trẻ\n\n";
                return $response . "📞 Liên hệ: 0123 456 789";
            } else {
                return "👩‍🏫 Đội ngũ giáo viên có trình độ cao, giàu kinh nghiệm. Vui lòng liên hệ 0123 456 789 để biết thêm chi tiết!";
            }
        }

        // Trả lời về hoạt động từ database thật
        if (str_contains($message, 'hoạt động') || str_contains($message, 'sự kiện') || str_contains($message, 'activity')) {
            if (!empty($schoolData['activities'])) {
                $response = "🎪 **Các hoạt động gần đây tại trường** (Dữ liệu thật):\n\n";
                foreach ($schoolData['activities'] as $activity) {
                    $response .= "• **{$activity['name']}**";
                    if ($activity['date']) {
                        $response .= " - {$activity['date']}";
                    }
                    $response .= "\n";
                    if ($activity['description']) {
                        $response .= "  {$activity['description']}\n";
                    }
                    $response .= "\n";
                }
                return $response . "📞 Thông tin thêm: 0123 456 789";
            } else {
                return "🎪 Trường thường xuyên tổ chức các hoạt động giáo dục đa dạng cho trẻ. Liên hệ 0123 456 789 để biết lịch hoạt động chi tiết!";
            }
        }

        // Trả lời về học sinh từ database thật
        if (str_contains($message, 'học sinh') || str_contains($message, 'student') || str_contains($message, 'bao nhiêu học sinh')) {
            if ($schoolData['student_count'] > 0) {
                $response = "👦👧 **Thông tin học sinh Trường MN Ánh Sao** (Dữ liệu thật từ hệ thống):\n\n";
                $response .= "• Học sinh đang học: **{$schoolData['student_count']} em**\n";
                $response .= "• Tổng số học sinh: **{$schoolData['total_students']} em**\n\n";
                $response .= "📊 Trường có **{$schoolData['teacher_count']} giáo viên** và **" . count($schoolData['classes']) . " lớp học**\n\n";
                return $response . "📞 Thông tin chi tiết: 0123 456 789";
            } else {
                return "👦👧 Hiện trường đang cập nhật thông tin học sinh. Liên hệ 0123 456 789 để biết chi tiết!";
            }
        }

        // Trả lời về học phí từ database thật
        if (str_contains($message, 'học phí') || str_contains($message, 'giá') || str_contains($message, 'phí') || str_contains($message, 'tuition')) {
            $response = "💰 **Học phí Trường MN Ánh Sao** (Dữ liệu thật từ hệ thống):\n\n";

            if (!empty($schoolData['tuition_data']) && count($schoolData['tuition_data']) > 0) {
                $tuition = $schoolData['tuition_data'][0]; // Lấy mẫu học phí từ database
                $response .= "💵 **Cấu trúc học phí (từ database thật):**\n";
                if (isset($tuition['hocphi']) && $tuition['hocphi'] > 0) {
                    $response .= "• Học phí cơ bản: " . number_format($tuition['hocphi']) . "đ/tháng\n";
                }
                if (isset($tuition['tienansang']) && $tuition['tienansang'] > 0) {
                    $response .= "• Tiền ăn sáng: " . number_format($tuition['tienansang']) . "đ/tháng\n";
                }
                if (isset($tuition['tienantrua']) && $tuition['tienantrua'] > 0) {
                    $response .= "• Tiền ăn trưa: " . number_format($tuition['tienantrua']) . "đ/tháng\n";
                }
                if (isset($tuition['tienxebus']) && $tuition['tienxebus'] > 0) {
                    $response .= "• Tiền xe bus: " . number_format($tuition['tienxebus']) . "đ/tháng\n";
                }
                if (isset($tuition['phikhac']) && $tuition['phikhac'] > 0) {
                    $response .= "• Phí khác: " . number_format($tuition['phikhac']) . "đ/tháng\n";
                }
            } else {
                // Fallback theo độ tuổi nếu không có dữ liệu học phí
                if (!empty($schoolData['classes'])) {
                    $ageGroups = [];
                    foreach ($schoolData['classes'] as $class) {
                        if ($class['age_group'] && $class['age_group'] !== 'Không xác định') {
                            $ageGroup = $class['age_group'];
                            if (!in_array($ageGroup, $ageGroups)) {
                                $ageGroups[] = $ageGroup;
                                if (str_contains($ageGroup, '2-3')) {
                                    $response .= "• Độ tuổi {$ageGroup}: 2.200.000đ/tháng\n";
                                } elseif (str_contains($ageGroup, '3-4')) {
                                    $response .= "• Độ tuổi {$ageGroup}: 2.500.000đ/tháng\n";
                                }
                            }
                        }
                    }
                }
            }

            $response .= "\n**Ưu đãi:** Giảm 10% cho con thứ 2\n\n📞 0123 456 789";
            return $response;
        }

        // Trả lời về liên hệ
        if (str_contains($message, 'liên hệ') || str_contains($message, 'contact') || str_contains($message, 'địa chỉ') || str_contains($message, 'phone')) {
            return "📞 **Thông tin liên hệ Trường MN Ánh Sao:**\n\n" .
                "• **Hotline:** 0123 456 789\n" .
                "• **Email:** info@anhsao.edu.vn\n" .
                "• **Địa chỉ:** 123 Đường ABC, Phường XYZ, Quận 1, TP.HCM\n" .
                "• **Giờ làm việc:** Thứ 2-6: 7:00-17:30, Thứ 7: 7:00-11:30";
        }

        // Trả lời chung
        return "Chào bạn! 👋 Tôi là trợ lý ảo của Trường Mầm Non Ánh Sao.\n\n" .
            "🏫 **Trường hiện có (dữ liệu thật từ hệ thống):**\n" .
            "• {$schoolData['teacher_count']} giáo viên\n" .
            "• " . count($schoolData['classes']) . " lớp học\n" .
            "• {$schoolData['student_count']} học sinh đang học\n\n" .
            "Bạn có thể hỏi tôi về:\n" .
            "• Thông tin các lớp học 📚\n" .
            "• Đội ngũ giáo viên 👩‍🏫\n" .
            "• Số lượng học sinh 👦👧\n" .
            "• Học phí 💰\n" .
            "• Hoạt động trường 🎪\n" .
            "• Thông tin liên hệ 📞\n\n" .
            "Hoặc gọi hotline: **0123 456 789**";
    }

    /**
     * Quick reply cho các button
     */
    public function quickReply(Request $request)
    {
        $type = $request->input('type', '');

        // Lấy dữ liệu thật để tạo quick reply
        $schoolData = $this->getSchoolData();

        $quickReplies = [
            'tuition' => $this->generateTuitionReply($schoolData),
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

    /**
     * Tạo thông tin học phí từ database thật
     */
    private function generateTuitionReply($schoolData)
    {
        $response = "💰 **Học phí Trường MN Ánh Sao** (Database thật):\n\n";

        if (!empty($schoolData['tuition_data']) && count($schoolData['tuition_data']) > 0) {
            $tuition = $schoolData['tuition_data'][0];
            $response .= "💵 **Cấu trúc học phí từ hệ thống:**\n";
            if (isset($tuition['hocphi']) && $tuition['hocphi'] > 0) {
                $response .= "• Học phí cơ bản: " . number_format($tuition['hocphi']) . "đ/tháng\n";
            }
            if (isset($tuition['tienansang']) && $tuition['tienansang'] > 0) {
                $response .= "• Tiền ăn sáng: " . number_format($tuition['tienansang']) . "đ/tháng\n";
            }
            if (isset($tuition['tienantrua']) && $tuition['tienantrua'] > 0) {
                $response .= "• Tiền ăn trưa: " . number_format($tuition['tienantrua']) . "đ/tháng\n";
            }
            if (isset($tuition['tienxebus']) && $tuition['tienxebus'] > 0) {
                $response .= "• Tiền xe bus: " . number_format($tuition['tienxebus']) . "đ/tháng\n";
            }
            if (isset($tuition['phikhac']) && $tuition['phikhac'] > 0) {
                $response .= "• Phí khác: " . number_format($tuition['phikhac']) . "đ/tháng\n";
            }
        } else {
            $response .= "• Liên hệ 0123 456 789 để biết học phí chi tiết\n";
        }

        $response .= "\n**Ưu đãi:** Giảm 10% cho con thứ 2\n\n📞 Liên hệ: 0123 456 789";

        return $response;
    }
}
