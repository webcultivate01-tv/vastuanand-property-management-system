/* ─────────────────────────────────────────────
   VASTU ANAND — LUXURY GLOBAL JS
   Lenis smooth-scroll · GSAP reveals · UI hooks
   ───────────────────────────────────────────── */
(() => {
  'use strict';

  /* ── Loader ─────────────────────────────── */
  const hideLoader = () => {
    const el = document.getElementById('vaLoader');
    if (el && !el.classList.contains('hidden')) el.classList.add('hidden');
  };
  // Hide as soon as DOM is parsed (don't wait for slow CDN assets on dev server)
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => setTimeout(hideLoader, 400));
  } else {
    setTimeout(hideLoader, 100);
  }
  // Safety net: never let the loader hang for more than 1.5 s
  setTimeout(hideLoader, 1500);

  /* ── Navbar scroll ──────────────────────── */
  const nav = document.querySelector('.va-nav');
  if (nav) {
    const onScroll = () => nav.classList.toggle('scrolled', window.scrollY > 40);
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

  /* ── Lenis smooth scroll ───────────────── */
  if (window.Lenis) {
    const lenis = new Lenis({ duration: 1.4, easing: t => 1 - Math.pow(1 - t, 3), smoothWheel: true });
    function raf(t){ lenis.raf(t); requestAnimationFrame(raf); }
    requestAnimationFrame(raf);
    document.querySelectorAll('a[href^="#"]').forEach(a => {
      a.addEventListener('click', e => {
        const id = a.getAttribute('href');
        if (id.length > 1 && document.querySelector(id)) {
          e.preventDefault();
          lenis.scrollTo(id, { offset: -80 });
        }
      });
    });
  }

  /* ── AOS-like reveals (no dependency) ──── */
  const io = new IntersectionObserver(entries => {
    entries.forEach(en => {
      if (en.isIntersecting) {
        en.target.classList.add('in');
        io.unobserve(en.target);
      }
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });
  document.querySelectorAll('[data-reveal]').forEach(el => io.observe(el));

  /* ── GSAP cinematic hero ───────────────── */
  if (window.gsap) {
    gsap.from('.va-hero__eyebrow', { y: 24, opacity: 0, duration: 1.2, ease: 'power3.out', delay: .3 });
    gsap.from('.va-hero h1 .word', { y: 60, opacity: 0, duration: 1.2, ease: 'power3.out', stagger: .08, delay: .5 });
    gsap.from('.va-hero p.lede', { y: 24, opacity: 0, duration: 1, ease: 'power3.out', delay: 1.1 });
    gsap.from('.va-hero__cta > *', { y: 16, opacity: 0, duration: .9, ease: 'power3.out', stagger: .1, delay: 1.3 });
    gsap.from('.va-search', { y: 32, opacity: 0, duration: 1.1, ease: 'power3.out', delay: 1.5 });
  }

  /* Split hero headline into spans for stagger */
  const hero = document.querySelector('.va-hero h1');
  if (hero && !hero.dataset.split) {
    hero.dataset.split = '1';
    hero.innerHTML = hero.innerHTML.split(' ').map(w =>
      `<span style="display:inline-block;overflow:hidden"><span class="word" style="display:inline-block">${w}&nbsp;</span></span>`
    ).join('');
  }

  /* ── Counters ──────────────────────────── */
  const counters = document.querySelectorAll('[data-counter]');
  const cIo = new IntersectionObserver(entries => {
    entries.forEach(en => {
      if (en.isIntersecting) {
        const el = en.target;
        const target = parseFloat(el.dataset.counter);
        const suffix = el.dataset.suffix || '';
        let cur = 0;
        const step = target / 60;
        const tick = () => {
          cur += step;
          if (cur >= target) { el.textContent = target + suffix; return; }
          el.textContent = Math.round(cur) + suffix;
          requestAnimationFrame(tick);
        };
        tick();
        cIo.unobserve(el);
      }
    });
  }, { threshold: 0.4 });
  counters.forEach(c => cIo.observe(c));

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

  function showToast(msg, ok = true) {
    const t = document.createElement('div');
    t.style.cssText = `position:fixed;bottom:90px;right:22px;z-index:99;padding:14px 22px;border-radius:12px;background:${ok?'rgba(20,30,20,0.96)':'rgba(40,20,20,0.96)'};color:#F5F2EC;border:1px solid ${ok?'#C9A35B':'#a55'};font-size:14px;backdrop-filter:blur(10px);box-shadow:0 12px 30px -10px rgba(0,0,0,0.6);opacity:0;transition:opacity .4s,transform .4s;transform:translateY(20px)`;
    t.textContent = msg;
    document.body.appendChild(t);
    requestAnimationFrame(()=>{ t.style.opacity=1; t.style.transform='translateY(0)'; });
    setTimeout(()=>{ t.style.opacity=0; t.style.transform='translateY(20px)'; setTimeout(()=>t.remove(),400); }, 4500);
  }
  window.vaToast = showToast;
})();
