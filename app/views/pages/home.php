<?php /** @var \App\Core\View $view */ $view->extend('layouts.main'); ?>
<?php $view->section('content'); ?>

<!-- ═══════════ HERO ═══════════ -->
<section class="va-hero2">
  <div class="container-lg">
    <div class="va-hero2__grid">
      <div class="va-hero2__copy" data-reveal="left">
        <span class="va-hero2__pill">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2 4 6v6c0 5 3.5 9.5 8 10 4.5-.5 8-5 8-10V6l-8-4Z"/></svg>
          #1 Premium Real Estate · Mumbai
        </span>

        <h1 class="va-hero2__h1">
          Find your dream<br>
          <span class="accent">home</span>, <span class="accent">beautifully</span>.
        </h1>

        <p class="va-hero2__lede">
          500+ RERA-verified properties across Mumbai's prime micro-markets. Owner-direct listings, senior-advisor support, and zero pushy sales calls.
        </p>

        <div class="va-hero2__cta">
          <a href="/properties" class="va-cta">
            Browse Properties
            <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
          </a>
          <a href="/contact" class="va-cta va-cta--ghost">Talk to an expert</a>
        </div>

        <div class="va-hero2__trust">
          <div class="va-hero2__trust-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="9 12 11 14 15 10"/></svg>
            <span>RERA verified</span>
          </div>
          <div class="va-hero2__trust-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="9 12 11 14 15 10"/></svg>
            <span>No spam calls</span>
          </div>
          <div class="va-hero2__trust-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="9 12 11 14 15 10"/></svg>
            <span>Free legal check</span>
          </div>
          <div class="va-hero2__trust-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="9 12 11 14 15 10"/></svg>
            <span>24/7 support</span>
          </div>
        </div>

        <div class="va-hero2__stats">
          <div>
            <strong>500<em>+</em></strong>
            <span>Properties</span>
          </div>
          <div>
            <strong>350<em>+</em></strong>
            <span>Happy Clients</span>
          </div>
          <div>
            <strong>15<em>+</em></strong>
            <span>Locations</span>
          </div>
        </div>
      </div>

      <div data-reveal="right" data-reveal-delay="150">
        <div class="va-hero2__media">
          <div class="va-hero2__photo">
            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1400&q=80"
                 alt="Featured Vastu Anand luxury home"
                 onerror="this.src='https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=1400&q=80'">
          </div>

          <div class="va-hero2__avatars">
            <div class="va-hero2__avatars-stack" aria-hidden="true">
              <span style="background-image:url('https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=120&q=80')"></span>
              <span style="background-image:url('https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=120&q=80')"></span>
              <span style="background-image:url('https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=120&q=80')"></span>
            </div>
            <div class="va-hero2__avatars-text">
              <strong>350+ booked</strong>
              <span>This quarter</span>
            </div>
          </div>

          <a href="/properties?type=Villa" class="va-hero2__featured">
            <span class="ic">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9 12 2l9 7v11a2 2 0 0 1-2 2h-4v-7h-6v7H5a2 2 0 0 1-2-2V9Z"/></svg>
            </span>
            <div class="va-hero2__featured-body">
              <strong>Luxury Villas in Bandra</strong>
              <span>Starting <em>₹4.2 Cr</em> · Mumbai</span>
            </div>
            <span class="va-hero2__featured-btn">View
              <svg width="12" height="9" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
            </span>
          </a>
        </div>
      </div>
    </div>

    <!-- QUICK SEARCH (filter card moved BELOW hero, overlapping) -->
    <div class="va-quicksearch-wrap" data-reveal>
      <form class="va-quicksearch" action="/properties" method="get">
        <div class="va-quicksearch__tabs" role="tablist">
          <button type="button" class="va-quicksearch__tab active" data-listing="sale">Buy</button>
          <button type="button" class="va-quicksearch__tab" data-listing="rent">Rent</button>
          <button type="button" class="va-quicksearch__tab" data-listing="lease">Commercial</button>
        </div>
        <input type="hidden" name="listing" value="sale">

        <div class="va-quicksearch__grid">
          <div class="va-quicksearch__field">
            <label for="qs-q">Location</label>
            <input id="qs-q" type="text" name="q" placeholder="Bandra, Powai, BKC…">
          </div>
          <div class="va-quicksearch__field">
            <label for="qs-type">Property Type</label>
            <select id="qs-type" name="type">
              <option value="">Any type</option>
              <option>Apartment</option><option>Villa</option><option>Penthouse</option>
              <option>Studio</option><option>Builder Floor</option><option>Commercial</option><option>Farmhouse</option>
            </select>
          </div>
          <div class="va-quicksearch__field">
            <label for="qs-bhk">BHK</label>
            <select id="qs-bhk" name="bhk">
              <option value="">Any</option>
              <option value="1">1 BHK</option><option value="2">2 BHK</option>
              <option value="3">3 BHK</option><option value="4">4 BHK</option><option value="5">5+ BHK</option>
            </select>
          </div>
          <div class="va-quicksearch__field">
            <label for="qs-max">Budget</label>
            <select id="qs-max" name="max">
              <option value="">Any</option>
              <option value="5000000">Up to ₹50 L</option>
              <option value="10000000">Up to ₹1 Cr</option>
              <option value="30000000">Up to ₹3 Cr</option>
              <option value="70000000">Up to ₹7 Cr</option>
              <option value="200000000">Up to ₹20 Cr</option>
            </select>
          </div>
          <button type="submit" class="va-quicksearch__submit">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Search
          </button>
        </div>
      </form>
    </div>
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
    <div class="grid cols-2 va-vision">
      <div data-reveal="left">
        <span class="eyebrow">OUR PURPOSE</span>
        <h2 class="display va-vision__h">
          Mumbai's most trusted partner for <span class="gold">insight-led</span> property decisions.
        </h2>
        <p class="muted va-vision__p">
          Vastu Anand exists for the discerning buyer, seller and investor who values transparency over theatrics. We deliver ethical, personalized, data-backed real estate solutions that simplify complexity and create lasting value.
        </p>
        <div class="grid cols-2 va-vision__cards">
          <div class="glass">
            <span class="eyebrow">Vision</span>
            <p>To be Mumbai's most trusted real estate partner for transparent and insight-led property decisions.</p>
          </div>
          <div class="glass">
            <span class="eyebrow">Mission</span>
            <p>Deliver ethical, personalized, and data-backed solutions that simplify complexity and create lasting value.</p>
          </div>
        </div>
        <a href="/about" class="va-link-arrow va-vision__cta">
          Discover Our Story
          <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
        </a>
      </div>
      <div data-reveal="right" data-reveal-delay="150" class="va-vision__media">
        <div class="va-vision__img-1">
          <img src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=900&q=80"
               alt="Vastu Anand advisor consulting client" loading="lazy">
        </div>
        <div class="va-vision__img-2">
          <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=600&q=80"
               alt="Modern luxury interior" loading="lazy">
        </div>
        <div class="va-vision__badge glass">
          <div class="va-vision__badge-num">350<span>+</span></div>
          <div class="eyebrow">Happy Mumbai Clients</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════ FEATURED PROPERTIES ═══════════ -->
