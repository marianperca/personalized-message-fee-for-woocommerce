<?php
/** @var string $label */
/** @var ?string $promo_text */
/** @var int $char_limit */
?>

<div class="personalized-message">
    <label for="personalized_message" class="personalized-message__label"><?php echo $label ?></label>
    <?php if (!empty($promo_text)): ?>
        <div class="personalized-message__promo-text"><?php echo $promo_text ?></div>
    <?php endif; ?>
    <textarea name="personalized_message" id="personalized_message" class="personalized-message__textarea" rows="3"></textarea>
    <div class="personalized-message__char-info"><span id="personalized_message_chars_remaining" class="char-info__count">0</span> / <span class="char-info__limit"><?php echo $char_limit ?></span></div>
</div>
