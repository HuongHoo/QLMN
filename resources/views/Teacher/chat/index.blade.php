@extends('teacher.teacher')

@section('content')
    <div class="col-12">
        <div class="card shadow-lg" style="height: calc(100vh - 200px); min-height: 500px;">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0">
                    <i class="fas fa-comments me-2"></i>
                    Nhắn tin với Phụ huynh
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="row g-0 h-100">
                    <!-- Danh sách phụ huynh -->
                    <div class="col-md-4 col-lg-3 border-end" style="height: 100%; overflow-y: auto;">
                        <div class="p-3 border-bottom bg-light">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" id="searchParent"
                                    placeholder="Tìm phụ huynh...">
                            </div>
                        </div>

                        <!-- Danh sách conversations -->
                        <div id="conversationList">
                            @forelse($phuHuynhs as $ph)
                                <div class="conversation-item p-3 border-bottom" data-phuhuynh-id="{{ $ph->id }}"
                                    onclick="selectConversation({{ $ph->id }})">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-primary text-white me-3">
                                            {{ strtoupper(substr($ph->hoten, 0, 1)) }}
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0 parent-name">{{ $ph->hoten }}</h6>
                                            <small class="text-muted last-message">Nhấn để bắt đầu trò chuyện</small>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted last-time"></small>
                                            <span class="badge bg-danger rounded-pill unread-badge"
                                                style="display: none;">0</span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center text-muted">
                                    <i class="fas fa-users fa-3x mb-3"></i>
                                    <p>Chưa có phụ huynh trong lớp</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Khung chat -->
                    <div class="col-md-8 col-lg-9 d-flex flex-column" style="height: 100%;">
                        <!-- Header chat -->
                        <div class="chat-header p-3 border-bottom bg-light d-none" id="chatHeader">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-success text-white me-3" id="chatAvatar">
                                    A
                                </div>
                                <div>
                                    <h6 class="mb-0" id="chatName">Tên phụ huynh</h6>
                                    <small class="text-muted" id="chatInfo">Phụ huynh của: </small>
                                </div>
                                <div class="ms-auto d-flex align-items-center gap-2">
                                    <span class="badge bg-success" id="chatStatus">
                                        <i class="fas fa-circle me-1" style="font-size: 8px;"></i> Online
                                    </span>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="closeChat()"
                                        title="Đóng cuộc trò chuyện">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Tin nhắn -->
                        <div class="chat-messages flex-grow-1 p-3" id="chatMessages"
                            style="overflow-y: auto; display: none;">
                            <!-- Messages sẽ được load ở đây -->
                        </div>

                        <!-- Placeholder khi chưa chọn cuộc trò chuyện -->
                        <div class="chat-placeholder flex-grow-1 d-flex align-items-center justify-content-center"
                            id="chatPlaceholder">
                            <div class="text-center text-muted">
                                <i class="fas fa-comments fa-4x mb-3" style="opacity: 0.3;"></i>
                                <h5>Nhấn để bắt đầu trò chuyện</h5>
                                <p class="small">Tin nhắn sẽ hiển thị tại đây</p>
                            </div>
                        </div>

                        <!-- Input gửi tin nhắn -->
                        <div class="chat-input p-3 border-top bg-light d-none" id="chatInput">
                            <form id="messageForm" onsubmit="sendMessage(event)">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="messageInput"
                                        placeholder="Nhập tin nhắn..." autocomplete="off">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .conversation-item {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .conversation-item:hover {
            background-color: #f8f9fa;
        }

        .conversation-item.active {
            background-color: #e3f2fd;
            border-left: 3px solid #4e73df;
        }

        .avatar-circle {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
        }

        .chat-messages {
            background-color: #f5f5f5;
        }

        .message-bubble {
            max-width: 70%;
            padding: 10px 15px;
            border-radius: 18px;
            margin-bottom: 10px;
            word-wrap: break-word;
        }

        .message-mine {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
            margin-left: auto;
            border-bottom-right-radius: 4px;
        }

        .message-other {
            background-color: white;
            color: #333;
            margin-right: auto;
            border-bottom-left-radius: 4px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .message-time {
            font-size: 11px;
            opacity: 0.7;
        }

        .message-status {
            font-size: 11px;
        }

        .message-status .seen {
            color: #4e73df;
        }

        .message-date-divider {
            text-align: center;
            margin: 20px 0;
        }

        .message-date-divider span {
            background-color: #e0e0e0;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 12px;
            color: #666;
        }

        .typing-indicator {
            display: flex;
            align-items: center;
            padding: 10px 15px;
        }

        .typing-indicator span {
            width: 8px;
            height: 8px;
            background-color: #90949c;
            border-radius: 50%;
            margin: 0 2px;
            animation: typing 1s infinite;
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        #chatMessages::-webkit-scrollbar {
            width: 6px;
        }

        #chatMessages::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        #chatMessages::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        #conversationList::-webkit-scrollbar {
            width: 6px;
        }

        #conversationList::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        #conversationList::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
    </style>

    <script>
        let currentPhuHuynhId = null;
        let checkNewMessagesInterval = null;
        let checkReadStatusInterval = null;

        // Đóng cuộc trò chuyện hiện tại
        function closeChat() {
            currentPhuHuynhId = null;

            // Dừng polling
            if (checkNewMessagesInterval) clearInterval(checkNewMessagesInterval);
            if (checkReadStatusInterval) clearInterval(checkReadStatusInterval);

            // Bỏ active khỏi tất cả conversation
            document.querySelectorAll('.conversation-item').forEach(item => {
                item.classList.remove('active');
            });

            // Ẩn chat area, hiện placeholder
            document.getElementById('chatPlaceholder').classList.remove('d-none');
            document.getElementById('chatHeader').classList.add('d-none');
            document.getElementById('chatMessages').style.display = 'none';
            document.getElementById('chatInput').classList.add('d-none');

            // Clear tin nhắn
            document.getElementById('chatMessages').innerHTML = '';
        }

        // Chọn cuộc trò chuyện
        function selectConversation(phuHuynhId) {
            currentPhuHuynhId = phuHuynhId;

            // Đánh dấu active
            document.querySelectorAll('.conversation-item').forEach(item => {
                item.classList.remove('active');
            });
            document.querySelector(`[data-phuhuynh-id="${phuHuynhId}"]`).classList.add('active');

            // Hiển thị chat area
            document.getElementById('chatPlaceholder').classList.add('d-none');
            document.getElementById('chatHeader').classList.remove('d-none');
            document.getElementById('chatMessages').style.display = 'block';
            document.getElementById('chatInput').classList.remove('d-none');

            // Load tin nhắn
            loadMessages(phuHuynhId);

            // Bắt đầu polling cho tin nhắn mới
            startPolling(phuHuynhId);
        }

        // Load tin nhắn
        function loadMessages(phuHuynhId) {
            fetch(`{{ url('/teacher/chat/messages') }}/${phuHuynhId}`)
                .then(response => response.json())
                .then(data => {
                    // Cập nhật header
                    document.getElementById('chatAvatar').textContent = data.phuHuynh.hoten.charAt(0).toUpperCase();
                    document.getElementById('chatName').textContent = data.phuHuynh.hoten;
                    document.getElementById('chatInfo').textContent = 'Phụ huynh của: ' + data.phuHuynh.hocsinhs.join(
                        ', ');

                    // Render tin nhắn
                    renderMessages(data.messages);

                    // Ẩn badge chưa đọc
                    const badge = document.querySelector(`[data-phuhuynh-id="${phuHuynhId}"] .unread-badge`);
                    if (badge) {
                        badge.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Render tin nhắn
        function renderMessages(messages) {
            const container = document.getElementById('chatMessages');
            container.innerHTML = '';

            let lastDate = null;

            messages.forEach(msg => {
                // Thêm divider ngày nếu khác ngày
                if (msg.created_date !== lastDate) {
                    container.innerHTML += `
                    <div class="message-date-divider">
                        <span>${msg.created_date}</span>
                    </div>
                `;
                    lastDate = msg.created_date;
                }

                const messageClass = msg.is_mine ? 'message-mine' : 'message-other';
                const readStatus = msg.is_mine ?
                    (msg.is_read ?
                        `<span class="seen"><i class="fas fa-check-double"></i> Đã xem</span>` :
                        `<i class="fas fa-check"></i> Đã gửi`) : '';

                container.innerHTML += `
                <div class="d-flex ${msg.is_mine ? 'justify-content-end' : 'justify-content-start'}" data-message-id="${msg.id}">
                    <div class="message-bubble ${messageClass}">
                        <div>${msg.message}</div>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <span class="message-time">${msg.created_at}</span>
                            ${msg.is_mine ? `<span class="message-status ms-2">${readStatus}</span>` : ''}
                        </div>
                    </div>
                </div>
            `;
            });

            // Scroll xuống cuối
            container.scrollTop = container.scrollHeight;
        }

        // Gửi tin nhắn
        function sendMessage(event) {
            event.preventDefault();

            const input = document.getElementById('messageInput');
            const message = input.value.trim();

            if (!message || !currentPhuHuynhId) return;

            // Gửi request
            fetch('{{ route('teacher.chat.send') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        receiver_id: currentPhuHuynhId,
                        message: message
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Thêm tin nhắn mới vào khung chat
                        const container = document.getElementById('chatMessages');
                        const today = new Date().toLocaleDateString('vi-VN');

                        // Kiểm tra xem có cần thêm divider ngày không
                        const lastDateDiv = container.querySelector('.message-date-divider:last-of-type span');
                        if (!lastDateDiv || lastDateDiv.textContent !== data.message.created_date) {
                            container.innerHTML += `
                        <div class="message-date-divider">
                            <span>${data.message.created_date}</span>
                        </div>
                    `;
                        }

                        container.innerHTML += `
                    <div class="d-flex justify-content-end" data-message-id="${data.message.id}">
                        <div class="message-bubble message-mine">
                            <div>${data.message.message}</div>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <span class="message-time">${data.message.created_at}</span>
                                <span class="message-status ms-2"><i class="fas fa-check"></i> Đã gửi</span>
                            </div>
                        </div>
                    </div>
                `;

                        // Scroll xuống cuối
                        container.scrollTop = container.scrollHeight;

                        // Clear input
                        input.value = '';

                        // Cập nhật last message trong danh sách
                        updateConversationPreview(currentPhuHuynhId, message);
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Bắt đầu polling
        function startPolling(phuHuynhId) {
            // Clear intervals cũ
            if (checkNewMessagesInterval) clearInterval(checkNewMessagesInterval);
            if (checkReadStatusInterval) clearInterval(checkReadStatusInterval);

            // Polling tin nhắn mới mỗi 3 giây
            checkNewMessagesInterval = setInterval(() => {
                checkNewMessages(phuHuynhId);
            }, 3000);

            // Polling trạng thái đã đọc mỗi 5 giây
            checkReadStatusInterval = setInterval(() => {
                checkReadStatus(phuHuynhId);
            }, 5000);
        }

        // Kiểm tra tin nhắn mới
        function checkNewMessages(phuHuynhId) {
            fetch(`{{ url('/teacher/chat/check-new') }}/${phuHuynhId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.count > 0) {
                        const container = document.getElementById('chatMessages');

                        data.newMessages.forEach(msg => {
                            // Kiểm tra xem tin nhắn đã tồn tại chưa
                            if (!container.querySelector(`[data-message-id="${msg.id}"]`)) {
                                container.innerHTML += `
                                <div class="d-flex justify-content-start" data-message-id="${msg.id}">
                                    <div class="message-bubble message-other">
                                        <div>${msg.message}</div>
                                        <div class="message-time mt-1">${msg.created_at}</div>
                                    </div>
                                </div>
                            `;
                            }
                        });

                        container.scrollTop = container.scrollHeight;
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Kiểm tra trạng thái đã đọc
        function checkReadStatus(phuHuynhId) {
            fetch(`{{ url('/teacher/chat/check-read') }}/${phuHuynhId}`)
                .then(response => response.json())
                .then(data => {
                    data.readMessages.forEach(msg => {
                        const messageEl = document.querySelector(
                            `[data-message-id="${msg.id}"] .message-status`);
                        if (messageEl) {
                            messageEl.innerHTML =
                                '<span class="seen"><i class="fas fa-check-double"></i> Đã xem</span>';
                        }
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        // Cập nhật preview tin nhắn trong danh sách
        function updateConversationPreview(phuHuynhId, message) {
            const item = document.querySelector(`[data-phuhuynh-id="${phuHuynhId}"]`);
            if (item) {
                const lastMsg = item.querySelector('.last-message');
                const lastTime = item.querySelector('.last-time');
                if (lastMsg) lastMsg.textContent = message.substring(0, 30) + (message.length > 30 ? '...' : '');
                if (lastTime) lastTime.textContent = 'Vừa xong';
            }
        }

        // Tìm kiếm phụ huynh
        document.getElementById('searchParent').addEventListener('input', function(e) {
            const search = e.target.value.toLowerCase();
            document.querySelectorAll('.conversation-item').forEach(item => {
                const name = item.querySelector('.parent-name').textContent.toLowerCase();
                item.style.display = name.includes(search) ? 'block' : 'none';
            });
        });

        // Load conversations khi trang load
        document.addEventListener('DOMContentLoaded', function() {
            loadConversations();

            // Cập nhật số tin chưa đọc
            setInterval(updateUnreadCounts, 10000);
        });

        // Load danh sách conversations
        function loadConversations() {
            fetch('{{ route('teacher.chat.conversations') }}')
                .then(response => response.json())
                .then(data => {
                    data.conversations.forEach(conv => {
                        const item = document.querySelector(`[data-phuhuynh-id="${conv.phuhuynh_id}"]`);
                        if (item) {
                            const lastMsg = item.querySelector('.last-message');
                            const lastTime = item.querySelector('.last-time');
                            const badge = item.querySelector('.unread-badge');

                            if (lastMsg && conv.last_message) {
                                lastMsg.textContent = conv.last_message.substring(0, 30) +
                                    (conv.last_message.length > 30 ? '...' : '');
                            }
                            if (lastTime && conv.last_message_at) {
                                lastTime.textContent = conv.last_message_at;
                            }
                            if (badge && conv.unread_count > 0) {
                                badge.textContent = conv.unread_count;
                                badge.style.display = 'inline';
                            }
                        }
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        // Cập nhật số tin chưa đọc
        function updateUnreadCounts() {
            fetch('{{ route('teacher.chat.conversations') }}')
                .then(response => response.json())
                .then(data => {
                    data.conversations.forEach(conv => {
                        const item = document.querySelector(`[data-phuhuynh-id="${conv.phuhuynh_id}"]`);
                        if (item && conv.phuhuynh_id !== currentPhuHuynhId) {
                            const badge = item.querySelector('.unread-badge');
                            if (badge) {
                                if (conv.unread_count > 0) {
                                    badge.textContent = conv.unread_count;
                                    badge.style.display = 'inline';
                                } else {
                                    badge.style.display = 'none';
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
@endsection
