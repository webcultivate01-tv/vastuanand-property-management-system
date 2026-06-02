<?php $view->extend('layouts.main'); $b = $blog; $related = $related ?? []; ?>
<?php $view->section('content'); ?>

<?php
  // Build list of gallery images: prefer $b['gallery'] (array), fallback to legacy 'images'.
  $galleryRaw = [];
  if (!empty($b['gallery']) && is_array($b['gallery'])) $galleryRaw = $b['gallery'];
  elseif (!empty($b['images']) && is_array($b['images'])) $galleryRaw = $b['images'];
  $galleryImages = array_values(array_filter(array_map('trim', $galleryRaw)));

  // Pretty-format a date from either a string or MongoDB UTCDateTime
  $fmtDate = function ($d): string {
    if (!$d) return '';
    if (is_object($d) && method_exists($d, 'toDateTime')) {
      try { return $d->toDateTime()->format('F j, Y'); } catch (\Throwable $e) {}
    }
    $ts = is_numeric($d) ? (int)$d : strtotime((string)$d);
    return $ts ? date('F j, Y', $ts) : (string)$d;
  };

  $shareUrl   = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
              . '://' . ($_SERVER['HTTP_HOST'] ?? '') . ($_SERVER['REQUEST_URI'] ?? '');
  $shareText  = $b['title'] ?? '';
?>

<!-- Reading progress bar -->
<div class="va-read-progress" id="vaReadProgress"><span></span></div>

<section class="va-blog-detail__hero">
  <div class="va-blog-detail__container" data-reveal>
    <a href="/blog" class="va-blog-detail__back">
      <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M14 5H1M5 1 1 5l4 4"/></svg>
      Back to all articles
    </a>

    <div class="va-blog-detail__meta">
      <span class="va-blog-detail__cat"><?= e($b['category'] ?? 'Article') ?></span>
      <span>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:-2px;margin-right:4px;color:var(--gold)"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        <?= e($fmtDate($b['publishedAt'] ?? '')) ?>
      </span>
      <span>·</span>
      <span>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:-2px;margin-right:4px;color:var(--gold)"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        <?= e($b['readTime'] ?? '5 min read') ?>
      </span>
    </div>

    <h1 class="va-blog-detail__title"><?= e($b['title']) ?></h1>
    <?php if (!empty($b['excerpt'])): ?>
      <p class="va-blog-detail__lede"><?= e($b['excerpt']) ?></p>
    <?php endif; ?>

    <!-- Author row -->
    <div class="va-blog-detail__byline">
      <div class="va-blog-detail__avatar" aria-hidden="true">
        <?= e(strtoupper(mb_substr((string)($b['author'] ?? 'Vastu Anand'), 0, 1))) ?>
      </div>
      <div>
        <strong><?= e($b['author'] ?? 'Vastu Anand Editorial') ?></strong>
        <span>Research &amp; Advisory · Mumbai</span>
      </div>

      <div class="va-blog-share" role="group" aria-label="Share this article">
        <a class="va-blog-share__btn" target="_blank" rel="noopener" aria-label="Share on WhatsApp"
           href="https://wa.me/?text=<?= e(rawurlencode($shareText . ' — ' . $shareUrl)) ?>">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M20.5 3.5A11 11 0 0 0 3.4 17.3L2 22l4.8-1.4a11 11 0 0 0 16.7-9.4 11 11 0 0 0-3-7.7Zm-8.5 17a9.1 9.1 0 0 1-4.6-1.3l-.3-.2-2.8.8.7-2.8-.2-.3a9 9 0 1 1 7.2 3.8Zm5-6.7c-.3-.1-1.6-.8-1.9-.9-.2-.1-.4-.1-.6.1-.2.2-.7.9-.9 1-.1.2-.3.2-.6.1-.3-.2-1.2-.5-2.2-1.4-.8-.7-1.4-1.6-1.5-1.9-.2-.3 0-.4.1-.6l.4-.5c.1-.2.2-.3.3-.5 0-.2 0-.4 0-.5l-.9-2.1c-.2-.5-.4-.4-.6-.4h-.5c-.2 0-.5.1-.7.3-.3.3-1 1-1 2.4s1 2.8 1.1 3c.1.2 2 3.1 4.9 4.4 1.8.8 2.5.8 3.3.7.5 0 1.6-.7 1.9-1.3.2-.7.2-1.2.1-1.3-.1-.1-.3-.2-.5-.3Z"/></svg>
        </a>
        <a class="va-blog-share__btn" target="_blank" rel="noopener" aria-label="Share on Facebook"
           href="https://www.facebook.com/sharer/sharer.php?u=<?= e(rawurlencode($shareUrl)) ?>">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 22v-8h2.7l.4-3.1h-3.1V8.9c0-.9.3-1.6 1.6-1.6h1.7V4.5c-.3 0-1.3-.1-2.4-.1-2.4 0-4 1.5-4 4.1V11H7.7v3.1h2.7V22h3.1Z"/></svg>
        </a>
        <a class="va-blog-share__btn" target="_blank" rel="noopener" aria-label="Share on LinkedIn"
           href="https://www.linkedin.com/sharing/share-offsite/?url=<?= e(rawurlencode($shareUrl)) ?>">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M4.5 4.5a2 2 0 1 1 0 4 2 2 0 0 1 0-4Zm-.5 5.5h3V20H4V10Zm5 0h2.9v1.4h0a3.2 3.2 0 0 1 2.9-1.6c3.1 0 3.7 2 3.7 4.7V20h-3v-5c0-1.2 0-2.7-1.6-2.7s-1.9 1.3-1.9 2.6V20H9V10Z"/></svg>
        </a>
        <a class="va-blog-share__btn" target="_blank" rel="noopener" aria-label="Share on Twitter / X"
           href="https://twitter.com/intent/tweet?url=<?= e(rawurlencode($shareUrl)) ?>&text=<?= e(rawurlencode($shareText)) ?>">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="m17.4 3 4.6 0-10 11.5L23 21h-7.8l-5.7-7L3 21H1l9.6-11L2 3h7.9l5.2 6.5L17.4 3Zm-1.3 16h2.1L8.2 5H6L16.1 19Z"/></svg>
        </a>
        <button type="button" class="va-blog-share__btn va-blog-share__copy" data-share-url="<?= e($shareUrl) ?>" aria-label="Copy link">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.07 0l3-3a5 5 0 0 0-7.07-7.07l-1.5 1.5"/><path d="M14 11a5 5 0 0 0-7.07 0l-3 3a5 5 0 0 0 7.07 7.07l1.5-1.5"/></svg>
        </button>
      </div>
    </div>
  </div>
