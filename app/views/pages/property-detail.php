<?php /** @var \App\Core\View $view */ $view->extend('layouts.main'); $p = $property; ?>
<?php $view->section('content'); ?>

<?php $gallery = $p['gallery'] ?? [$p['cover'] ?? asset('images/p1.jpg')];
      if (empty($gallery)) $gallery = [$p['cover'] ?? asset('images/p1.jpg')]; ?>

<!-- Property header -->
<section style="padding:120px 0 24px;background:var(--surface-2)">
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
      <h1 class="display" style="font-size:clamp(30px,4vw,52px);margin:18px 0 12px"><?= e($p['title']) ?></h1>
      <p class="muted" style="display:flex;align-items:center;gap:8px;font-size:15px">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>
        <?= e($p['location']) ?>
      </p>
    </div>
  </div>
</section>

<!-- Two-column body: gallery (left) + sticky sidebar (right) -->
<section style="padding:24px 0 60px;background:var(--surface-2)">
  <div class="container-lg">
    <div class="property-detail-grid" style="display:grid;grid-template-columns:1fr;gap:32px">

      <!-- LEFT: Gallery (main image + column of thumbs) + content below -->
      <div>
        <div class="pd-gallery" data-reveal>
          <div class="pd-gallery__main">
            <img id="pdMainImage" src="<?= e(cld($gallery[0], 1400)) ?>" alt="<?= e($p['title']) ?>"
                 data-full="<?= e(cld($gallery[0], 1800)) ?>"
                 onerror="this.src='https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1400&q=80'"
                 onclick="pdOpenLightbox(0)">
            <button type="button" class="pd-gallery__zoom" onclick="pdOpenLightbox(pdCurrentIndex)" aria-label="View larger">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
              View larger
            </button>
            <?php if (count($gallery) > 1): ?>
              <div class="pd-gallery__count"><span id="pdCounter">1</span> / <?= count($gallery) ?></div>
            <?php endif; ?>
          </div>

          <?php if (count($gallery) > 1): ?>
          <div class="pd-gallery__thumbs">
            <?php foreach ($gallery as $i => $g): ?>
              <button type="button" class="pd-thumb <?= $i === 0 ? 'active' : '' ?>"
                      data-index="<?= $i ?>"
                      data-src="<?= e(cld($g, 1400)) ?>"
                      data-full="<?= e(cld($g, 1800)) ?>"
                      onclick="pdSelectThumb(<?= $i ?>)">
                <img src="<?= e(cld($g, 400)) ?>" alt="View <?= $i + 1 ?>"
                     onerror="this.src='https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=400&q=80'">
              </button>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </div>

        <!-- key facts -->
        <div class="pd-stats" data-reveal>
          <div class="va-stat"><div class="va-stat__val">₹<?= number_format(($p['price'] ?? 0)/10000000,2) ?>Cr</div><span class="va-stat__lbl"><?= ($p['listing']??'')==='rent'?'Monthly Rent':'Asking Price' ?></span></div>
          <?php if (!empty($p['bhk'])): ?><div class="va-stat"><div class="va-stat__val"><?= (int)$p['bhk'] ?></div><span class="va-stat__lbl">Bedrooms</span></div><?php endif; ?>
          <?php if (!empty($p['baths'])): ?><div class="va-stat"><div class="va-stat__val"><?= (int)$p['baths'] ?></div><span class="va-stat__lbl">Bathrooms</span></div><?php endif; ?>
          <?php if (!empty($p['area'])): ?><div class="va-stat"><div class="va-stat__val"><?= number_format($p['area']) ?></div><span class="va-stat__lbl">Sqft</span></div><?php endif; ?>
        </div>

        <!-- description -->
        <div data-reveal style="margin-top:48px">
          <span class="eyebrow">DESCRIPTION</span>
          <h2 style="font-size:32px;margin:14px 0 18px">About this property</h2>
          <p class="muted" style="line-height:1.9;font-size:16px"><?= nl2br(e($p['description'] ?? '')) ?></p>
        </div>

        <!-- video tour -->
        <?php if ($embedUrl = youtube_embed_url($p['video_url'] ?? null)): ?>
        <div data-reveal style="margin-top:48px">
          <span class="eyebrow">VIDEO TOUR</span>
          <h2 style="font-size:32px;margin:14px 0 18px">Walk through this property</h2>
          <div class="pd-video">
            <iframe src="<?= e($embedUrl) ?>"
                    title="Property video tour"
                    loading="lazy"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allowfullscreen></iframe>
          </div>
        </div>
        <?php endif; ?>

        <!-- amenities -->
        <?php if (!empty($p['amenities'])): ?>
        <div data-reveal style="margin-top:48px">
          <span class="eyebrow">AMENITIES</span>
          <h2 style="font-size:32px;margin:14px 0 24px">What's included</h2>
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
        <div data-reveal style="margin-top:48px">
          <span class="eyebrow">NEARBY</span>
          <h2 style="font-size:32px;margin:14px 0 24px">Connectivity</h2>
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

      <!-- RIGHT: enquiry sidebar -->
      <aside data-reveal class="pd-sidebar">
        <div class="glass pd-sidebar__card">
          <div class="pd-price-row">
            <div>
              <span class="muted" style="font-size:12px;letter-spacing:.08em;text-transform:uppercase"><?= ($p['listing']??'')==='rent'?'Monthly Rent':'Asking Price' ?></span>
              <div class="pd-price">₹<?= number_format(($p['price'] ?? 0)/10000000,2) ?> Cr</div>
            </div>
            <?php if (!empty($p['area'])): ?>
              <div style="text-align:right">
                <span class="muted" style="font-size:12px;letter-spacing:.08em;text-transform:uppercase">Per Sqft</span>
                <div style="font-size:16px;font-weight:600">₹<?= number_format(($p['price'] ?? 0) / max(1,(int)$p['area'])) ?></div>
              </div>
            <?php endif; ?>
          </div>

          <div class="pd-quick-facts">
            <?php if (!empty($p['bhk'])): ?>
              <div><strong><?= (int)$p['bhk'] ?></strong><span>Bedrooms</span></div>
            <?php endif; ?>
            <?php if (!empty($p['baths'])): ?>
              <div><strong><?= (int)$p['baths'] ?></strong><span>Bathrooms</span></div>
            <?php endif; ?>
            <?php if (!empty($p['area'])): ?>
              <div><strong><?= number_format($p['area']) ?></strong><span>Sqft</span></div>
            <?php endif; ?>
            <?php if (!empty($p['type'])): ?>
              <div><strong style="font-size:14px;text-transform:capitalize"><?= e($p['type']) ?></strong><span>Type</span></div>
            <?php endif; ?>
          </div>

          <h3 style="font-size:20px;margin:24px 0 4px">Interested? Talk to an advisor.</h3>
          <p class="muted" style="font-size:13px;margin-bottom:18px">We respond on WhatsApp within 15 minutes.</p>
          <form data-ajax action="/inquiry" method="post">
            <input type="hidden" name="property_id" value="<?= e($p['id'] ?? '') ?>">
            <input type="hidden" name="property" value="<?= e($p['title']) ?>">
            <input type="hidden" name="property_slug" value="<?= e($p['slug'] ?? '') ?>">
            <div class="form-group"><label>Full Name</label><input class="form-control" name="name" required></div>
            <div class="form-group"><label>Phone</label><input class="form-control" name="phone" type="tel" required></div>
            <div class="form-group"><label>Email</label><input class="form-control" name="email" type="email"></div>
            <div class="form-group"><label>Message</label><textarea class="form-control" name="message" rows="3" placeholder="When would you like to visit?"></textarea></div>
            <button type="submit" class="btn btn-primary" style="width:100%">Send Inquiry</button>
          </form>
          <div style="margin-top:14px;display:flex;gap:10px">
            <a href="tel:<?= e(config('app.brand.phone')) ?>" class="btn btn-ghost" style="flex:1;justify-content:center">Call</a>
            <a href="https://wa.me/<?= e(config('app.brand.whatsapp')) ?>" class="btn btn-ghost" style="flex:1;justify-content:center">WhatsApp</a>
          </div>
        </div>
      </aside>

    </div>
  </div>
