<?php $view->extend('layouts.main'); ?>
<?php $view->section('content'); ?>
<section class="va-hero" style="min-height:70vh">
  <div class="va-hero__bg"><img src="<?= asset('images/nri.jpg') ?>" onerror="this.src='https://images.unsplash.com/photo-1542223189-67a03fa0f0bd?auto=format&fit=crop&w=1920&q=80'"></div>
  <div class="va-hero__overlay"></div>
  <div class="container va-hero__inner">
    <span class="eyebrow">NRI INVESTMENT DESK</span>
    <h1 class="display" style="font-size:clamp(44px,6vw,80px);margin:24px 0 22px">A trusted Mumbai team, <span class="accent">wherever you live</span>.</h1>
    <p class="lede">Virtual site tours, legal & taxation, property management, and remote ownership — designed end-to-end for NRIs across UAE, Singapore, UK and the US.</p>
    <div class="va-hero__cta"><a href="/contact" class="va-cta">Book NRI Consultation</a></div>
  </div>
</section>
<section>
  <div class="container">
    <div class="grid cols-3">
      <?php foreach ([
        ['Virtual Tours','High-fidelity video walkthroughs and live video site visits coordinated by our advisor on-ground.'],
        ['Legal & Tax','TDS compliance, capital gains, FEMA and RBI guidelines handled by partnered CAs and lawyers.'],
        ['Property Management','Tenant screening, rent collection, maintenance and quarterly reports — all remotely managed.'],
        ['Loan Coordination','NRE/NRO loan paperwork coordinated with leading banks — fully online wherever possible.'],
        ['Power of Attorney','Drafted, notarized and registered POA assistance for remote transactions.'],
        ['Quarterly Updates','Quarterly portfolio review with valuation, rental yield and recommended actions.'],
      ] as $i => [$h,$p]): ?>
        <div class="va-service" data-reveal data-reveal-delay="<?= 80*$i ?>">
          <h3><?= e($h) ?></h3><p class="muted"><?= e($p) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php $view->endSection(); ?>
