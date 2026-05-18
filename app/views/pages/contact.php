<?php $view->extend('layouts.main'); $brand = config('app.brand'); ?>
<?php $view->section('content'); ?>

<section class="va-hero-contact">
  <div class="container-lg">
    <div class="va-hero-contact__inner">
      <div class="va-hero-contact__copy" data-reveal="left">
        <div class="va-h-crumb">
          <a href="/">Home</a> <span>/</span> <strong>Contact</strong>
        </div>
        <span class="eyebrow" style="margin-top:22px">GET IN TOUCH</span>
        <h1>Let's start a <span class="va-h-accent">conversation</span>.</h1>
        <p class="lede">Schedule a consultation, request a property viewing, or simply ask a question. We respond on WhatsApp within 15 minutes during business hours.</p>

        <div class="va-hero-contact__status">
          <span class="dot"></span>
          Advisors online · responding now
        </div>
      </div>

      <div data-reveal="right">
        <div class="va-hero-contact__media">
          <div class="va-hero-contact__media-tile va-hero-contact__media-tile--main">
            <img loading="lazy" src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=900&q=80" alt="Vastu Anand consultation lounge">
          </div>
          <div class="va-hero-contact__media-tile va-hero-contact__media-tile--sub">
            <img loading="lazy" src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&w=800&q=80" alt="Advisor with client">
          </div>

          <div class="va-hero-contact__badge">
            <span class="ic">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
            </span>
            <div>
              <strong>Senior advisor</strong>
              <span>On every conversation</span>
            </div>
          </div>

          <div class="va-hero-contact__stat">
            <strong>15<em>min</em></strong>
            <span>WhatsApp reply</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section style="padding:30px 0 60px">
  <div class="container-lg">
    <div class="va-contact-grid">

      <!-- LEFT: FORM -->
      <div data-reveal="left">
        <div class="va-contact-form">
          <?php if (!empty($_GET['sent'])): ?>
            <div class="va-contact-flash">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              Thank you. Our team will reach out within 24 hours.
            </div>
          <?php endif; ?>
          <h2>Send a message</h2>
          <p class="lede">Tell us what you're looking for. A senior advisor will respond shortly with curated next steps.</p>

          <form action="/contact" method="post" class="va-floating-form">
            <?= csrf_field() ?>

            <div class="va-contact-form__row">
              <div class="va-input">
                <input type="text" name="name" id="cf-name" placeholder=" " required>
                <label for="cf-name">Full Name</label>
              </div>
              <div class="va-input">
                <input type="tel" name="phone" id="cf-phone" placeholder=" " required>
                <label for="cf-phone">Phone Number</label>
              </div>
            </div>

            <div class="va-contact-form__row" style="grid-template-columns:1fr">
              <div class="va-input">
                <input type="email" name="email" id="cf-email" placeholder=" " required>
                <label for="cf-email">Email Address</label>
              </div>
            </div>

            <div class="va-contact-form__row" style="grid-template-columns:1fr;margin-top:16px">
              <div class="va-input has-value">
                <select name="subject" id="cf-subject">
                  <option>General Consultation</option>
                  <option>Buying Property</option>
                  <option>Renting Property</option>
                  <option>Selling Property</option>
                  <option>NRI Services</option>
                  <option>Commercial Real Estate</option>
                  <option>Investment Consultation</option>
                </select>
                <label for="cf-subject">I'm interested in</label>
              </div>
            </div>

            <div class="va-contact-form__row" style="grid-template-columns:1fr;margin-top:16px">
              <div class="va-input">
                <textarea name="message" id="cf-message" placeholder=" " required rows="5"></textarea>
                <label for="cf-message">Your message</label>
              </div>
            </div>

            <button type="submit" class="va-contact-form__submit">
              Send Message
              <svg width="16" height="14" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
            </button>
            <p style="text-align:center;font-size:12px;color:var(--slate-2);margin:12px 0 0">By submitting you agree to our <a href="/privacy" class="gold">privacy policy</a>.</p>
          </form>
        </div>
      </div>

      <!-- RIGHT: INFO -->
      <div class="va-contact-info" data-reveal="right">
        <h2>Reach out to our experts</h2>
        <p class="lede">We're here on phone, email and WhatsApp during business hours — and via this form 24/7.</p>

        <?php foreach ([
          ['Phone',    $brand['phone'], 'tel:' . $brand['phone'],
           '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92Z"/>'],
          ['Email',    $brand['email'], 'mailto:' . $brand['email'],
           '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2Z"/><polyline points="22,6 12,13 2,6"/>'],
          ['WhatsApp', '+91 ' . substr($brand['whatsapp'],2,5) . ' ' . substr($brand['whatsapp'],-5), 'https://wa.me/' . $brand['whatsapp'],
           '<path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5Z"/>'],
        ] as $i => [$label, $value, $link, $iconPath]): ?>
          <a href="<?= e($link) ?>" class="va-contact-card" data-reveal data-reveal-delay="<?= 80 * $i ?>">
            <div class="va-contact-card__icon">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?= $iconPath ?></svg>
            </div>
            <div class="va-contact-card__body">
              <strong><?= e($label) ?></strong>
              <span><?= e($value) ?></span>
            </div>
            <svg class="va-contact-card__arrow" width="16" height="12" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
          </a>
        <?php endforeach; ?>

        <a href="#offices-map" class="va-contact-card" data-reveal style="text-align:left">
          <div class="va-contact-card__icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>
          </div>
          <div class="va-contact-card__body">
            <strong>3 Offices</strong>
            <span>Mumbai · Kalyan · Amravati</span>
          </div>
          <svg class="va-contact-card__arrow" width="16" height="12" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
        </a>

        <div class="va-contact-socials" data-reveal>
          <strong>Follow</strong>
          <a href="<?= e($brand['social']['facebook']) ?>" aria-label="Facebook">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12Z"/></svg>
          </a>
          <a href="<?= e($brand['social']['instagram']) ?>" aria-label="Instagram">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37Z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
          </a>
          <a href="<?= e($brand['social']['linkedin']) ?>" aria-label="LinkedIn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M20.45 20.45h-3.55v-5.57c0-1.33-.03-3.03-1.85-3.03-1.85 0-2.13 1.45-2.13 2.94v5.66H9.36V9h3.41v1.56h.05c.48-.9 1.64-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28zM5.34 7.43a2.06 2.06 0 1 1 0-4.12 2.06 2.06 0 0 1 0 4.12zM7.12 20.45H3.56V9h3.56v11.45z"/></svg>
          </a>
          <a href="<?= e($brand['social']['youtube']) ?>" aria-label="YouTube">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M21.58 7.19a2.51 2.51 0 0 0-1.77-1.77C18.25 5 12 5 12 5s-6.25 0-7.81.42A2.51 2.51 0 0 0 2.42 7.19 26.21 26.21 0 0 0 2 12a26.21 26.21 0 0 0 .42 4.81 2.51 2.51 0 0 0 1.77 1.77C5.75 19 12 19 12 19s6.25 0 7.81-.42a2.51 2.51 0 0 0 1.77-1.77A26.21 26.21 0 0 0 22 12a26.21 26.21 0 0 0-.42-4.81ZM10 15V9l5.2 3Z"/></svg>
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- THREE OFFICES — each with its own embedded mini-map -->
<section id="offices-map" style="padding:30px 0 100px">
  <div class="container-lg">
    <div class="section-head" data-reveal>
      <span class="eyebrow">VISIT IN PERSON</span>
      <h2>Three offices across <span class="gold">Maharashtra</span></h2>
      <p>Drop in for a coffee — we're set up to host a private property review at each of our three locations.</p>
    </div>

    <?php
      // Office metadata — drives addresses, mini-map queries and city/state copy.
      $offices = [
        [
          'name'  => 'Mumbai Head Office',
          'addr'  => $brand['address'][0] ?? 'Mumbai, Maharashtra, India',
          'city'  => 'Mumbai, Maharashtra',
          'hours' => 'Mon–Sat · 9 AM – 8 PM',
          'note'  => 'Flagship advisory desk',
        ],
        [
          'name'  => 'Kalyan Branch',
          'addr'  => $brand['address'][1] ?? 'Kalyan (W), Maharashtra',
          'city'  => 'Kalyan West, Maharashtra',
          'hours' => 'Mon–Sat · 10 AM – 7 PM',
          'note'  => 'Suburban & investment desk',
        ],
        [
          'name'  => 'Amravati Office',
          'addr'  => $brand['address'][2] ?? 'Amravati, Maharashtra',
          'city'  => 'Amravati, Maharashtra',
          'hours' => 'By appointment · Mon–Fri',
          'note'  => 'Regional partnerships',
        ],
      ];
    ?>

    <div class="va-offices-grid" data-stagger>
      <?php foreach ($offices as $i => $o): ?>
        <article class="va-office">
          <div class="va-office__map">
            <span class="va-office__pin">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>
              Office <?= str_pad((string)($i+1), 2, '0', STR_PAD_LEFT) ?>
            </span>
            <iframe
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              src="https://maps.google.com/maps?q=<?= e(urlencode($o['city'])) ?>&t=&z=12&ie=UTF8&iwloc=&output=embed"
              title="Map — <?= e($o['name']) ?>">
            </iframe>
          </div>
          <div class="va-office__body">
            <div class="va-office__head">
              <h3 class="va-office__name"><?= e($o['name']) ?></h3>
              <span class="va-office__num"><?= e(str_pad((string)($i+1), 2, '0', STR_PAD_LEFT)) ?></span>
            </div>
            <p class="va-office__addr"><?= e($o['addr']) ?></p>

            <div class="va-office__meta">
              <span>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <?= e($o['hours']) ?>
              </span>
              <span>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9 12 2l9 7v11a2 2 0 0 1-2 2h-4v-7h-6v7H5a2 2 0 0 1-2-2V9Z"/></svg>
                <?= e($o['note']) ?>
              </span>
            </div>

            <div class="va-office__actions">
              <a href="https://www.google.com/maps/search/?api=1&query=<?= e(urlencode($o['city'])) ?>" target="_blank" rel="noopener">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                Directions
              </a>
              <a href="tel:<?= e($brand['phone']) ?>" class="is-primary">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
                Call us
              </a>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php $view->endSection(); ?>
