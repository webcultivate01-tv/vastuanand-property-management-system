<?php $view->extend('layouts.main'); $brand = config('app.brand'); ?>
<?php $view->section('content'); ?>

<section style="padding:140px 0 60px;background:linear-gradient(180deg,#000,var(--ink-2))">
  <div class="container" data-reveal>
    <span class="eyebrow">CONTACT US</span>
    <h1 class="display" style="font-size:clamp(44px,5vw,72px);margin:18px 0 16px">Let's start a <span class="gold" style="font-style:italic">conversation</span>.</h1>
    <p class="muted" style="max-width:680px;font-size:17px;line-height:1.7">Schedule a consultation, request a property viewing, or simply ask a question. We respond on WhatsApp within 15 minutes during business hours.</p>
  </div>
</section>

<section style="padding-top:30px">
  <div class="container">
    <div class="grid cols-2" style="gap:60px;align-items:start">
      <div data-reveal>
        <div class="glass" style="padding:36px">
          <?php if (!empty($_GET['sent'])): ?>
            <div style="padding:14px 18px;background:rgba(46,160,67,0.15);border:1px solid #2ea043;border-radius:10px;margin-bottom:22px;color:#7ee787">Thank you. Our team will reach out within 24 hours.</div>
          <?php endif; ?>
          <h2 style="font-family:'Cormorant Garamond',serif;font-size:32px;margin:0 0 20px">Send a Message</h2>
          <form action="/contact" method="post">
            <?= csrf_field() ?>
            <div class="grid cols-2" style="gap:16px">
              <div class="form-group"><label>Full Name</label><input class="form-control" name="name" required></div>
              <div class="form-group"><label>Phone</label><input class="form-control" name="phone" type="tel" required></div>
            </div>
            <div class="form-group"><label>Email</label><input class="form-control" name="email" type="email" required></div>
            <div class="form-group">
              <label>Subject</label>
              <select class="form-control" name="subject">
                <option>General Consultation</option>
                <option>Buying Property</option>
                <option>Renting Property</option>
                <option>Selling Property</option>
                <option>NRI Services</option>
                <option>Commercial Real Estate</option>
                <option>Investment Consultation</option>
              </select>
            </div>
            <div class="form-group"><label>Message</label><textarea class="form-control" name="message" required rows="5"></textarea></div>
            <button type="submit" class="btn btn-primary" style="width:100%">Send Message</button>
          </form>
        </div>
      </div>

      <div data-reveal data-reveal-delay="200">
        <h2 style="font-family:'Cormorant Garamond',serif;font-size:32px;margin:0 0 28px">Reach Out to Our Experts</h2>

        <?php foreach ([
          ['Phone',    $brand['phone'], 'tel:' . $brand['phone'],     'M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92Z'],
          ['Email',    $brand['email'], 'mailto:' . $brand['email'],  'M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2Zm18 2-10 7L2 6'],
          ['WhatsApp', '+91 ' . substr($brand['whatsapp'],2,5) . ' ' . substr($brand['whatsapp'],-5), 'https://wa.me/' . $brand['whatsapp'], 'M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5Z'],
        ] as [$label, $value, $link, $path]): ?>
          <a href="<?= e($link) ?>" class="glass" style="display:flex;align-items:center;gap:18px;padding:22px;margin-bottom:14px;transition:border-color .3s">
            <div style="width:52px;height:52px;border-radius:50%;background:rgba(201,163,91,0.16);display:grid;place-items:center;color:var(--gold);flex-shrink:0">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="<?= $path ?>"/></svg>
            </div>
            <div>
              <div class="eyebrow"><?= e($label) ?></div>
              <div style="margin-top:4px;color:var(--pearl);font-size:16px"><?= e($value) ?></div>
            </div>
          </a>
        <?php endforeach; ?>

        <div class="glass" style="padding:22px;margin-top:14px">
          <div class="eyebrow">OFFICE LOCATIONS</div>
          <ul style="list-style:none;padding:0;margin:14px 0 0">
            <?php foreach ($brand['address'] as $addr): ?>
              <li style="padding:10px 0;border-bottom:1px solid var(--line);display:flex;gap:10px;font-size:14px">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C9A35B" stroke-width="2" style="flex-shrink:0;margin-top:2px"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                <?= e($addr) ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Map -->
<section style="padding:0 0 100px">
  <div class="container">
    <div class="glass" style="padding:0;overflow:hidden;border-radius:20px;aspect-ratio:21/9;background:#111" data-reveal>
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d241317.11609823654!2d72.71637068835428!3d19.082197925797946!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c6306644edc1%3A0x5da4ed8f8d648c69!2sMumbai%2C%20Maharashtra!5e0!3m2!1sen!2sin!4v1700000000000" width="100%" height="100%" style="border:0;filter:grayscale(0.6) invert(0.92)" loading="lazy"></iframe>
    </div>
  </div>
</section>

<?php $view->endSection(); ?>
