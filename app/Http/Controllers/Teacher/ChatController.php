<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Conversation;
use App\Models\PhuHuynh;
use App\Models\HocSinh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Hiển thị trang chat chính với danh sách phụ huynh
     */
    public function index()
    {
        $teacher = Auth::user()->giaovien;

        if (!$teacher) {
            return abort(404, 'Không tìm thấy thông tin giáo viên');
        }

        // Lấy danh sách phụ huynh có con trong lớp của giáo viên
        $phuHuynhs = $this->getParentsInClass($teacher);

        // Lấy các cuộc trò chuyện của giáo viên
        $conversations = Conversation::forTeacher($teacher->id)
            ->with(['phuHuynh', 'lastMessage'])
            ->get();

        return view('teacher.chat.index', compact('teacher', 'phuHuynhs', 'conversations'));
    }

    /**
     * Lấy danh sách phụ huynh có con trong lớp của giáo viên
     */
    private function getParentsInClass($teacher)
    {
        if (!$teacher->malopchunhiem) {
            return collect();
        }

        // Lấy danh sách học sinh trong lớp
        $hocSinhs = HocSinh::where('malop', $teacher->malopchunhiem)->get();

        // Lấy danh sách phụ huynh từ học sinh
        $phuHuynhIds = $hocSinhs->pluck('maphuhuynh')->unique()->filter();

        return PhuHuynh::whereIn('id', $phuHuynhIds)->get();
    }

    /**
     * Lấy tin nhắn với một phụ huynh cụ thể
     */
    public function getMessages($phuHuynhId)
    {
        $teacher = Auth::user()->giaovien;

        if (!$teacher) {
            return response()->json(['error' => 'Không tìm thấy giáo viên'], 404);
        }

        // Lấy thông tin phụ huynh
        $phuHuynh = PhuHuynh::find($phuHuynhId);
        if (!$phuHuynh) {
            return response()->json(['error' => 'Không tìm thấy phụ huynh'], 404);
        }

        // Đánh dấu tin nhắn từ phụ huynh đã đọc
        Message::where('sender_id', $phuHuynhId)
            ->where('sender_type', 'phuhuynh')
            ->where('receiver_id', $teacher->id)
            ->where('receiver_type', 'giaovien')
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        // Lấy tin nhắn giữa giáo viên và phụ huynh
        $messages = Message::between($teacher->id, $phuHuynhId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) use ($teacher) {
                return [
                    'id' => $msg->id,
                    'message' => $msg->message,
                    'is_mine' => $msg->sender_type === 'giaovien' && $msg->sender_id === $teacher->id,
                    'is_read' => $msg->is_read,
                    'read_at' => $msg->read_at ? $msg->read_at->format('H:i d/m') : null,
                    'created_at' => $msg->created_at->format('H:i'),
                    'created_date' => $msg->created_at->format('d/m/Y'),
                    'sender_name' => $msg->sender_name,
                ];
            });

        // Lấy thông tin học sinh của phụ huynh trong lớp
        $hocSinhs = HocSinh::where('maphuhuynh', $phuHuynhId)
            ->where('malop', $teacher->malopchunhiem)
            ->get();

        return response()->json([
            'phuHuynh' => [
                'id' => $phuHuynh->id,
                'hoten' => $phuHuynh->hoten,
                'sdt' => $phuHuynh->sdt,
                'hocsinhs' => $hocSinhs->pluck('tenhocsinh')->toArray(),
            ],
            'messages' => $messages,
        ]);
    }

    /**
     * Gửi tin nhắn cho phụ huynh
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|integer',
            'message' => 'required|string|max:1000',
        ]);

        $teacher = Auth::user()->giaovien;

        if (!$teacher) {
            return response()->json(['error' => 'Không tìm thấy giáo viên'], 404);
        }

        // Tạo tin nhắn mới
        $message = Message::create([
            'sender_id' => $teacher->id,
            'sender_type' => 'giaovien',
            'receiver_id' => $request->receiver_id,
            'receiver_type' => 'phuhuynh',
            'message' => $request->message,
            'is_read' => false,
        ]);

        // Tạo hoặc cập nhật conversation
        $conversation = Conversation::findOrCreateConversation($teacher->id, $request->receiver_id);
        $conversation->updateLastMessage($message->id);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'message' => $message->message,
                'is_mine' => true,
                'is_read' => false,
                'created_at' => $message->created_at->format('H:i'),
                'created_date' => $message->created_at->format('d/m/Y'),
            ],
        ]);
    }

    /**
     * Kiểm tra tin nhắn mới
     */
    public function checkNewMessages($phuHuynhId)
    {
        $teacher = Auth::user()->giaovien;

        if (!$teacher) {
            return response()->json(['error' => 'Không tìm thấy giáo viên'], 404);
        }

        // Lấy tin nhắn mới từ phụ huynh (chưa đọc)
        $newMessages = Message::where('sender_id', $phuHuynhId)
            ->where('sender_type', 'phuhuynh')
            ->where('receiver_id', $teacher->id)
            ->where('receiver_type', 'giaovien')
            ->where('is_read', false)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'message' => $msg->message,
                    'is_mine' => false,
                    'is_read' => $msg->is_read,
                    'created_at' => $msg->created_at->format('H:i'),
                    'created_date' => $msg->created_at->format('d/m/Y'),
                    'sender_name' => $msg->sender_name,
                ];
            });

        // Đánh dấu đã đọc
        Message::where('sender_id', $phuHuynhId)
            ->where('sender_type', 'phuhuynh')
            ->where('receiver_id', $teacher->id)
            ->where('receiver_type', 'giaovien')
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return response()->json([
            'newMessages' => $newMessages,
            'count' => $newMessages->count(),
        ]);
    }

    /**
     * Kiểm tra trạng thái đã đọc của tin nhắn đã gửi
     */
    public function checkReadStatus($phuHuynhId)
    {
        $teacher = Auth::user()->giaovien;

        if (!$teacher) {
            return response()->json(['error' => 'Không tìm thấy giáo viên'], 404);
        }

        // Lấy tin nhắn mà giáo viên đã gửi và đã được đọc
        $readMessages = Message::where('sender_id', $teacher->id)
            ->where('sender_type', 'giaovien')
            ->where('receiver_id', $phuHuynhId)
            ->where('receiver_type', 'phuhuynh')
            ->where('is_read', true)
            ->select('id', 'read_at')
            ->get();

        return response()->json([
            'readMessages' => $readMessages,
        ]);
    }

    /**
     * Lấy số tin nhắn chưa đọc tổng cộng
     */
    public function getUnreadCount()
    {
        $teacher = Auth::user()->giaovien;

        if (!$teacher) {
            return response()->json(['count' => 0]);
        }

        $count = Message::where('receiver_id', $teacher->id)
            ->where('receiver_type', 'giaovien')
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Lấy danh sách cuộc trò chuyện với số tin chưa đọc
     */
    public function getConversations()
    {
        $teacher = Auth::user()->giaovien;

        if (!$teacher) {
            return response()->json(['conversations' => []]);
        }

        // Lấy các cuộc trò chuyện
        $conversations = Conversation::forTeacher($teacher->id)
            ->with(['phuHuynh', 'lastMessage'])
            ->get()
            ->map(function ($conv) {
                return [
                    'id' => $conv->id,
                    'phuhuynh_id' => $conv->phuhuynh_id,
                    'phuhuynh_name' => $conv->phuHuynh->hoten ?? 'Phụ huynh',
                    'last_message' => $conv->lastMessage ? $conv->lastMessage->message : '',
                    'last_message_at' => $conv->last_message_at ? $conv->last_message_at->diffForHumans() : '',
                    'unread_count' => $conv->unreadCountForTeacher(),
                ];
            });

        return response()->json(['conversations' => $conversations]);
    }
}
