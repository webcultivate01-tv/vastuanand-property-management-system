<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<div class="admin-page-head">
  <div>
    <h1>Users</h1>
    <p>Visitors who unlocked property details by sharing their name, email and mobile.</p>
  </div>
  <div style="display:flex;gap:10px">
    <a href="/admin/users/export?format=csv&q=<?= e($q) ?>" class="btn btn-ghost">Export CSV</a>
    <a href="/admin/users/export?format=excel&q=<?= e($q) ?>" class="btn btn-ghost">Excel</a>
    <a href="/admin/users/export?format=pdf&q=<?= e($q) ?>" target="_blank" class="btn btn-primary">PDF</a>
  </div>
</div>

<div class="grid cols-3" style="gap:14px;margin-bottom:24px">
  <div class="va-stat">
    <div class="va-stat__val"><?= number_format($total) ?></div>
    <span class="va-stat__lbl">Total Captured</span>
  </div>
  <div class="va-stat">
    <div class="va-stat__val"><?= number_format(count($result['data'] ?? [])) ?></div>
    <span class="va-stat__lbl">On this page</span>
  </div>
  <div class="va-stat">
    <div class="va-stat__val"><?= number_format($result['pages'] ?? 1) ?></div>
    <span class="va-stat__lbl">Pages</span>
  </div>
</div>

<form method="get" class="flex gap-16 mb-24">
  <input type="text" name="q" value="<?= e($q) ?>" class="form-control" placeholder="Search name, email or phone…" style="max-width:380px">
  <button type="submit" class="btn btn-ghost">Search</button>
  <?php if ($q !== ''): ?>
    <a href="/admin/users" class="btn btn-ghost">Clear</a>
  <?php endif; ?>
</form>

<div class="admin-card" style="padding:0;overflow:hidden">
  <table class="admin-table">
    <thead>
      <tr>
        <th>Captured</th>
        <th>Name</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>Last Property Viewed</th>
        <th>Views</th>
        <th style="text-align:right">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($result['data'])): ?>
        <tr>
          <td colspan="7" style="text-align:center;padding:48px 20px" class="muted">
            <?php if ($q !== ''): ?>
              No users match "<?= e($q) ?>".
            <?php else: ?>
              No users captured yet. They will appear here when visitors unlock a property detail page.
            <?php endif; ?>
          </td>
        </tr>
      <?php else: ?>
        <?php foreach ($result['data'] as $u):
          $phoneDigits = preg_replace('/\D/', '', (string)($u['phone'] ?? ''));
          $waNumber    = $phoneDigits ? ltrim($phoneDigits, '0') : '';
        ?>
          <tr>
            <td class="muted"><?= e(substr((string)($u['createdAt'] ?? ''), 0, 16)) ?></td>
            <td><strong><?= e($u['name'] ?? '—') ?></strong></td>
            <td><a href="mailto:<?= e($u['email'] ?? '') ?>" class="gold"><?= e($u['email'] ?? '—') ?></a></td>
            <td><a href="tel:<?= e($u['phone'] ?? '') ?>" class="gold"><?= e($u['phone'] ?? '—') ?></a></td>
            <td>
              <?php if (!empty($u['last_property_slug'])): ?>
                <a href="/property/<?= e($u['last_property_slug']) ?>" target="_blank" rel="noopener" class="gold" style="font-weight:500;text-decoration:none"><?= e($u['last_property'] ?? 'View') ?></a>
              <?php else: ?>
                <?= e($u['last_property'] ?? '—') ?>
              <?php endif; ?>
            </td>
            <td><span class="chip"><?= (int)($u['views_count'] ?? 0) ?></span></td>
            <td style="text-align:right">
              <div class="admin-quick-actions">
                <a href="/admin/users/<?= e($u['id']) ?>" class="admin-qa" title="View detail" style="background:rgba(201,163,91,0.16);color:#C9A35B">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </a>
                <?php if ($waNumber): ?>
                  <a class="admin-qa admin-qa--wa" href="https://wa.me/<?= e($waNumber) ?>" target="_blank" rel="noopener" title="WhatsApp">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M20.5 3.5A11 11 0 0 0 3 17.2L1.5 22.5l5.4-1.4A11 11 0 1 0 20.5 3.5Z"/></svg>
                  </a>
                <?php endif; ?>
                <?php if (!empty($u['email'])): ?>
                  <a class="admin-qa admin-qa--email" href="mailto:<?= e($u['email']) ?>" title="Email">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><polyline points="3 7 12 13 21 7"/></svg>
                  </a>
                <?php endif; ?>
                <form method="post" action="/admin/users/<?= e($u['id']) ?>/delete" style="display:inline" onsubmit="return confirm('Remove this user?');">
                  <?= csrf_field() ?>
                  <button type="submit" class="admin-qa" title="Remove" style="background:rgba(229,62,62,0.12);color:#e53e3e;border-color:rgba(229,62,62,0.25);cursor:pointer">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php if (($result['pages'] ?? 1) > 1): ?>
  <div class="flex items-center gap-8" style="justify-content:center;margin-top:24px">
    <?php for ($i = 1; $i <= $result['pages']; $i++): ?>
      <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"
         class="btn <?= ($result['page'] ?? 1) === $i ? 'btn-primary' : 'btn-ghost' ?>"
         style="padding:6px 14px;font-size:13px"><?= $i ?></a>
    <?php endfor; ?>
  </div>
<?php endif; ?>

<?php $view->endSection(); ?>
