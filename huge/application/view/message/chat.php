<div class="container">
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
        <a href="<?= Config::get('URL') ?>message/index" style="
               text-decoration: none;
               font-size: 22px;
               padding: 4px 10px;
               border: 1px solid #ccc;
               border-radius: 4px;
               color: #000;
           ">
            ←
        </a>

        <h2 style="margin: 0;">
            Chat mit <?= htmlspecialchars($this->chatUser->user_name) ?>
        </h2>
    </div>

    <div class="box">
        <div class="messenger">
            <!-- RIGHT: Chat -->
            <div class="messenger-chat">
                <div class="messages">
                        <?php foreach ($this->messages as $msg): ?>
                        <div class="message <?= ($msg->sender_id == Session::get('user_id')) ? 'me' : 'them' ?>">

                                <?= htmlspecialchars($msg->message_text) ?>
                        </div>
                        <?php endforeach; ?>
                </div>

                <!-- SEND FORM -->
                <form class="chat-input" method="post"
                    action="<?= Config::get('URL') ?>message/send">
                    <input type="hidden" name="receiver_id" value="<?= $this->chatUser->user_id ?>">
                    <input type="text" name="message_text" required>
                    <button type="submit">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Funktion, die den Chat nach unten scrollt
    function scrollToBottom() {
        const messageContainer = document.querySelector('.messages');
        if (messageContainer) {
            messageContainer.scrollTop = messageContainer.scrollHeight;
        }
    }

    // Führt die Funktion aus, sobald die Seite fertig geladen ist
    document.addEventListener("DOMContentLoaded", scrollToBottom);

    // Optional: Falls du Bilder im Chat hast, scrolle nochmal, wenn alles fertig gerendert ist
    window.onload = scrollToBottom;
</script>