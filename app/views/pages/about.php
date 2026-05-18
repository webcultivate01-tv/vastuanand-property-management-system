<?php /** @var \App\Core\View $view */ $view->extend('layouts.main'); ?>
<?php $view->section('content'); ?>

<!-- ═══════════ HERO (image collage) ═══════════ -->
<section class="va-about-hero va-about-hero--collage">
  <div class="va-about-hero__bg-blur" aria-hidden="true">
    <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1600&q=70" alt="" loading="eager">
  </div>

  <div class="container va-about-hero__inner">
    <div class="va-about-hero__copy" data-reveal="left">
      <div class="va-about-hero__crumb-top">
        <a href="/">Home</a><span>›</span><strong>About</strong>
      </div>
      <span class="eyebrow va-about-hero__eyebrow">ABOUT VASTU ANAND</span>
      <h1 class="display">
        A quietly powerful real estate firm built on
        <span class="gold">trust, insight &amp; discretion</span>.
      </h1>
      <p class="lede">
        We've helped 350+ families and investors find their right address in Mumbai over four years. Built for the discerning client who values clarity over noise.
      </p>
      <div class="va-about-hero__cta">
        <a href="/properties" class="va-cta">Browse Portfolio
          <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
        </a>
        <a href="/contact" class="va-cta va-cta--ghost">Talk to an Advisor</a>
      </div>

      <div class="va-about-hero__chips">
        <div class="va-about-hero__chip">
          <strong>RERA</strong><span>Verified</span>
        </div>
        <div class="va-about-hero__chip">
          <strong>4.9★</strong><span>Client rating</span>
        </div>
        <div class="va-about-hero__chip">
          <strong>120+</strong><span>Properties sold</span>
        </div>
      </div>
    </div>

    <div class="va-about-hero__collage" data-reveal="right" data-reveal-delay="150">
      <div class="va-about-hero__tile va-about-hero__tile--main">
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=900&q=80"
             alt="Luxury apartment interior" loading="lazy">
      </div>
      <div class="va-about-hero__tile va-about-hero__tile--sec">
        <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=600&q=80"
             alt="Modern living room" loading="lazy">
      </div>
      <div class="va-about-hero__tile va-about-hero__tile--ter">
        <img src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=600&q=80"
             alt="Vastu Anand advisor" loading="lazy">
      </div>

      <div class="va-about-hero__sticker">
        <div class="va-about-hero__sticker-ring">
          <svg viewBox="0 0 100 100" aria-hidden="true">
            <defs>
              <path id="aboutCircle" d="M 50 50 m -38 0 a 38 38 0 1 1 76 0 a 38 38 0 1 1 -76 0"/>
            </defs>
            <text font-size="9.2" font-weight="600" letter-spacing="2" fill="currentColor">
              <textPath href="#aboutCircle">CRAFTED IN MUMBAI · TRUSTED ACROSS INDIA · </textPath>
            </text>
          </svg>
          <div class="va-about-hero__sticker-core">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
          </div>
        </div>
      </div>

      <div class="va-about-hero__stat">
        <strong>350<span>+</span></strong>
        <span class="lbl">Happy Mumbai clients</span>
      </div>
    </div>
  </div>

  <div class="va-about-hero__divider" aria-hidden="true"></div>
</section>

<!-- ═══════════ STORY (split) ═══════════ -->
<section class="va-story">
  <div class="container">
    <div class="grid cols-2 va-story__grid">
      <div data-reveal="left" class="va-story__media">
        <div class="va-story__img-1">
          <img src="https://images.unsplash.com/photo-1582407947304-fd86f028f716?auto=format&fit=crop&w=900&q=80"
               alt="Modern Mumbai apartment" loading="lazy">
        </div>
        <div class="va-story__img-2">
          <img src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=600&q=80"
               alt="Advisor conversation" loading="lazy">
        </div>
        <div class="va-story__floating">
          <strong>4+</strong>
          <span>Years building Mumbai's most trusted advisory</span>
        </div>
      </div>

      <div data-reveal="right" data-reveal-delay="150">
        <span class="eyebrow">OUR STORY</span>
        <h2 class="va-story__h">Built for Mumbai's <span class="gold">most discerning</span> clients.</h2>
        <p class="muted va-story__p">
          Mumbai's real estate market rewards depth over noise. We started Vastu Anand because we saw too many buyers, sellers and NRIs overwhelmed by opaque pricing, weak documentation and pushy sales tactics. We do the opposite — patient research, honest counsel, and a long-term relationship.
        </p>
        <p class="muted va-story__p">
          Today, our practice spans luxury residential, Grade-A commercial, NRI advisory and end-to-end property management — anchored by an ethos that the <em>right property, at the right price, at the right time</em> is the only deal worth doing.
        </p>

        <div class="va-story__bullets">
          <div>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            <div><strong>Patient research</strong><span>Months of micro-market study before every recommendation</span></div>
          </div>
          <div>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            <div><strong>Transparent pricing</strong><span>No hidden brokerage, no inflated comps, no surprises</span></div>
          </div>
          <div>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            <div><strong>Lifetime relationships</strong><span>Most of our clients return for their next property</span></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════ STATS BAND ═══════════ -->
<section class="va-about-stats">
  <div class="container">
    <div class="va-stats" data-reveal>
      <?php foreach ([
        ['350+','Happy Clients'],
        ['500+','Properties Listed'],
        ['120+','Properties Sold'],
        ['4+','Years of Excellence'],
      ] as [$v,$l]):
        preg_match('/(\d+)/', $v, $m); ?>
        <div class="va-stat">
          <div class="va-stat__val"><span data-counter="<?= $m[1] ?>" data-suffix="<?= str_replace($m[1],'',$v) ?>">0</span></div>
          <span class="va-stat__lbl"><?= e($l) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════ VISION · MISSION · VALUES ═══════════ -->
