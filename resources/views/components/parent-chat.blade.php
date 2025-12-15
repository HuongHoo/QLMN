{{-- Chat Component - Chat với Giáo viên --}}
<div id="chat-container">
    {{-- Chat Button --}}
    <button id="chat-toggle-btn" class="chat-toggle-btn" onclick="toggleChat()">
        <i class="fas fa-comments" id="chat-icon"></i>
        <i class="fas fa-times" id="close-icon" style="display: none;"></i>
        <span class="chat-badge" id="chat-badge" style="display: none;">0</span>
    </button>

    {{-- Chat Window --}}
    <div id="chat-window" class="chat-window">
        {{-- Header --}}
        <div class="chat-window-header">
            <div class="header-left">
                <div class="header-avatar" id="headerAvatar">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="header-info">
                    <h5 id="headerName">Chọn giáo viên</h5>
                    <span class="header-status" id="headerStatus">
                        <span class="status-dot"></span> Nhắn tin với giáo viên
                    </span>
                </div>
            </div>
            <div class="header-actions">
                <button class="header-btn" onclick="toggleTeacherList()" id="teacherListBtn">
                    <i class="fas fa-list"></i>
                </button>
                <button class="header-btn" onclick="toggleChat()">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        {{-- Teacher List (sidebar) --}}
        <div class="teacher-list" id="teacherList" style="display: none;">
            <div class="teacher-list-header">
                <h6><i class="fas fa-chalkboard-teacher me-2"></i>Giáo viên của bé</h6>
            </div>
            <div class="teacher-list-body" id="teacherListBody">
                <div class="text-center p-3">
                    <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                    <p class="small mt-2">Đang tải...</p>
                </div>
            </div>
        </div>

        {{-- Messages --}}
        <div class="chat-messages" id="chatMessages">
            {{-- Welcome message --}}
            <div class="chat-welcome" id="chatWelcome">
                <div class="welcome-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <h5>Nhắn tin với Giáo viên</h5>
                <p>Chọn giáo viên để bắt đầu cuộc trò chuyện</p>
                <button class="btn btn-primary btn-sm" onclick="toggleTeacherList()">
                    <i class="fas fa-list me-1"></i> Danh sách giáo viên
                </button>
            </div>
        </div>

        {{-- Input --}}
        <div class="chat-input-area" id="chatInputArea" style="display: none;">
            <form id="chatForm" onsubmit="sendChatMessage(event)">
                <div class="input-wrapper">
                    <input type="text" id="chatInput" placeholder="Nhập tin nhắn..." autocomplete="off">
                    <button type="submit" id="sendBtn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Chat Toggle Button */
    .chat-toggle-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        box-shadow: 0 4px 20px rgba(78, 115, 223, 0.4);
        z-index: 9999;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chat-toggle-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 25px rgba(78, 115, 223, 0.5);
    }

    .chat-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #ff4757;
        color: white;
        font-size: 12px;
        min-width: 22px;
        height: 22px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        padding: 0 5px;
        animation: badgePulse 1.5s infinite;
        box-shadow: 0 2px 8px rgba(255, 71, 87, 0.5);
    }

    @keyframes badgePulse {

        0%,
        100% {
            transform: scale(1);
            box-shadow: 0 2px 8px rgba(255, 71, 87, 0.5);
        }

        50% {
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(255, 71, 87, 0.8);
        }
    }

    /* Chat Window */
    .chat-window {
        position: fixed;
        bottom: 100px;
        right: 30px;
        width: 380px;
        height: 520px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        z-index: 9998;
        display: none;
        flex-direction: column;
        overflow: hidden;
        animation: slideUp 0.3s ease;
    }

    .chat-window.active {
        display: flex;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Header */
    .chat-window-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .header-avatar {
        width: 45px;
        height: 45px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .header-info h5 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
    }

    .header-status {
        font-size: 12px;
        opacity: 0.9;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        background: #2ecc71;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }
    }

    .header-actions {
        display: flex;
        gap: 8px;
    }

    .header-btn {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        cursor: pointer;
        transition: background 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .header-btn:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Teacher List */
    .teacher-list {
        position: absolute;
        top: 75px;
        left: 0;
        right: 0;
        bottom: 0;
        background: white;
        z-index: 10;
        animation: fadeIn 0.2s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .teacher-list-header {
        padding: 15px;
        border-bottom: 1px solid #eee;
        background: #f8f9fa;
    }

    .teacher-list-header h6 {
        margin: 0;
        color: #4e73df;
        font-weight: 600;
    }

    .teacher-list-body {
        overflow-y: auto;
        height: calc(100% - 50px);
    }

    .teacher-item {
        padding: 15px;
        border-bottom: 1px solid #eee;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .teacher-item:hover {
        background: #f8f9fa;
    }

    .teacher-item.active {
        background: #e3f2fd;
        border-left: 3px solid #4e73df;
    }

    .teacher-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #28a745 0%, #34ce57 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 18px;
    }

    .teacher-info {
        flex: 1;
    }

    .teacher-info h6 {
        margin: 0 0 3px 0;
        font-size: 14px;
        font-weight: 600;
    }

    .teacher-info small {
        color: #666;
    }

    .teacher-badge {
        background: #ff4757;
        color: white;
        font-size: 11px;
        min-width: 20px;
        height: 20px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 5px;
    }

    /* Messages */
    .chat-messages {
        flex: 1;
        padding: 15px;
        overflow-y: auto;
        background: #f5f5f5;
    }

    .chat-welcome {
        text-align: center;
        padding: 50px 20px;
    }

    .welcome-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: white;
    }

    .chat-welcome h5 {
        color: #333;
        margin-bottom: 10px;
    }

    .chat-welcome p {
        color: #666;
        margin-bottom: 20px;
    }

    .message-bubble-wrapper {
        display: flex;
        margin-bottom: 12px;
        animation: fadeIn 0.3s ease;
    }

    .message-bubble-wrapper.mine {
        justify-content: flex-end;
    }

    .message-bubble-wrapper.other {
        justify-content: flex-start;
    }

    .message-bubble {
        max-width: 75%;
        padding: 10px 15px;
        border-radius: 18px;
        word-wrap: break-word;
    }

    .message-bubble.mine {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        border-bottom-right-radius: 4px;
    }

    .message-bubble.other {
        background: white;
        color: #333;
        border-bottom-left-radius: 4px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .message-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 5px;
        font-size: 11px;
        opacity: 0.7;
    }

    .message-status {
        margin-left: 8px;
    }

    .message-status .seen {
        color: #4fc3f7;
    }

    .message-date-divider {
        text-align: center;
        margin: 20px 0;
    }

    .message-date-divider span {
        background: #e0e0e0;
        padding: 5px 15px;
        border-radius: 15px;
        font-size: 12px;
        color: #666;
    }

    /* Input Area */
    .chat-input-area {
        padding: 15px;
        background: white;
        border-top: 1px solid #eee;
    }

    .input-wrapper {
        display: flex;
        gap: 10px;
    }

    .chat-input-area input {
        flex: 1;
        padding: 12px 18px;
        border: 2px solid #e8e8e8;
        border-radius: 25px;
        font-size: 14px;
        transition: border-color 0.3s;
    }

    .chat-input-area input:focus {
        outline: none;
        border-color: #4e73df;
    }

    .chat-input-area button {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border: none;
        color: white;
        cursor: pointer;
        transition: transform 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chat-input-area button:hover {
        transform: scale(1.05);
    }

    /* Scrollbar */
    .chat-messages::-webkit-scrollbar,
    .teacher-list-body::-webkit-scrollbar {
        width: 6px;
    }

    .chat-messages::-webkit-scrollbar-track,
    .teacher-list-body::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .chat-messages::-webkit-scrollbar-thumb,
    .teacher-list-body::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }

    /* Responsive */
    @media (max-width: 480px) {
        .chat-window {
            width: calc(100% - 20px);
            right: 10px;
            bottom: 80px;
            height: 70vh;
        }

        .chat-toggle-btn {
            right: 15px;
            bottom: 15px;
            width: 55px;
            height: 55px;
        }
    }
</style>

<script>
    let currentTeacherId = null;
    let checkMessagesInterval = null;
    let checkReadInterval = null;

    // Toggle chat window
    function toggleChat() {
        const chatWindow = document.getElementById('chat-window');
        const chatIcon = document.getElementById('chat-icon');
        const closeIcon = document.getElementById('close-icon');
        const badge = document.getElementById('chat-badge');

        chatWindow.classList.toggle('active');

        if (chatWindow.classList.contains('active')) {
            chatIcon.style.display = 'none';
            closeIcon.style.display = 'block';
            badge.style.display = 'none';
            loadTeachers();
            loadConversations();
        } else {
            chatIcon.style.display = 'block';
            closeIcon.style.display = 'none';
            document.getElementById('teacherList').style.display = 'none';
        }
    }

    // Toggle teacher list
    function toggleTeacherList() {
        const teacherList = document.getElementById('teacherList');
        teacherList.style.display = teacherList.style.display === 'none' ? 'block' : 'none';
        if (teacherList.style.display === 'block') {
            loadTeachers();
        }
    }

    // Load teachers
    function loadTeachers() {
        fetch('{{ route('parent.chat.teachers') }}')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('teacherListBody');

                if (data.teachers.length === 0) {
                    container.innerHTML = `
                        <div class="text-center p-4">
                            <i class="fas fa-user-slash fa-2x text-muted mb-2"></i>
                            <p class="text-muted small">Không tìm thấy giáo viên</p>
                        </div>
                    `;
                    return;
                }

                container.innerHTML = data.teachers.map(teacher => `
                    <div class="teacher-item ${currentTeacherId === teacher.id ? 'active' : ''}"
                         onclick="selectTeacher(${teacher.id}, '${teacher.tengiaovien}', '${teacher.lop}')">
                        <div class="teacher-avatar">
                            ${teacher.tengiaovien.charAt(0).toUpperCase()}
                        </div>
                        <div class="teacher-info">
                            <h6>${teacher.tengiaovien}</h6>
                            <small>Lớp: ${teacher.lop || 'Chưa có'}</small>
                        </div>
                        <span class="teacher-badge" id="teacherBadge-${teacher.id}" style="display: none;">0</span>
                    </div>
                `).join('');

                // Update unread counts
                loadConversations();
            })
            .catch(error => {
                console.error('Error loading teachers:', error);
            });
    }

    // Load conversations
    function loadConversations() {
        fetch('{{ route('parent.chat.conversations') }}')
            .then(response => response.json())
            .then(data => {
                let totalUnread = 0;
                data.conversations.forEach(conv => {
                    const badge = document.getElementById(`teacherBadge-${conv.giaovien_id}`);
                    if (badge) {
                        if (conv.unread_count > 0) {
                            badge.textContent = conv.unread_count;
                            badge.style.display = 'flex';
                            totalUnread += conv.unread_count;
                        } else {
                            badge.style.display = 'none';
                        }
                    }
                });

                // Update main badge
                const mainBadge = document.getElementById('chat-badge');
                if (totalUnread > 0 && !document.getElementById('chat-window').classList.contains('active')) {
                    mainBadge.textContent = totalUnread;
                    mainBadge.style.display = 'flex';
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Select teacher
    function selectTeacher(teacherId, teacherName, teacherClass) {
        currentTeacherId = teacherId;

        // Update header
        document.getElementById('headerName').textContent = teacherName;
        document.getElementById('headerStatus').innerHTML = `
            <span class="status-dot"></span> Lớp: ${teacherClass || 'N/A'}
        `;
        document.getElementById('headerAvatar').innerHTML = teacherName.charAt(0).toUpperCase();

        // Hide teacher list
        document.getElementById('teacherList').style.display = 'none';

        // Show input area
        document.getElementById('chatInputArea').style.display = 'block';

        // Hide welcome, show messages
        document.getElementById('chatWelcome').style.display = 'none';

        // Load messages
        loadMessages(teacherId);

        // Start polling
        startPolling(teacherId);

        // Update active state
        document.querySelectorAll('.teacher-item').forEach(item => {
            item.classList.remove('active');
        });
    }

    // Load messages
    function loadMessages(teacherId) {
        fetch(`{{ url('/nguoidung/chat/messages') }}/${teacherId}`)
            .then(response => response.json())
            .then(data => {
                renderMessages(data.messages);

                // Hide teacher badge
                const badge = document.getElementById(`teacherBadge-${teacherId}`);
                if (badge) badge.style.display = 'none';
            })
            .catch(error => console.error('Error:', error));
    }

    // Render messages
    function renderMessages(messages) {
        const container = document.getElementById('chatMessages');
        container.innerHTML = '';

        if (messages.length === 0) {
            container.innerHTML = `
                <div class="text-center p-4">
                    <i class="fas fa-comments fa-2x text-muted mb-2"></i>
                    <p class="text-muted small">Chưa có tin nhắn. Hãy bắt đầu cuộc trò chuyện!</p>
                </div>
            `;
            return;
        }

        let lastDate = null;

        messages.forEach(msg => {
            // Date divider
            if (msg.created_date !== lastDate) {
                container.innerHTML += `
                    <div class="message-date-divider">
                        <span>${msg.created_date}</span>
                    </div>
                `;
                lastDate = msg.created_date;
            }

            const wrapperClass = msg.is_mine ? 'mine' : 'other';
            const bubbleClass = msg.is_mine ? 'mine' : 'other';
            const readStatus = msg.is_mine ?
                (msg.is_read ?
                    `<span class="message-status"><span class="seen"><i class="fas fa-check-double"></i> Đã xem</span></span>` :
                    `<span class="message-status"><i class="fas fa-check"></i> Đã gửi</span>`) : '';

            container.innerHTML += `
                <div class="message-bubble-wrapper ${wrapperClass}" data-message-id="${msg.id}">
                    <div class="message-bubble ${bubbleClass}">
                        <div>${msg.message}</div>
                        <div class="message-meta">
                            <span>${msg.created_at}</span>
                            ${readStatus}
                        </div>
                    </div>
                </div>
            `;
        });

        container.scrollTop = container.scrollHeight;
    }

    // Send message
    function sendChatMessage(event) {
        event.preventDefault();

        const input = document.getElementById('chatInput');
        const message = input.value.trim();

        if (!message || !currentTeacherId) return;

        fetch('{{ route('parent.chat.send') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    receiver_id: currentTeacherId,
                    message: message
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const container = document.getElementById('chatMessages');

                    // Remove empty message if exists
                    const emptyMsg = container.querySelector('.text-center.p-4');
                    if (emptyMsg) emptyMsg.remove();

                    // Check date divider
                    const today = data.message.created_date;
                    const lastDateDiv = container.querySelector('.message-date-divider:last-of-type span');
                    if (!lastDateDiv || lastDateDiv.textContent !== today) {
                        container.innerHTML += `
                        <div class="message-date-divider">
                            <span>${today}</span>
                        </div>
                    `;
                    }

                    container.innerHTML += `
                    <div class="message-bubble-wrapper mine" data-message-id="${data.message.id}">
                        <div class="message-bubble mine">
                            <div>${data.message.message}</div>
                            <div class="message-meta">
                                <span>${data.message.created_at}</span>
                                <span class="message-status"><i class="fas fa-check"></i> Đã gửi</span>
                            </div>
                        </div>
                    </div>
                `;

                    container.scrollTop = container.scrollHeight;
                    input.value = '';
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Start polling
    function startPolling(teacherId) {
        if (checkMessagesInterval) clearInterval(checkMessagesInterval);
        if (checkReadInterval) clearInterval(checkReadInterval);

        checkMessagesInterval = setInterval(() => {
            checkNewMessages(teacherId);
        }, 3000);

        checkReadInterval = setInterval(() => {
            checkReadStatus(teacherId);
        }, 5000);
    }

    // Check new messages
    function checkNewMessages(teacherId) {
        fetch(`{{ url('/nguoidung/chat/check-new') }}/${teacherId}`)
            .then(response => response.json())
            .then(data => {
                if (data.count > 0) {
                    const container = document.getElementById('chatMessages');

                    data.newMessages.forEach(msg => {
                        if (!container.querySelector(`[data-message-id="${msg.id}"]`)) {
                            container.innerHTML += `
                                <div class="message-bubble-wrapper other" data-message-id="${msg.id}">
                                    <div class="message-bubble other">
                                        <div>${msg.message}</div>
                                        <div class="message-meta">
                                            <span>${msg.created_at}</span>
                                        </div>
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

    // Check read status
    function checkReadStatus(teacherId) {
        fetch(`{{ url('/nguoidung/chat/check-read') }}/${teacherId}`)
            .then(response => response.json())
            .then(data => {
                data.readMessages.forEach(msg => {
                    const messageEl = document.querySelector(
                        `[data-message-id="${msg.id}"] .message-status`);
                    if (messageEl && !messageEl.querySelector('.seen')) {
                        messageEl.innerHTML =
                            '<span class="seen"><i class="fas fa-check-double"></i> Đã xem</span>';
                    }
                });
            })
            .catch(error => console.error('Error:', error));
    }

    // Kiểm tra số tin nhắn chưa đọc
    function checkUnreadCount() {
        if (!document.getElementById('chat-window').classList.contains('active')) {
            fetch('{{ route('parent.chat.unread-count') }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('chat-badge');
                    if (data.count > 0) {
                        badge.textContent = data.count;
                        badge.style.display = 'flex';
                    } else {
                        badge.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }

    // Kiểm tra ngay khi trang load
    document.addEventListener('DOMContentLoaded', function() {
        // Kiểm tra số tin nhắn chưa đọc ngay lập tức
        checkUnreadCount();
    });

    // Check unread count periodically (mỗi 5 giây)
    setInterval(() => {
        checkUnreadCount();
    }, 5000);
</script>
