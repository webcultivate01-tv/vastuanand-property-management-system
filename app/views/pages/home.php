<?php /** @var \App\Core\View $view */ $view->extend('layouts.main'); ?>
<?php $view->section('content'); ?>

<!-- ═══════════ HERO ═══════════ -->
<section class="va-hero">
  <div class="va-hero__bg">
    <img src="<?= asset('images/hero.jpg') ?>" alt="Luxury Mumbai skyline at dusk"
         onerror="this.src='https://images.unsplash.com/photo-1567552379162-eb29c9bb5be3?auto=format&fit=crop&w=1920&q=80'">
  </div>
  <div class="va-hero__overlay"></div>
  <div class="va-hero__grain"></div>

  <div class="container-lg va-hero__inner">
    <span class="eyebrow va-hero__eyebrow">PREMIUM REAL ESTATE · MUMBAI</span>
    <h1 class="display">Find Your Perfect <span class="accent">Address</span> in Mumbai's Finest Locations.</h1>
    <p class="lede">Curated luxury apartments, sea-facing penthouses, private villas and Grade-A commercial spaces — handpicked across Bandra, BKC, Powai, Worli and beyond. RERA-verified. Insight-led. Quietly powerful.</p>
    <div class="va-hero__cta">
      <a href="/properties" class="va-cta">Explore Properties</a>
      <a href="/contact" class="va-cta va-cta--ghost">Book Consultation</a>
    </div>
  </div>
</section>

<!-- ═══════════ SEARCH BAR ═══════════ -->
<section style="padding:0 0 80px;margin-top:-90px;position:relative;z-index:5">
  <div class="container">
    <form class="va-search" action="/properties" method="get">
      <div class="va-search__tabs">
        <div class="va-search__tab active" data-listing="sale">Buy</div>
        <div class="va-search__tab" data-listing="rent">Rent</div>
        <div class="va-search__tab" data-listing="lease">Commercial</div>
      </div>
      <input type="hidden" name="listing" value="sale">
      <div class="va-search__grid">
        <input class="va-search__field" type="text" name="q" placeholder="Search by location, project or area">
        <select class="va-search__field" name="type">
          <option value="">Property Type</option>
          <option>Apartment</option><option>Villa</option><option>Penthouse</option>
          <option>Studio</option><option>Builder Floor</option><option>Commercial</option><option>Farmhouse</option>
        </select>
        <select class="va-search__field" name="bhk">
          <option value="">BHK</option>
          <option value="1">1 BHK</option><option value="2">2 BHK</option>
          <option value="3">3 BHK</option><option value="4">4 BHK</option><option value="5">5+ BHK</option>
        </select>
        <select class="va-search__field" name="max">
          <option value="">Budget</option>
          <option value="5000000">Up to ₹50 L</option>
          <option value="10000000">Up to ₹1 Cr</option>
          <option value="30000000">Up to ₹3 Cr</option>
          <option value="70000000">Up to ₹7 Cr</option>
          <option value="200000000">Up to ₹20 Cr</option>
        </select>
        <button type="submit" class="va-search__submit">Search</button>
      </div>
    </form>
  </div>
</section>

<!-- ═══════════ MARQUEE ═══════════ -->
<div class="va-marquee" aria-hidden="true">
  <div class="va-marquee__track">
    <?php for ($i = 0; $i < 2; $i++): ?>
      <span>Bandra West</span><span>Juhu</span><span>BKC</span><span>Worli</span><span>Powai</span>
      <span>Lower Parel</span><span>Andheri</span><span>Navi Mumbai</span><span>Thane</span><span>Panvel</span>
    <?php endfor; ?>
  </div>
</div>

