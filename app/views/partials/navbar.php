<?php $current = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH); ?>
<nav class="va-nav" id="vaNav">
  <div class="container-lg va-nav__inner">
    <a href="/" class="va-brand">
      <span class="va-brand__monogram">Va</span>
      <span class="va-brand__text">
        <strong>Vastu Anand</strong>
        <span>Luxury Real Estate · Mumbai</span>
      </span>
    </a>

    <div class="va-menu">
      <?php
      $links = [
        '/' => 'Home',
        '/about' => 'About',
        '/properties' => 'Properties',
        '/services' => 'Services',
        '/luxury-homes' => 'Luxury Homes',
        '/blog' => 'Blog',
        '/contact' => 'Contact',
      ];
      foreach ($links as $href => $label):
      ?>
        <a href="<?= $href ?>" class="<?= $current === $href ? 'active' : '' ?>"><?= $label ?></a>
      <?php endforeach; ?>
    </div>

    <div class="flex items-center gap-16">
      <a href="tel:<?= e(config('app.brand.phone')) ?>" class="va-cta va-cta--ghost hide-mobile">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
        Call Now
      </a>
      <a href="/contact" class="va-cta hide-mobile">Book Consultation</a>
      <div class="va-burger" id="vaBurger"><span></span><span></span><span></span></div>
    </div>
  </div>
</nav>

<div class="va-mobile" id="vaMobile">
  <?php foreach ($links as $href => $label): ?>
    <a href="<?= $href ?>"><?= $label ?></a>
  <?php endforeach; ?>
  <div style="margin-top:32px;display:flex;gap:12px;flex-wrap:wrap">
    <a href="tel:<?= e(config('app.brand.phone')) ?>" class="va-cta va-cta--ghost" style="flex:1;justify-content:center">Call Now</a>
    <a href="/contact" class="va-cta" style="flex:1;justify-content:center">Book Consultation</a>
  </div>
</div>
