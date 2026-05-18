<?php $view->extend('layouts.main'); ?>
<?php $view->section('content'); ?>

<section style="padding:140px 0 60px;background:linear-gradient(180deg,var(--surface-2),var(--bg))">
  <div class="container" data-reveal>
    <span class="eyebrow">CAREERS</span>
    <h1 class="display" style="font-size:clamp(44px,5vw,72px);margin:18px 0 16px">Build a career with <span class="gold" style="font-style:italic">Mumbai's most trusted</span> real estate firm.</h1>
    <p class="muted" style="max-width:680px;font-size:17px;line-height:1.7">We are quietly growing. Join a team that values discretion, deep knowledge and long-term client relationships over noisy targets.</p>
  </div>
</section>

<section>
  <div class="container">
    <div class="grid cols-2" style="gap:20px">
      <?php foreach ($jobs as $i => $j): ?>
        <div class="va-service" data-reveal data-reveal-delay="<?= 100 * $i ?>">
          <span class="chip"><?= e($j['dept'] ?? 'Team') ?></span>
          <h3 style="margin-top:14px"><?= e($j['title']) ?></h3>
          <p class="muted" style="font-size:14px;margin:6px 0 16px"><?= e($j['location'] ?? 'Mumbai') ?> · <?= e($j['type'] ?? 'Full-time') ?></p>
          <a href="mailto:<?= e(config('app.brand.email')) ?>?subject=Application: <?= e($j['title']) ?>" class="va-link-arrow">Apply Now
            <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php $view->endSection(); ?>