</section>

<!-- Lightbox -->
<div id="pdLightbox" class="pd-lightbox" hidden>
  <button class="pd-lightbox__close" type="button" onclick="pdCloseLightbox()" aria-label="Close">&times;</button>
  <button class="pd-lightbox__nav pd-lightbox__nav--prev" type="button" onclick="pdLightboxNav(-1)" aria-label="Previous">&#10094;</button>
  <img id="pdLightboxImage" src="" alt="">
  <button class="pd-lightbox__nav pd-lightbox__nav--next" type="button" onclick="pdLightboxNav(1)" aria-label="Next">&#10095;</button>
  <div class="pd-lightbox__counter"><span id="pdLightboxCounter">1</span> / <?= count($gallery) ?></div>
</div>

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
/* Key facts row — always 4 columns, scales down on mobile */
.pd-stats{
  display:grid; grid-template-columns:repeat(4, 1fr); gap:14px; margin-top:48px;
}
.pd-stats .va-stat{ padding:14px 10px; text-align:center; }
.pd-stats .va-stat__val{ font-size:clamp(15px, 4.2vw, 28px); white-space:nowrap; line-height:1.1; }
.pd-stats .va-stat__lbl{ font-size:clamp(9px, 2.4vw, 12px); }
@media(max-width:600px){
  .pd-stats{ gap:6px; }
  .pd-stats .va-stat{ padding:10px 4px; }
}

