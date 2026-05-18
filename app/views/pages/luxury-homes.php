<?php $view->extend('layouts.main'); ?>
<?php $view->section('content'); ?>

<!-- HERO -->
<section class="va-lux-hero">
  <div class="va-lux-hero__bg">
    <img src="<?= asset('images/luxury.jpg') ?>" alt="Luxury Mumbai residence" onerror="this.src='https://images.unsplash.com/photo-1613490493576-7fde63acd811?auto=format&fit=crop&w=1920&q=80'">
  </div>
  <div class="va-lux-hero__overlay"></div>
  <div class="container">
    <div class="va-lux-hero__inner" data-reveal>
      <span class="eyebrow">LUXURY HOMES</span>
      <h1>Mumbai's most <span class="accent">prestigious</span> addresses.</h1>
      <p class="lede">Sea-facing penthouses, private villas, and limited-edition residences in Bandra, Worli, Juhu and Malabar Hill — curated for clients who recognise true rarity.</p>
      <div class="va-hero__cta">
        <a href="/properties?type=Villa" class="va-cta va-cta--gold">Browse Luxury Homes</a>
        <a href="/contact" class="btn" style="background:transparent;color:#fff;border-color:rgba(255,255,255,0.35);padding:11px 22px;border-radius:999px">Schedule a Private Showing</a>
      </div>
      <div class="va-lux-hero__chips">
        <span>Off-market access</span>
        <span>Pre-launch inventory</span>
        <span>Concierge handover</span>
        <span>NDA-protected viewings</span>
      </div>
    </div>
  </div>
</section>

<!-- CATEGORIES -->
<section>
  <div class="container-lg">
    <div class="section-head" data-reveal>
      <span class="eyebrow">CURATED CATEGORIES</span>
      <h2>A residence for <span class="gold">every</span> taste</h2>
      <p>From sky-high penthouses to heritage bungalows — we curate inventory across every form of luxury living in Mumbai.</p>
    </div>

    <div class="va-lux-cats" data-stagger>
      <?php
      $cats = [
        ['Sea-Facing Penthouses','Sky-high duplexes with uninterrupted Arabian Sea views.','https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=900&q=80','penthouse'],
        ['Private Villas','Gated villa communities with private pools and gardens.','https://images.unsplash.com/photo-1613977257592-4871e5fcd7c4?auto=format&fit=crop&w=900&q=80','villa'],
        ['Sky Residences','Branded high-floor apartments with hotel-style services.','https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=900&q=80','sky-residence'],
        ['Limited Editions','Single-floor and twin-tower releases — rarely on the open market.','https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=900&q=80','limited'],
        ['Branded Residences','Four Seasons, Ritz-Carlton and Trump-branded inventory.','https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?auto=format&fit=crop&w=900&q=80','branded'],
        ['Heritage Bungalows','Bandra & Malabar Hill villas with restored colonial detailing.','https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=900&q=80','bungalow'],
      ];
      foreach ($cats as $i => [$name,$desc,$img,$slug]): ?>
        <a href="/properties?type=<?= e($name) ?>" class="va-lux-cat">
          <img loading="lazy" src="<?= e($img) ?>" alt="<?= e($name) ?>">
          <div class="va-lux-cat__body">
            <span><?= e(str_pad((string)($i+1), 2, '0', STR_PAD_LEFT)) ?> · Category</span>
            <h3><?= e($name) ?></h3>
            <p><?= e($desc) ?></p>
            <span class="va-link-arrow">Explore
              <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
            </span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- FEATURED LUXURY -->
<section style="background:linear-gradient(180deg,var(--surface-2),var(--bg))">
  <div class="container-lg">
    <div class="va-lux-feature">
      <div data-reveal="left">
        <div class="va-lux-feature__media">
          <img src="https://images.unsplash.com/photo-1613977257592-4871e5fcd7c4?auto=format&fit=crop&w=1200&q=80" alt="Featured luxury residence">
          <span class="va-lux-feature__badge">Featured · Off-market</span>
          <span class="va-lux-feature__price">₹42 Cr</span>
        </div>
      </div>
      <div class="va-lux-feature__copy" data-reveal="right">
        <span class="eyebrow">FEATURED RESIDENCE</span>
        <h2>The Atelier Penthouse — <span class="gold" style="font-style:italic">Worli Sea Face</span></h2>
        <p>A 6,200 sqft duplex penthouse with private elevator access, a 60-foot infinity pool, and 270° Arabian Sea views. Designed by Studio Lotus with imported Italian stonework and a dedicated home automation suite.</p>

        <div class="va-lux-feature__specs">
          <div><strong>5 BHK</strong><span>Bedrooms</span></div>
          <div><strong>6,200</strong><span>Sqft Carpet</span></div>
          <div><strong>2 Car</strong><span>Valet Parking</span></div>
          <div><strong>270°</strong><span>Sea View</span></div>
        </div>

        <p style="font-size:13.5px;color:var(--slate-2);margin:0 0 24px">Shown by appointment only. Floor plans and pricing shared under NDA.</p>

        <div class="flex gap-16" style="flex-wrap:wrap">
          <a href="/contact" class="btn btn-primary">Request Private Tour</a>
          <a href="/properties?type=Penthouse" class="btn btn-ghost">View All Penthouses</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- AMENITIES -->
