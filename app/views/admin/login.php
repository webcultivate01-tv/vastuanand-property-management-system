<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin Login · Vastu Anand</title>
<link rel="stylesheet" href="<?= asset('css/luxury.css') ?>">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400&family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body style="min-height:100vh;display:grid;place-items:center;padding:24px;background:radial-gradient(circle at 50% 0%,rgba(201,163,91,0.06),transparent 60%),#050505">
  <div style="width:100%;max-width:440px">
    <div style="text-align:center;margin-bottom:36px">
      <div style="width:60px;height:60px;border-radius:50%;border:1px solid var(--gold);color:var(--gold);font-family:'Cormorant Garamond',serif;font-size:28px;display:grid;place-items:center;margin:0 auto 18px">Va</div>
      <h1 style="font-family:'Cormorant Garamond',serif;font-size:36px;color:var(--gold);margin:0">Vastu Anand</h1>
      <div class="eyebrow" style="justify-content:center;margin-top:8px">ADMIN CONSOLE</div>
    </div>

    <div class="glass" style="padding:36px">
      <?php if (!empty($_SESSION['_errors'])): ?>
        <div style="padding:12px 16px;border-radius:10px;background:rgba(255,80,80,0.12);border:1px solid #a55;color:#ffb4b4;margin-bottom:20px;font-size:14px">
          <?= e(implode(' ', array_merge(...array_values($_SESSION['_errors'])))) ?>
        </div>
        <?php unset($_SESSION['_errors']); ?>
      <?php endif; ?>

      <form action="/admin/login" method="post">
        <?= csrf_field() ?>
        <div class="form-group"><label>Email</label><input class="form-control" name="email" type="email" required autofocus></div>
        <div class="form-group"><label>Password</label><input class="form-control" name="password" type="password" required></div>
        <button class="btn btn-primary" style="width:100%" type="submit">Sign In</button>
      </form>
      <p style="text-align:center;color:var(--pearl-faint);font-size:12px;margin:24px 0 0">Authorised personnel only</p>
    </div>
  </div>
</body>
</html>
