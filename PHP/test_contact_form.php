<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Contact Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        button {
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        button:hover {
            background: #5568d3;
        }
        button:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            display: none;
        }
        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .message.show {
            display: block;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Test Contact Form Submission</h2>
        
        <div id="messageBox" class="message"></div>
        
        <form id="testContactForm">
            <input type="hidden" name="form_type" value="contact">
            
            <div class="form-group">
                <label for="name">Name *</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="subject">Subject *</label>
                <input type="text" id="subject" name="subject" required>
            </div>
            
            <div class="form-group">
                <label for="message">Message *</label>
                <textarea id="message" name="message" required></textarea>
            </div>
            
            <button type="submit" id="submitBtn">Send Test Message</button>
        </form>
        
        <div style="margin-top: 20px; padding: 15px; background: #e7f3ff; border-radius: 5px;">
            <strong>Instructions:</strong>
            <ol style="margin: 10px 0; padding-left: 20px;">
                <li>Fill in all fields</li>
                <li>Click "Send Test Message"</li>
                <li>Check the response message</li>
                <li>Go to admin page to verify submission</li>
            </ol>
        </div>
    </div>

    <script>
        document.getElementById('testContactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const messageBox = document.getElementById('messageBox');
            const submitBtn = document.getElementById('submitBtn');
            const formData = new FormData(this);
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.textContent = 'Sending...';
            messageBox.className = 'message';
            messageBox.textContent = '';
            
            // Send data
            fetch('submit_contact.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Response:', data);
                
                if (data.success) {
                    messageBox.className = 'message success show';
                    messageBox.textContent = '✓ ' + data.message;
                    this.reset();
                } else {
                    messageBox.className = 'message error show';
                    messageBox.textContent = '✗ Error: ' + data.message;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                messageBox.className = 'message error show';
                messageBox.textContent = '✗ Network error: ' + error.message;
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Send Test Message';
            });
        });
    </script>
</body>
</html>
