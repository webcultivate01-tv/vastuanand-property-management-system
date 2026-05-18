<?php
/**
 * @var array  $p     Property data (must contain cover / gallery)
 * @var string $alt   Alt text fallback
 * @var bool   $thumb Optional small thumbs row (defaults to false)
 */
$images = array_values(array_filter(array_merge(
  [$p['cover'] ?? null],
  $p['gallery'] ?? []
)));
if (empty($images)) {
  $images = ['https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=900&q=80'];
}
$count = count($images);
$alt = $alt ?? ($p['title'] ?? 'Property image');
?>
<div class="va-pslider" data-pslider data-count="<?= $count ?>">
  <div class="va-pslider__track">
    <?php foreach ($images as $i => $url): ?>
      <div class="va-pslider__slide<?= $i === 0 ? ' is-active' : '' ?>" data-i="<?= $i ?>">
        <img loading="lazy" src="<?= e($url) ?>" alt="<?= e($alt) ?>">
      </div>
    <?php endforeach; ?>
  </div>

  <?php if ($count > 1): ?>
    <button type="button" class="va-pslider__nav va-pslider__nav--prev" aria-label="Previous image">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
    </button>
    <button type="button" class="va-pslider__nav va-pslider__nav--next" aria-label="Next image">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
    </button>
    <div class="va-pslider__dots">
      <?php for ($i = 0; $i < $count; $i++): ?>
        <button type="button" class="va-pslider__dot<?= $i === 0 ? ' is-active' : '' ?>" data-i="<?= $i ?>" aria-label="Go to image <?= $i + 1 ?>"></button>
      <?php endfor; ?>
    </div>
  <?php endif; ?>
</div>