/* Gallery layout: main image + thumbnail column */
.pd-gallery{ display:grid; grid-template-columns:1fr; gap:14px; }
.pd-gallery__main{ position:relative; aspect-ratio:4/3; border-radius:18px; overflow:hidden; background:#111; cursor:zoom-in; }
.pd-gallery__main img{ width:100%; height:100%; object-fit:cover; transition:transform .6s ease; }
.pd-gallery__main:hover img{ transform:scale(1.03); }
.pd-gallery__zoom{
  position:absolute; bottom:16px; right:16px; display:inline-flex; align-items:center; gap:6px;
  padding:10px 14px; border-radius:999px; border:1px solid rgba(255,255,255,0.25);
  background:rgba(0,0,0,0.55); color:#fff; font-size:13px; cursor:pointer;
  backdrop-filter:blur(10px); -webkit-backdrop-filter:blur(10px);
}
.pd-gallery__zoom:hover{ background:rgba(0,0,0,0.75); }
.pd-gallery__count{
  position:absolute; top:16px; right:16px; padding:6px 12px; border-radius:999px;
  background:rgba(0,0,0,0.55); color:#fff; font-size:12px; letter-spacing:.06em;
  backdrop-filter:blur(10px); -webkit-backdrop-filter:blur(10px);
}
.pd-gallery__thumbs{
  display:grid; grid-template-columns:repeat(5, 1fr); gap:10px;
}
.pd-thumb{
  position:relative; padding:0; border:2px solid transparent; border-radius:10px;
  overflow:hidden; cursor:pointer; aspect-ratio:1/1; background:#111;
  transition:border-color .2s ease, transform .2s ease;
}
.pd-thumb img{ width:100%; height:100%; object-fit:cover; transition:transform .3s ease; }
.pd-thumb:hover{ transform:translateY(-2px); }
.pd-thumb:hover img{ transform:scale(1.06); }
.pd-thumb.active{ border-color:var(--gold); box-shadow:0 0 0 2px rgba(201,163,91,0.18); }

/* Video tour */
.pd-video{
  position:relative; width:100%; aspect-ratio:16/9; border-radius:18px;
  overflow:hidden; background:#000;
  box-shadow:0 10px 30px rgba(0,0,0,0.25);
}
.pd-video iframe{ position:absolute; inset:0; width:100%; height:100%; border:0; }

/* Sidebar */
.pd-sidebar{ align-self:start; }
.pd-sidebar__card{ padding:24px; }
.pd-price-row{
  display:flex; justify-content:space-between; align-items:flex-end; gap:16px;
  padding-bottom:18px; border-bottom:1px solid rgba(255,255,255,0.08); margin-bottom:18px;
}
.pd-price{ font-size:30px; font-weight:700; color:var(--gold); line-height:1.1; margin-top:4px; }
.pd-quick-facts{
  display:grid; grid-template-columns:repeat(2,1fr); gap:10px; margin-bottom:8px;
}
.pd-quick-facts > div{
  display:flex; flex-direction:column; padding:12px;
  background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.06);
  border-radius:10px;
}
.pd-quick-facts strong{ font-size:18px; font-weight:600; }
.pd-quick-facts span{ font-size:11px; color:var(--muted); letter-spacing:.06em; text-transform:uppercase; margin-top:2px; }

