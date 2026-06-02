<?php $view->extend('layouts.main'); ?>
<?php $view->section('content'); ?>

<!-- HERO — Editorial split (cream + gold frame + floating stat) -->
<section class="va-lux-hero">
  <div class="container-lg">
    <div class="va-lux-hero__grid">
      <div class="va-lux-hero__copy" data-reveal="left">
        <div class="va-lux-hero__crumb">
          <a href="/">Home</a>
          <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
          <strong>Luxury Homes</strong>
        </div>

        <span class="eyebrow">CURATED · OFF-MARKET · NDA-PROTECTED</span>

        <h1>Mumbai's most <span class="accent">prestigious</span> addresses, privately shown.</h1>

        <p class="lede">
          Sea-facing penthouses, private villas and branded sky-residences across Bandra, Worli,
          Juhu and Malabar Hill — curated for clients who recognise true rarity.
        </p>

        <div class="va-lux-hero__cta">
          <a href="/properties?type=Villa" class="va-cta va-cta--gold">Browse Luxury Homes
            <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
          </a>
          <a href="/contact" class="va-cta va-cta--ghost">Schedule a Private Showing</a>
        </div>

        <div class="va-lux-hero__chips">
          <span>Off-market access</span>
          <span>Pre-launch inventory</span>
          <span>Concierge handover</span>
          <span>NDA-protected viewings</span>
        </div>
      </div>

      <div class="va-lux-hero__media" data-reveal="right">
        <span class="va-lux-hero__tag">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
          Featured Residence
        </span>
        <div class="va-lux-hero__media-frame">
          <img src="<?= asset('images/luxury.jpg') ?>" alt="Luxury Mumbai residence" loading="eager"
               onerror="this.src='https://images.unsplash.com/photo-1613977257592-4871e5fcd7c4?auto=format&fit=crop&w=1200&q=80'">
        </div>
        <div class="va-lux-hero__floater">
          <div>
            <div class="num">42<em>+</em></div>
            <small>Off-market listings</small>
          </div>
          <div class="bar"></div>
          <div>
            <div class="num">₹4–80<em>Cr</em></div>
            <small>Price band</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- TRUST STRIP -->
<section style="padding:30px 0 10px">
  <div class="container-lg">
    <div class="va-lux-amenities" data-stagger style="grid-template-columns:repeat(2,1fr)">
      <?php foreach ([
        ['12+ Yrs', 'Boutique luxury practice'],
        ['₹2,400 Cr+', 'Lifetime closed value'],
        ['180+', 'High-net-worth clients'],
        ['48 Hrs', 'Avg. brief-to-shortlist'],
      ] as [$num,$sub]): ?>
        <div class="va-lux-amenity">
          <strong style="font-size:22px;color:var(--gold-deep);letter-spacing:-0.01em"><?= e($num) ?></strong>
          <span><?= e($sub) ?></span>
        </div>
      <?php endforeach; ?>
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
        ['Sea-Facing Penthouses','Sky-high duplexes with uninterrupted Arabian Sea views.','https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=900&q=80','Penthouse'],
        ['Private Villas','Gated villa communities with private pools and gardens.','https://images.unsplash.com/photo-1613977257592-4871e5fcd7c4?auto=format&fit=crop&w=900&q=80','Villa'],
        ['Sky Residences','Branded high-floor apartments with hotel-style services.','https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=900&q=80','Apartment'],
        ['Limited Editions','Single-floor and twin-tower releases — rarely on the open market.','https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=900&q=80','Penthouse'],
        ['Branded Residences','Four Seasons, Ritz-Carlton and Trump-branded inventory.','https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?auto=format&fit=crop&w=900&q=80','Apartment'],
        ['Heritage Bungalows','Bandra & Malabar Hill villas with restored colonial detailing.','https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=900&q=80','Villa'],
      ];
      foreach ($cats as $i => [$name,$desc,$img,$type]): ?>
        <a href="/properties?type=<?= e($type) ?>" class="va-lux-cat">
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
          <img src="https://images.unsplash.com/photo-1613977257592-4871e5fcd7c4?auto=format&fit=crop&w=1200&q=80" alt="Featured luxury residence" loading="lazy">
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

