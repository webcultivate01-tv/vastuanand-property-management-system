<style>
.va-chat { position: fixed; right: 22px; bottom: 100px; z-index: 80; width: 360px; max-width: calc(100vw - 44px); height: 460px; max-height: calc(100vh - 160px); background: linear-gradient(180deg,#101010,#070707); border:1px solid rgba(201,163,91,0.25); border-radius: 22px; box-shadow: 0 30px 80px -25px rgba(0,0,0,0.9); display: flex; flex-direction: column; transform-origin: bottom right; transform: scale(.85) translateY(20px); opacity: 0; pointer-events: none; transition: all .5s cubic-bezier(.22,1,.36,1); overflow: hidden; }
.va-chat.open { transform: scale(1) translateY(0); opacity: 1; pointer-events: auto; }
.va-chat__head { padding: 18px 20px; background: linear-gradient(135deg,rgba(201,163,91,0.18),rgba(0,0,0,0)); border-bottom: 1px solid rgba(255,255,255,0.06); display:flex; align-items:center; gap:12px; }
.va-chat__avatar { width:36px; height:36px; border-radius:50%; background: linear-gradient(135deg,#C9A35B,#8B6F30); display:grid; place-items:center; color:#0a0a0a; font-family:'Cormorant Garamond',serif; font-size:20px; }
.va-chat__title { font-family:'Cormorant Garamond',serif; font-size:18px; color:#F5F2EC; }
.va-chat__sub { font-size:11px; letter-spacing:0.18em; text-transform:uppercase; color:#C9A35B; }
.va-chat__body { flex: 1; overflow-y: auto; padding: 20px; display: flex; flex-direction: column; gap: 10px; }
.va-chat__bubble { max-width: 80%; padding: 10px 14px; border-radius: 14px; font-size: 13.5px; line-height: 1.5; }
.va-chat__bubble--bot { background: rgba(255,255,255,0.04); color: #F5F2EC; align-self: flex-start; border:1px solid rgba(255,255,255,0.06); }
.va-chat__bubble--user { background: linear-gradient(135deg,#C9A35B,#8B6F30); color: #0a0a0a; align-self: flex-end; }
.va-chat__form { padding: 12px; border-top: 1px solid rgba(255,255,255,0.06); display: flex; gap: 8px; }
.va-chat__form input { flex:1; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; padding: 12px 14px; color: #F5F2EC; font-size: 13px; }
.va-chat__form input:focus { outline:none; border-color:#C9A35B; }
.va-chat__form button { background:#C9A35B; color:#0a0a0a; border:none; padding: 0 16px; border-radius: 10px; cursor:pointer; font-weight:700; }
.va-chat-toggle { position: fixed; right: 22px; bottom: 96px; z-index: 70; width: 56px; height: 56px; border-radius:50%; background: linear-gradient(135deg,#161616,#0a0a0a); border:1px solid #C9A35B; display:grid; place-items:center; color:#C9A35B; cursor:pointer; box-shadow: 0 12px 30px -10px rgba(0,0,0,0.6); }
.va-chat-toggle:hover { color: #E6C887; }
</style>
<button id="vaChatToggle" class="va-chat-toggle" aria-label="Open chat">
  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5Z"/></svg>
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
