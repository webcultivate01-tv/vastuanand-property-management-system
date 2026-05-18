<?php $view->extend('layouts.main'); ?>
<?php $view->section('content'); ?>

<?php
  $items = $result['data'] ?? [];
  // Collect categories for filter pills
  $categories = [];
  foreach ($items as $b) {
    $c = trim((string)($b['category'] ?? ''));
    if ($c !== '' && !in_array($c, $categories, true)) $categories[] = $c;
  }
  $activeCat = $_GET['category'] ?? '';
  $featured  = !empty($items) ? $items[0] : null;
  $rest      = !empty($items) ? array_slice($items, 1) : [];
?>

<section class="va-hero-blog">
  <div class="container-lg">
    <div class="va-hero-blog__grid">
      <div data-reveal="left">
        <div class="va-h-crumb" style="margin-bottom:22px">
          <a href="/">Home</a> <span>/</span> <strong>Blog</strong>
        </div>

        <div class="va-hero-blog__issue">
          <span>The Vastu Anand <strong>Journal</strong></span>
          <span>Vol. <?= date('Y') ?> · <?= date('M') ?></span>
        </div>

        <h1>Mumbai real estate <span class="va-h-accent">stories</span> &amp; insights.</h1>

        <div class="va-hero-blog__sub">
          <div>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/></svg>
            <span><strong><?= count($items) ?> articles</strong> · published</span>
          </div>
          <div>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <span>Updated weekly</span>
          </div>
          <div>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2 4 6v6c0 5 3.5 9.5 8 10 4.5-.5 8-5 8-10V6l-8-4Z"/></svg>
            <span>Editor-reviewed</span>
          </div>
        </div>
      </div>

      <?php if ($featured): ?>
      <div data-reveal="right">
        <a href="/blog/<?= e($featured['slug']) ?>" class="va-hero-blog__cover">
          <img src="<?= e($featured['cover'] ?? asset('images/b1.jpg')) ?>" alt="<?= e($featured['title']) ?>" onerror="this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1000&q=80'">
          <span class="va-hero-blog__cover-tag">On the Cover</span>
          <div class="va-hero-blog__cover-bottom">
            <strong><?= e(mb_strimwidth($featured['title'], 0, 80, '…')) ?></strong>
            <span><?= e($featured['category'] ?? 'Article') ?> · <?= e($featured['readTime'] ?? '5 min') ?></span>
          </div>
        </a>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<section style="padding-top:10px">
  <div class="container-lg">

    <?php if (!empty($categories)): ?>
      <div class="va-blog-filter" data-reveal>
        <a href="/blog" class="<?= $activeCat === '' ? 'active' : '' ?>">All Articles</a>
        <?php foreach ($categories as $c): ?>
          <a href="/blog?category=<?= e(urlencode($c)) ?>" class="<?= $activeCat === $c ? 'active' : '' ?>"><?= e($c) ?></a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if (empty($items)): ?>
      <div class="va-empty" data-reveal>
        <div class="va-empty__icon">
          <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/></svg>
        </div>
        <h3>No articles published yet</h3>
        <p>Our research desk is preparing the next batch of articles — check back soon, or subscribe to be notified.</p>
        <a href="/contact" class="btn btn-primary">Subscribe for updates</a>
      </div>
    <?php else: ?>

      <?php if (!empty($rest)): ?>
        <div class="va-blog-grid" data-stagger>
          <?php foreach ($rest as $b): ?>
            <a href="/blog/<?= e($b['slug']) ?>" class="va-blog-card">
              <div class="va-blog-card__img">
                <img loading="lazy" src="<?= e($b['cover'] ?? asset('images/b1.jpg')) ?>" alt="<?= e($b['title']) ?>" onerror="this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=900&q=80'">
                <span class="va-blog-card__cat"><?= e($b['category'] ?? 'Article') ?></span>
              </div>
              <div class="va-blog-card__body">
                <div class="va-blog-card__meta">
                  <span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg><?= e($b['publishedAt'] ?? '') ?></span>
                  <span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg><?= e($b['readTime'] ?? '5 min') ?></span>
                </div>
                <h3 class="va-blog-card__title"><?= e($b['title']) ?></h3>
                <p class="va-blog-card__excerpt"><?= e(mb_strimwidth($b['excerpt'] ?? '', 0, 140, '…')) ?></p>
                <span class="va-blog-card__cta">View Details
                  <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
                </span>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <?php if (($result['pages'] ?? 1) > 1): ?>
        <nav class="va-pagination" aria-label="Pagination">
          <?php for ($i = 1; $i <= $result['pages']; $i++): ?>
            <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"
               class="<?= $i === ($result['page'] ?? 1) ? 'is-active' : '' ?>"><?= $i ?></a>
          <?php endfor; ?>
        </nav>
      <?php endif; ?>

    <?php endif; ?>
  </div>
</section>

<?php $view->endSection(); ?>
