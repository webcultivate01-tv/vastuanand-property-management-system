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
<section class="va-cta-section--full">
  <div class="va-cta-banner va-cta-banner--full" data-reveal>
    <div class="va-cta-banner__bg" aria-hidden="true">
      <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1800&q=80" alt="" loading="lazy">
    </div>
    <div class="va-cta-banner__overlay"></div>
    <div class="va-cta-banner__glow" aria-hidden="true"></div>

    <div class="va-cta-banner__content">
      <span class="va-cta-banner__eyebrow">
        <span class="va-cta-banner__dot"></span>
        READY WHEN YOU ARE
      </span>

      <h2 class="va-cta-banner__heading">
        Let's design your <span class="va-cta-banner__accent">next move</span>.
      </h2>

      <p class="va-cta-banner__lede">
        A 20-minute call is usually all it takes to know if we're a good fit — and you'll leave with three actionable next steps even if we don't work together.
      </p>

      <div class="va-cta-banner__actions">
        <a href="/contact" class="va-cta-banner__btn va-cta-banner__btn--gold">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          Book Free Consultation
        </a>
        <a href="https://wa.me/<?= e(config('app.brand.whatsapp')) ?>" target="_blank" rel="noopener" class="va-cta-banner__btn va-cta-banner__btn--ghost">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M20.5 3.5A11 11 0 0 0 3 17.2L1.5 22.5l5.4-1.4A11 11 0 1 0 20.5 3.5ZM12 20a8 8 0 0 1-4.1-1.1l-.3-.2-3.2.8.9-3.2-.2-.3a8 8 0 1 1 6.9 4Zm4.5-6c-.2-.1-1.4-.7-1.6-.8-.2-.1-.4-.1-.5.1l-.7.9c-.1.2-.3.2-.5.1a6.5 6.5 0 0 1-3.2-2.8c-.2-.4.2-.4.6-1.2 0-.2 0-.3-.1-.4l-.7-1.7c-.2-.4-.4-.4-.5-.4h-.5a1 1 0 0 0-.7.3 3 3 0 0 0-.9 2.2c0 1.3 1 2.6 1.1 2.8.1.2 1.9 3 4.7 4.2 1.7.7 2.3.7 3.1.6.5-.1 1.4-.6 1.6-1.1.2-.6.2-1 .1-1.1Z"/></svg>
          WhatsApp Us
        </a>
        <a href="tel:<?= e(config('app.brand.phone')) ?>" class="va-cta-banner__btn va-cta-banner__btn--ghost">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
          Call Now
        </a>
      </div>

      <div class="va-cta-banner__trust">
        <div class="va-cta-banner__trust-item">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2 4 6v6c0 5 3.5 9.4 8 10 4.5-.6 8-5 8-10V6l-8-4z"/><polyline points="9 12 11 14 15 10"/></svg>
          <div><strong>RERA Verified</strong><span>Every listing</span></div>
        </div>
        <div class="va-cta-banner__trust-item">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          <div><strong>15-min Response</strong><span>On WhatsApp</span></div>
        </div>
        <div class="va-cta-banner__trust-item">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          <div><strong>Senior Advisor</strong><span>On every call</span></div>
        </div>
        <div class="va-cta-banner__trust-item">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 17 13.5 8.5 8.5 13.5 2 7"/><polyline points="16 17 22 17 22 11"/></svg>
          <div><strong>Best-in-Class</strong><span>Price realization</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php $view->endSection(); ?>
