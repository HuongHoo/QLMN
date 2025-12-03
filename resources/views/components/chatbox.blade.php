{{-- Chatbox Component - Include trong layout --}}
<div id="chatbox-container">
    {{-- Chat Button --}}
    <button id="chat-toggle-btn" class="chat-toggle-btn" onclick="toggleChatbox()">
        <i class="fas fa-comments" id="chat-icon"></i>
        <i class="fas fa-times" id="close-icon" style="display: none;"></i>
        <span class="chat-badge" id="chat-badge" style="display: none;">1</span>
    </button>

    {{-- Chat Window --}}
    <div id="chatbox-window" class="chatbox-window">
        {{-- Header --}}
        <div class="chatbox-header">
            <div class="chatbox-header-info">
                <div class="chatbox-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="chatbox-title">
                    <h5>Trợ lý Ánh Sao</h5>
                    <span class="chatbox-status">
                        <span class="status-dot"></span> Online
                    </span>
                </div>
            </div>
            <button class="chatbox-close" onclick="toggleChatbox()">
                <i class="fas fa-minus"></i>
            </button>
        </div>

        {{-- Messages --}}
        <div class="chatbox-messages" id="chatbox-messages">
            {{-- Welcome message --}}
            <div class="chat-message bot-message">
                <div class="message-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="message-content">
                    <p>Xin chào! 👋 Tôi là trợ lý ảo của Trường MN Ánh Sao. Tôi có thể giúp bạn:</p>
                    <ul>
                        <li>Thông tin về trường & lớp học</li>
                        <li>Học phí & đăng ký nhập học</li>
                        <li>Giờ học & liên hệ</li>
                    </ul>
                    <p>Hãy hỏi tôi bất cứ điều gì! 😊</p>
                </div>
            </div>
        </div>

        {{-- Quick Replies --}}
        <div class="chatbox-quick-replies">
            <button onclick="sendQuickReply('tuition')">💰 Học phí</button>
            <button onclick="sendQuickReply('schedule')">🕐 Giờ học</button>
            <button onclick="sendQuickReply('contact')">📍 Liên hệ</button>
            <button onclick="sendQuickReply('register')">📝 Đăng ký</button>
        </div>

        {{-- Input --}}
        <div class="chatbox-input">
            <form id="chatbox-form" onsubmit="sendMessage(event)">
                <input type="text" id="chat-input" placeholder="Nhập tin nhắn..." autocomplete="off">
                <button type="submit" id="send-btn">
                    <i class="fas fa-paper-plane"></i>
                </button>
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
        z-index: 9999;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chat-toggle-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 25px rgba(102, 126, 234, 0.5);
    }

    .chat-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #ff4757;
        color: white;
        font-size: 12px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    /* Chat Window */
    .chatbox-window {
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

    .chatbox-window.active {
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
    .chatbox-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .chatbox-header-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .chatbox-avatar {
        width: 45px;
        height: 45px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .chatbox-title h5 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
    }

    .chatbox-status {
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

    .chatbox-close {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        cursor: pointer;
        transition: background 0.3s;
    }

    .chatbox-close:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Messages */
    .chatbox-messages {
        flex: 1;
        padding: 15px;
        overflow-y: auto;
        background: #f8f9fa;
    }

    .chat-message {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .bot-message {
        flex-direction: row;
    }

    .user-message {
        flex-direction: row-reverse;
    }

    .message-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .bot-message .message-avatar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .user-message .message-avatar {
        background: #e8e8e8;
        color: #666;
    }

    .message-content {
        max-width: 75%;
        padding: 12px 16px;
        border-radius: 18px;
        font-size: 14px;
        line-height: 1.5;
    }

    .bot-message .message-content {
        background: white;
        color: #333;
        border-bottom-left-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .user-message .message-content {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-bottom-right-radius: 5px;
    }

    .message-content p {
        margin: 0 0 8px 0;
    }

    .message-content p:last-child {
        margin-bottom: 0;
    }

    .message-content ul {
        margin: 8px 0;
        padding-left: 18px;
    }

    .message-content li {
        margin-bottom: 4px;
    }

    /* Quick Replies */
    .chatbox-quick-replies {
        padding: 10px 15px;
        background: white;
        border-top: 1px solid #eee;
        display: flex;
        gap: 8px;
        overflow-x: auto;
        white-space: nowrap;
    }

    .chatbox-quick-replies::-webkit-scrollbar {
        height: 4px;
    }

    .chatbox-quick-replies::-webkit-scrollbar-thumb {
        background: #ddd;
        border-radius: 2px;
    }

    .chatbox-quick-replies button {
        padding: 8px 14px;
        border: 1px solid #667eea;
        background: white;
        color: #667eea;
        border-radius: 20px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s;
        flex-shrink: 0;
    }

    .chatbox-quick-replies button:hover {
        background: #667eea;
        color: white;
    }

    /* Input */
    .chatbox-input {
        padding: 15px;
        background: white;
        border-top: 1px solid #eee;
    }

    .chatbox-input form {
        display: flex;
        gap: 10px;
    }

    .chatbox-input input {
        flex: 1;
        padding: 12px 18px;
        border: 2px solid #e8e8e8;
        border-radius: 25px;
        font-size: 14px;
        transition: border-color 0.3s;
    }

    .chatbox-input input:focus {
        outline: none;
        border-color: #667eea;
    }

    .chatbox-input button {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        cursor: pointer;
        transition: transform 0.3s;
    }

    .chatbox-input button:hover {
        transform: scale(1.05);
    }

    /* Typing Indicator */
    .typing-indicator {
        display: flex;
        gap: 4px;
        padding: 12px 16px;
    }

    .typing-indicator span {
        width: 8px;
        height: 8px;
        background: #999;
        border-radius: 50%;
        animation: typing 1.4s infinite;
    }

    .typing-indicator span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .typing-indicator span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes typing {

        0%,
        60%,
        100% {
            transform: translateY(0);
        }

        30% {
            transform: translateY(-8px);
        }
    }

    /* Responsive */
    @media (max-width: 480px) {
        .chatbox-window {
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
    // Toggle chatbox
    function toggleChatbox() {
        const chatWindow = document.getElementById('chatbox-window');
        const chatIcon = document.getElementById('chat-icon');
        const closeIcon = document.getElementById('close-icon');
        const badge = document.getElementById('chat-badge');

        chatWindow.classList.toggle('active');

        if (chatWindow.classList.contains('active')) {
            chatIcon.style.display = 'none';
            closeIcon.style.display = 'block';
            badge.style.display = 'none';
            document.getElementById('chat-input').focus();
        } else {
            chatIcon.style.display = 'block';
            closeIcon.style.display = 'none';
        }
    }

    // Send message
    function sendMessage(e) {
        e.preventDefault();
        const input = document.getElementById('chat-input');
        const message = input.value.trim();

        if (!message) return;

        // Add user message
        addMessage(message, 'user');
        input.value = '';

        // Show typing indicator
        showTyping();

        // Send to server
        fetch('/chatbot/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                        '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    message: message
                }),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                hideTyping();
                if (data.success && data.message) {
                    addMessage(data.message, 'bot');
                } else {
                    addMessage('Xin lỗi, tôi không hiểu. Vui lòng thử lại!', 'bot');
                }
            })
            .catch(error => {
                console.error('Chat error:', error);
                hideTyping();
                addMessage(
                    '😊 Cảm ơn bạn đã nhắn tin! Để được hỗ trợ tốt nhất, vui lòng liên hệ:\n\n📞 Hotline: 0123 456 789\n📧 Email: info@anhsao.edu.vn',
                    'bot');
            });
    }

    // Send quick reply
    function sendQuickReply(type) {
        showTyping();

        fetch('/chatbot/quick', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                        '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    type: type
                }),
            })
            .then(response => response.json())
            .then(data => {
                hideTyping();
                if (data.success && data.message) {
                    addMessage(data.message, 'bot');
                }
            })
            .catch(error => {
                hideTyping();
                console.error('Quick reply error:', error);
            });
    }

    // Send quick message (typed)
    function sendQuickMessage(message) {
        document.getElementById('chat-input').value = message;
        sendMessage(new Event('submit'));
    }

    // Format message with markdown-like syntax
    function formatMessage(text) {
        // Convert **bold** to <strong>
        text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        // Convert newlines to <br>
        text = text.replace(/\n/g, '<br>');
        // Convert bullet points
        text = text.replace(/• /g, '&bull; ');
        return text;
    }

    // Add message to chat
    function addMessage(text, type) {
        const messagesContainer = document.getElementById('chatbox-messages');
        const messageDiv = document.createElement('div');
        messageDiv.className = `chat-message ${type}-message`;

        const icon = type === 'bot' ? 'fa-robot' : 'fa-user';
        const formattedText = type === 'bot' ? formatMessage(text) : text.replace(/\n/g, '<br>');

        messageDiv.innerHTML = `
            <div class="message-avatar">
                <i class="fas ${icon}"></i>
            </div>
            <div class="message-content">
                ${formattedText}
            </div>
        `;

        messagesContainer.appendChild(messageDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Show typing indicator
    function showTyping() {
        const messagesContainer = document.getElementById('chatbox-messages');
        const typingDiv = document.createElement('div');
        typingDiv.id = 'typing-indicator';
        typingDiv.className = 'chat-message bot-message';
        typingDiv.innerHTML = `
            <div class="message-avatar">
                <i class="fas fa-robot"></i>
            </div>
            <div class="message-content">
                <div class="typing-indicator">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        `;
        messagesContainer.appendChild(typingDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Hide typing indicator
    function hideTyping() {
        const typing = document.getElementById('typing-indicator');
        if (typing) typing.remove();
    }

    // Auto show greeting after 3 seconds (optional)
    // setTimeout(() => {
    //     const badge = document.getElementById('chat-badge');
    //     badge.style.display = 'flex';
    // }, 3000);
</script>
