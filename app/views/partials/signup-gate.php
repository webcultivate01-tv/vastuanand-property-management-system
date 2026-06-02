<?php
// Click-triggered "Sign up to view Property in detail" modal.
// Intercepts any link with [data-va-gate] when the visitor hasn't unlocked yet.
$gateUnlocked = !empty($_SESSION['va_unlocked']) || !empty($_COOKIE['va_unlocked']);
$visitor      = $_SESSION['va_visitor'] ?? [];
?>
<div id="vaSignupGate" class="va-gate" role="dialog" aria-modal="true" aria-labelledby="vaGateTitle" hidden>
  <div class="va-gate__backdrop" data-va-gate-close></div>
  <div class="va-gate__card">
    <button type="button" class="va-gate__close" data-va-gate-close aria-label="Close">&times;</button>
    <div class="va-gate__badge">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
    </div>
    <h2 id="vaGateTitle">Sign up to view Property in detail</h2>
    <p class="va-gate__lede">Tell us a little about you and we'll unlock the full listing — gallery, price breakdown and our advisor's notes.</p>
    <form id="vaGateForm" action="/property-access" method="post" novalidate>
      <?= csrf_field() ?>
      <input type="hidden" name="property_id"   id="vaGateId"   value="">
      <input type="hidden" name="property"      id="vaGateName" value="">
      <input type="hidden" name="property_slug" id="vaGateSlug" value="">
      <input type="hidden" name="_next"         id="vaGateNext" value="">

      <div class="va-gate__field">
        <label>Full Name</label>
        <input name="name" type="text" required autocomplete="name" placeholder="Your name" value="<?= e($visitor['name'] ?? '') ?>">
      </div>
      <div class="va-gate__field">
        <label>Mobile Number</label>
        <input name="phone" type="tel" required autocomplete="tel" placeholder="+91 9XXXXXXXXX" value="<?= e($visitor['phone'] ?? '') ?>">
      </div>
      <div class="va-gate__field">
        <label>Email</label>
        <input name="email" type="email" required autocomplete="email" placeholder="you@example.com" value="<?= e($visitor['email'] ?? '') ?>">
      </div>

      <button type="submit" class="va-gate__cta">
        Sign up &amp; View Details
        <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
      </button>
      <p class="va-gate__note">We respect your privacy. We'll only get in touch if you ask us to.</p>
      <div class="va-gate__error" id="vaGateError" hidden></div>
    </form>
  </div>
</div>