</section>

<div class="va-blog-cover" data-reveal>
  <div class="va-blog-cover__img">
    <img src="<?= e(cld($b['cover'] ?? asset('images/b1.jpg'), 1600)) ?>" alt="<?= e($b['title']) ?>" onerror="this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1600&q=80'">
  </div>
</div>

<article class="va-blog-body" data-reveal>
  <?= $b['body'] ?? '<p>Article content coming soon.</p>' ?>
</article>

<?php if (!empty($galleryImages)): ?>
  <section class="va-blog-gallery" data-reveal>
    <h2 class="va-blog-gallery__title">In Pictures</h2>
    <?php $count = count($galleryImages); ?>
    <div class="va-blog-mosaic va-blog-mosaic--<?= min($count, 4) ?>" data-lightbox="blog-gallery">
      <?php foreach ($galleryImages as $i => $img): ?>
        <button type="button" class="va-blog-mosaic__item" data-lightbox-trigger="<?= $i ?>" aria-label="Open image <?= $i + 1 ?>">
          <img loading="lazy" src="<?= e(cld($img, 1200)) ?>" alt="<?= e($b['title']) ?> — image <?= $i + 1 ?>">
          <span class="va-blog-mosaic__zoom" aria-hidden="true">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/><path d="M11 8v6M8 11h6"/></svg>
          </span>
        </button>
      <?php endforeach; ?>
    </div>
  </section>
<?php endif; ?>

<!-- Advisor CTA strip -->
<section style="padding:70px 0 70px">
  <div class="container" style="max-width:880px">
    <div class="va-cta-banner" data-reveal style="padding:48px 28px;text-align:left">
      <div class="va-cta-banner__bg" aria-hidden="true">
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1600&q=80" alt="" loading="lazy">
      </div>
      <div class="va-cta-banner__overlay"></div>
      <div class="va-cta-banner__content" style="display:flex;align-items:center;justify-content:space-between;gap:24px;flex-wrap:wrap">
        <div>
          <span class="eyebrow" style="color:var(--gold-2)">FOUND THIS HELPFUL?</span>
          <h3 style="font-size:clamp(22px,3vw,32px);margin:10px 0 6px;color:#fff;letter-spacing:-0.02em">Talk to an advisor next.</h3>
          <p style="margin:0;color:rgba(255,255,255,0.78);max-width:520px;font-size:14.5px">A 20-minute call gets you matched listings and a clear plan — no obligation.</p>
        </div>
        <div class="flex gap-16" style="flex-wrap:wrap">
          <a href="/contact" class="btn btn-gold">Book a Call</a>
          <a href="https://wa.me/<?= e(config('app.brand.whatsapp')) ?>" class="btn" style="background:transparent;color:#fff;border-color:rgba(255,255,255,0.4)">WhatsApp Us</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php if (!empty($related)): ?>
  <section class="va-blog-related" data-reveal>
    <div class="container-lg">
      <div class="va-blog-section-head">
        <h2>Keep Reading</h2>
        <a href="/blog" class="va-link-arrow">All articles
          <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
        </a>
      </div>
      <div class="va-blog-grid">
        <?php foreach ($related as $r): ?>
          <a href="/blog/<?= e($r['slug']) ?>" class="va-blog-card">
            <div class="va-blog-card__img">
              <img loading="lazy" src="<?= e(cld($r['cover'] ?? asset('images/b1.jpg'), 800)) ?>" alt="<?= e($r['title']) ?>" onerror="this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=900&q=80'">
              <span class="va-blog-card__cat"><?= e($r['category'] ?? 'Article') ?></span>
            </div>
            <div class="va-blog-card__body">
              <div class="va-blog-card__meta">
                <span><?= e($fmtDate($r['publishedAt'] ?? '')) ?></span>
                <span>·</span>
                <span><?= e($r['readTime'] ?? '5 min') ?></span>
              </div>
              <h3 class="va-blog-card__title"><?= e($r['title']) ?></h3>
              <p class="va-blog-card__excerpt"><?= e(mb_strimwidth($r['excerpt'] ?? '', 0, 120, '…')) ?></p>
              <span class="va-blog-card__cta">Read article
                <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
              </span>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>

