<?php /** @var \App\Core\View $view */ $view->extend('layouts.main'); ?>
<?php $view->section('content'); ?>

<section style="padding:140px 0 60px">
  <div class="container" data-reveal>
    <span class="eyebrow">OUR SERVICES</span>
    <h1 class="display" style="font-size:clamp(44px,5vw,72px);margin:18px 0 18px">Real Estate Services in <span class="gold" style="font-style:italic">Mumbai</span></h1>
    <p class="muted" style="max-width:720px;font-size:17px;line-height:1.8">Comprehensive end-to-end services — from acquisition and disposition to ongoing management. Every engagement is led by a senior advisor with deep local knowledge.</p>
  </div>
</section>

<section style="padding-top:0">
  <div class="container-lg">
    <div class="grid cols-2" style="gap:28px">
      <?php
      $svcs = [
        ['property-buying','Property Buying','Find and acquire your dream home in Mumbai\'s prime locations.', ['Curated property shortlist','RERA-verified listings','Site visits coordinated','Price negotiation','Legal & documentation','Loan & finance support']],
        ['property-selling','Property Selling','Sell at the right price, in the right time, to the right buyer.', ['Free professional valuation','Premium marketing','Verified buyer screening','Negotiation expertise','Paperwork & registration','Tax & capital-gains advisory']],
        ['property-consultation','Property Consultation','Make confident property decisions with expert advisors.', ['Investment strategy','Micro-market analysis','Builder due-diligence','Rental yield projection','Vastu compatibility','Personalised roadmap']],
        ['rental-services','Rental & Management','Premium rentals & full property management.', ['Verified tenant screening','Rental agreements','Property handover','Maintenance coordination','Renewal & vacate support','NRI landlord services']],
      ];
      foreach ($svcs as $i => [$slug,$title,$hero,$features]): ?>
        <div class="va-service" data-reveal data-reveal-delay="<?= 100*$i ?>">
          <h3><?= e($title) ?></h3>
          <p class="muted" style="margin-top:10px;line-height:1.7"><?= e($hero) ?></p>
          <ul style="list-style:none;padding:0;margin:22px 0 0">
            <?php foreach ($features as $f): ?>
              <li style="display:flex;align-items:center;gap:10px;padding:7px 0;color:var(--pearl-dim);font-size:14px">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#C9A35B" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                <?= e($f) ?>
              </li>
            <?php endforeach; ?>
          </ul>
          <a href="/services/<?= e($slug) ?>" class="va-link-arrow" style="margin-top:22px">Learn more
            <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php $view->endSection(); ?>
