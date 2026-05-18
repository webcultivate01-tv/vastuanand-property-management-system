<?php $view->extend('layouts.main'); ?>
<?php $view->section('content'); ?>
<section class="va-hero" style="min-height:80vh">
  <div class="va-hero__bg"><img src="<?= asset('images/luxury.jpg') ?>" onerror="this.src='https://images.unsplash.com/photo-1613490493576-7fde63acd811?auto=format&fit=crop&w=1920&q=80'"></div>
  <div class="va-hero__overlay"></div>
  <div class="container va-hero__inner">
    <span class="eyebrow">LUXURY HOMES</span>
    <h1 class="display" style="font-size:clamp(48px,7vw,96px);margin:24px 0 22px">Mumbai's most <span class="accent">prestigious</span> addresses.</h1>
    <p class="lede">Sea-facing penthouses, private villas, and limited-edition residences in Bandra, Worli, Juhu and Malabar Hill — curated for clients who recognise true rarity.</p>
    <div class="va-hero__cta"><a href="/properties?type=Villa" class="va-cta">Browse Luxury Homes</a><a href="/contact" class="va-cta va-cta--ghost">Private Showing</a></div>
  </div>
</section>
<section>
  <div class="container">
    <div class="grid cols-3">
      <?php foreach (['Sea-Facing Penthouses','Private Villas','Sky Residences','Limited Editions','Branded Residences','Heritage Bungalows'] as $i => $cat): ?>
        <div class="va-service" data-reveal data-reveal-delay="<?= 80*$i ?>">
          <h3><?= e($cat) ?></h3>
          <p class="muted">Hand-curated from off-market and pre-launch inventory across Mumbai's most prestigious micro-markets.</p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php $view->endSection(); ?>
