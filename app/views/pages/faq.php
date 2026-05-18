<?php $view->extend('layouts.main'); ?>
<?php $view->section('content'); ?>

<section style="padding:140px 0 60px">
  <div class="container" style="max-width:880px" data-reveal>
    <span class="eyebrow">FAQ</span>
    <h1 class="display" style="font-size:clamp(40px,5vw,68px);margin:18px 0 16px">Frequently Asked <span class="gold" style="font-style:italic">Questions</span></h1>
    <p class="muted" style="font-size:17px;line-height:1.7">Common questions from our clients on buying, renting, NRI services and legal documentation.</p>
  </div>
</section>

<section style="padding-top:0">
  <div class="container" style="max-width:880px">
    <?php foreach (\App\Controllers\Api\ContentApi::FAQS as $i => $f): ?>
      <details class="glass" style="padding:0;margin-bottom:14px;border-radius:14px;overflow:hidden" data-reveal>
        <summary style="padding:22px 26px;cursor:pointer;display:flex;justify-content:space-between;align-items:center;font-size:17px;list-style:none">
          <span><?= e($f['q']) ?></span>
          <span style="color:var(--gold);font-size:24px;line-height:1">+</span>
        </summary>
        <div style="padding:0 26px 22px;color:var(--slate);line-height:1.8"><?= e($f['a']) ?></div>
      </details>
    <?php endforeach; ?>
  </div>
</section>

<style>
  details[open] summary span:last-child { transform: rotate(45deg); transition: transform .3s; }
  summary::-webkit-details-marker { display: none; }
</style>
<?php $view->endSection(); ?>