<section style="background:var(--surface-2)">
  <div class="container-lg">
    <?php $view->include('components.section-head', [
      'eyebrow' => 'WHAT GUIDES US',
      'heading' => 'Our <span class="gold">North Star</span>',
      'sub'     => 'A simple framework that has shaped every recommendation we have ever made.'
    ]); ?>

    <div class="va-pillars">
      <?php
      $pillars = [
        ['Vision',  'To be Mumbai\'s most trusted real estate partner for transparent and insight-led property decisions.',                       'eye'],
        ['Mission', 'Deliver ethical, personalized and data-backed real estate solutions that simplify complexity and create lasting value.',     'target'],
        ['Values',  'Discretion. Depth. Discipline. We do fewer deals, more carefully — and we keep showing up long after closing.',              'gem'],
      ];
      $icons = [
        'eye'    => '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>',
        'target' => '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>',
        'gem'    => '<path d="M6 3h12l4 6-10 13L2 9l4-6z"/><path d="M11 3 8 9l4 13 4-13-3-6"/><path d="M2 9h20"/>',
      ];
      foreach ($pillars as $i => [$title, $body, $ic]):
      ?>
        <div class="va-pillar" data-reveal data-reveal-delay="<?= 100 * $i ?>">
          <div class="va-pillar__num"><?= str_pad($i+1, 2, '0', STR_PAD_LEFT) ?></div>
          <div class="va-pillar__icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><?= $icons[$ic] ?></svg>
          </div>
          <h3><?= e($title) ?></h3>
          <p><?= e($body) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════ TIMELINE / JOURNEY ═══════════ -->
<section>
  <div class="container">
    <?php $view->include('components.section-head', [
      'eyebrow' => 'OUR JOURNEY',
      'heading' => 'Four Years, <span class="gold">350+ Stories</span>',
      'sub'     => 'Milestones from a quietly compounding practice across Mumbai\'s most coveted micro-markets.'
    ]); ?>

    <div class="va-timeline">
      <?php
      $milestones = [
        ['2021', 'Founded in Mumbai', 'Vastu Anand opens its doors with a single Bandra-focused mandate and a small founding team.'],
        ['2022', 'First 100 transactions', 'Crossed 100 successful property transactions across luxury residential and rental segments.'],
        ['2023', 'Expanded to BKC & Worli', 'Added Grade-A commercial advisory and grew into Mumbai\'s premier business districts.'],
        ['2024', 'NRI desk launched', 'Dedicated NRI service line for end-to-end virtual property purchase and management.'],
        ['2025', '350+ clients served', 'Today, we partner with discerning families, investors and corporates across Maharashtra.'],
      ];
      foreach ($milestones as $i => [$year, $title, $body]):
      ?>
        <div class="va-timeline__item" data-reveal="<?= $i % 2 === 0 ? 'left' : 'right' ?>" data-reveal-delay="<?= 60 * $i ?>">
          <div class="va-timeline__year"><?= e($year) ?></div>
          <div class="va-timeline__body">
            <h4><?= e($title) ?></h4>
            <p><?= e($body) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════ FOUNDER / LEADERSHIP ═══════════ -->
<section style="background:var(--surface-2)">
  <div class="container-lg">
    <?php $view->include('components.section-head', [
      'eyebrow' => 'LEADERSHIP',
      'heading' => 'The People Behind <span class="gold">Vastu Anand</span>',
      'sub'     => 'A small senior team that personally handles every consultation.'
    ]); ?>

    <div class="grid cols-3 va-team">
      <?php
      $team = [
        ['Mr. Anand',    'Founder &amp; Principal Advisor',  'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=600&q=80', '15+ years in Mumbai real estate, specializing in luxury residential and HNI advisory.'],
        ['Mrs. Priya',   'Head of Client Experience',         'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=600&q=80', 'Leads our NRI desk and end-to-end concierge service for international clients.'],
        ['Mr. Rohan',    'Director, Commercial &amp; Investments','https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=600&q=80','Grade-A commercial leasing and investment-grade portfolio construction across BKC.'],
      ];
      foreach ($team as $i => [$n,$role,$img,$bio]):
      ?>
        <div class="va-team__member" data-reveal data-reveal-delay="<?= 100 * $i ?>">
          <div class="va-team__photo">
            <img src="<?= $img ?>" alt="<?= e($n) ?>" loading="lazy">
          </div>
          <h4><?= $n ?></h4>
          <div class="va-team__role"><?= $role ?></div>
          <p><?= $bio ?></p>
        </div>
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
        <h2 class="display" style="font-size:clamp(32px,4.5vw,54px);margin:16px 0 18px;color:#fff;max-width:680px;margin-inline:auto">
          Have a property question? <span style="color:var(--gold-2)">We'd love to listen.</span>
        </h2>
        <p style="max-width:560px;margin:0 auto 28px;font-size:15px;line-height:1.7;color:rgba(255,255,255,0.78)">
          Book a complimentary consultation — buying, selling, leasing or investing. We'll take the time to understand your goals before we recommend anything.
        </p>
        <div class="flex gap-16" style="justify-content:center;flex-wrap:wrap">
          <a href="/contact" class="btn btn-gold">Book Consultation</a>
          <a href="https://wa.me/<?= e(config('app.brand.whatsapp')) ?>" class="btn" style="background:transparent;color:#fff;border-color:rgba(255,255,255,0.4)">WhatsApp Us</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php $view->endSection(); ?>
