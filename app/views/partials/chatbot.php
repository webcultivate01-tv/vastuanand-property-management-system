<style>
.va-chat { position: fixed; right: 22px; bottom: 100px; z-index: 80; width: 360px; max-width: calc(100vw - 44px); height: 460px; max-height: calc(100vh - 160px); background: var(--surface); border: 1px solid var(--line); border-radius: 18px; box-shadow: var(--shadow-3); display: flex; flex-direction: column; transform-origin: bottom right; transform: scale(.92) translateY(12px); opacity: 0; pointer-events: none; transition: transform .35s var(--ease), opacity .35s var(--ease); overflow: hidden; }
.va-chat.open { transform: scale(1) translateY(0); opacity: 1; pointer-events: auto; }
.va-chat__head { padding: 16px 18px; background: var(--surface-2); border-bottom: 1px solid var(--line); display: flex; align-items: center; gap: 12px; }
.va-chat__avatar { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--gold), var(--gold-deep)); display: grid; place-items: center; color: #fff; font-size: 15px; font-weight: 700; }
.va-chat__title { font-size: 15px; font-weight: 600; color: var(--ink); }
.va-chat__sub { font-size: 11px; color: var(--slate-2); margin-top: 2px; }
.va-chat__body { flex: 1; overflow-y: auto; padding: 18px; display: flex; flex-direction: column; gap: 10px; }
.va-chat__bubble { max-width: 80%; padding: 9px 13px; border-radius: 12px; font-size: 13.5px; line-height: 1.5; }
.va-chat__bubble--bot { background: var(--surface-2); color: var(--ink); align-self: flex-start; border: 1px solid var(--line); }
.va-chat__bubble--user { background: var(--ink); color: #fff; align-self: flex-end; }
.va-chat__form { padding: 12px; border-top: 1px solid var(--line); display: flex; gap: 8px; }
.va-chat__form input { flex: 1; background: var(--surface); border: 1px solid var(--line); border-radius: 10px; padding: 10px 12px; color: var(--ink); font-size: 13px; font-family: inherit; }
.va-chat__form input:focus { outline: none; border-color: var(--ink); }
.va-chat__form button { background: var(--ink); color: #fff; border: none; padding: 0 16px; border-radius: 10px; cursor: pointer; font-weight: 600; font-family: inherit; }
.va-chat__form button:hover { background: var(--gold); }
.va-chat-toggle { position: fixed; right: 22px; bottom: 96px; z-index: 70; width: 52px; height: 52px; border-radius: 50%; background: var(--surface); border: 1px solid var(--line); display: grid; place-items: center; color: var(--ink); cursor: pointer; box-shadow: var(--shadow-2); transition: transform .2s var(--ease); }
.va-chat-toggle:hover { transform: translateY(-2px); color: var(--gold); }
</style>
<button id="vaChatToggle" class="va-chat-toggle" aria-label="Open chat">
  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5Z"/></svg>
</button>
<div id="vaChat" class="va-chat">
  <div class="va-chat__head">
    <div class="va-chat__avatar">A</div>
    <div>
      <div class="va-chat__title">Anand — Concierge</div>
      <div class="va-chat__sub">We typically reply in 2 minutes</div>
    </div>
  </div>
  <div id="vaChatBody" class="va-chat__body">
    <div class="va-chat__bubble va-chat__bubble--bot">Hello! I'm Anand. Are you looking to <b>buy</b>, <b>rent</b>, or <b>sell</b> a property in Mumbai today?</div>
  </div>
  <form id="vaChatForm" class="va-chat__form">
    <input type="text" placeholder="Type your question…" autocomplete="off" required>
    <button type="submit">→</button>
  </form>
</div>