<!-- ═══════════ WHO WE ARE / VISION ═══════════ -->
<section>
  <div class="container">
    <div class="grid cols-2" style="gap:80px;align-items:center">
      <div data-reveal>
        <span class="eyebrow">OUR PURPOSE</span>
        <h2 class="display" style="font-size:clamp(34px,4.5vw,56px);margin:18px 0 24px">
          Mumbai's most trusted partner for <span class="gold" style="font-style:italic">insight-led</span> property decisions.
        </h2>
        <p class="muted" style="line-height:1.8;font-size:16px">
          Vastu Anand exists for the discerning buyer, seller and investor who values transparency over theatrics.
          We deliver ethical, personalized, data-backed real estate solutions that simplify complexity and create lasting value.
        </p>
        <div class="grid cols-2" style="margin-top:36px;gap:18px">
          <div class="glass" style="padding:22px">
            <span class="eyebrow">Vision</span>
            <p class="mt-8 mb-0" style="font-size:14px;line-height:1.6">To be Mumbai's most trusted real estate partner for transparent and insight-led property decisions.</p>
          </div>
          <div class="glass" style="padding:22px">
            <span class="eyebrow">Mission</span>
            <p class="mt-8 mb-0" style="font-size:14px;line-height:1.6">Deliver ethical, personalized, and data-backed solutions that simplify complexity and create lasting value.</p>
          </div>
        </div>
        <a href="/about" class="va-link-arrow" style="margin-top:36px;display:inline-flex">
          Discover Our Story
          <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
        </a>
      </div>
      <div data-reveal data-reveal-delay="200" style="position:relative">
        <div style="position:relative;border-radius:24px;overflow:hidden;aspect-ratio:4/5">
          <img src="<?= asset('images/about-1.jpg') ?>" alt="Vastu Anand property advisor"
               onerror="this.src='https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=900&q=80'"
               style="width:100%;height:100%;object-fit:cover">
          <div style="position:absolute;left:24px;bottom:24px;right:24px">
            <div class="glass" style="padding:18px 22px">
              <div style="font-size:34px;color:var(--gold);line-height:1">350<span style="font-size:20px">+</span></div>
              <div class="eyebrow" style="margin-top:4px">Happy Mumbai Clients</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════ FEATURED PROPERTIES ═══════════ -->
<section style="background:linear-gradient(180deg,var(--ink-2),var(--ink))">
  <div class="container-lg">
    <?php $view->include('components.section-head', [
      'eyebrow' => 'CURATED PORTFOLIO',
      'heading' => 'Featured <span class="gold" style="font-style:italic">Properties</span>',
      'sub'     => 'Handpicked premium residences in Mumbai\'s most desirable locations — designed for elegance, comfort, and long-term value.'
    ]); ?>

    <div class="grid cols-3">
      <?php foreach ($featured as $p) $view->include('components.property-card', ['p' => $p]); ?>
    </div>

    <div class="text-center" style="margin-top:56px" data-reveal>
      <a href="/properties" class="btn btn-primary">View All Properties
        <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
      </a>
    </div>
  </div>
</section>

<!-- ═══════════ SERVICES ═══════════ -->
<section>
  <div class="container-lg">
    <?php $view->include('components.section-head', [
      'eyebrow' => 'OUR SERVICES',
      'heading' => 'Solutions Across Every <span class="gold" style="font-style:italic">Real Estate</span> Need',
      'sub'     => 'A complete suite of services — from acquisition to ongoing management — delivered with the discretion and depth Mumbai\'s top families expect.'
    ]); ?>

    <div class="grid cols-4">
      <?php
      $services = [
        ['slug'=>'property-buying',      'title'=>'Property Buying',      'icon'=>'home',     'desc'=>'Find and acquire your dream home in Mumbai\'s prime locations with expert advisory.'],
        ['slug'=>'property-selling',     'title'=>'Property Selling',     'icon'=>'tag',      'desc'=>'Premium marketing, verified buyers and best-in-class price realization for sellers.'],
        ['slug'=>'property-consultation','title'=>'Consultation',         'icon'=>'compass',  'desc'=>'Deep-dive consultations on micro-markets, builder due-diligence and investment strategy.'],
        ['slug'=>'rental-services',     'title'=>'Rental & Management', 'icon'=>'key',      'desc'=>'Zero-brokerage rentals with tenant screening, agreements and full property management.'],
      ];
      foreach ($services as $i => $s):
      ?>
        <a href="/services/<?= e($s['slug']) ?>" data-reveal data-reveal-delay="<?= 100*$i ?>">
          <div class="va-service">
            <div class="va-service__icon">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                <?php switch($s['icon']) {
                  case 'home':    echo '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/>'; break;
                  case 'tag':     echo '<path d="M20.59 13.41 11 23l-9-9V3h11l9.59 9.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/>'; break;
                  case 'compass': echo '<circle cx="12" cy="12" r="10"/><polygon points="16.24,7.76 14.12,14.12 7.76,16.24 9.88,9.88"/>'; break;
                  case 'key':     echo '<path d="M21 2l-9.6 9.6a5.5 5.5 0 1 0 2.83 2.83L17 11.5h2.5V14l3-3-3-3z"/>'; break;
                } ?>
              </svg>
            </div>
            <h3><?= e($s['title']) ?></h3>
            <p><?= e($s['desc']) ?></p>
            <span class="va-service__arrow">Explore
              <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
            </span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════ MUMBAI SHOWCASE ═══════════ -->
