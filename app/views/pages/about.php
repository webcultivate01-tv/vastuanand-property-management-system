<?php /** @var \App\Core\View $view */ $view->extend('layouts.main'); ?>
<?php $view->section('content'); ?>

<section style="padding:140px 0 60px;position:relative;overflow:hidden">
  <div style="position:absolute;inset:0;opacity:0.2"><img src="<?= asset('images/about-hero.jpg') ?>" onerror="this.src='https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1920&q=80'" style="width:100%;height:100%;object-fit:cover"></div>
  <div class="container" data-reveal style="position:relative">
    <span class="eyebrow">ABOUT US</span>
    <h1 class="display" style="font-size:clamp(48px,6vw,88px);margin:18px 0 22px;max-width:880px">A quietly powerful real estate firm built on <span class="gold" style="font-style:italic">trust, insight & discretion</span>.</h1>
    <p class="muted" style="max-width:680px;font-size:17px;line-height:1.8">Vastu Anand has helped 350+ families and investors find their right address in Mumbai over the last 4+ years. We exist for the discerning client who values clarity over noise.</p>
  </div>
</section>

<section>
  <div class="container">
    <div class="grid cols-2" style="gap:80px;align-items:center">
      <div data-reveal>
        <span class="eyebrow">OUR STORY</span>
        <h2 style="font-size:clamp(34px,4vw,52px);margin:18px 0 22px">Built for Mumbai's <span class="gold" style="font-style:italic">most discerning</span> clients.</h2>
        <p class="muted" style="line-height:1.8">Mumbai's real estate market rewards depth over noise. We started Vastu Anand because we saw too many buyers, sellers and NRIs being overwhelmed by opaque pricing, weak documentation and pushy sales tactics. We do the opposite — patient research, honest counsel, and a long-term relationship.</p>
        <p class="muted" style="line-height:1.8;margin-top:18px">Today, our practice spans luxury residential, Grade-A commercial, NRI advisory and end-to-end property management — anchored by an ethos that the right property, at the right price, at the right time, is the only deal worth doing.</p>
      </div>
      <div data-reveal data-reveal-delay="200" style="border-radius:24px;overflow:hidden;aspect-ratio:4/5">
        <img src="<?= asset('images/about-2.jpg') ?>" onerror="this.src='https://images.unsplash.com/photo-1582407947304-fd86f028f716?auto=format&fit=crop&w=900&q=80'" style="width:100%;height:100%;object-fit:cover">
      </div>
    </div>
  </div>
</section>

<section style="background:linear-gradient(180deg,var(--ink-2),var(--ink))">
  <div class="container">
    <div class="grid cols-3">
      <?php foreach ([
        ['Vision','To be Mumbai\'s most trusted real estate partner for transparent and insight-led property decisions.'],
        ['Mission','Deliver ethical, personalized and data-backed real estate solutions that simplify complexity and create lasting value.'],
        ['Values','Discretion. Depth. Discipline. We do fewer deals, more carefully — and we keep showing up for our clients long after closing.'],
      ] as $i => [$h,$p]): ?>
        <div class="va-service" data-reveal data-reveal-delay="<?= 100*$i ?>">
          <h3><?= e($h) ?></h3>
          <p class="muted" style="line-height:1.8"><?= e($p) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section>
  <div class="container">
    <div class="va-stats" data-reveal>
      <?php foreach ([['350+','Happy Clients'],['500+','Properties Listed'],['120+','Properties Sold'],['4+','Years of Excellence']] as [$v,$l]):
        preg_match('/(\d+)/', $v, $m); ?>
        <div class="va-stat">
          <div class="va-stat__val"><span data-counter="<?= $m[1] ?>" data-suffix="<?= str_replace($m[1],'',$v) ?>">0</span></div>
          <span class="va-stat__lbl"><?= e($l) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php $view->endSection(); ?>
