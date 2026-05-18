<?php $view->extend('layouts.main'); $s = $service; ?>
<?php $view->section('content'); ?>

<section style="padding:140px 0 80px;background:linear-gradient(180deg,var(--surface-2),var(--bg))">
  <div class="container" data-reveal>
    <a href="/services" class="va-link-arrow"><svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.4" style="transform:rotate(180deg)"><path d="M0 5h13M9 1l4 4-4 4"/></svg>All Services</a>
    <h1 class="display" style="font-size:clamp(40px,5vw,72px);margin:24px 0 16px"><?= e($s['title']) ?></h1>
    <p class="muted" style="max-width:720px;font-size:17px;line-height:1.7"><?= e($s['hero']) ?></p>
  </div>
</section>

<section style="padding-top:30px">
  <div class="container">
    <div class="grid cols-2" style="gap:60px;align-items:start">
      <div data-reveal>
        <h2 style="font-size:34px;margin-bottom:18px">What's included</h2>
        <p class="muted" style="line-height:1.8"><?= e($s['body']) ?></p>
        <ul style="list-style:none;padding:0;margin:32px 0 0">
          <?php foreach ($s['features'] as $f): ?>
            <li style="display:flex;align-items:center;gap:12px;padding:12px 0;border-bottom:1px solid var(--line);font-size:15px">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C9A35B" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              <?= e($f) ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <aside data-reveal>
        <div class="glass" style="padding:32px">
          <span class="eyebrow">START NOW</span>
          <h3 style="font-size:28px;margin:14px 0 18px">Book a complimentary consultation</h3>
          <form data-ajax action="/contact" method="post">
            <input type="hidden" name="subject" value="<?= e($s['title']) ?>">
            <div class="form-group"><label>Name</label><input class="form-control" name="name" required></div>
            <div class="form-group"><label>Phone</label><input class="form-control" name="phone" type="tel" required></div>
            <div class="form-group"><label>Email</label><input class="form-control" name="email" type="email" required></div>
            <div class="form-group"><label>Message</label><textarea class="form-control" name="message" rows="3"></textarea></div>
            <button type="submit" class="btn btn-primary" style="width:100%">Request Consultation</button>
          </form>
        </div>
      </aside>
    </div>
  </div>
</section>

<?php $view->endSection(); ?>
