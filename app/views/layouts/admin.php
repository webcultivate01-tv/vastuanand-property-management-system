<?php
/** @var \App\Core\View $view */
$current = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$adminName  = $_SESSION['admin']['name']  ?? 'Super Admin';
$adminEmail = $_SESSION['admin']['email'] ?? 'admin@vastuanand.com';
$adminRole  = strtoupper($_SESSION['admin']['role'] ?? 'SUPER');
$adminInitial = strtoupper(mb_substr($adminName, 0, 1));
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($title ?? 'Admin · Vastu Anand') ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= asset('css/luxury.css') ?>">
</head>
<body>
<?php
$nav = [
  'OVERVIEW' => [
    ['/admin/dashboard',    'Dashboard',    'dashboard'],
  ],
  'CATALOG' => [
    ['/admin/properties',   'Properties',   'home'],
    ['/admin/blogs',        'Blogs',        'edit'],
    ['/admin/gallery',      'Gallery',      'image'],
  ],
  'CUSTOMERS' => [
    ['/admin/leads',        'Inquiries',    'chat'],
    ['/admin/testimonials', 'Reviews',      'star'],
  ],
  'TEAM' => [
    ['/admin/careers',      'Careers',      'briefcase'],
  ],
  'SYSTEM' => [
    ['/admin/popups',       'Popups',       'megaphone'],
    ['/admin/settings',     'Settings',     'settings'],
  ],
];

function admin_icon(string $key): string {
  $icons = [
    'dashboard' => '<rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/>',
    'home'      => '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/>',
    'edit'      => '<path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z"/>',
    'image'     => '<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/>',
    'chat'      => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
    'star'      => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>',
    'briefcase' => '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>',
    'megaphone' => '<path d="M3 11l18-8v18l-18-8z"/><path d="M11 11v6"/>',
    'settings'  => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>',
    'logout'    => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>',
    'back'      => '<line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>',
    'search'    => '<circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>',
    'calc'      => '<rect x="4" y="2" width="16" height="20" rx="2"/><line x1="8" y1="6" x2="16" y2="6"/><line x1="8" y1="10" x2="10" y2="10"/><line x1="12" y1="10" x2="14" y2="10"/><line x1="8" y1="14" x2="10" y2="14"/><line x1="12" y1="14" x2="14" y2="14"/><line x1="8" y1="18" x2="10" y2="18"/><line x1="12" y1="18" x2="14" y2="18"/>',
    'moon'      => '<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>',
    'bell'      => '<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>',
  ];
  $path = $icons[$key] ?? '';
  return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' . $path . '</svg>';
}
$pageTitle = $title ?? 'Admin Panel';
?>
<div class="admin-shell">
  <aside class="admin-side">
    <div class="admin-side__brand">
      <div class="admin-side__brand-logo">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
      </div>
      <div class="admin-side__brand-text">
        <strong>Vastu Anand</strong>
        <span>Admin Console</span>
      </div>
    </div>

    <nav class="admin-side__nav">
      <?php foreach ($nav as $section => $items): ?>
        <div class="admin-side__section"><?= e($section) ?></div>
        <?php foreach ($items as [$href, $label, $icon]):
          $active = $current === $href || str_starts_with($current, $href . '/');
        ?>
          <a href="<?= $href ?>" class="<?= $active ? 'active' : '' ?>">
            <?= admin_icon($icon) ?>
            <span><?= e($label) ?></span>
          </a>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </nav>

    <div class="admin-side__footer">
      <a href="/" target="_blank"><?= admin_icon('back') ?><span>Back to Site</span></a>
      <form action="/admin/logout" method="post" style="margin:0">
        <?= csrf_field() ?>
        <button type="submit"><?= admin_icon('logout') ?><span>Logout</span></button>
      </form>
    </div>
  </aside>

  <main class="admin-main">
    <div class="admin-topbar">
      <div class="admin-topbar__status">
        <span class="admin-topbar__dot"></span>
        Live
      </div>
      <div class="admin-topbar__divider"></div>
      <div class="admin-topbar__title"><?= e($pageTitle) ?></div>

      <div class="admin-topbar__search">
        <?= admin_icon('search') ?>
        <input type="text" placeholder="Search or jump to…" id="adminSearch">
        <span class="admin-topbar__kbd">Ctrl K</span>
      </div>

      <div class="admin-topbar__actions">
        <button class="admin-topbar__icon-btn" title="EMI Calculator" onclick="window.open('/','_blank')"><?= admin_icon('calc') ?></button>
        <button class="admin-topbar__icon-btn" title="Theme" id="adminTheme"><?= admin_icon('moon') ?></button>
        <button class="admin-topbar__icon-btn" title="Notifications"><?= admin_icon('bell') ?><span class="badge"></span></button>

        <div class="admin-topbar__user">
          <div class="admin-topbar__user-info">
            <strong><?= e($adminName) ?></strong>
            <span><?= e($adminEmail) ?></span>
          </div>
          <div class="admin-topbar__avatar"><?= e($adminInitial) ?></div>
          <span class="admin-topbar__role-chip"><?= e($adminRole) ?></span>
        </div>
      </div>
    </div>

    <div class="admin-main__content">
      <?php if (!empty($_SESSION['_flash']['success'])): ?>
        <div class="admin-flash"><?= e($_SESSION['_flash']['success']) ?></div>
        <?php unset($_SESSION['_flash']['success']); ?>
      <?php endif; ?>

      <?= $view->yield('content') ?>
    </div>
  </main>
</div>

<script>
  document.addEventListener('keydown', e => {
    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
      e.preventDefault();
      document.getElementById('adminSearch')?.focus();
    }
  });
</script>
</body>
</html>
