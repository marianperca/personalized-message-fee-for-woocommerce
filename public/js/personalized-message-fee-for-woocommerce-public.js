document.addEventListener('DOMContentLoaded', function () {
	const messageInput = document.getElementById('personalized_message');
	const messageInputCharRemaining = document.getElementById('personalized_message_chars_remaining');

	if (messageInput) {
		messageInput.addEventListener('input', function () {
			const cleanMessage = messageInput.value.replace(/[\s\n]+/g, '');
			const charLimit = parseInt(personalizedMessageSettings.charLimit, 10);

			if (cleanMessage.length > charLimit) {
				messageInput.value = messageInput.value.substring(0, messageInput.value.length - 1);
				messageInputCharRemaining.textContent = 0;
			} else {
				messageInputCharRemaining.textContent = charLimit - cleanMessage.length;
			}
		});
	}
});