<section>
  <div class="container-lg">
    <div class="section-head" data-reveal>
      <span class="eyebrow">SIGNATURE AMENITIES</span>
      <h2>What makes a home <span class="gold">truly luxurious</span></h2>
      <p>The amenities our clients ask for most — and the standard we hold every featured property to.</p>
    </div>

    <div class="va-lux-amenities" data-stagger>
      <?php foreach ([
        ['Infinity Pool',     '<path d="M3 18s2-2 5-2 5 2 8 2 5-2 5-2"/><path d="M3 14s2-2 5-2 5 2 8 2 5-2 5-2"/><path d="M3 22s2-2 5-2 5 2 8 2 5-2 5-2"/>', 'Private & rooftop'],
        ['Concierge',         '<circle cx="12" cy="7" r="4"/><path d="M5 22v-2a7 7 0 0 1 14 0v2"/>',                                                'Hotel-grade service'],
        ['Smart Home',        '<path d="M3 12 12 3l9 9"/><path d="M5 10v10h14V10"/>',                                                              'Full automation'],
        ['Private Lift',      '<rect x="6" y="2" width="12" height="20" rx="2"/><path d="M9 9l3-3 3 3M9 15l3 3 3-3"/>',                          'Direct unit access'],
        ['Valet Parking',     '<path d="M5 17h14"/><path d="M6 11l1.5-4.5A2 2 0 0 1 9.4 5h5.2a2 2 0 0 1 1.9 1.5L18 11"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/>', '2-3 car bays'],
        ['Wellness Spa',      '<path d="M12 2v20"/><path d="M5 8c2 0 7 4 7 4s5-4 7-4"/><path d="M5 16c2 0 7 4 7 4s5-4 7-4"/>',                    'On-premise spa'],
      ] as [$name,$icon,$sub]): ?>
        <div class="va-lux-amenity">
          <div class="va-lux-amenity__icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><?= $icon ?></svg>
          </div>
          <strong><?= e($name) ?></strong>
          <span><?= e($sub) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- HIGHLIGHTS -->
<section style="padding-top:0">
  <div class="container-lg">
    <div class="grid cols-3" data-stagger>
      <?php foreach ([
        ['Discreet Access','Many of our finest listings are not advertised — we share inventory under NDA after a private brief.','<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>'],
        ['White-Glove Handover','We coordinate interiors, smart-home set-up, staffing and final inspection — so you move in to a finished home.','<path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5Z"/>'],
        ['Long-Term Asset','Beyond the buy: rental, leaseback, and resale strategy — your home stays an appreciating asset.','<polyline points="22 17 13.5 8.5 8.5 13.5 2 7"/><polyline points="16 17 22 17 22 11"/>'],
      ] as [$h,$p,$icon]): ?>
        <div class="va-pillar">
          <div class="va-pillar__icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><?= $icon ?></svg>
          </div>
          <h3><?= e($h) ?></h3>
          <p><?= e($p) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA -->
<section style="padding:30px 0 110px">
  <div class="container">
    <div class="va-cta-banner" data-reveal>
      <div class="va-cta-banner__bg" aria-hidden="true">
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1600&q=80" alt="" loading="lazy">
      </div>
      <div class="va-cta-banner__overlay"></div>
      <div class="va-cta-banner__content">
        <span class="eyebrow" style="color:var(--gold-2)">PRIVATE INVENTORY</span>
        <h2 class="display" style="font-size:clamp(28px,5vw,56px);margin:14px 0 16px;color:#fff;max-width:720px;margin-inline:auto">Access homes you <span style="color:var(--gold-2);font-style:italic">won't find online</span>.</h2>
        <p style="max-width:560px;margin:0 auto 28px;font-size:15.5px;line-height:1.7;color:rgba(255,255,255,0.78)">A 30-minute brief is the start of our luxury onboarding. We share three off-market matches within 48 hours.</p>
        <div class="flex gap-16" style="justify-content:center;flex-wrap:wrap">
          <a href="/contact" class="btn btn-gold">Request Off-Market Brief</a>
          <a href="https://wa.me/<?= e(config('app.brand.whatsapp')) ?>" class="btn" style="background:transparent;color:#fff;border-color:rgba(255,255,255,0.4)">WhatsApp the Desk</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php $view->endSection(); ?>
