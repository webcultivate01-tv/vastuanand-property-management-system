<?php $view->extend('layouts.main'); $brand = config('app.brand'); ?>
<?php $view->section('content'); ?>

<section class="va-legal">
  <div class="container-lg">

    <header class="va-legal__hero" data-reveal>
      <span class="eyebrow">LEGAL</span>
      <h1>Terms &amp; <span class="gold">Conditions</span></h1>
      <p>The basic rules for using the <?= e($brand['name'] ?? 'Vastu Anand') ?> website and our real estate advisory services.</p>
      <span class="va-legal__updated">Last updated · 21 May 2026</span>
    </header>

    <article class="va-legal__content" style="margin:0 auto">

      <section class="va-legal__section">
        <ul>
          <li>By using <strong><?= e(parse_url(config('app.url') ?: 'https://vastuanandm.com', PHP_URL_HOST)) ?></strong> or engaging our services, you agree to these Terms and our <a href="/privacy">Privacy Policy</a>.</li>
          <li><?= e($brand['name'] ?? 'Vastu Anand') ?> acts as a real estate advisor and facilitator — we are not a party to your final agreement with the owner or developer.</li>
          <li>All prices, photos, configurations and availability on this site are indicative and may change without notice.</li>
          <li>You are expected to independently verify title, RERA registration, approvals and final commercial terms before any commitment.</li>
          <li>Browsing the website, an initial consultation and property recommendations are free; brokerage is payable only upon successful closure as per a signed engagement letter.</li>
          <li>You agree not to submit false enquiries, scrape our content, attempt unauthorised access or bypass our team to engage directly with sellers we introduce you to.</li>
          <li>All website content — text, images, logos and design — belongs to us and may not be reused without prior written permission.</li>
          <li>Our total liability under any engagement will not exceed the brokerage fee actually paid to us under that engagement.</li>
          <li>These Terms are governed by Indian law; the courts of Mumbai have exclusive jurisdiction over any dispute arising from them.</li>
        </ul>
      </section>

      <div class="va-legal__contact">
        <h3>Legal &amp; Compliance Desk</h3>
        <p><?= e($brand['legal_name'] ?? $brand['name'] ?? 'Vastu Anand Real Estate') ?></p>
        <div class="va-legal__contact-rows">
          <div><span class="va-legal__contact-label">Email</span> <a href="mailto:<?= e($brand['email'] ?? 'info@vastuanandm.com') ?>"><?= e($brand['email'] ?? 'info@vastuanandm.com') ?></a></div>
          <?php if (!empty($brand['phone'])): ?>
            <div><span class="va-legal__contact-label">Phone</span> <a href="tel:<?= e($brand['phone']) ?>"><?= e($brand['phone']) ?></a></div>
          <?php endif; ?>
          <?php if (!empty($brand['address'])): ?>
            <div><span class="va-legal__contact-label">Office</span> <?= e(implode(', ', (array)$brand['address'])) ?></div>
          <?php endif; ?>
          <?php if (!empty($brand['rera'])): ?>
            <div><span class="va-legal__contact-label">RERA</span> <?= e($brand['rera']) ?></div>
          <?php endif; ?>
        </div>
      </div>

    </article>

  </div>
</section>

<?php $view->endSection(); ?>
