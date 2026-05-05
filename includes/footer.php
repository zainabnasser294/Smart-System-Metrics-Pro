</div> 
</div> 

<footer class="bg-white border-top py-4 mt-auto">
    <div class="container-fluid px-5">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <span class="text-muted small">
                    <strong>SmartMonitor AI System</strong> &copy; 2026. All Rights Reserved.
                </span>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <span class="text-muted small">
                    <i class="fas fa-graduation-cap me-1"></i> 
                    Student: <strong>Zainab Nasser ALhdidi</strong> | ID: 2110072
                </span>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>


<div id="chat-widget" style="position: fixed; bottom: 25px; right: 25px; z-index: 9999; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    
   
    <button onclick="toggleChat()" style="padding: 14px 22px; border-radius: 30px; background: #2c3e50; color: white; border: none; cursor: pointer; box-shadow: 0 5px 15px rgba(0,0,0,0.2); font-weight: 600; transition: all 0.3s ease;">
        <i class="fas fa-robot" style="margin-right: 8px;"></i> AI Assistant
    </button>
    
  
    <div id="chat-box" style="display: none; width: 360px; height: 500px; background: #ffffff; border-radius: 15px; position: absolute; bottom: 75px; right: 0; flex-direction: column; box-shadow: 0 10px 35px rgba(0,0,0,0.15); overflow: hidden; border: 1px solid #e0e0e0;">
        
        
        <div style="background: #2c3e50; color: white; padding: 18px; font-weight: bold; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center;">
                <div style="width: 10px; height: 10px; background: #2ecc71; border-radius: 50%; margin-right: 10px;"></div>
                <span>SmartMonitor Support</span>
            </div>
            <button onclick="toggleChat()" style="background:none; border:none; color:white; cursor:pointer; font-size: 20px;">&times;</button>
        </div>

       
        <div id="messages" style="flex: 1; padding: 20px; overflow-y: auto; background: #fdfdfd; display: flex; flex-direction: column; gap: 12px; scroll-behavior: smooth;">
            <div style="background: #f1f3f5; color: #495057; padding: 12px 16px; border-radius: 15px 15px 15px 2px; align-self: flex-start; max-width: 85%; font-size: 14px; line-height: 1.5;">
                Hello! How can I assist you today?
            </div>
        </div>

        
        <div style="padding: 15px; background: white; border-top: 1px solid #eee; display: flex; gap: 10px; align-items: center;">
            <input type="text" id="userInput" placeholder="Ask a question..." style="flex: 1; border: 1px solid #e0e0e0; padding: 10px 15px; border-radius: 25px; outline: none; font-size: 14px; background: #f9f9f9;">
            <button onclick="sendMessage()" style="background: #3498db; color: white; border: none; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s;">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<script>
function toggleChat() {
    const box = document.getElementById('chat-box');
    box.style.display = box.style.display === 'none' ? 'flex' : 'none';
}

async function sendMessage() {
    const input = document.getElementById('userInput');
    const msg = input.value.trim();
    if (!msg) return;

    const messagesDiv = document.getElementById('messages');
    
    
    messagesDiv.innerHTML += `
        <div style="background: #3498db; color: white; padding: 12px 16px; border-radius: 15px 15px 2px 15px; align-self: flex-end; max-width: 85%; font-size: 14px; box-shadow: 0 2px 5px rgba(52,152,219,0.2);">
            ${msg}
        </div>`;
    
    input.value = '';
    messagesDiv.scrollTop = messagesDiv.scrollHeight;

const n8n_url = "http://localhost:5678/webhook/f8374bc0-7992-45de-a51e-523debf6c284";

    
    try {
        const loadingId = "loading-" + Date.now();
        messagesDiv.innerHTML += `
            <div id="${loadingId}" style="background: #f1f3f5; color: #7f8c8d; padding: 10px 16px; border-radius: 12px; align-self: flex-start; font-size: 13px;">
                <i class="fas fa-spinner fa-spin"></i> Processing...
            </div>`;
        messagesDiv.scrollTop = messagesDiv.scrollHeight;

        const response = await fetch(n8n_url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                chatInput: msg,
                user_email: "<?php echo $_SESSION['email'] ?? 'guest@example.com'; ?>" 
            })
        });
        
        if(response.ok) {
            const data = await response.json();
            
           
            const aiResponse = data.output || "I've processed your request. Please check your email.";
            
            const loadingElement = document.getElementById(loadingId);
            loadingElement.innerHTML = aiResponse; 
            loadingElement.style.color = "#2c3e50";
            
            
            messagesDiv.innerHTML += `<div style="font-size: 10px; color: #95a5a6; margin-left: 10px; margin-top: -5px;">Details sent to your email.</div>`;
        } else {
            throw new Error();
        }
        
    } catch (e) {
        messagesDiv.innerHTML += `<div style="color: #e74c3c; font-size: 12px; text-align: center; margin-top: 5px;">Connection error. Make sure n8n is active.</div>`;
    }
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}


document.getElementById('userInput').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        sendMessage();
    }
});
</script>

</body>
</html>