<?php $view->extend('layouts.main'); $b = $blog; ?>
<?php $view->section('content'); ?>

<?php
  // Build list of gallery images: prefer $b['gallery'] (array), fallback to legacy 'images', then cover
  $galleryRaw = [];
  if (!empty($b['gallery']) && is_array($b['gallery'])) $galleryRaw = $b['gallery'];
  elseif (!empty($b['images']) && is_array($b['images'])) $galleryRaw = $b['images'];
  $galleryImages = array_values(array_filter(array_map('trim', $galleryRaw)));
?>

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
        <?= e($b['publishedAt'] ?? '') ?>
      </span>
      <span>·</span>
      <span>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:-2px;margin-right:4px;color:var(--gold)"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        <?= e($b['readTime'] ?? '5 min read') ?>
      </span>
      <?php if (!empty($b['author'])): ?>
        <span>·</span>
        <span>By <strong style="color:var(--ink)"><?= e($b['author']) ?></strong></span>
      <?php endif; ?>
    </div>

    <h1 class="va-blog-detail__title"><?= e($b['title']) ?></h1>
    <?php if (!empty($b['excerpt'])): ?>
      <p class="va-blog-detail__lede"><?= e($b['excerpt']) ?></p>
    <?php endif; ?>
  </div>
</section>

<div class="va-blog-cover" data-reveal>
  <div class="va-blog-cover__img">
    <img src="<?= e($b['cover'] ?? asset('images/b1.jpg')) ?>" alt="<?= e($b['title']) ?>" onerror="this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1600&q=80'">
  </div>
</div>

<article class="va-blog-body" data-reveal>
  <?= $b['body'] ?? '<p>Article content coming soon.</p>' ?>
</article>

<?php if (!empty($galleryImages)): ?>
  <section class="va-blog-gallery" data-reveal>
    <h2 class="va-blog-gallery__title">More from this story</h2>
    <div class="va-blog-gallery__grid" data-lightbox="blog-gallery">
      <?php foreach ($galleryImages as $i => $img): ?>
        <button type="button" class="va-blog-gallery__item" data-lightbox-trigger="<?= $i ?>" aria-label="Open image <?= $i+1 ?>">
          <img loading="lazy" src="<?= e($img) ?>" alt="<?= e($b['title']) ?> — image <?= $i+1 ?>">
        </button>
      <?php endforeach; ?>
    </div>
  </section>
<?php endif; ?>

<!-- Share + CTA strip -->
<section style="padding:60px 0 100px">
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

<?php if (!empty($galleryImages)): ?>
  <div class="va-lightbox" id="vaLightbox" role="dialog" aria-modal="true" aria-label="Image viewer">
    <button class="va-lightbox__close" id="vaLightboxClose" aria-label="Close">&times;</button>
    <button class="va-lightbox__nav va-lightbox__nav--prev" id="vaLightboxPrev" aria-label="Previous image">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
    </button>
    <img id="vaLightboxImg" alt="">
    <button class="va-lightbox__nav va-lightbox__nav--next" id="vaLightboxNext" aria-label="Next image">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
    </button>
  </div>
<?php endif; ?>

<?php $view->endSection(); ?>

<?php $view->section('scripts'); ?>
<?php if (!empty($galleryImages)): ?>
<script>
  (function(){
    var images = <?= json_encode(array_values($galleryImages), JSON_UNESCAPED_SLASHES) ?>;
    var lb    = document.getElementById('vaLightbox');
    var img   = document.getElementById('vaLightboxImg');
    var close = document.getElementById('vaLightboxClose');
    var prev  = document.getElementById('vaLightboxPrev');
    var next  = document.getElementById('vaLightboxNext');
    if (!lb || !images.length) return;

    var idx = 0;
    function open(i){ idx = (i + images.length) % images.length; img.src = images[idx]; lb.classList.add('open'); document.body.style.overflow = 'hidden'; }
    function shut(){ lb.classList.remove('open'); document.body.style.overflow = ''; }

    document.querySelectorAll('[data-lightbox-trigger]').forEach(function(btn){
      btn.addEventListener('click', function(){ open(parseInt(btn.dataset.lightboxTrigger, 10) || 0); });
    });
    close.addEventListener('click', shut);
    prev.addEventListener('click', function(){ open(idx - 1); });
    next.addEventListener('click', function(){ open(idx + 1); });
    lb.addEventListener('click', function(e){ if (e.target === lb) shut(); });
    document.addEventListener('keydown', function(e){
      if (!lb.classList.contains('open')) return;
      if (e.key === 'Escape') shut();
      if (e.key === 'ArrowLeft') open(idx - 1);
      if (e.key === 'ArrowRight') open(idx + 1);
    });
  })();
</script>
<?php endif; ?>
<?php $view->endSection(); ?>