<section style="background:var(--surface)">
  <div class="container-lg">
    <div class="va-featured__head" data-reveal>
      <div>
        <span class="eyebrow">CURATED PORTFOLIO</span>
        <h2>Featured <span class="gold">Properties</span></h2>
      </div>
      <a href="/properties" class="va-link-arrow">View All
        <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
      </a>
    </div>

    <div class="va-featured__row" data-stagger>
      <?php foreach ($featured as $p): ?>
        <article class="va-featured__item">
          <div class="va-featured__img">
            <span class="va-featured__badge"><?= e(ucfirst($p['listing'] ?? 'sale')) ?></span>
            <?php $view->include('components.property-slider', ['p' => $p, 'alt' => $p['title'] ?? 'Property']); ?>
          </div>
          <div class="va-featured__body">
            <div class="va-featured__price">
              <?= format_price($p['price'] ?? 0) ?><?= ($p['listing'] ?? '') === 'rent' ? '<span>/mo</span>' : '' ?>
            </div>
            <a href="/property/<?= e($p['slug']) ?>"><h3 class="va-featured__title"><?= e($p['title']) ?></h3></a>
            <p class="va-featured__loc">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>
              <?= e($p['location'] ?? 'Mumbai') ?>
            </p>
            <div class="va-featured__meta">
              <?php if (!empty($p['bhk'])): ?>
                <span>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 18v-6a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v6"/><path d="M3 18h18"/><path d="M6 9V6a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v3"/></svg>
                  <strong><?= (int)$p['bhk'] ?></strong> BHK
                </span>
              <?php endif; ?>
              <?php if (!empty($p['area'])): ?>
                <span>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h18v18H3z"/><path d="M3 9h18M9 3v18"/></svg>
                  <strong><?= number_format((float)$p['area']) ?></strong> sqft
                </span>
              <?php endif; ?>
              <?php if (!empty($p['type'])): ?>
                <span>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9 12 2l9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"/></svg>
                  <?= e($p['type']) ?>
                </span>
              <?php endif; ?>
            </div>
            <a href="/property/<?= e($p['slug']) ?>" class="va-featured__cta">
              View Details
              <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
            </a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════ NEIGHBOURHOODS ═══════════ -->