<?php if (!empty($galleryImages)): ?>
  <div class="va-lightbox" id="vaLightbox" role="dialog" aria-modal="true" aria-label="Image viewer">
    <button class="va-lightbox__close" id="vaLightboxClose" aria-label="Close">&times;</button>
    <button class="va-lightbox__nav va-lightbox__nav--prev" id="vaLightboxPrev" aria-label="Previous image">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
    </button>
    <img id="vaLightboxImg" alt="">
    <div class="va-lightbox__counter" id="vaLightboxCounter">1 / <?= count($galleryImages) ?></div>
    <button class="va-lightbox__nav va-lightbox__nav--next" id="vaLightboxNext" aria-label="Next image">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
    </button>
  </div>
<?php endif; ?>

<?php $view->endSection(); ?>

<?php $view->section('scripts'); ?>
<script>
  // Reading progress bar
  (function () {
    var bar = document.querySelector('#vaReadProgress > span');
    var article = document.querySelector('.va-blog-body');
    if (!bar || !article) return;
    function update() {
      var rect = article.getBoundingClientRect();
      var total = rect.height - window.innerHeight;
      var scrolled = -rect.top;
      var pct = total > 0 ? Math.max(0, Math.min(100, (scrolled / total) * 100)) : 0;
      bar.style.width = pct + '%';
    }
    update();
    window.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', update);
  })();

  // Copy-to-clipboard share button
  (function () {
    var btn = document.querySelector('.va-blog-share__copy');
    if (!btn) return;
    btn.addEventListener('click', function () {
      var url = btn.getAttribute('data-share-url') || window.location.href;
      if (navigator.clipboard) {
        navigator.clipboard.writeText(url).then(function () {
          btn.classList.add('copied');
          setTimeout(function () { btn.classList.remove('copied'); }, 1400);
        });
      }
    });
  })();
</script>

<?php if (!empty($galleryImages)): ?>
<script>
  (function () {
    var images  = <?= json_encode(array_values($galleryImages), JSON_UNESCAPED_SLASHES) ?>;
    var lb      = document.getElementById('vaLightbox');
    var img     = document.getElementById('vaLightboxImg');
    var counter = document.getElementById('vaLightboxCounter');
    var close   = document.getElementById('vaLightboxClose');
    var prev    = document.getElementById('vaLightboxPrev');
    var next    = document.getElementById('vaLightboxNext');
    if (!lb || !images.length) return;

    var idx = 0;
    function open(i) {
      idx = (i + images.length) % images.length;
      img.src = images[idx];
      if (counter) counter.textContent = (idx + 1) + ' / ' + images.length;
      lb.classList.add('open');
      document.body.style.overflow = 'hidden';
    }
    function shut() {
      lb.classList.remove('open');
      document.body.style.overflow = '';
    }

    document.querySelectorAll('[data-lightbox-trigger]').forEach(function (btn) {
      btn.addEventListener('click', function () { open(parseInt(btn.dataset.lightboxTrigger, 10) || 0); });
    });
    close.addEventListener('click', shut);
    prev.addEventListener('click', function () { open(idx - 1); });
    next.addEventListener('click', function () { open(idx + 1); });
    lb.addEventListener('click', function (e) { if (e.target === lb) shut(); });
    document.addEventListener('keydown', function (e) {
      if (!lb.classList.contains('open')) return;
      if (e.key === 'Escape') shut();
      if (e.key === 'ArrowLeft') open(idx - 1);
      if (e.key === 'ArrowRight') open(idx + 1);
    });
  })();
</script>
<?php endif; ?>
<?php $view->endSection(); ?>
