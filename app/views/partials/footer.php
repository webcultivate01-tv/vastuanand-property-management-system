<?php $brand = config('app.brand'); ?>
<footer class="va-footer">
  <div class="container-lg">
    <div class="va-footer__grid">
      <div>
        <a href="/" class="va-brand">
          <span class="va-brand__monogram">Va</span>
          <span class="va-brand__text">
            <strong>Vastu Anand</strong>
            <span>Luxury Real Estate · Mumbai</span>
          </span>
        </a>
        <p class="muted" style="margin-top:22px;font-size:14px;line-height:1.8;max-width:380px">
          Mumbai's trusted real estate partner for transparent, insight-led property decisions across Bandra, Powai, BKC, Juhu, Thane &amp; Navi Mumbai. RERA-verified listings, zero-brokerage assistance and a dedicated NRI desk.
        </p>
        <form data-ajax action="/newsletter" method="post" class="va-newsletter" style="margin-top:28px;max-width:380px">
          <input type="email" name="email" placeholder="Your email address" required>
          <button type="submit">Subscribe</button>
        </form>
      </div>

      <div>
        <h5>Explore</h5>
        <ul>
          <li><a href="/about">About Us</a></li>
          <li><a href="/properties">Properties</a></li>
          <li><a href="/services">Services</a></li>
          <li><a href="/luxury-homes">Luxury Homes</a></li>
          <li><a href="/nri">NRI Services</a></li>
          <li><a href="/blog">Blog</a></li>
          <li><a href="/careers">Careers</a></li>
        </ul>
      </div>

      <div>
        <h5>Quick Links</h5>
        <ul>
          <li><a href="/properties/buy">Buy a Property</a></li>
          <li><a href="/properties/rent">Rent a Property</a></li>
          <li><a href="/commercial">Commercial Real Estate</a></li>
          <li><a href="/property-management">Property Management</a></li>
          <li><a href="/faq">FAQs</a></li>
          <li><a href="/privacy">Privacy Policy</a></li>
          <li><a href="/terms">Terms &amp; Conditions</a></li>
        </ul>
      </div>

      <div>
        <h5>Connect</h5>
        <ul>
          <li class="flex items-center gap-8">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
            <a href="tel:<?= e($brand['phone']) ?>"><?= e($brand['phone']) ?></a>
          </li>
          <li class="flex items-center gap-8">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2Z"/><polyline points="22,6 12,13 2,6"/></svg>
            <a href="mailto:<?= e($brand['email']) ?>"><?= e($brand['email']) ?></a>
          </li>
          <li class="flex items-center gap-8" style="align-items:flex-start">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-top:4px"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>
            <span><?= e($brand['address'][0]) ?><br><?= e($brand['address'][1]) ?><br><?= e($brand['address'][2]) ?></span>
          </li>
        </ul>
        <div class="va-socials" style="margin-top:24px">
          <a href="<?= e($brand['social']['facebook']) ?>" aria-label="Facebook"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12Z"/></svg></a>
          <a href="<?= e($brand['social']['instagram']) ?>" aria-label="Instagram"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37Z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></a>
          <a href="<?= e($brand['social']['linkedin']) ?>" aria-label="LinkedIn"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M20.45 20.45h-3.55v-5.57c0-1.33-.03-3.03-1.85-3.03-1.85 0-2.13 1.45-2.13 2.94v5.66H9.36V9h3.41v1.56h.05c.48-.9 1.64-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28zM5.34 7.43a2.06 2.06 0 1 1 0-4.12 2.06 2.06 0 0 1 0 4.12zM7.12 20.45H3.56V9h3.56v11.45z"/></svg></a>
          <a href="<?= e($brand['social']['youtube']) ?>" aria-label="YouTube"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M21.58 7.19a2.51 2.51 0 0 0-1.77-1.77C18.25 5 12 5 12 5s-6.25 0-7.81.42A2.51 2.51 0 0 0 2.42 7.19 26.21 26.21 0 0 0 2 12a26.21 26.21 0 0 0 .42 4.81 2.51 2.51 0 0 0 1.77 1.77C5.75 19 12 19 12 19s6.25 0 7.81-.42a2.51 2.51 0 0 0 1.77-1.77A26.21 26.21 0 0 0 22 12a26.21 26.21 0 0 0-.42-4.81ZM10 15V9l5.2 3Z"/></svg></a>
        </div>
      </div>
    </div>

    <div class="va-footer__bottom">
      <div>© <?= date('Y') ?> <?= e($brand['legal_name']) ?>. All rights reserved.</div>
      <div>RERA: <?= e($brand['rera']) ?> &nbsp;·&nbsp; GSTIN: <?= e($brand['gst']) ?></div>
    </div>
  </div>
</footer>
