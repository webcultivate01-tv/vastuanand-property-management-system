<?php $view->extend('layouts.main'); $b = $blog; ?>
<?php $view->section('content'); ?>

<section style="padding:140px 0 40px">
  <div class="container" style="max-width:880px" data-reveal>
    <a href="/blog" class="va-link-arrow"><svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.4" style="transform:rotate(180deg)"><path d="M0 5h13M9 1l4 4-4 4"/></svg>All Articles</a>
    <div class="flex gap-16" style="margin-top:24px"><span class="chip" style="background:rgba(201,163,91,0.16);color:var(--gold);border-color:var(--gold)"><?= e($b['category'] ?? 'Insights') ?></span><span class="muted"><?= e($b['publishedAt'] ?? '') ?> · <?= e($b['readTime'] ?? '5 min') ?></span></div>
    <h1 class="display" style="font-size:clamp(36px,4.5vw,64px);margin:18px 0 16px"><?= e($b['title']) ?></h1>
    <p class="muted" style="font-size:18px;line-height:1.7"><?= e($b['excerpt'] ?? '') ?></p>
  </div>
</section>

<section style="padding-top:0">
  <div class="container" style="max-width:880px">
    <div data-reveal style="aspect-ratio:16/9;border-radius:20px;overflow:hidden;background:#111;margin-bottom:48px">
      <img src="<?= e($b['cover'] ?? asset('images/b1.jpg')) ?>" style="width:100%;height:100%;object-fit:cover" onerror="this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1600&q=80'">
    </div>
    <div data-reveal style="font-size:17px;line-height:1.9;color:var(--pearl-dim)"><?= $b['body'] ?? '<p>Article content coming soon.</p>' ?></div>
  </div>
</section>

<?php $view->endSection(); ?>
