<?php /** @var array $p */ ?>
<article class="va-card" data-reveal>
  <div class="va-card__img">
    <span class="va-card__badge"><?= e(ucfirst($p['listing'] ?? 'sale')) ?></span>
    <button class="va-card__fav" aria-label="Save property" type="button">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
    </button>
    <?php $view->include('components.property-slider', ['p' => $p, 'alt' => $p['title'] ?? 'Property']); ?>
    <div class="va-card__price">
      <?= format_price($p['price'] ?? 0) ?><?php if (($p['listing'] ?? '') === 'rent'): ?><span style="font-size:11px;color:rgba(255,255,255,0.7);font-weight:500;margin-left:2px"> / mo</span><?php endif; ?>
    </div>
  </div>
  <div class="va-card__body">
    <a href="/property/<?= e($p['slug']) ?>">
      <h3 class="va-card__title"><?= e($p['title']) ?></h3>
    </a>
    <div class="va-card__loc">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>
      <?= e($p['location'] ?? 'Mumbai') ?>
    </div>
    <?php if (!empty($p['type'])): ?>
      <div class="va-card__chips">
        <span class="va-card__chip"><?= e($p['type']) ?></span>
        <?php if (!empty($p['tags']) && is_array($p['tags'])): foreach (array_slice($p['tags'], 0, 1) as $tag): ?>
          <span class="va-card__chip"><?= e($tag) ?></span>
        <?php endforeach; endif; ?>
      </div>
    <?php endif; ?>
    <div class="va-card__meta">
      <?php if (!empty($p['bhk'])): ?>
        <span title="Bedrooms">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 18v-6a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v6"/><path d="M3 18h18"/><path d="M6 9V6a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v3"/></svg>
          <strong><?= (int)$p['bhk'] ?></strong> BHK
        </span>
      <?php endif; ?>
      <?php if (!empty($p['baths'])): ?>
        <span title="Bathrooms">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12V6a2 2 0 0 1 2-2h2"/><path d="M3 12h18v3a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4v-3Z"/></svg>
          <strong><?= (int)$p['baths'] ?></strong>
        </span>
      <?php endif; ?>
      <?php if (!empty($p['area'])): ?>
        <span title="Carpet area">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h18v18H3z"/><path d="M3 9h18M9 3v18"/></svg>
          <strong><?= number_format((float)$p['area']) ?></strong> sqft
        </span>
      <?php endif; ?>
    </div>
    <a href="/property/<?= e($p['slug']) ?>" class="va-card__cta">
      View Details
      <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
    </a>
  </div>
</article>
