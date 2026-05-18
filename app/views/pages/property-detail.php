<?php /** @var \App\Core\View $view */ $view->extend('layouts.main'); $p = $property; ?>
<?php $view->section('content'); ?>

<!-- Gallery hero -->
<section style="padding:120px 0 0;background:#000">
  <div class="container-lg">
    <div data-reveal>
      <a href="/properties" class="va-link-arrow" style="margin-bottom:18px">
        <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.4" style="transform:rotate(180deg)"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
        Back to Properties
      </a>
      <div class="flex items-center gap-16" style="flex-wrap:wrap;margin-top:8px">
        <span class="chip" style="background:rgba(201,163,91,0.16);color:var(--gold);border-color:var(--gold)"><?= e(ucfirst($p['listing'] ?? 'sale')) ?></span>
        <?php foreach (($p['tags'] ?? []) as $tag): ?><span class="chip"><?= e($tag) ?></span><?php endforeach; ?>
      </div>
      <h1 class="display" style="font-size:clamp(36px,5vw,68px);margin:18px 0 12px"><?= e($p['title']) ?></h1>
      <p class="muted" style="display:flex;align-items:center;gap:8px;font-size:15px">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>
        <?= e($p['location']) ?>
      </p>
    </div>

    <div style="margin-top:36px;display:grid;grid-template-columns:1fr;gap:12px" data-reveal>
      <?php $gallery = $p['gallery'] ?? [$p['cover'] ?? asset('images/p1.jpg')]; ?>
      <div style="aspect-ratio:16/9;border-radius:20px;overflow:hidden;background:#111">
        <img src="<?= e($gallery[0]) ?>" alt="<?= e($p['title']) ?>" style="width:100%;height:100%;object-fit:cover"
             onerror="this.src='https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1600&q=80'">
      </div>
      <?php if (count($gallery) > 1): ?>
      <div style="display:grid;grid-template-columns:repeat(<?= min(4, count($gallery)-1) ?>,1fr);gap:12px">
        <?php foreach (array_slice($gallery, 1, 4) as $g): ?>
          <div style="aspect-ratio:1/1;border-radius:14px;overflow:hidden;background:#111">
            <img src="<?= e($g) ?>" style="width:100%;height:100%;object-fit:cover"
                 onerror="this.src='https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=900&q=80'">
          </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Body -->
<section>
  <div class="container-lg">
    <div style="display:grid;grid-template-columns:1fr;gap:48px" class="property-detail-grid">
      <div>
        <!-- key facts -->
        <div class="grid cols-4" style="gap:14px" data-reveal>
          <div class="va-stat"><div class="va-stat__val">₹<?= number_format(($p['price'] ?? 0)/10000000,2) ?>Cr</div><span class="va-stat__lbl"><?= ($p['listing']??'')==='rent'?'Monthly Rent':'Asking Price' ?></span></div>
          <?php if (!empty($p['bhk'])): ?><div class="va-stat"><div class="va-stat__val"><?= (int)$p['bhk'] ?></div><span class="va-stat__lbl">Bedrooms</span></div><?php endif; ?>
          <?php if (!empty($p['baths'])): ?><div class="va-stat"><div class="va-stat__val"><?= (int)$p['baths'] ?></div><span class="va-stat__lbl">Bathrooms</span></div><?php endif; ?>
          <?php if (!empty($p['area'])): ?><div class="va-stat"><div class="va-stat__val"><?= number_format($p['area']) ?></div><span class="va-stat__lbl">Sqft</span></div><?php endif; ?>
        </div>

        <!-- description -->
        <div data-reveal style="margin-top:60px">
          <span class="eyebrow">DESCRIPTION</span>
          <h2 style="font-size:36px;margin:14px 0 18px">About this property</h2>
          <p class="muted" style="line-height:1.9;font-size:16px"><?= nl2br(e($p['description'] ?? '')) ?></p>
        </div>

        <!-- amenities -->
        <?php if (!empty($p['amenities'])): ?>
        <div data-reveal style="margin-top:60px">
          <span class="eyebrow">AMENITIES</span>
          <h2 style="font-size:36px;margin:14px 0 24px">What's included</h2>
          <div class="grid cols-3" style="gap:14px">
            <?php foreach ($p['amenities'] as $a): ?>
              <div class="glass" style="padding:18px;display:flex;align-items:center;gap:12px">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C9A35B" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                <span style="font-size:14px"><?= e($a) ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

        <!-- nearby -->
        <?php if (!empty($p['nearby'])): ?>
        <div data-reveal style="margin-top:60px">
          <span class="eyebrow">NEARBY</span>
          <h2 style="font-size:36px;margin:14px 0 24px">Connectivity</h2>
          <div class="grid cols-2" style="gap:14px">
            <?php foreach ($p['nearby'] as [$name, $dist]): ?>
              <div class="glass" style="padding:18px;display:flex;justify-content:space-between;align-items:center">
                <span><?= e($name) ?></span><span class="gold"><?= e($dist) ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>
      </div>

      <!-- Sidebar: enquiry + schedule visit -->
      <aside data-reveal style="position:sticky;top:120px;align-self:start">
        <div class="glass" style="padding:32px">
          <h3 style="font-size:26px;margin:0 0 6px">Interested? Talk to an advisor.</h3>
          <p class="muted" style="font-size:13px;margin-bottom:24px">We respond on WhatsApp within 15 minutes.</p>
          <form data-ajax action="/inquiry" method="post">
            <input type="hidden" name="property_id" value="<?= e($p['id'] ?? '') ?>">
            <input type="hidden" name="property" value="<?= e($p['title']) ?>">
            <div class="form-group"><label>Full Name</label><input class="form-control" name="name" required></div>
            <div class="form-group"><label>Phone</label><input class="form-control" name="phone" type="tel" required></div>
            <div class="form-group"><label>Email</label><input class="form-control" name="email" type="email"></div>
            <div class="form-group"><label>Message</label><textarea class="form-control" name="message" rows="3" placeholder="When would you like to visit?"></textarea></div>
            <button type="submit" class="btn btn-primary" style="width:100%">Send Inquiry</button>
          </form>
          <div style="margin-top:18px;display:flex;gap:10px">
            <a href="tel:<?= e(config('app.brand.phone')) ?>" class="btn btn-ghost" style="flex:1;justify-content:center">Call</a>
            <a href="https://wa.me/<?= e(config('app.brand.whatsapp')) ?>" class="btn btn-ghost" style="flex:1;justify-content:center">WhatsApp</a>
          </div>
        </div>
      </aside>
    </div>
  </div>
</section>

<!-- Similar -->
<?php if (!empty($similar)): ?>
<section>
  <div class="container-lg">
    <?php $view->include('components.section-head', ['eyebrow'=>'YOU MAY ALSO LIKE','heading'=>'Similar <span class="gold" style="font-style:italic">Properties</span>','sub'=>'Curated picks based on this property\'s type, listing and location.']); ?>
    <div class="grid cols-3">
      <?php foreach ($similar as $sp) $view->include('components.property-card', ['p' => $sp]); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<style>
@media(min-width:1024px){ .property-detail-grid{ grid-template-columns: 1.6fr 1fr !important; gap: 60px !important; } }
</style>

<?php $view->endSection(); ?>