<section style="background:#000;padding:140px 0;position:relative;overflow:hidden">
  <div style="position:absolute;inset:0;opacity:0.18">
    <img src="<?= asset('images/mumbai-night.jpg') ?>" alt=""
         onerror="this.src='https://images.unsplash.com/photo-1570168007204-dfb528c6958f?auto=format&fit=crop&w=1920&q=80'"
         style="width:100%;height:100%;object-fit:cover">
  </div>
  <div class="container" style="position:relative" data-reveal>
    <div style="max-width:780px;margin:0 auto;text-align:center">
      <span class="eyebrow">PRIME LOCATIONS ACROSS MAHARASHTRA</span>
      <h2 class="display" style="font-size:clamp(40px,5vw,72px);margin:18px 0 28px">
        Bandra. Worli. BKC. <br><span class="gold" style="font-style:italic">Powai. Navi Mumbai. Thane.</span>
      </h2>
      <p class="muted" style="font-size:17px;line-height:1.7;margin-bottom:42px">
        Each micro-market serves a different investor profile. Bandra offers stability, Powai balances yield and lifestyle, Thane provides growth, and Navi Mumbai delivers infrastructure-led appreciation.
      </p>
      <a href="/properties" class="btn btn-primary">Explore Locations</a>
    </div>
  </div>
</section>

<!-- ═══════════ STATS COUNTER ═══════════ -->
<section style="padding:100px 0">
  <div class="container">
    <div class="va-stats" data-reveal>
      <?php foreach ($stats as $s):
        preg_match('/(\d+)/', $s['value'], $m);
        $num = $m[1] ?? '0';
        $suffix = trim(str_replace($num, '', $s['value']));
      ?>
        <div class="va-stat">
          <div class="va-stat__val"><span data-counter="<?= (int)$num ?>" data-suffix="<?= e($suffix) ?>">0</span></div>
          <span class="va-stat__lbl"><?= e($s['label']) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════ WHY US ═══════════ -->
<section style="background:linear-gradient(180deg,var(--ink),var(--ink-2))">
  <div class="container-lg">
    <?php $view->include('components.section-head', [
      'eyebrow' => 'WHY CHOOSE US',
      'heading' => 'Why Mumbai Chooses <span class="gold" style="font-style:italic">Vastu Anand</span>',
      'sub'     => '4+ years of real estate excellence backed by 350+ happy clients across luxury and commercial segments.'
    ]); ?>

    <div class="grid cols-3">
      <?php
      $usps = [
        ['Trusted Real Estate Advisors',      'Deep local expertise across Mumbai\'s micro-markets and emerging zones — built on relationships, not transactions.'],
        ['Best Market Pricing',                'Accurate, data-driven valuations and negotiation expertise that consistently deliver the best price-to-value outcomes.'],
        ['Zero Brokerage Assistance',          'Curated rental options with zero brokerage and complete legal & documentation support included.'],
        ['Confident Property Decisions',       'Clear strategic guidance, transparent pricing and complete legal clarity at every stage of the journey.'],
        ['RERA-Verified Listings',             'Every project is RERA-checked and legally verified before being added to your shortlist.'],
        ['Dedicated NRI Desk',                 'End-to-end NRI services: virtual tours, legal compliance, property management and remote ownership.'],
      ];
      foreach ($usps as $i => [$h,$p]):
      ?>
        <div class="va-service" data-reveal data-reveal-delay="<?= 100*$i ?>">
          <div class="va-service__icon">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M9 12l2 2 4-4"/><path d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
          </div>
          <h3><?= e($h) ?></h3>
          <p><?= e($p) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════ EMI CALCULATOR ═══════════ -->
<section>
  <div class="container">
    <div class="grid cols-2" style="gap:60px;align-items:center">
      <div data-reveal>
        <span class="eyebrow">SMART TOOLS</span>
        <h2 class="display" style="font-size:clamp(34px,4.5vw,56px);margin:18px 0 22px">
          Calculate your <span class="gold" style="font-style:italic">monthly EMI</span> in seconds.
        </h2>
        <p class="muted" style="margin-bottom:32px;line-height:1.8">
          A pre-approved loan strengthens your negotiation and saves time once you finalise a property. Get an instant estimate, then talk to our advisors for the best bank offer.
        </p>
        <form id="emiCalc" class="glass" style="padding:28px">
          <div class="grid cols-3" style="gap:14px">
            <div class="form-group" style="margin-bottom:0">
              <label>Loan Amount (₹)</label>
              <input class="form-control" name="principal" type="number" value="10000000" min="100000" step="10000" required>
            </div>
            <div class="form-group" style="margin-bottom:0">
              <label>Rate (% pa)</label>
              <input class="form-control" name="rate" type="number" step="0.05" value="8.5" required>
            </div>
            <div class="form-group" style="margin-bottom:0">
              <label>Tenure (years)</label>
              <input class="form-control" name="years" type="number" value="20" required>
            </div>
          </div>
          <button type="submit" class="btn btn-primary" style="margin-top:18px;width:100%">Calculate EMI</button>
        </form>
      </div>
      <div data-reveal data-reveal-delay="200">
        <div id="emiResult" class="grid cols-1" style="gap:14px">
          <div class="va-stat"><div class="va-stat__val">₹86,782</div><span class="va-stat__lbl">Monthly EMI</span></div>
          <div class="va-stat"><div class="va-stat__val">₹10.83L</div><span class="va-stat__lbl">Total Interest</span></div>
          <div class="va-stat"><div class="va-stat__val">₹2.08Cr</div><span class="va-stat__lbl">Total Payment</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════ TESTIMONIALS ═══════════ -->
