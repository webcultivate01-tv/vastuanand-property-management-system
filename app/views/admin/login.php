<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin Login · Vastu Anand</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= asset('css/luxury.css') ?>">
</head>
<body style="min-height:100vh;display:grid;place-items:center;padding:24px;background:radial-gradient(circle at 20% 0%,#F5EFE2 0%,transparent 55%),radial-gradient(circle at 100% 100%,#EEF0FF 0%,transparent 55%),var(--bg)">
  <div style="width:100%;max-width:420px">
    <div style="text-align:center;margin-bottom:32px">
      <div style="width:56px;height:56px;border-radius:14px;background:linear-gradient(135deg,var(--gold),var(--gold-deep));color:#fff;display:grid;place-items:center;margin:0 auto 16px;box-shadow:0 8px 20px -6px rgba(176,137,71,0.5)">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
      </div>
      <h1 style="font-size:24px;font-weight:700;margin:0;color:var(--ink);letter-spacing:-0.02em">Vastu Anand</h1>
      <div style="font-size:11px;letter-spacing:0.22em;color:var(--gold);text-transform:uppercase;font-weight:600;margin-top:6px">Admin Console</div>
    </div>

    <div class="admin-card" style="padding:32px;box-shadow:var(--shadow-3)">
      <?php if (!empty($_SESSION['_errors'])): ?>
        <div class="admin-flash error">
          <?= e(implode(' ', array_merge(...array_values($_SESSION['_errors'])))) ?>
        </div>
        <?php unset($_SESSION['_errors']); ?>
      <?php endif; ?>

      <h2 style="font-size:18px;font-weight:600;margin:0 0 4px">Welcome back</h2>
      <p class="muted" style="font-size:13px;margin:0 0 22px">Sign in to manage your portfolio.</p>

      <form action="/admin/login" method="post">
        <?= csrf_field() ?>
        <div class="form-group"><label>Email</label><input class="form-control" name="email" type="email" required autofocus placeholder="you@vastuanand.com"></div>
        <div class="form-group"><label>Password</label><input class="form-control" name="password" type="password" required placeholder="••••••••"></div>
        <button class="btn btn-primary" style="width:100%;justify-content:center" type="submit">Sign In</button>
      </form>
      <p style="text-align:center;color:var(--slate-3);font-size:12px;margin:22px 0 0">Authorised personnel only</p>
    </div>

    <p style="text-align:center;color:var(--slate-3);font-size:12px;margin-top:20px">
      <a href="/" style="color:var(--slate);font-weight:500">← Back to website</a>
    </p>
  </div>
</body>
</html>
