<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chatbot GPT</title>
    <style>
        body {
            font-family: Arial;
            margin: 10px;
            background: #f8f9fa;
        }

        #chatbox {
            border: 1px solid #ccc;
            background: white;
            padding: 10px;
            height: 400px;
            overflow-y: auto;
            border-radius: 8px;
        }

        .user {
            text-align: right;
            color: blue;
            margin: 5px;
        }

        .bot {
            text-align: left;
            color: green;
            margin: 5px;
        }

        #input {
            width: 80%;
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        #send {
            padding: 8px 15px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
        }
    </style>
</head>

<body>
    <div id="chatbox"></div>
    <div style="margin-top:10px;">
        <input type="text" id="input" placeholder="Nhập câu hỏi..." />
        <button id="send">Gửi</button>
    </div>

    <script>
        const sendBtn = document.getElementById('send');
        sendBtn.onclick = async () => {
            const msg = document.getElementById('input').value;
            if (!msg) return;

            const chatbox = document.getElementById('chatbox');
            chatbox.innerHTML += `<div class="user"><b>Bạn:</b> ${msg}</div>`;
            document.getElementById('input').value = '';

            const res = await fetch('{{ route('Teacher.chatbot.ask') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    message: msg
                })
            });

            const data = await res.json();
            chatbox.innerHTML += `<div class="bot"><b>Bot:</b> ${data.reply}</div>`;
            chatbox.scrollTop = chatbox.scrollHeight;
        };
    </script>
</body>

</html>
