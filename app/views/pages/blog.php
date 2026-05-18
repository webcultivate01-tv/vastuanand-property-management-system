<?php $view->extend('layouts.main'); ?>
<?php $view->section('content'); ?>

<section style="padding:140px 0 60px">
  <div class="container" data-reveal>
    <span class="eyebrow">INSIGHTS</span>
    <h1 class="display" style="font-size:clamp(44px,5vw,72px);margin:18px 0 16px">Mumbai Real Estate <span class="gold" style="font-style:italic">Insights</span></h1>
    <p class="muted" style="max-width:680px;font-size:17px;line-height:1.7">Investment guides, legal articles and market commentary from our research desk.</p>
  </div>
</section>

<section style="padding-top:0">
  <div class="container-lg">
    <div class="grid cols-3">
      <?php foreach ($result['data'] as $b): ?>
        <a href="/blog/<?= e($b['slug']) ?>" class="va-card" data-reveal>
          <div class="va-card__img">
            <img loading="lazy" src="<?= e($b['cover'] ?? asset('images/b1.jpg')) ?>" alt="<?= e($b['title']) ?>" onerror="this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=900&q=80'">
            <span class="va-card__badge"><?= e($b['category'] ?? 'Insights') ?></span>
          </div>
          <div class="va-card__body">
            <h3 class="va-card__title"><?= e($b['title']) ?></h3>
            <p class="va-card__loc"><?= e($b['publishedAt'] ?? '') ?> · <?= e($b['readTime'] ?? '5 min') ?></p>
            <p class="muted" style="font-size:14px;line-height:1.6;margin-top:12px"><?= e(mb_strimwidth($b['excerpt'] ?? '', 0, 130, '…')) ?></p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php $view->endSection(); ?>
