<?php /** @var array $t */ ?>
<div class="va-quote" data-reveal>
  <div class="va-quote__stars">
    <?php for ($i = 0; $i < (int)($t['rating'] ?? 5); $i++) echo '★'; ?>
  </div>
  <p class="va-quote__msg">"<?= e($t['message']) ?>"</p>
  <div class="va-quote__author">
    <div class="va-quote__avatar"><?= e(mb_substr($t['name'] ?? 'V', 0, 1)) ?></div>
    <div>
      <div class="va-quote__name"><?= e($t['name'] ?? '') ?></div>
      <div class="va-quote__role"><?= e($t['role'] ?? 'Vastu Anand Client') ?></div>
    </div>
  </div>
</div>
