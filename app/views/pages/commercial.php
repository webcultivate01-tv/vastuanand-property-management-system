<?php $view->extend('layouts.main'); ?>
<?php $view->section('content'); ?>
<section style="padding:140px 0 60px">
  <div class="container" data-reveal>
    <span class="eyebrow">COMMERCIAL REAL ESTATE</span>
    <h1 class="display" style="font-size:clamp(44px,5vw,72px);margin:18px 0 16px">Grade-A commercial spaces in <span class="gold" style="font-style:italic">Mumbai's office hubs</span>.</h1>
    <p class="muted" style="max-width:680px;font-size:17px;line-height:1.7">Premium office spaces in BKC, Lower Parel, Andheri and Worli — purchase, lease, or co-invest with our institutional desk.</p>
  </div>
</section>
<section style="padding-top:30px">
  <div class="container">
    <div class="grid cols-2" style="gap:24px">
      <?php foreach ([['BKC','Bandra Kurla Complex'],['Lower Parel','One Lodha Place'],['Andheri East','SEEPZ'],['Worli','One Avighna']] as $i => [$loc, $project]): ?>
        <div class="va-service" data-reveal data-reveal-delay="<?= 80*$i ?>">
          <span class="chip" style="color:var(--gold);border-color:var(--gold)">PRIME HUB</span>
          <h3 style="margin-top:14px"><?= e($loc) ?></h3>
          <p class="muted">Featured project — <?= e($project) ?>. Grade-A, IT-ready, on-site parking, premium amenities and 24×7 facility management.</p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php $view->endSection(); ?>