<!-- HIGHLIGHTS / PILLARS -->
<section style="padding-top:0">
  <div class="container-lg">
    <div class="va-pillars" data-stagger>
      <?php foreach ([
        ['Discreet Access','Many of our finest listings are not advertised — we share inventory under NDA after a private brief.','<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>'],
        ['White-Glove Handover','We coordinate interiors, smart-home set-up, staffing and final inspection — so you move in to a finished home.','<path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5Z"/>'],
        ['Long-Term Asset','Beyond the buy: rental, leaseback, and resale strategy — your home stays an appreciating asset.','<polyline points="22 17 13.5 8.5 8.5 13.5 2 7"/><polyline points="16 17 22 17 22 11"/>'],
      ] as $i => [$h,$p,$icon]): ?>
        <div class="va-pillar">
          <span class="va-pillar__num"><?= str_pad((string)($i+1), 2, '0', STR_PAD_LEFT) ?></span>
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
<section class="va-cta-section--full">
  <div class="va-cta-banner va-cta-banner--full" data-reveal>
    <div class="va-cta-banner__bg" aria-hidden="true">
      <img src="https://images.unsplash.com/photo-1613977257592-4871e5fcd7c4?auto=format&fit=crop&w=1800&q=80" alt="" loading="lazy">
    </div>
    <div class="va-cta-banner__overlay"></div>
    <div class="va-cta-banner__glow" aria-hidden="true"></div>

    <div class="va-cta-banner__content">
      <span class="va-cta-banner__eyebrow">
        <span class="va-cta-banner__dot"></span>
        PRIVATE INVENTORY
      </span>

      <h2 class="va-cta-banner__heading">
        Access homes you <span class="va-cta-banner__accent">won't find online</span>.
      </h2>

      <p class="va-cta-banner__lede">
        A 30-minute brief is the start of our luxury onboarding. We share three curated off-market matches within 48 hours — shown privately, priced honestly.
      </p>

      <div class="va-cta-banner__actions">
        <a href="/contact" class="va-cta-banner__btn va-cta-banner__btn--gold">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          Request Off-Market Brief
        </a>
        <a href="https://wa.me/<?= e(config('app.brand.whatsapp')) ?>" target="_blank" rel="noopener" class="va-cta-banner__btn va-cta-banner__btn--ghost">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M20.5 3.5A11 11 0 0 0 3 17.2L1.5 22.5l5.4-1.4A11 11 0 1 0 20.5 3.5ZM12 20a8 8 0 0 1-4.1-1.1l-.3-.2-3.2.8.9-3.2-.2-.3a8 8 0 1 1 6.9 4Zm4.5-6c-.2-.1-1.4-.7-1.6-.8-.2-.1-.4-.1-.5.1l-.7.9c-.1.2-.3.2-.5.1a6.5 6.5 0 0 1-3.2-2.8c-.2-.4.2-.4.6-1.2 0-.2 0-.3-.1-.4l-.7-1.7c-.2-.4-.4-.4-.5-.4h-.5a1 1 0 0 0-.7.3 3 3 0 0 0-.9 2.2c0 1.3 1 2.6 1.1 2.8.1.2 1.9 3 4.7 4.2 1.7.7 2.3.7 3.1.6.5-.1 1.4-.6 1.6-1.1.2-.6.2-1 .1-1.1Z"/></svg>
          WhatsApp the Desk
        </a>
        <a href="tel:<?= e(config('app.brand.phone')) ?>" class="va-cta-banner__btn va-cta-banner__btn--ghost">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
          Call Now
        </a>
      </div>

      <div class="va-cta-banner__trust">
        <div class="va-cta-banner__trust-item">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          <div><strong>NDA-Protected</strong><span>Private viewings</span></div>
        </div>
        <div class="va-cta-banner__trust-item">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          <div><strong>48-Hr Shortlist</strong><span>Brief to matches</span></div>
        </div>
        <div class="va-cta-banner__trust-item">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
          <div><strong>Off-Market Access</strong><span>180+ HNI clients</span></div>
        </div>
        <div class="va-cta-banner__trust-item">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5Z"/></svg>
          <div><strong>Concierge Handover</strong><span>White-glove close</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php $view->endSection(); ?>