<section style="background:linear-gradient(180deg,var(--ink-2),var(--ink))">
  <div class="container-lg">
    <?php $view->include('components.section-head', [
      'eyebrow' => 'CLIENT STORIES',
      'heading' => 'What Our Mumbai <span class="gold" style="font-style:italic">Clients Say</span>',
      'sub'     => 'A small sample from 350+ families and investors we\'ve had the privilege of serving.'
    ]); ?>

    <div class="swiper testimonialSwiper" data-reveal>
      <div class="swiper-wrapper">
        <?php foreach ($testimonials as $t): ?>
          <div class="swiper-slide" style="height:auto;padding:8px"><?php $view->include('components.testimonial', ['t' => $t]); ?></div>
        <?php endforeach; ?>
      </div>
      <div class="swiper-pagination" style="position:relative;margin-top:32px"></div>
    </div>
  </div>
</section>

<!-- ═══════════ BLOG / INSIGHTS ═══════════ -->
<section>
  <div class="container-lg">
    <?php $view->include('components.section-head', [
      'eyebrow' => 'INSIGHTS',
      'heading' => 'Latest <span class="gold" style="font-style:italic">Market Insights</span>',
      'sub'     => 'Stay informed with our research on Mumbai\'s neighbourhoods, prices, and policy.'
    ]); ?>

    <div class="grid cols-3">
      <?php foreach ($blogs as $b): ?>
        <a href="/blog/<?= e($b['slug']) ?>" class="va-card" data-reveal>
          <div class="va-card__img">
            <img loading="lazy" src="<?= e($b['cover'] ?? asset('images/b1.jpg')) ?>" alt="<?= e($b['title']) ?>"
                 onerror="this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=900&q=80'">
            <span class="va-card__badge"><?= e($b['category'] ?? 'Insights') ?></span>
          </div>
          <div class="va-card__body">
            <h3 class="va-card__title"><?= e($b['title']) ?></h3>
            <p class="va-card__loc"><?= e($b['publishedAt'] ?? '') ?> &nbsp;·&nbsp; <?= e($b['readTime'] ?? '5 min read') ?></p>
            <p class="muted" style="font-size:14px;line-height:1.6;margin-top:12px"><?= e(mb_strimwidth($b['excerpt'] ?? '', 0, 130, '…')) ?></p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════ CTA BANNER ═══════════ -->
<section style="padding:80px 0">
  <div class="container">
    <div class="glass" style="padding:80px 40px;text-align:center;background:linear-gradient(135deg,rgba(201,163,91,0.16),rgba(0,0,0,0.6));border:1px solid rgba(201,163,91,0.35)" data-reveal>
      <span class="eyebrow">START YOUR JOURNEY</span>
      <h2 class="display" style="font-size:clamp(36px,5vw,64px);margin:18px 0 22px;max-width:760px;margin-inline:auto">
        Ready to discover your <span class="gold" style="font-style:italic">perfect address</span>?
      </h2>
      <p class="muted" style="max-width:600px;margin:0 auto 38px;font-size:16px;line-height:1.7">
        Book a complimentary consultation with our senior advisor. We will understand your goals, shortlist 5-7 matched properties, and walk you through the entire journey — quietly and professionally.
      </p>
      <div class="flex gap-16" style="justify-content:center;flex-wrap:wrap">
        <a href="/contact" class="btn btn-primary">Book Free Consultation</a>
        <a href="https://wa.me/<?= e(config('app.brand.whatsapp')) ?>" class="btn btn-ghost">WhatsApp Us</a>
      </div>
    </div>
  </div>
</section>

<?php $view->endSection(); ?>

<?php $view->section('scripts'); ?>
<script>
  if (window.Swiper) {
    new Swiper('.testimonialSwiper', {
      slidesPerView: 1,
      spaceBetween: 24,
      autoplay: { delay: 5500 },
      pagination: { el: '.swiper-pagination', clickable: true },
      breakpoints: { 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } },
    });
  }
</script>
<?php $view->endSection(); ?>
