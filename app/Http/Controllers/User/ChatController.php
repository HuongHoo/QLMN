<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Conversation;
use App\Models\GiaoVien;
use App\Models\HocSinh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Lấy danh sách giáo viên mà phụ huynh có thể nhắn tin
     */
    public function getTeachers()
    {
        $user = Auth::user();
        $phuHuynh = $user->phuHuynh;

        if (!$phuHuynh) {
            return response()->json(['teachers' => []]);
        }

        // Lấy danh sách học sinh của phụ huynh
        $hocSinhs = HocSinh::where('maphuhuynh', $phuHuynh->id)->get();

        // Lấy danh sách lớp của các bé
        $lopIds = $hocSinhs->pluck('malop')->unique()->filter();

        // Lấy giáo viên chủ nhiệm của các lớp
        $giaoViens = GiaoVien::whereIn('malopchunhiem', $lopIds)->with('lophoc')->get();

        $teachers = $giaoViens->map(function ($gv) {
            return [
                'id' => $gv->id,
                'tengiaovien' => $gv->tengiaovien,
                'lop' => $gv->lophoc ? $gv->lophoc->tenlop : '',
                'sdt' => $gv->sdt,
                'anh' => $gv->anh,
            ];
        });

        return response()->json(['teachers' => $teachers]);
    }

    /**
     * Lấy tin nhắn với một giáo viên cụ thể
     */
    public function getMessages($giaoVienId)
    {
        $user = Auth::user();
        $phuHuynh = $user->phuHuynh;

        if (!$phuHuynh) {
            return response()->json(['error' => 'Không tìm thấy phụ huynh'], 404);
        }

        // Lấy thông tin giáo viên
        $giaoVien = GiaoVien::with('lophoc')->find($giaoVienId);
        if (!$giaoVien) {
            return response()->json(['error' => 'Không tìm thấy giáo viên'], 404);
        }

        // Đánh dấu tin nhắn từ giáo viên đã đọc
        Message::where('sender_id', $giaoVienId)
            ->where('sender_type', 'giaovien')
            ->where('receiver_id', $phuHuynh->id)
            ->where('receiver_type', 'phuhuynh')
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        // Lấy tin nhắn giữa phụ huynh và giáo viên
        $messages = Message::between($giaoVienId, $phuHuynh->id)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) use ($phuHuynh) {
                return [
                    'id' => $msg->id,
                    'message' => $msg->message,
                    'is_mine' => $msg->sender_type === 'phuhuynh' && $msg->sender_id === $phuHuynh->id,
                    'is_read' => $msg->is_read,
                    'read_at' => $msg->read_at ? $msg->read_at->format('H:i d/m') : null,
                    'created_at' => $msg->created_at->format('H:i'),
                    'created_date' => $msg->created_at->format('d/m/Y'),
                    'sender_name' => $msg->sender_name,
                ];
            });

        return response()->json([
            'giaoVien' => [
                'id' => $giaoVien->id,
                'tengiaovien' => $giaoVien->tengiaovien,
                'lop' => $giaoVien->lophoc ? $giaoVien->lophoc->tenlop : '',
                'sdt' => $giaoVien->sdt,
            ],
            'messages' => $messages,
        ]);
    }

    /**
     * Gửi tin nhắn cho giáo viên
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|integer',
            'message' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        $phuHuynh = $user->phuHuynh;

        if (!$phuHuynh) {
            return response()->json(['error' => 'Không tìm thấy phụ huynh'], 404);
        }

        // Tạo tin nhắn mới
        $message = Message::create([
            'sender_id' => $phuHuynh->id,
            'sender_type' => 'phuhuynh',
            'receiver_id' => $request->receiver_id,
            'receiver_type' => 'giaovien',
            'message' => $request->message,
            'is_read' => false,
        ]);

        // Tạo hoặc cập nhật conversation
        $conversation = Conversation::findOrCreateConversation($request->receiver_id, $phuHuynh->id);
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
     * Kiểm tra tin nhắn mới từ giáo viên
     */
    public function checkNewMessages($giaoVienId)
    {
        $user = Auth::user();
        $phuHuynh = $user->phuHuynh;

        if (!$phuHuynh) {
            return response()->json(['error' => 'Không tìm thấy phụ huynh'], 404);
        }

        // Lấy tin nhắn mới từ giáo viên (chưa đọc)
        $newMessages = Message::where('sender_id', $giaoVienId)
            ->where('sender_type', 'giaovien')
            ->where('receiver_id', $phuHuynh->id)
            ->where('receiver_type', 'phuhuynh')
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
        Message::where('sender_id', $giaoVienId)
            ->where('sender_type', 'giaovien')
            ->where('receiver_id', $phuHuynh->id)
            ->where('receiver_type', 'phuhuynh')
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
    public function checkReadStatus($giaoVienId)
    {
        $user = Auth::user();
        $phuHuynh = $user->phuHuynh;

        if (!$phuHuynh) {
            return response()->json(['error' => 'Không tìm thấy phụ huynh'], 404);
        }

        // Lấy tin nhắn mà phụ huynh đã gửi và đã được đọc
        $readMessages = Message::where('sender_id', $phuHuynh->id)
            ->where('sender_type', 'phuhuynh')
            ->where('receiver_id', $giaoVienId)
            ->where('receiver_type', 'giaovien')
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
        $user = Auth::user();
        $phuHuynh = $user->phuHuynh;

        if (!$phuHuynh) {
            return response()->json(['count' => 0]);
        }

        $count = Message::where('receiver_id', $phuHuynh->id)
            ->where('receiver_type', 'phuhuynh')
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Lấy danh sách cuộc trò chuyện với số tin chưa đọc
     */
    public function getConversations()
    {
        $user = Auth::user();
        $phuHuynh = $user->phuHuynh;

        if (!$phuHuynh) {
            return response()->json(['conversations' => []]);
        }

        // Lấy các cuộc trò chuyện
        $conversations = Conversation::forParent($phuHuynh->id)
            ->with(['giaoVien', 'giaoVien.lophoc', 'lastMessage'])
            ->get()
            ->map(function ($conv) {
                return [
                    'id' => $conv->id,
                    'giaovien_id' => $conv->giaovien_id,
                    'giaovien_name' => $conv->giaoVien->tengiaovien ?? 'Giáo viên',
                    'lop' => $conv->giaoVien && $conv->giaoVien->lophoc ? $conv->giaoVien->lophoc->tenlop : '',
                    'last_message' => $conv->lastMessage ? $conv->lastMessage->message : '',
                    'last_message_at' => $conv->last_message_at ? $conv->last_message_at->diffForHumans() : '',
                    'unread_count' => $conv->unreadCountForParent(),
                ];
            });

        return response()->json(['conversations' => $conversations]);
    }
}
