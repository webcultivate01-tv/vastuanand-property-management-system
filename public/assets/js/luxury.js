/* ─────────────────────────────────────────────
   VASTU ANAND — Global JS (lightweight, no deps)
   ───────────────────────────────────────────── */
(() => {
  'use strict';

  /* ── Loader ─────────────────────────────── */
  const hideLoader = () => {
    const el = document.getElementById('vaLoader');
    if (el && !el.classList.contains('hidden')) el.classList.add('hidden');
  };
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', hideLoader);
  } else {
    hideLoader();
  }
  setTimeout(hideLoader, 800);

  /* ── Navbar scroll ──────────────────────── */
  const nav = document.querySelector('.va-nav');
  if (nav) {
    const onScroll = () => nav.classList.toggle('scrolled', window.scrollY > 24);
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  /* ── Mobile menu ───────────────────────── */
  const burger = document.getElementById('vaBurger');
  const mobile = document.getElementById('vaMobile');
  if (burger && mobile) {
    burger.addEventListener('click', () => mobile.classList.toggle('open'));
    mobile.querySelectorAll('a').forEach(a => a.addEventListener('click', () => mobile.classList.remove('open')));
  }

  /* ── Smooth scroll for in-page anchors (native, no lib) ─ */
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const id = a.getAttribute('href');
      if (id.length > 1) {
        const target = document.querySelector(id);
        if (target) {
          e.preventDefault();
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      }
    });
  });

  /* ── Reveal animations (single IO, no deps) ── */
  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver(entries => {
      entries.forEach(en => {
        if (en.isIntersecting) {
          en.target.classList.add('in');
          io.unobserve(en.target);
        }
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
    document.querySelectorAll('[data-reveal]').forEach(el => io.observe(el));
  } else {
    document.querySelectorAll('[data-reveal]').forEach(el => el.classList.add('in'));
  }

  /* ── Counters ──────────────────────────── */
  const counters = document.querySelectorAll('[data-counter]');
  if (counters.length && 'IntersectionObserver' in window) {
    const cIo = new IntersectionObserver(entries => {
      entries.forEach(en => {
        if (en.isIntersecting) {
          const el = en.target;
          const target = parseFloat(el.dataset.counter);
          const suffix = el.dataset.suffix || '';
          const duration = 1100;
          const startTime = performance.now();
          const tick = (now) => {
            const t = Math.min(1, (now - startTime) / duration);
            const eased = 1 - Math.pow(1 - t, 3);
            const cur = Math.round(target * eased);
            el.textContent = cur + suffix;
            if (t < 1) requestAnimationFrame(tick);
            else el.textContent = target + suffix;
          };
          requestAnimationFrame(tick);
          cIo.unobserve(el);
        }
      });
    }, { threshold: 0.4 });
    counters.forEach(c => cIo.observe(c));
  }

  /* ── Property search tab toggle ────────── */
  document.querySelectorAll('.va-search__tabs').forEach(tabs => {
    const buttons = tabs.querySelectorAll('.va-search__tab');
    buttons.forEach(b => b.addEventListener('click', () => {
      buttons.forEach(x => x.classList.remove('active'));
      b.classList.add('active');
      const hidden = tabs.closest('form').querySelector('input[name="listing"]');
      if (hidden) hidden.value = b.dataset.listing;
    }));
  });

  /* ── Chatbot ──────────────────────────── */
  const chatToggle = document.getElementById('vaChatToggle');
  const chatBox    = document.getElementById('vaChat');
  const chatBody   = document.getElementById('vaChatBody');
  const chatForm   = document.getElementById('vaChatForm');
  if (chatToggle && chatBox) {
    chatToggle.addEventListener('click', () => chatBox.classList.toggle('open'));
  }
  if (chatForm) {
    chatForm.addEventListener('submit', async e => {
      e.preventDefault();
      const input = chatForm.querySelector('input');
      const msg = input.value.trim();
      if (!msg) return;
      appendChat('user', msg);
      input.value = '';
      try {
        const r = await fetch('/api/v1/chatbot', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ message: msg }),
        });
        const j = await r.json();
        appendChat('bot', j.reply || 'Connecting you to our advisor...');
      } catch { appendChat('bot', 'Network glitch — please WhatsApp +91 98765 43210.'); }
    });
  }
  function appendChat(who, text){
    if (!chatBody) return;
    const b = document.createElement('div');
    b.className = `va-chat__bubble va-chat__bubble--${who}`;
    b.textContent = text;
    chatBody.appendChild(b);
    chatBody.scrollTop = chatBody.scrollHeight;
  }

  /* ── EMI calculator ───────────────────── */
  const emiForm = document.getElementById('emiCalc');
  if (emiForm) {
    emiForm.addEventListener('submit', async e => {
      e.preventDefault();
      const fd = new FormData(emiForm);
      const r  = await fetch('/api/v1/calc/emi', {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body: JSON.stringify(Object.fromEntries(fd))
      });
      const j = await r.json();
      const out = document.getElementById('emiResult');
      if (out && j.ok) {
        out.innerHTML = `
          <div class="va-stat"><div class="va-stat__val">₹${j.emi.toLocaleString('en-IN')}</div><span class="va-stat__lbl">Monthly EMI</span></div>
          <div class="va-stat"><div class="va-stat__val">₹${(j.totalInterest/100000).toFixed(1)}L</div><span class="va-stat__lbl">Total Interest</span></div>
          <div class="va-stat"><div class="va-stat__val">₹${(j.totalPaid/10000000).toFixed(2)}Cr</div><span class="va-stat__lbl">Total Payment</span></div>`;
      }
    });
  }

  /* ── Async forms (data-ajax) ───────────── */
  document.querySelectorAll('form[data-ajax]').forEach(f => {
    f.addEventListener('submit', async e => {
      e.preventDefault();
      const btn = f.querySelector('button[type="submit"]');
      const orig = btn?.textContent;
      if (btn) { btn.disabled = true; btn.textContent = 'Sending…'; }
      try {
        const fd = new FormData(f);
        const r  = await fetch(f.action, { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        const j  = await r.json();
        showToast(j.message || (j.ok ? 'Sent successfully' : 'Something went wrong'), j.ok);
        if (j.ok) f.reset();
      } catch { showToast('Network error. Please try again.', false); }
      finally { if (btn) { btn.disabled = false; btn.textContent = orig; } }
    });
  });

  /* ── Testimonials swiper (when present) ── */
  if (window.Swiper && document.querySelector('.testimonialSwiper')) {
    new Swiper('.testimonialSwiper', {
      slidesPerView: 1,
      spaceBetween: 22,
      autoplay: { delay: 5500 },
      pagination: { el: '.swiper-pagination', clickable: true },
      breakpoints: { 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } },
    });
  }

  function showToast(msg, ok = true) {
    const t = document.createElement('div');
    t.style.cssText = `position:fixed;bottom:90px;right:22px;z-index:99;padding:12px 20px;border-radius:10px;background:${ok?'#0F1115':'#DC2626'};color:#fff;font-size:14px;font-weight:500;box-shadow:0 12px 30px -10px rgba(0,0,0,0.25);opacity:0;transition:opacity .25s,transform .25s;transform:translateY(10px)`;
    t.textContent = msg;
    document.body.appendChild(t);
    requestAnimationFrame(()=>{ t.style.opacity=1; t.style.transform='translateY(0)'; });
    setTimeout(()=>{ t.style.opacity=0; t.style.transform='translateY(10px)'; setTimeout(()=>t.remove(),300); }, 4000);
  }
  window.vaToast = showToast;
})();
