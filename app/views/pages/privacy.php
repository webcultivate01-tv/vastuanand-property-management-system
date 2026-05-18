<?php $view->extend('layouts.main'); ?>
<?php $view->section('content'); ?>
<section style="padding:140px 0 100px">
  <div class="container" style="max-width:880px" data-reveal>
    <span class="eyebrow">LEGAL</span>
    <h1 class="display" style="font-size:clamp(36px,4.5vw,60px);margin:18px 0 30px">Privacy Policy</h1>
    <div class="muted" style="line-height:1.9;font-size:15px">
      <p>This Privacy Policy describes how Vastu Anand collects, uses and protects information that you provide while using vastuanandm.com. We are committed to ensuring your privacy is protected.</p>
      <h3 style="color:var(--gold);margin-top:32px">Information we collect</h3>
      <p>Name, contact details (phone, email, WhatsApp), property preferences, budget range and any messages you submit through our forms or chatbot.</p>
      <h3 style="color:var(--gold);margin-top:32px">How we use your information</h3>
      <p>To respond to enquiries, schedule property viewings, send relevant property recommendations and improve our services. We never sell or share your data with third parties for marketing.</p>
      <h3 style="color:var(--gold);margin-top:32px">Cookies</h3>
      <p>We use essential cookies for site functionality and analytics cookies (anonymised) to understand visitor behaviour.</p>
      <h3 style="color:var(--gold);margin-top:32px">Contact</h3>
      <p>Questions about this policy? Email <a href="mailto:<?= e(config('app.brand.email')) ?>" class="gold"><?= e(config('app.brand.email')) ?></a>.</p>
    </div>
  </div>
</section>
<?php $view->endSection(); ?>
