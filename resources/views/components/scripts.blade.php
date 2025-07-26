<script>
    // Theme Toggle
    function toggleTheme() {
        // Currently locked to dark mode for this design
        console.log('Theme toggle - currently using dark mode only');
    }

    // Auto-resize textarea
    const textarea = document.getElementById('prompt-input');
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 128) + 'px';
    });

    // Handle Enter key (Shift+Enter for new line)
    textarea.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            this.closest('form').submit();
        }
    });

    // File handling
    function handleFileSelect(event) {
        const file = event.target.files[0];
        if (file) {
            document.getElementById('file-name').textContent = file.name;
            document.getElementById('file-size').textContent = formatFileSize(file.size);
            document.getElementById('file-preview').classList.remove('hidden');
        }
    }

    function removeFile() {
        document.getElementById('file-input').value = '';
        document.getElementById('file-preview').classList.add('hidden');
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Fill prompt from examples
    function fillPrompt(text) {
        document.getElementById('prompt-input').value = text;
        document.getElementById('prompt-input').focus();
    }

    // Copy to clipboard function
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // Show a brief success message
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-fade-in';
            toast.textContent = 'Copied to clipboard!';
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 2000);
        }).catch(function() {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);

            // Show success message
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg z-50';
            toast.textContent = 'Copied to clipboard!';
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 2000);
        });
    }

    // Auto-focus on load
    window.addEventListener('load', function() {
        document.getElementById('prompt-input').focus();

        // Scroll to bottom if there are conversations
        @if(isset($conversations) && $conversations->isNotEmpty())
        const messagesContainer = document.getElementById('messages');
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        @endif
    });

    // Auto-scroll to bottom when new message is sent
    document.querySelector('form').addEventListener('submit', function() {
        // Clear the input after submit
        setTimeout(() => {
            const messagesContainer = document.getElementById('messages');
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            document.getElementById('prompt-input').value = '';
            document.getElementById('prompt-input').style.height = 'auto';
        }, 100);
    });

    // Show loading state when form is submitted
    document.querySelector('form').addEventListener('submit', function(e) {
        const sendBtn = document.getElementById('send-btn');
        const originalContent = sendBtn.innerHTML;

        sendBtn.innerHTML = `
            <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
            <span class="text-sm">Sending...</span>
        `;
        sendBtn.disabled = true;

        // Re-enable after a timeout (in case of errors)
        setTimeout(() => {
            sendBtn.innerHTML = originalContent;
            sendBtn.disabled = false;
        }, 10000);
    });

    // Legacy support - keep existing scroll behavior
    @if(isset($response) && (!isset($conversations) || $conversations->isEmpty()))
    window.addEventListener('load', function() {
        document.getElementById('messages').scrollIntoView({ behavior: 'smooth', block: 'end' });
    });
    @endif
</script>