<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<?php
$currentAdminId = $_SESSION['admin']['id'] ?? null;
$totalAdmins    = count($items);
?>

<div class="admin-page-head">
  <div>
    <h1>Admin Users</h1>
    <p>Manage who can sign in to the admin console.</p>
  </div>
  <a href="/admin/admins/create" class="btn btn-primary">+ New Admin</a>
</div>

<?php if ($totalAdmins === 0): ?>
  <div class="admin-card">
    <p class="muted" style="margin:0">
      No admin users in the database yet. The <code>.env</code> bootstrap admin
      (<strong><?= e(env('ADMIN_EMAIL', '')) ?></strong>) can still sign in. Create your first
      real admin to take over.
    </p>
  </div>
<?php else: ?>
  <div class="admin-card" style="padding:0;overflow:hidden">
    <table class="admin-table">
      <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Created</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($items as $a):
          $isSelf = $currentAdminId && (string)$currentAdminId === (string)($a['id'] ?? '');
        ?>
          <tr>
            <td>
              <strong><?= e($a['name'] ?? '—') ?></strong>
              <?php if ($isSelf): ?><span class="chip" style="margin-left:6px">You</span><?php endif; ?>
            </td>
            <td class="muted"><?= e($a['email'] ?? '') ?></td>
            <td><span class="chip"><?= e(strtoupper($a['role'] ?? 'admin')) ?></span></td>
            <td class="muted"><?= e($a['createdAt'] ?? '') ?></td>
            <td style="text-align:right">
              <a href="/admin/admins/<?= e($a['id']) ?>/edit" class="va-link-arrow">Edit</a>
              <?php if (!$isSelf && $totalAdmins > 1): ?>
                <form method="post" action="/admin/admins/<?= e($a['id']) ?>/delete"
                      style="display:inline"
                      onsubmit="return confirm('Delete admin user <?= e($a['email'] ?? '') ?>?')">
                  <?= csrf_field() ?>
                  <button class="btn btn-ghost" style="padding:6px 12px;font-size:11px">×</button>
                </form>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<?php $view->endSection(); ?>
