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
          <?php foreach ($filters as $f):
            $k         = $f['key'] ?? '';
            $label     = $f['label'] ?? '';
            $type      = $f['type'] ?? 'select';
            $ph        = $f['placeholder'] ?? '';
            $opts      = $f['options'] ?? [];
            $fieldId   = 'qs-' . $k;
          ?>
            <div class="va-quicksearch__field" id="<?= e($fieldId) ?>-field" data-filter-key="<?= e($k) ?>">
              <label for="<?= e($fieldId) ?>"><?= e($label) ?></label>
              <?php if ($type === 'select'): ?>
                <select id="<?= e($fieldId) ?>" name="<?= e($k) ?>" data-filter-input>
                  <option value=""><?= e($ph !== '' ? $ph : 'Any') ?></option>
                  <?php foreach ($opts as $o): ?>
                    <option value="<?= e($o['value'] ?? $o['label'] ?? '') ?>"
                            data-hide="<?= e(is_array($o['hide'] ?? null) ? implode(',', $o['hide']) : '') ?>">
                      <?= e($o['label'] ?? '') ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              <?php else: ?>
                <input id="<?= e($fieldId) ?>" type="<?= $type === 'number' ? 'number' : 'text' ?>" name="<?= e($k) ?>" placeholder="<?= e($ph) ?>" data-filter-input>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>

          <button type="submit" class="va-quicksearch__submit">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Search
          </button>
        </div>
      </form>
    </div>
  </div>
</section>

<script>
  (function () {
    var form = document.querySelector('.va-quicksearch');
    if (!form) return;

    var fieldsByKey = {};
    form.querySelectorAll('[data-filter-key]').forEach(function (el) {
      fieldsByKey[el.getAttribute('data-filter-key')] = el;
    });

    function sync() {
      // first reveal everything
      Object.values(fieldsByKey).forEach(function (el) { el.style.display = ''; });

      // then collect hide-keys from every active selection
      var hideSet = new Set();
      form.querySelectorAll('select[data-filter-input]').forEach(function (sel) {
        var opt = sel.options[sel.selectedIndex];
        if (!opt) return;
        (opt.getAttribute('data-hide') || '')
          .split(',').map(function (s) { return s.trim(); }).filter(Boolean)
          .forEach(function (k) { hideSet.add(k); });
      });

      hideSet.forEach(function (k) {
        var el = fieldsByKey[k];
        if (!el) return;
        el.style.display = 'none';
        var inp = el.querySelector('[data-filter-input]');
        if (inp) inp.value = '';
      });
    }

    form.querySelectorAll('select[data-filter-input]').forEach(function (sel) {
      sel.addEventListener('change', sync);
    });
    sync();
  })();
