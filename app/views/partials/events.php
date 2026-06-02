<?php
// Surface currently-running events as a dismissible popup on the public site.
// "Live" means: active=true AND the (optional) starts_at/ends_at window includes now.
// Dismissals are stored per-event in localStorage for 24 hours.
$liveEvents = [];
try {
    if (class_exists(\App\Models\Event::class)) {
        $liveEvents = \App\Models\Event::live(3);
    }
} catch (\Throwable $e) {
    $liveEvents = [];
}
if (empty($liveEvents)) return;
$primary = $liveEvents[0];
?>
<div id="vaEvent" class="va-event" data-event-id="<?= e($primary['id'] ?? '') ?>" hidden>
  <div class="va-event__backdrop" data-va-event-close></div>
  <div class="va-event__card" role="dialog" aria-modal="true" aria-labelledby="vaEventTitle">
    <button type="button" class="va-event__close" data-va-event-close aria-label="Close">&times;</button>
    <?php if (!empty($primary['image'])): ?>
      <div class="va-event__media">
        <img src="<?= e(cld($primary['image'], 900)) ?>" alt="<?= e($primary['title'] ?? '') ?>">
      </div>
    <?php endif; ?>
    <div class="va-event__body">
      <span class="va-event__pill">EVENT</span>
      <h3 id="vaEventTitle"><?= e($primary['title'] ?? '') ?></h3>
      <?php if (!empty($primary['description'])): ?>
        <p><?= nl2br(e($primary['description'])) ?></p>
      <?php endif; ?>
      <div class="va-event__meta">
        <?php if (!empty($primary['starts_at'])): ?>
          <span>📅 <?= e(date('d M Y · h:i A', strtotime($primary['starts_at']))) ?></span>
        <?php endif; ?>
        <?php if (!empty($primary['location'])): ?>
          <span>📍 <?= e($primary['location']) ?></span>
        <?php endif; ?>
      </div>
      <?php if (!empty($primary['cta']) && !empty($primary['link'])): ?>
        <a href="<?= e($primary['link']) ?>" class="va-event__cta">
          <?= e($primary['cta']) ?>
          <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
        </a>
      <?php elseif (!empty($primary['link'])): ?>
        <a href="<?= e($primary['link']) ?>" class="va-event__cta">Learn more</a>
      <?php endif; ?>
    </div>
  </div>
</div>
<style>
  .va-event{position:fixed;inset:0;z-index:9500;display:flex;align-items:center;justify-content:center;padding:20px}
  .va-event[hidden]{display:none}
  .va-event__backdrop{position:absolute;inset:0;background:rgba(8,8,10,0.72);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px)}
  .va-event__card{position:relative;width:min(520px,100%);background:#1A1A1A;border:1px solid rgba(201,163,91,0.25);border-radius:18px;overflow:hidden;box-shadow:0 25px 80px rgba(0,0,0,0.55);color:#F5F4EF;transform:translateY(10px);opacity:0;transition:transform .35s ease, opacity .35s ease}
  .va-event.is-shown .va-event__card{transform:translateY(0);opacity:1}
  .va-event__close{position:absolute;top:12px;right:14px;width:34px;height:34px;border-radius:50%;border:1px solid rgba(255,255,255,0.18);background:rgba(0,0,0,0.45);color:#fff;font-size:22px;line-height:1;cursor:pointer;z-index:2}
  .va-event__media{aspect-ratio:16/9;background:#0E0E0E}
  .va-event__media img{width:100%;height:100%;object-fit:cover;display:block}
  .va-event__body{padding:22px 24px 26px}
  .va-event__pill{display:inline-block;padding:4px 10px;border-radius:999px;background:rgba(201,163,91,0.18);color:#C9A35B;font-size:10px;letter-spacing:.14em;font-weight:600;margin-bottom:10px}
  .va-event__body h3{font-size:22px;margin:0 0 8px;color:#FFFCF4}
  .va-event__body p{font-size:14px;color:#B7B3A8;margin:0 0 14px;line-height:1.55}
  .va-event__meta{display:flex;flex-wrap:wrap;gap:14px;font-size:12px;color:#9A9486;margin-bottom:16px}
  .va-event__cta{display:inline-flex;align-items:center;gap:8px;padding:11px 20px;background:linear-gradient(135deg,#C9A35B,#A8843E);color:#1A1A1A;text-decoration:none;font-weight:600;font-size:13px;border-radius:10px;letter-spacing:.02em;transition:transform .2s,box-shadow .2s}
  .va-event__cta:hover{transform:translateY(-1px);box-shadow:0 12px 28px rgba(201,163,91,0.4)}
</style>
<script>
(function(){
  var modal = document.getElementById('vaEvent');
  if (!modal) return;
  var id = modal.getAttribute('data-event-id') || 'va-event';
  var key = 'va_event_dismissed_' + id;
  try {
    var hidden = localStorage.getItem(key);
    if (hidden && (Date.now() - parseInt(hidden, 10)) < 24 * 60 * 60 * 1000) return;
  } catch (e) {}
  setTimeout(function(){
    modal.hidden = false;
    requestAnimationFrame(function(){ modal.classList.add('is-shown'); });
  }, 2500);
  function close(){
    modal.classList.remove('is-shown');
    setTimeout(function(){ modal.hidden = true; }, 350);
    try { localStorage.setItem(key, String(Date.now())); } catch (e) {}
  }
  modal.querySelectorAll('[data-va-event-close]').forEach(function(el){ el.addEventListener('click', close); });
  document.addEventListener('keydown', function(e){ if (e.key === 'Escape' && !modal.hidden) close(); });
})();
</script>
