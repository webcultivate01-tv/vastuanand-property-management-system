<?php /** @var \App\Core\View $view */ $current = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH); ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($title ?? 'Admin · Vastu Anand') ?></title>
<link rel="stylesheet" href="<?= asset('css/luxury.css') ?>">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="admin-shell">
  <aside class="admin-side">
    <div class="brand">Vastu Anand</div>
    <?php
    $items = [
      ['/admin/dashboard', 'Dashboard', '🏠'],
      ['/admin/properties', 'Properties', '🏘️'],
      ['/admin/leads', 'Leads', '📞'],
      ['/admin/blogs', 'Blogs', '✍️'],
      ['/admin/testimonials', 'Testimonials', '⭐'],
      ['/admin/gallery', 'Gallery', '🖼️'],
      ['/admin/careers', 'Careers', '💼'],
      ['/admin/popups', 'Popups', '📣'],
      ['/admin/settings', 'Settings', '⚙️'],
    ];
    foreach ($items as [$href, $label, $icon]):
    ?>
      <a href="<?= $href ?>" class="<?= str_starts_with($current, $href) ? 'active' : '' ?>">
        <span style="opacity:0.8"><?= $icon ?></span> <?= $label ?>
      </a>
    <?php endforeach; ?>
    <form action="/admin/logout" method="post" style="margin-top:30px">
      <button type="submit" class="btn btn-ghost" style="width:100%">Logout</button>
    </form>
  </aside>

  <main class="admin-main">
    <?php if (!empty($_SESSION['_flash']['success'])): ?>
      <div style="padding:14px 18px;border-radius:10px;background:rgba(46,160,67,0.15);border:1px solid #2ea043;color:#7ee787;margin-bottom:24px">
        <?= e($_SESSION['_flash']['success']) ?>
      </div>
      <?php unset($_SESSION['_flash']['success']); ?>
    <?php endif; ?>

    <?= $view->yield('content') ?>
  </main>
</div>
</body>
</html>
