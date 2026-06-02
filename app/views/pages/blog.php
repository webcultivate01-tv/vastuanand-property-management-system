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

  $featured = !empty($items) ? $items[0] : null;
  $second   = $items[1] ?? null;            // shown as a horizontal "Editor's Pick" card
  $rest     = array_slice($items, 2);       // remaining articles in the grid

  // Pretty-format a date from either a string or MongoDB UTCDateTime
  $fmtDate = function ($d): string {
    if (!$d) return '';
    if (is_object($d) && method_exists($d, 'toDateTime')) {
      try { return $d->toDateTime()->format('M j, Y'); } catch (\Throwable $e) {}
    }
    $ts = is_numeric($d) ? (int)$d : strtotime((string)$d);
    return $ts ? date('M j, Y', $ts) : (string)$d;
  };
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

        <p class="va-hero-blog__intro">A curated journal of market analysis, neighbourhood guides, design ideas and investor briefings — written by our advisors, not by an algorithm.</p>

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
          <img src="<?= e(cld($featured['cover'] ?? asset('images/b1.jpg'), 1200)) ?>" alt="<?= e($featured['title']) ?>" onerror="this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1000&q=80'">
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

<section style="padding-top:14px">
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

      <?php if ($second): ?>
        <a href="/blog/<?= e($second['slug']) ?>" class="va-blog-featured" data-reveal>
          <div class="va-blog-featured__img">
            <img loading="lazy" src="<?= e(cld($second['cover'] ?? asset('images/b1.jpg'), 1200)) ?>" alt="<?= e($second['title']) ?>" onerror="this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1200&q=80'">
            <span class="va-blog-featured__tag">Editor's Pick</span>
          </div>
          <div class="va-blog-featured__body">
            <div class="va-blog-featured__meta">
              <span class="va-blog-card__cat" style="position:static"><?= e($second['category'] ?? 'Article') ?></span>
              <span><?= e($fmtDate($second['publishedAt'] ?? '')) ?></span>
              <span>·</span>
              <span><?= e($second['readTime'] ?? '5 min read') ?></span>
            </div>
            <h2 class="va-blog-featured__title"><?= e($second['title']) ?></h2>
            <p class="va-blog-featured__excerpt"><?= e(mb_strimwidth($second['excerpt'] ?? '', 0, 220, '…')) ?></p>
            <span class="va-blog-featured__cta">Read the full story
              <svg width="16" height="11" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
            </span>
          </div>
        </a>
      <?php endif; ?>

      <?php if (!empty($rest)): ?>
        <div class="va-blog-section-head" data-reveal>
          <h2>Latest Articles</h2>
          <span><?= count($rest) ?> more <?= count($rest) === 1 ? 'story' : 'stories' ?></span>
        </div>

        <div class="va-blog-grid" data-stagger>
          <?php foreach ($rest as $b): ?>
            <a href="/blog/<?= e($b['slug']) ?>" class="va-blog-card">
              <div class="va-blog-card__img">
                <img loading="lazy" src="<?= e(cld($b['cover'] ?? asset('images/b1.jpg'), 800)) ?>" alt="<?= e($b['title']) ?>" onerror="this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=900&q=80'">
                <span class="va-blog-card__cat"><?= e($b['category'] ?? 'Article') ?></span>
              </div>
              <div class="va-blog-card__body">
                <div class="va-blog-card__meta">
                  <span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg><?= e($fmtDate($b['publishedAt'] ?? '')) ?></span>
                  <span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg><?= e($b['readTime'] ?? '5 min') ?></span>
                </div>
                <h3 class="va-blog-card__title"><?= e($b['title']) ?></h3>
                <p class="va-blog-card__excerpt"><?= e(mb_strimwidth($b['excerpt'] ?? '', 0, 140, '…')) ?></p>
                <span class="va-blog-card__cta">Read article
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

<!-- CTA BANNER -->
<section class="va-cta-section--full">
  <div class="va-cta-banner va-cta-banner--full" data-reveal>
    <div class="va-cta-banner__bg" aria-hidden="true">
      <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1800&q=80" alt="" loading="lazy">
    </div>
    <div class="va-cta-banner__overlay"></div>
    <div class="va-cta-banner__glow" aria-hidden="true"></div>

    <div class="va-cta-banner__content">
      <span class="va-cta-banner__eyebrow">
        <span class="va-cta-banner__dot"></span>
        TURN INSIGHTS INTO ACTION
      </span>

      <h2 class="va-cta-banner__heading">
        Ready to make your <span class="va-cta-banner__accent">next smart move</span>?
      </h2>

      <p class="va-cta-banner__lede">
        Our advisors read the same market — but they act on it daily. Book a free consultation and get a personalised property brief built around your goals.
      </p>

      <div class="va-cta-banner__actions">
        <a href="/contact" class="va-cta-banner__btn va-cta-banner__btn--gold">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          Book Free Consultation
        </a>
        <a href="https://wa.me/<?= e(config('app.brand.whatsapp')) ?>" target="_blank" rel="noopener" class="va-cta-banner__btn va-cta-banner__btn--ghost">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M20.5 3.5A11 11 0 0 0 3 17.2L1.5 22.5l5.4-1.4A11 11 0 1 0 20.5 3.5ZM12 20a8 8 0 0 1-4.1-1.1l-.3-.2-3.2.8.9-3.2-.2-.3a8 8 0 1 1 6.9 4Zm4.5-6c-.2-.1-1.4-.7-1.6-.8-.2-.1-.4-.1-.5.1l-.7.9c-.1.2-.3.2-.5.1a6.5 6.5 0 0 1-3.2-2.8c-.2-.4.2-.4.6-1.2 0-.2 0-.3-.1-.4l-.7-1.7c-.2-.4-.4-.4-.5-.4h-.5a1 1 0 0 0-.7.3 3 3 0 0 0-.9 2.2c0 1.3 1 2.6 1.1 2.8.1.2 1.9 3 4.7 4.2 1.7.7 2.3.7 3.1.6.5-.1 1.4-.6 1.6-1.1.2-.6.2-1 .1-1.1Z"/></svg>
          WhatsApp Us
        </a>
        <a href="tel:<?= e(config('app.brand.phone')) ?>" class="va-cta-banner__btn va-cta-banner__btn--ghost">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
          Call Now
        </a>
      </div>

      <div class="va-cta-banner__trust">
        <div class="va-cta-banner__trust-item">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2 4 6v6c0 5 3.5 9.4 8 10 4.5-.6 8-5 8-10V6l-8-4z"/><polyline points="9 12 11 14 15 10"/></svg>
          <div><strong>RERA Verified</strong><span>Every listing</span></div>
        </div>
        <div class="va-cta-banner__trust-item">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          <div><strong>15-min Response</strong><span>On WhatsApp</span></div>
        </div>
        <div class="va-cta-banner__trust-item">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/></svg>
          <div><strong>Weekly Insights</strong><span>Expert-written</span></div>
        </div>
        <div class="va-cta-banner__trust-item">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 12a8 8 0 0 1-8 8 8 8 0 0 1-8-8 8 8 0 0 1 8-8c2 0 3.83.74 5.23 1.96"/><polyline points="20 4 20 8 16 8"/></svg>
          <div><strong>Zero Brokerage</strong><span>For NRI buyers</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php $view->endSection(); ?>