</script>

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
          <img src="https://images.unsplash.com/photo-1552133457-ce1d2d33cdfb?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8N3x8bXVtYmFpJTIwc2t5bGluZXxlbnwwfHwwfHx8MA%3D%3D"
               alt="Vastu Anand advisor consulting client" loading="lazy">
        </div>
        <div class="va-vision__img-2">
          <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=600&q=80"
               alt="Modern luxury interior" loading="lazy">
        </div>
        <div class="va-vision__badge glass">
          <div class="va-vision__badge-num">100<span>+</span></div>
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
            <a href="/property/<?= e($p['slug']) ?>" class="va-featured__cta"
               data-va-gate
               data-property-slug="<?= e($p['slug'] ?? '') ?>"
               data-property-title="<?= e($p['title'] ?? '') ?>"
               data-property-id="<?= e($p['id'] ?? '') ?>">
              View in Detail
              <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
            </a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="va-featured__more" data-reveal>
      <a href="/properties" class="va-cta va-cta--gold">
        View More Properties
        <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
      </a>
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
      // Mumbai-specific imagery — primary URL + fallback URL per neighbourhood.
      // Fallback fires onerror; second fallback is a generic luxury interior.
      $hoods = [
        ['Bandra West', '₹5-25 Cr', 'Boutique Living',     'https://images.unsplash.com/photo-1594817060351-8f3de84b7e0e?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'https://images.unsplash.com/photo-1567157577867-05ccb1388e66?auto=format&fit=crop&w=1400&q=85', 'large'],
        ['BKC',         '₹8-40 Cr', 'Business District',   'https://www.hotelkohinoorelite.com/blog/admin/assets/img/post/image_2024-08-14-12-22-07_66bca16fc520e.jpg',  'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=900&q=85',  'small'],
        ['Worli',       '₹6-30 Cr', 'Sea-Link Skyline',    'https://images.unsplash.com/photo-1567157577867-05ccb1388e66?auto=format&fit=crop&w=900&q=85',  'https://images.unsplash.com/photo-1582510003544-4d00b7f74220?auto=format&fit=crop&w=900&q=85',  'small'],
        ['Powai',       '₹2-12 Cr', 'Lakeside Tech Hub',   'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=900&q=85',  'https://images.unsplash.com/photo-1502082553048-f009c37129b9?auto=format&fit=crop&w=900&q=85',  'small'],
        ['Juhu',        '₹4-20 Cr', 'Beachfront Heritage', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=900&q=85',  'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=900&q=85',  'small'],
        ['Navi Mumbai', '₹0.6-4 Cr','Emerging Frontier',   'https://images.unsplash.com/photo-1573132223210-d65883b944aa?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fG11bWJhaXxlbnwwfHwwfHx8MA%3D%3D', 'https://images.unsplash.com/photo-1572976625828-eed5ff0c1c43?auto=format&fit=crop&w=1400&q=85', 'small'],
      ];
      foreach ($hoods as $i => [$name, $price, $tagline, $img, $fallback, $size]):
      ?>
        <a href="/properties?q=<?= urlencode($name) ?>" class="va-hood va-hood--<?= $size ?>" data-reveal="<?= $i % 2 === 0 ? 'left' : 'right' ?>" data-reveal-delay="<?= ($i % 3) * 100 ?>">
          <img src="<?= e($img) ?>" alt="<?= e($name) ?> properties" loading="lazy"
               data-fallback="<?= e($fallback) ?>"
               onerror="if(this.dataset.fallback){this.src=this.dataset.fallback;this.removeAttribute('data-fallback');}else{this.src='https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=900&q=80';}">
          <span class="va-hood__index"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <div class="va-hood__overlay"></div>
          <div class="va-hood__body">
            <span class="va-hood__tagline"><?= e($tagline) ?></span>
            <h3 class="va-hood__name"><?= e($name) ?></h3>
            <div class="va-hood__meta">
              <span class="va-hood__price"><?= e($price) ?></span>
              <span class="va-hood__sep"></span>
              <span class="va-hood__arrow">
                Discover
                <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
              </span>
            </div>
          </div>
          <span class="va-hood__accent"></span>
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
<section id="testimonials" style="background:var(--surface-2)">
  <div class="container-lg">
    <?php $view->include('components.section-head', [
      'eyebrow' => 'CLIENT STORIES',
      'heading' => 'What Our Mumbai <span class="gold">Clients Say</span>',
      'sub'     => 'A small sample from 350+ families and investors we\'ve had the privilege of serving.'
    ]); ?>

    <div style="text-align:center;margin:-12px 0 32px" data-reveal>
      <button type="button" class="va-cta va-cta--gold" id="vaReviewOpen">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add Your Review
      </button>
    </div>

    <div class="swiper testimonialSwiper" data-reveal>
      <div class="swiper-wrapper">
        <?php foreach ($testimonials as $t): ?>
          <div class="swiper-slide" style="height:auto;padding:6px"><?php $view->include('components.testimonial', ['t' => $t]); ?></div>
        <?php endforeach; ?>
      </div>
      <div class="swiper-pagination" style="position:relative;margin-top:32px"></div>
    </div>
  </div>

  <!-- Add Review modal -->
  <div id="vaReviewModal" class="va-review-modal" aria-hidden="true" role="dialog" aria-labelledby="vaReviewTitle">
    <div class="va-review-modal__backdrop" data-va-review-close></div>
    <div class="va-review-modal__card" role="document">
      <button type="button" class="va-review-modal__close" data-va-review-close aria-label="Close">×</button>
      <span class="eyebrow">SHARE YOUR EXPERIENCE</span>
      <h3 id="vaReviewTitle" style="margin:6px 0 6px;font-size:24px">Add a Review</h3>
      <p class="muted" style="margin:0 0 20px;font-size:14px">Your review will appear on the site once approved by our team.</p>

      <form id="vaReviewForm" method="post" action="/reviews" novalidate>
        <?= csrf_field() ?>
        <div class="form-group">
          <label>Your Name</label>
          <input class="form-control" name="name" required maxlength="80">
        </div>
        <div class="form-group">
          <label>Role / Location <span class="muted" style="text-transform:none;letter-spacing:0;font-weight:400">(optional)</span></label>
          <input class="form-control" name="role" placeholder="Home Buyer, Bandra" maxlength="120">
        </div>
        <div class="form-group">
          <label>Rating</label>
          <div class="va-review-stars" data-va-stars>
            <?php for ($i = 1; $i <= 5; $i++): ?>
              <button type="button" class="va-review-stars__btn" data-value="<?= $i ?>" aria-label="<?= $i ?> star">★</button>
            <?php endfor; ?>
            <input type="hidden" name="rating" value="5">
          </div>
        </div>
        <div class="form-group">
          <label>Your Review</label>
          <textarea class="form-control" name="message" rows="4" required minlength="10" maxlength="1000" placeholder="Tell us about your experience..."></textarea>
        </div>

        <div id="vaReviewMsg" class="va-review-modal__msg" hidden></div>

        <button type="submit" class="va-cta va-cta--gold" style="width:100%;justify-content:center">
          Submit Review
        </button>
      </form>
    </div>
  </div>
</section>

<style>
  .va-review-modal{position:fixed;inset:0;z-index:9000;display:none;align-items:center;justify-content:center;padding:20px}
  .va-review-modal.is-open{display:flex}
  .va-review-modal__backdrop{position:absolute;inset:0;background:rgba(10,10,10,.72);backdrop-filter:blur(4px)}
  .va-review-modal__card{position:relative;background:var(--surface,#fff);max-width:520px;width:100%;border-radius:14px;padding:32px;box-shadow:0 40px 90px rgba(0,0,0,.4);max-height:92vh;overflow-y:auto}
  .va-review-modal__close{position:absolute;top:12px;right:12px;width:36px;height:36px;border:0;background:transparent;font-size:26px;cursor:pointer;color:#1A1A1A;line-height:1}
  .va-review-modal__msg{padding:10px 14px;border-radius:8px;margin-bottom:14px;font-size:13px}
  .va-review-modal__msg.is-ok{background:#E7F6E9;color:#1B5E20}
  .va-review-modal__msg.is-err{background:#FBEAEA;color:#9F2A2A}
  .va-review-stars{display:flex;gap:6px}
  .va-review-stars__btn{background:none;border:0;font-size:30px;color:#D9D9D9;cursor:pointer;padding:0;line-height:1;transition:color .15s ease,transform .1s ease}
  .va-review-stars__btn:hover,.va-review-stars__btn.is-active{color:#C9A35B}
  .va-review-stars__btn:active{transform:scale(.92)}
</style>

<!-- ═══════════ CTA BANNER ═══════════ -->
<section class="va-cta-section va-cta-section--full">
  <div class="va-cta-banner va-cta-banner--full" data-reveal>
      <div class="va-cta-banner__bg" aria-hidden="true">
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1800&q=80" alt="" loading="lazy">
      </div>
      <div class="va-cta-banner__overlay"></div>
      <div class="va-cta-banner__glow" aria-hidden="true"></div>

      <div class="va-cta-banner__content">
        <span class="va-cta-banner__eyebrow">
          <span class="va-cta-banner__dot"></span>
          START YOUR JOURNEY
        </span>

        <h2 class="va-cta-banner__heading">
          Ready to discover your <span class="va-cta-banner__accent">perfect address</span>?
        </h2>

        <p class="va-cta-banner__lede">
          Book a complimentary consultation with our senior advisor. We'll understand your goals, shortlist 5–7 matched properties, and walk you through every step — quietly and professionally.
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
            <div>
              <strong>RERA Verified</strong>
              <span>Every listing</span>
            </div>
          </div>
          <div class="va-cta-banner__trust-item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <div>
              <strong>15-min Response</strong>
              <span>On WhatsApp</span>
            </div>
          </div>
          <div class="va-cta-banner__trust-item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 12a8 8 0 0 1-8 8 8 8 0 0 1-8-8 8 8 0 0 1 8-8c2 0 3.83.74 5.23 1.96"/><polyline points="20 4 20 8 16 8"/></svg>
            <div>
              <strong>Zero Brokerage</strong>
              <span>For NRI buyers</span>
            </div>
          </div>
          <div class="va-cta-banner__trust-item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <div>
              <strong>500+ Families</strong>
              <span>Served since 2018</span>
            </div>
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

  // ── Add Review modal ──
  (function () {
    var openBtn = document.getElementById('vaReviewOpen');
    var modal   = document.getElementById('vaReviewModal');
    if (!openBtn || !modal) return;

    var form    = document.getElementById('vaReviewForm');
    var msgBox  = document.getElementById('vaReviewMsg');
    var stars   = modal.querySelectorAll('[data-va-stars] .va-review-stars__btn');
    var rating  = modal.querySelector('input[name="rating"]');

    function paintStars(n) {
      stars.forEach(function (b, i) { b.classList.toggle('is-active', (i + 1) <= n); });
    }
    paintStars(parseInt(rating.value, 10) || 5);

    stars.forEach(function (b) {
      b.addEventListener('mouseenter', function () { paintStars(parseInt(b.dataset.value, 10)); });
      b.addEventListener('mouseleave', function () { paintStars(parseInt(rating.value, 10) || 5); });
      b.addEventListener('click', function () {
        rating.value = b.dataset.value;
        paintStars(parseInt(b.dataset.value, 10));
      });
    });

    function open()  { modal.classList.add('is-open');    modal.setAttribute('aria-hidden', 'false'); document.body.style.overflow = 'hidden'; }
    function close() { modal.classList.remove('is-open'); modal.setAttribute('aria-hidden', 'true');  document.body.style.overflow = ''; if (msgBox) { msgBox.hidden = true; msgBox.className = 'va-review-modal__msg'; } }

    openBtn.addEventListener('click', open);
    modal.querySelectorAll('[data-va-review-close]').forEach(function (el) { el.addEventListener('click', close); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && modal.classList.contains('is-open')) close(); });

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var data = new FormData(form);
      var btn  = form.querySelector('button[type="submit"]');
      btn.disabled = true; btn.textContent = 'Submitting…';
      msgBox.hidden = true;

      fetch(form.action, {
        method: 'POST',
        body: data,
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
      })
        .then(function (r) { return r.json().then(function (j) { return { ok: r.ok, body: j }; }); })
        .then(function (res) {
          if (res.ok && res.body && res.body.ok) {
            msgBox.textContent = res.body.message || 'Thank you! Your review has been submitted for approval.';
            msgBox.className = 'va-review-modal__msg is-ok';
            msgBox.hidden = false;
            form.reset();
            rating.value = 5; paintStars(5);
            setTimeout(close, 2400);
          } else {
            var errs = (res.body && res.body.errors) ? Object.values(res.body.errors).flat().join(' ') : (res.body && res.body.message) || 'Something went wrong. Please try again.';
            msgBox.textContent = errs;
            msgBox.className = 'va-review-modal__msg is-err';
            msgBox.hidden = false;
          }
        })
        .catch(function () {
          msgBox.textContent = 'Network error. Please try again.';
          msgBox.className = 'va-review-modal__msg is-err';
          msgBox.hidden = false;
        })
        .finally(function () {
          btn.disabled = false; btn.textContent = 'Submit Review';
        });
    });

    // Auto-open if URL has #review-add
    if (location.hash === '#review-add') open();
  })();
</script>
<?php $view->endSection(); ?>
