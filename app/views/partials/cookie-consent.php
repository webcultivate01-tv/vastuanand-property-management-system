<div class="va-cookie" id="vaCookie" hidden role="dialog" aria-live="polite" aria-label="Cookie consent">
  <div class="va-cookie__icon" aria-hidden="true">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <path d="M21.8 14a9 9 0 1 1-10-10c-.9 2 .3 4 2 4.2-.5 2.3 1.5 4 3.5 3.5.3 1.5 2 2.5 4.5 2.3Z"/>
      <circle cx="9"  cy="10" r=".7" fill="currentColor"/>
      <circle cx="14" cy="15" r=".7" fill="currentColor"/>
      <circle cx="8"  cy="15" r=".7" fill="currentColor"/>
      <circle cx="13" cy="9"  r=".7" fill="currentColor"/>
    </svg>
  </div>

  <div class="va-cookie__body">
    <h4>We value your privacy</h4>
    <p>
      We use cookies to enhance your browsing experience, serve relevant property recommendations
      and analyse traffic. By clicking <strong>&ldquo;Accept All&rdquo;</strong>, you consent to our use of cookies.
      Read our <a href="/privacy">Privacy Policy</a> for details.
    </p>
  </div>

  <div class="va-cookie__actions">
    <button type="button" class="va-cookie__btn va-cookie__btn--ghost" data-cookie="reject">Decline</button>
    <button type="button" class="va-cookie__btn va-cookie__btn--gold"  data-cookie="accept">Accept All</button>
  </div>

  <button type="button" class="va-cookie__close" data-cookie="reject" aria-label="Dismiss">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
  </button>
</div>

<script>
(function () {
  const KEY  = 'va_cookie_consent';
  const el   = document.getElementById('vaCookie');
  if (!el) return;

  // Already chose? do nothing.
  try { if (localStorage.getItem(KEY)) return; } catch (e) { /* private mode — show anyway */ }

  // Reveal after a short delay so it doesn't fight first-paint
  setTimeout(() => {
    el.hidden = false;
    requestAnimationFrame(() => el.classList.add('is-open'));
  }, 900);

  el.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-cookie]');
    if (!btn) return;
    const choice = btn.getAttribute('data-cookie'); // "accept" or "reject"
    try { localStorage.setItem(KEY, JSON.stringify({ choice, at: new Date().toISOString() })); } catch (e) {}
    el.classList.remove('is-open');
    setTimeout(() => { el.hidden = true; }, 350);
  });
})();
</script>