/* Lightbox */
.pd-lightbox{
  position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.92);
  display:flex; align-items:center; justify-content:center; padding:40px;
}
.pd-lightbox[hidden]{ display:none !important; }
.pd-lightbox img{ max-width:95vw; max-height:90vh; object-fit:contain; border-radius:8px; }
.pd-lightbox__close{
  position:absolute; top:20px; right:24px; width:44px; height:44px;
  border-radius:50%; border:1px solid rgba(255,255,255,0.25);
  background:rgba(255,255,255,0.08); color:#fff; font-size:26px; line-height:1; cursor:pointer;
}
.pd-lightbox__close:hover{ background:rgba(255,255,255,0.18); }
.pd-lightbox__nav{
  position:absolute; top:50%; transform:translateY(-50%); width:48px; height:48px;
  border-radius:50%; border:1px solid rgba(255,255,255,0.25);
  background:rgba(255,255,255,0.08); color:#fff; font-size:18px; cursor:pointer;
}
.pd-lightbox__nav:hover{ background:rgba(255,255,255,0.18); }
.pd-lightbox__nav--prev{ left:24px; }
.pd-lightbox__nav--next{ right:24px; }
.pd-lightbox__counter{
  position:absolute; bottom:24px; left:50%; transform:translateX(-50%);
  padding:8px 16px; border-radius:999px; background:rgba(255,255,255,0.08);
  color:#fff; font-size:13px; letter-spacing:.06em;
}

/* Desktop layout: gallery left, sidebar right (sticky) */
@media(min-width:1024px){
  .property-detail-grid{ grid-template-columns: 1.55fr 1fr !important; gap: 40px !important; align-items:start; }
  .pd-sidebar{ position:sticky; top:100px; }
  .pd-gallery__main{ aspect-ratio:16/11; }
  .pd-gallery__thumbs{ grid-template-columns:repeat(5, 1fr); }
}
@media(max-width:600px){
  .pd-gallery__thumbs{ grid-template-columns:repeat(4, 1fr); }
  .pd-quick-facts{ grid-template-columns:repeat(2,1fr); }
}
</style>

<script>
(function(){
  const gallery = <?= json_encode(array_map(function($g){ return ['thumb'=>cld($g, 1400), 'full'=>cld($g, 1800)]; }, $gallery)) ?>;
  window.pdCurrentIndex = 0;
  const main = document.getElementById('pdMainImage');
  const counter = document.getElementById('pdCounter');
  const thumbs = document.querySelectorAll('.pd-thumb');

  window.pdSelectThumb = function(i){
    if (!gallery[i]) return;
    window.pdCurrentIndex = i;
    main.src = gallery[i].thumb;
    main.dataset.full = gallery[i].full;
    if (counter) counter.textContent = (i+1);
    thumbs.forEach((t, idx)=> t.classList.toggle('active', idx === i));
  };

  const lightbox = document.getElementById('pdLightbox');
  const lbImg    = document.getElementById('pdLightboxImage');
  const lbCount  = document.getElementById('pdLightboxCounter');

  window.pdOpenLightbox = function(i){
    window.pdCurrentIndex = i;
    lbImg.src = gallery[i].full;
    if (lbCount) lbCount.textContent = (i+1);
    lightbox.hidden = false;
    document.body.style.overflow = 'hidden';
  };
  window.pdCloseLightbox = function(){
    lightbox.hidden = true;
    document.body.style.overflow = '';
  };
  window.pdLightboxNav = function(dir){
    let i = window.pdCurrentIndex + dir;
    if (i < 0) i = gallery.length - 1;
    if (i >= gallery.length) i = 0;
    window.pdSelectThumb(i);
    window.pdOpenLightbox(i);
  };

  document.addEventListener('keydown', function(e){
    if (lightbox.hidden) return;
    if (e.key === 'Escape') window.pdCloseLightbox();
    if (e.key === 'ArrowRight') window.pdLightboxNav(1);
    if (e.key === 'ArrowLeft') window.pdLightboxNav(-1);
  });

  lightbox.addEventListener('click', function(e){
    if (e.target === lightbox) window.pdCloseLightbox();
  });
})();
</script>

<?php $view->endSection(); ?>
