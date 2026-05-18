<?php /** @var \App\Core\View $view */ $view->extend('layouts.main'); ?>
<?php $view->section('content'); ?>

<section class="va-hero-svc">
  <div class="container-lg">
    <div class="va-hero-svc__grid">
      <div class="va-hero-svc__copy" data-reveal="left">
        <div class="va-h-crumb">
          <a href="/">Home</a> <span>/</span> <strong>Services</strong>
        </div>
        <span class="eyebrow" style="margin-top:22px">WHAT WE DO</span>
        <h1>Real-estate services, <span class="va-h-accent">elevated</span>.</h1>
        <p class="lede">End-to-end advisory from acquisition and disposition to leasing and management. Every engagement is led by a senior advisor with deep local knowledge of Mumbai's micro-markets.</p>
        <div class="va-hero-svc__cta">
          <a href="/contact" class="va-cta va-cta--gold">Book a Consultation</a>
          <a href="/properties" class="va-cta va-cta--ghost">Browse Inventory</a>
        </div>

        <div class="va-hero-svc__quotebar">
          <div class="avatar">VA</div>
          <p><strong>Personalised, never templated.</strong> Most clients meet our senior advisor on the first call.</p>
        </div>
      </div>

      <div data-reveal="right">
        <div class="va-hero-svc__orbit" aria-hidden="true">
          <div class="va-hero-svc__core">VASTU<br>ANAND</div>

          <div class="va-hero-svc__node va-hero-svc__node--1">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9 12 2l9 7v11a2 2 0 0 1-2 2h-4v-7h-6v7H5a2 2 0 0 1-2-2V9Z"/></svg>
            <span>Buy</span>
          </div>
          <div class="va-hero-svc__node va-hero-svc__node--2">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            <span>Sell</span>
          </div>
          <div class="va-hero-svc__node va-hero-svc__node--3">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
            <span>Manage</span>
          </div>
          <div class="va-hero-svc__node va-hero-svc__node--4">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            <span>Advise</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section style="padding-top:20px">
  <div class="container-lg">
    <div class="va-services-grid">
      <?php
      $svcs = [
        [
          'slug'    => 'property-buying',
          'title'   => 'Property Buying',
          'hero'    => 'Find and acquire your dream home in Mumbai\'s prime locations with full legal and financial support.',
          'features'=> ['Curated property shortlist','RERA-verified listings','Coordinated site visits','Expert price negotiation','Legal & documentation','Loan & finance support'],
          'icon'    => '<path d="M3 9 12 2l9 7v11a2 2 0 0 1-2 2h-4v-7h-6v7H5a2 2 0 0 1-2-2V9Z"/>',
        ],
        [
          'slug'    => 'property-selling',
          'title'   => 'Property Selling',
          'hero'    => 'Sell at the right price, in the right time, to the right buyer — with marketing that reaches qualified leads.',
          'features'=> ['Free professional valuation','Premium marketing creatives','Verified buyer screening','Negotiation expertise','Paperwork & registration','Tax & capital-gains advisory'],
          'icon'    => '<path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>',
        ],
        [
          'slug'    => 'property-consultation',
          'title'   => 'Investment Advisory',
          'hero'    => 'Make confident property decisions with research-led advisors and a transparent investment roadmap.',
          'features'=> ['Investment strategy','Micro-market analysis','Builder due-diligence','Rental yield projection','Vastu compatibility','Personalised roadmap'],
          'icon'    => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',
        ],
        [
          'slug'    => 'rental-services',
          'title'   => 'Rentals & Management',
          'hero'    => 'Premium rentals and full property management for owners — including a dedicated NRI desk.',
          'features'=> ['Verified tenant screening','Watertight rental agreements','Property handover support','Maintenance coordination','Renewal & vacate support','NRI landlord services'],
          'icon'    => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/>',
        ],
      ];
      foreach ($svcs as $i => $s): ?>
        <article class="va-service-card" data-reveal data-reveal-delay="<?= 80*$i ?>">
          <div class="va-service-card__head">
            <div class="va-service-card__icon">
              <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><?= $s['icon'] ?></svg>
            </div>
            <div class="va-service-card__num">0<?= $i+1 ?></div>
          </div>
          <h3><?= e($s['title']) ?></h3>
          <p><?= e($s['hero']) ?></p>
          <ul>
            <?php foreach ($s['features'] as $f): ?>
              <li>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                <?= e($f) ?>
              </li>
            <?php endforeach; ?>
          </ul>
          <div class="va-service-card__foot">
            <a href="/services/<?= e($s['slug']) ?>" class="va-link-arrow">Learn more
              <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
            </a>
            <a href="/contact?service=<?= e($s['slug']) ?>" class="btn btn-sm btn-ghost">Get a quote</a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- HOW WE WORK -->
<section style="padding-top:30px">
  <div class="container-lg">
    <div class="section-head" data-reveal>
      <span class="eyebrow">HOW WE WORK</span>
      <h2>A simple, <span class="gold">transparent</span> process</h2>
      <p>Four predictable steps from first conversation to keys-in-hand — designed to remove the noise and protect your time.</p>
    </div>

    <div class="va-process" data-stagger>
      <?php foreach ([
        ['01','Discovery','Share your goals, budget and timeline. A senior advisor maps a shortlist of 5–7 matched options.'],
        ['02','Site Visits','Curated, scheduled visits at your convenience — with legal & loan facilitators ready to step in.'],
        ['03','Negotiation','We negotiate on price, payment plan and value-adds, backed by real comparable sales data.'],
        ['04','Closing','Watertight paperwork, registration and handover — plus warm intros for interiors and movers.'],
      ] as [$num,$h,$p]): ?>
        <div class="va-process__step">
          <strong class="num"><?= e($num) ?></strong>
          <h4><?= e($h) ?></h4>
          <p><?= e($p) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA BANNER -->
<section style="padding:40px 0 100px">
  <div class="container">
    <div class="va-cta-banner" data-reveal>
      <div class="va-cta-banner__bg" aria-hidden="true">
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1600&q=80" alt="" loading="lazy">
      </div>
      <div class="va-cta-banner__overlay"></div>
      <div class="va-cta-banner__content">
        <span class="eyebrow" style="color:var(--gold-2)">READY WHEN YOU ARE</span>
        <h2 class="display" style="font-size:clamp(28px,4.5vw,52px);margin:16px 0 18px;color:#fff;max-width:680px;margin-inline:auto">Let's design your <span style="color:var(--gold-2);font-style:italic">next move</span>.</h2>
        <p style="max-width:580px;margin:0 auto 28px;font-size:15.5px;line-height:1.7;color:rgba(255,255,255,0.78)">A 20-minute call is usually all it takes to know if we're a good fit — and you'll leave with three actionable next steps even if we don't work together.</p>
        <div class="flex gap-16" style="justify-content:center;flex-wrap:wrap">
          <a href="/contact" class="btn btn-gold">Book Free Consultation</a>
          <a href="https://wa.me/<?= e(config('app.brand.whatsapp')) ?>" class="btn" style="background:transparent;color:#fff;border-color:rgba(255,255,255,0.4)">WhatsApp Us</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php $view->endSection(); ?>