<section>
  <div class="container-lg">
    <?php $view->include('components.section-head', [
      'eyebrow' => 'PRIME LOCATIONS',
      'heading' => 'Mumbai\'s <span class="gold">Most Coveted</span> Addresses',
      'sub'     => 'Each micro-market serves a different investor profile. Explore neighbourhoods curated to your lifestyle and ambition.'
    ]); ?>

    <div class="va-hoods">
      <?php
      $hoods = [
        ['Bandra West', '₹5-25 Cr', 'https://images.unsplash.com/photo-1577415124269-fc1140a69e91?auto=format&fit=crop&w=900&q=80', 'large'],
        ['BKC',         '₹8-40 Cr', 'https://images.unsplash.com/photo-1486325212027-8081e485255e?auto=format&fit=crop&w=600&q=80', 'small'],
        ['Worli',       '₹6-30 Cr', 'https://images.unsplash.com/photo-1493809842364-78817add7ffb?auto=format&fit=crop&w=600&q=80', 'small'],
        ['Powai',       '₹2-12 Cr', 'https://images.unsplash.com/photo-1582407947304-fd86f028f716?auto=format&fit=crop&w=600&q=80', 'small'],
        ['Juhu',        '₹4-20 Cr', 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=600&q=80', 'small'],
        ['Navi Mumbai', '₹0.6-4 Cr','https://images.unsplash.com/photo-1542621334-a254cf47733d?auto=format&fit=crop&w=900&q=80', 'large'],
      ];
      foreach ($hoods as $i => [$name, $price, $img, $size]):
      ?>
        <a href="/properties?q=<?= urlencode($name) ?>" class="va-hood va-hood--<?= $size ?>" data-reveal="<?= $i % 2 === 0 ? 'left' : 'right' ?>" data-reveal-delay="<?= ($i % 3) * 100 ?>">
          <img src="<?= e($img) ?>" alt="<?= e($name) ?> properties" loading="lazy">
          <div class="va-hood__overlay"></div>
          <div class="va-hood__body">
            <span class="va-hood__price"><?= e($price) ?></span>
            <h3 class="va-hood__name"><?= e($name) ?></h3>
            <span class="va-hood__arrow">
              Explore
              <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
            </span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════ SERVICES ═══════════ -->
<section style="background:linear-gradient(180deg,var(--surface-2),var(--surface))">
  <div class="container-lg">
    <?php $view->include('components.section-head', [
      'eyebrow' => 'OUR SERVICES',
      'heading' => 'Solutions Across Every <span class="gold">Real Estate</span> Need',
      'sub'     => 'A complete suite of services — from acquisition to ongoing management — delivered with the discretion and depth Mumbai\'s top families expect.'
    ]); ?>

    <div class="grid cols-4">
      <?php
      $services = [
        ['slug'=>'property-buying',      'title'=>'Property Buying',      'icon'=>'home',     'desc'=>'Find and acquire your dream home in Mumbai\'s prime locations with expert advisory.'],
        ['slug'=>'property-selling',     'title'=>'Property Selling',     'icon'=>'tag',      'desc'=>'Premium marketing, verified buyers and best-in-class price realization for sellers.'],
        ['slug'=>'property-consultation','title'=>'Consultation',         'icon'=>'compass',  'desc'=>'Deep-dive consultations on micro-markets, builder due-diligence and investment strategy.'],
        ['slug'=>'rental-services',      'title'=>'Rental & Management',  'icon'=>'key',      'desc'=>'Zero-brokerage rentals with tenant screening, agreements and full property management.'],
      ];
      foreach ($services as $i => $s):
      ?>
        <a href="/services/<?= e($s['slug']) ?>" data-reveal data-reveal-delay="<?= 100 * $i ?>">
          <div class="va-service">
            <div class="va-service__icon">
              <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
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
              <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
            </span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════ STATS COUNTER ═══════════ -->
<section style="padding:80px 0">
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
<section style="background:var(--surface-2)">
  <div class="container-lg">
    <?php $view->include('components.section-head', [
      'eyebrow' => 'WHY CHOOSE US',
      'heading' => 'Why Mumbai Chooses <span class="gold">Vastu Anand</span>',
      'sub'     => '4+ years of real estate excellence backed by 350+ happy clients across luxury and commercial segments.'
    ]); ?>

    <div class="grid cols-3">
      <?php
      $usps = [
        ['Trusted Advisors',        'Deep local expertise across Mumbai\'s micro-markets — built on relationships, not transactions.',           'users'],
        ['Best Market Pricing',     'Data-driven valuations and negotiation expertise that consistently deliver the best price-to-value.',       'trending'],
        ['Zero Brokerage Rentals',  'Curated rental options with zero brokerage and complete legal &amp; documentation support included.',       'gift'],
        ['Confident Decisions',     'Clear strategic guidance, transparent pricing and complete legal clarity at every stage of the journey.',   'shield'],
        ['RERA-Verified Listings',  'Every project is RERA-checked and legally verified before being added to your shortlist.',                  'check'],
        ['Dedicated NRI Desk',      'End-to-end NRI services: virtual tours, legal compliance, property management and remote ownership.',       'globe'],
      ];
      $usp_icons = [
        'users'    => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'trending' => '<polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/>',
        'gift'     => '<polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/>',
        'shield'   => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
        'check'    => '<path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="10"/>',
        'globe'    => '<circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>',
      ];
      foreach ($usps as $i => [$h, $desc, $ic]):
      ?>
        <div class="va-service" data-reveal data-reveal-delay="<?= 80 * $i ?>">
          <div class="va-service__icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
              <?= $usp_icons[$ic] ?>
            </svg>
          </div>
          <h3><?= $h ?></h3>
          <p><?= $desc ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════ EMI CALCULATOR ═══════════ -->
<section>
  <div class="container">
    <div class="grid cols-2" style="gap:56px;align-items:center">
      <div data-reveal="left">
        <span class="eyebrow">SMART TOOLS</span>
        <h2 class="display" style="font-size:clamp(30px,4vw,48px);margin:14px 0 18px">
          Calculate your <span class="gold">monthly EMI</span> in seconds.
        </h2>
        <p class="muted" style="margin-bottom:28px;line-height:1.7">
          A pre-approved loan strengthens your negotiation and saves time once you finalise a property. Get an instant estimate, then talk to our advisors for the best bank offer.
        </p>
        <form id="emiCalc" class="glass" style="padding:24px">
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
          <button type="submit" class="btn btn-primary" style="margin-top:16px;width:100%;justify-content:center">Calculate EMI</button>
        </form>
      </div>
      <div data-reveal="right" data-reveal-delay="150">
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
<section style="background:var(--surface-2)">
  <div class="container-lg">
    <?php $view->include('components.section-head', [
      'eyebrow' => 'CLIENT STORIES',
      'heading' => 'What Our Mumbai <span class="gold">Clients Say</span>',
      'sub'     => 'A small sample from 350+ families and investors we\'ve had the privilege of serving.'
    ]); ?>

    <div class="swiper testimonialSwiper" data-reveal>
      <div class="swiper-wrapper">
        <?php foreach ($testimonials as $t): ?>
          <div class="swiper-slide" style="height:auto;padding:6px"><?php $view->include('components.testimonial', ['t' => $t]); ?></div>
        <?php endforeach; ?>
      </div>
      <div class="swiper-pagination" style="position:relative;margin-top:32px"></div>
    </div>
  </div>
</section>

<!-- ═══════════ BLOG ═══════════ -->
<section>
  <div class="container-lg">
    <?php $view->include('components.section-head', [
      'eyebrow' => 'FROM OUR BLOG',
      'heading' => 'Latest <span class="gold">Market Insights</span>',
      'sub'     => 'Stay informed with our research on Mumbai\'s neighbourhoods, prices, and policy.'
    ]); ?>

    <div class="va-blog-grid" data-stagger>
      <?php foreach ($blogs as $i => $b): ?>
        <a href="/blog/<?= e($b['slug']) ?>" class="va-blog-card">
          <div class="va-blog-card__img">
            <img loading="lazy"
                 src="<?= e($b['cover'] ?? 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=900&q=80') ?>"
                 alt="<?= e($b['title']) ?>"
                 onerror="this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=900&q=80'">
            <span class="va-blog-card__cat"><?= e($b['category'] ?? 'Article') ?></span>
          </div>
          <div class="va-blog-card__body">
            <div class="va-blog-card__meta">
              <span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg><?= e($b['publishedAt'] ?? '') ?></span>
              <span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg><?= e($b['readTime'] ?? '5 min') ?></span>
            </div>
            <h3 class="va-blog-card__title"><?= e($b['title']) ?></h3>
            <p class="va-blog-card__excerpt"><?= e(mb_strimwidth($b['excerpt'] ?? '', 0, 140, '…')) ?></p>
            <span class="va-blog-card__cta">View Details
              <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
            </span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════ CTA BANNER ═══════════ -->
<section style="padding:60px 0 100px">
  <div class="container">
    <div class="va-cta-banner" data-reveal>
      <div class="va-cta-banner__bg" aria-hidden="true">
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1600&q=80" alt="" loading="lazy">
      </div>
      <div class="va-cta-banner__overlay"></div>
      <div class="va-cta-banner__content">
        <span class="eyebrow" style="color:var(--gold-2)">START YOUR JOURNEY</span>
        <h2 class="display" style="font-size:clamp(34px,5vw,60px);margin:16px 0 18px;color:#fff;max-width:700px;margin-inline:auto">
          Ready to discover your <span style="color:var(--gold-2)">perfect address</span>?
        </h2>
        <p style="max-width:600px;margin:0 auto 32px;font-size:16px;line-height:1.7;color:rgba(255,255,255,0.78)">
          Book a complimentary consultation with our senior advisor. We will understand your goals, shortlist 5-7 matched properties, and walk you through the entire journey — quietly and professionally.
        </p>
        <div class="flex gap-16" style="justify-content:center;flex-wrap:wrap">
          <a href="/contact" class="btn btn-gold">Book Free Consultation</a>
          <a href="https://wa.me/<?= e(config('app.brand.whatsapp')) ?>" class="btn" style="background:transparent;color:#fff;border-color:rgba(255,255,255,0.4)">WhatsApp Us</a>
        </div>
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
      spaceBetween: 22,
      autoplay: { delay: 5500 },
      pagination: { el: '.swiper-pagination', clickable: true },
      breakpoints: { 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } },
    });
  }
</script>
<?php $view->endSection(); ?>
