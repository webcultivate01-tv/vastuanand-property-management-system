<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<div class="admin-page-head">
  <div>
    <h1><?= e($user['name'] ?? 'User') ?></h1>
    <p>Captured <?= e(substr((string)($user['createdAt'] ?? ''), 0, 16)) ?> · <?= (int)($user['views_count'] ?? 0) ?> property view<?= ((int)($user['views_count'] ?? 0)) === 1 ? '' : 's' ?>.</p>
  </div>
  <a href="/admin/users" class="btn btn-ghost">← Back</a>
</div>

<div class="grid cols-2" style="gap:18px;margin-bottom:24px">
  <div class="admin-card">
    <div class="admin-card__head"><div class="admin-card__title">Contact</div></div>
    <div style="display:grid;gap:10px;font-size:14px">
      <div><span class="muted">Email · </span><a href="mailto:<?= e($user['email'] ?? '') ?>" class="gold"><?= e($user['email'] ?? '—') ?></a></div>
      <div><span class="muted">Phone · </span><a href="tel:<?= e($user['phone'] ?? '') ?>" class="gold"><?= e($user['phone'] ?? '—') ?></a></div>
      <?php if (!empty($user['ip'])): ?>
      <div><span class="muted">IP · </span><?= e($user['ip']) ?></div>
      <?php endif; ?>
    </div>
  </div>
  <div class="admin-card">
    <div class="admin-card__head"><div class="admin-card__title">Engagement</div></div>
    <div style="display:grid;gap:10px;font-size:14px">
      <div><span class="muted">First seen · </span><?= e(substr((string)($user['createdAt'] ?? ''), 0, 16)) ?></div>
      <div><span class="muted">Last seen · </span><?= e(substr((string)($user['last_seen'] ?? $user['updatedAt'] ?? ''), 0, 16)) ?></div>
      <div><span class="muted">Properties viewed · </span><strong><?= (int)($user['views_count'] ?? 0) ?></strong></div>
    </div>
  </div>
</div>

<div class="admin-card mb-24">
  <div class="admin-card__head"><div class="admin-card__title">Properties Viewed</div></div>
  <?php if (empty($views)): ?>
    <p class="muted" style="margin:0">No property views logged.</p>
  <?php else: ?>
    <table class="admin-table">
      <thead><tr><th>Date</th><th>Property</th><th>Slug</th></tr></thead>
      <tbody>
        <?php foreach ($views as $v): ?>
          <tr>
            <td class="muted"><?= e(substr((string)($v['createdAt'] ?? ''), 0, 16)) ?></td>
            <td><strong><?= e($v['property_title'] ?? '—') ?></strong></td>
            <td>
              <?php if (!empty($v['property_slug'])): ?>
                <a href="/property/<?= e($v['property_slug']) ?>" class="gold" target="_blank" rel="noopener"><?= e($v['property_slug']) ?></a>
              <?php else: ?>—<?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<div class="admin-card">
  <div class="admin-card__head"><div class="admin-card__title">Related Inquiries</div></div>
  <?php if (empty($leads)): ?>
    <p class="muted" style="margin:0">No inquiries logged for this email.</p>
  <?php else: ?>
    <table class="admin-table">
      <thead><tr><th>Date</th><th>Source</th><th>Property</th><th>Status</th><th>Message</th></tr></thead>
      <tbody>
        <?php foreach ($leads as $l): ?>
          <tr>
            <td class="muted"><?= e(substr((string)($l['createdAt'] ?? ''), 0, 16)) ?></td>
            <td><span class="chip"><?= e($l['source'] ?? '—') ?></span></td>
            <td><?= e($l['property'] ?? '—') ?></td>
            <td><span class="chip chip-gold"><?= e($l['status'] ?? 'new') ?></span></td>
            <td class="muted" style="font-size:12px"><?= e(mb_strimwidth((string)($l['message'] ?? ''), 0, 80, '…')) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php $view->endSection(); ?>