<style>
  .va-gate{position:fixed;inset:0;z-index:10001;display:flex;align-items:center;justify-content:center;padding:20px}
  .va-gate[hidden]{display:none}
  .va-gate__backdrop{position:absolute;inset:0;background:rgba(8,8,10,0.80);backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px)}
  .va-gate__card{position:relative;width:min(460px,100%);background:linear-gradient(180deg,#1A1A1A,#0E0E0E);border:1px solid rgba(201,163,91,0.28);border-radius:18px;padding:30px 28px 26px;box-shadow:0 30px 90px rgba(0,0,0,0.55);color:#F5F4EF;transform:translateY(12px) scale(.98);opacity:0;transition:transform .35s ease,opacity .35s ease}
  .va-gate.is-shown .va-gate__card{transform:translateY(0) scale(1);opacity:1}
  .va-gate__close{position:absolute;top:12px;right:14px;width:32px;height:32px;border-radius:50%;border:1px solid rgba(255,255,255,0.18);background:rgba(0,0,0,0.45);color:#fff;font-size:22px;line-height:1;cursor:pointer}
  .va-gate__badge{width:54px;height:54px;border-radius:14px;background:rgba(201,163,91,0.16);color:#C9A35B;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;border:1px solid rgba(201,163,91,0.35)}
  .va-gate__card h2{font-size:22px;text-align:center;margin:0 0 6px;font-weight:600;color:#FFFCF4}
  .va-gate__lede{font-size:13.5px;color:#B7B3A8;text-align:center;margin:0 0 22px;line-height:1.55}
  .va-gate__field{margin-bottom:14px}
  .va-gate__field label{display:block;font-size:11px;letter-spacing:.08em;text-transform:uppercase;color:#A39E91;margin-bottom:6px}
  .va-gate__field input{width:100%;padding:12px 14px;border-radius:10px;border:1px solid rgba(255,255,255,0.10);background:rgba(255,255,255,0.04);color:#fff;font-size:14px;font-family:inherit;transition:border-color .2s,background .2s}
  .va-gate__field input:focus{outline:none;border-color:#C9A35B;background:rgba(201,163,91,0.07)}
  .va-gate__cta{width:100%;padding:14px;border:0;border-radius:12px;background:linear-gradient(135deg,#C9A35B,#A8843E);color:#1A1A1A;font-weight:600;font-size:14px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;margin-top:8px;letter-spacing:.02em;transition:transform .2s,box-shadow .2s}
  .va-gate__cta:hover{transform:translateY(-1px);box-shadow:0 14px 30px rgba(201,163,91,0.35)}
  .va-gate__cta:disabled{opacity:.7;cursor:default;transform:none;box-shadow:none}
  .va-gate__note{font-size:11px;color:#8B8676;text-align:center;margin:12px 0 0}
  .va-gate__error{margin-top:10px;padding:10px 12px;border-radius:8px;background:rgba(229,62,62,0.12);color:#fca5a5;font-size:12px;border:1px solid rgba(229,62,62,0.3)}
  body.va-gate-open{overflow:hidden}
</style>

<script>
(function(){
  var modal   = document.getElementById('vaSignupGate');
  if (!modal) return;
  var form    = document.getElementById('vaGateForm');
  var errBox  = document.getElementById('vaGateError');
  var fId     = document.getElementById('vaGateId');
  var fName   = document.getElementById('vaGateName');
  var fSlug   = document.getElementById('vaGateSlug');
  var fNext   = document.getElementById('vaGateNext');
  var alreadyUnlocked = <?= $gateUnlocked ? 'true' : 'false' ?>;

  function hasUnlockCookie(){
    return alreadyUnlocked || document.cookie.split(';').some(function(c){
      return c.trim().indexOf('va_unlocked=') === 0;
    });
  }

  function openGate(href, slug, title, id){
    fNext.value = href || '';
    fSlug.value = slug || '';
    fName.value = title || '';
    fId.value   = id || '';
    modal.hidden = false;
    document.body.classList.add('va-gate-open');
    requestAnimationFrame(function(){ modal.classList.add('is-shown'); });
    setTimeout(function(){
      var firstEmpty = form.querySelector('input[required]:not([value]):not([readonly]), input[required][value=""]');
      (firstEmpty || form.querySelector('input[name="name"]')).focus();
    }, 50);
  }
  function closeGate(){
    modal.classList.remove('is-shown');
    setTimeout(function(){ modal.hidden = true; document.body.classList.remove('va-gate-open'); }, 300);
  }
  modal.querySelectorAll('[data-va-gate-close]').forEach(function(el){ el.addEventListener('click', closeGate); });
  document.addEventListener('keydown', function(e){ if (e.key === 'Escape' && !modal.hidden) closeGate(); });

  // Intercept clicks on any element flagged data-va-gate OR on detail links inside property cards.
  document.addEventListener('click', function(e){
    var trigger = e.target.closest('[data-va-gate], a[href^="/property/"]');
    if (!trigger) return;
    // Skip if already unlocked or if it's the explicit opt-out attribute.
    if (trigger.hasAttribute('data-va-gate-skip')) return;
    if (hasUnlockCookie()) return;

    var href  = trigger.getAttribute('href') || trigger.getAttribute('data-href') || '';
    var slug  = trigger.getAttribute('data-property-slug') || (href.indexOf('/property/') === 0 ? href.replace('/property/', '') : '');
    var title = trigger.getAttribute('data-property-title') || '';
    var pid   = trigger.getAttribute('data-property-id')    || '';
    if (!href && slug) href = '/property/' + slug;
    if (!href) return;

    e.preventDefault();
    openGate(href, slug, title, pid);
  });

  // Submit via fetch so we can redirect after success.
  form.addEventListener('submit', function(e){
    e.preventDefault();
    errBox.hidden = true;
    var btn = form.querySelector('button[type="submit"]');
    btn.disabled = true;
    var data = new FormData(form);
    fetch(form.action, {
      method: 'POST',
      body: data,
      credentials: 'same-origin',
      headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(function(r){ return r.json().catch(function(){ return {}; }); })
    .then(function(res){
      if (res && res.ok) {
        document.cookie = 'va_unlocked=1; max-age=' + (60*60*24*30) + '; path=/; SameSite=Lax';
        alreadyUnlocked = true;
        var next = fNext.value || '/';
        window.location.assign(next);
      } else {
        errBox.textContent = (res && res.errors)
          ? Object.values(res.errors).flat().join(' ')
          : 'Could not submit — please check your details and try again.';
        errBox.hidden = false;
        btn.disabled = false;
      }
    })
    .catch(function(){
      errBox.textContent = 'Network error. Please try again.';
      errBox.hidden = false;
      btn.disabled = false;
    });
  });
})();
</script>
