<?php $view->extend('layouts.main'); $brand = config('app.brand'); ?>
<?php $view->section('content'); ?>

<section class="va-legal">
  <div class="container-lg">

    <header class="va-legal__hero" data-reveal>
      <span class="eyebrow">LEGAL</span>
      <h1>Privacy <span class="gold">Policy</span></h1>
      <p>How <?= e($brand['name'] ?? 'Vastu Anand') ?> collects, uses and protects your information.</p>
      <span class="va-legal__updated">Last updated · 21 May 2026</span>
    </header>

    <article class="va-legal__content" style="margin:0 auto">

      <section class="va-legal__section">
        <ul>
          <li>We collect basic details — your name, phone number, email and property preferences — when you contact us or submit an enquiry.</li>
          <li>Limited technical data such as IP address, browser type and pages visited is logged to keep the website secure.</li>
          <li>Your information is used only to respond to enquiries, recommend properties, schedule visits and complete due diligence.</li>
          <li>We never sell or rent your data to third parties.</li>
          <li>Data is shared only with property owners, trusted service providers or authorities when strictly necessary.</li>
          <li>We use HTTPS, hashed passwords and access controls to keep your records secure.</li>
          <li>Records are retained only for as long as needed or as required by Indian law.</li>
          <li>You may request access, correction or deletion of your data, and opt out of marketing anytime by emailing <a href="mailto:<?= e($brand['email'] ?? 'info@vastuanandm.com') ?>"><?= e($brand['email'] ?? 'info@vastuanandm.com') ?></a>.</li>
          <li>This policy may be revised from time to time; the date above reflects the latest version.</li>
        </ul>
      </section>

      <div class="va-legal__contact">
        <h3>Grievance Officer</h3>
        <p><?= e($brand['legal_name'] ?? $brand['name'] ?? 'Vastu Anand Real Estate') ?></p>
        <div class="va-legal__contact-rows">
          <div><span class="va-legal__contact-label">Email</span> <a href="mailto:<?= e($brand['email'] ?? 'info@vastuanandm.com') ?>"><?= e($brand['email'] ?? 'info@vastuanandm.com') ?></a></div>
          <?php if (!empty($brand['phone'])): ?>
            <div><span class="va-legal__contact-label">Phone</span> <a href="tel:<?= e($brand['phone']) ?>"><?= e($brand['phone']) ?></a></div>
          <?php endif; ?>
          <?php if (!empty($brand['address'])): ?>
            <div><span class="va-legal__contact-label">Office</span> <?= e(implode(', ', (array)$brand['address'])) ?></div>
          <?php endif; ?>
        </div>
      </div>

    </article>

  </div>
</section>

<?php $view->endSection(); ?>
