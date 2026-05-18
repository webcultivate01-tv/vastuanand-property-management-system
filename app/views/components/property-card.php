<?php /** @var array $p */ ?>
<article class="va-card" data-reveal>
  <div class="va-card__img">
    <span class="va-card__badge"><?= e(ucfirst($p['listing'] ?? 'sale')) ?></span>
    <button class="va-card__fav" aria-label="Save property" type="button">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
    </button>
    <img loading="lazy" src="<?= e($p['cover'] ?? asset('images/p1.jpg')) ?>" alt="<?= e($p['title']) ?>">
    <div class="va-card__price"><?= format_price($p['price'] ?? 0) ?><?php if (($p['listing'] ?? '') === 'rent'): ?><span style="font-size:12px;color:var(--pearl-mid);"> / mo</span><?php endif; ?></div>
  </div>
  <div class="va-card__body">
    <a href="/property/<?= e($p['slug']) ?>">
      <h3 class="va-card__title"><?= e($p['title']) ?></h3>
    </a>
    <div class="va-card__loc">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>
      <?= e($p['location'] ?? 'Mumbai') ?>
    </div>
    <div class="va-card__meta">
      <?php if (!empty($p['bhk'])): ?><span><strong><?= (int)$p['bhk'] ?></strong> BHK</span><?php endif; ?>
      <?php if (!empty($p['area'])): ?><span><strong><?= number_format((float)$p['area']) ?></strong> sqft</span><?php endif; ?>
      <span style="margin-left:auto;color:var(--gold)">
        <a href="/property/<?= e($p['slug']) ?>" class="va-link-arrow">View Details
          <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
        </a>
      </span>
    </div>
  </div>
</article>
