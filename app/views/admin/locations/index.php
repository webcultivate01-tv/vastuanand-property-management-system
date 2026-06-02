<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<div class="admin-page-head">
  <div>
    <h1>Locations</h1>
    <p>Manage the location options shown in the home page filter.</p>
  </div>
</div>

<div class="admin-card" style="margin-bottom:16px">
  <form method="post" action="/admin/locations" class="grid" style="grid-template-columns:1fr 110px auto;gap:12px;align-items:end">
    <?= csrf_field() ?>
    <div>
      <label class="form-label">Location name</label>
      <input type="text" name="name" class="form-control" placeholder="e.g. Bandra West" required>
    </div>
    <div>
      <label class="form-label">Order</label>
      <input type="number" name="order" class="form-control" value="0">
    </div>
    <button type="submit" class="btn btn-primary">+ Add</button>
  </form>
</div>

<?php if (empty($items)): ?>
  <div class="admin-card">
    <p class="muted" style="margin:0">No locations yet. Add your first one above.</p>
  </div>
<?php else: ?>
  <div class="admin-card" style="padding:0;overflow:hidden">
    <table class="admin-table">
      <thead><tr><th>Name</th><th>Slug</th><th>Order</th><th>Status</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($items as $loc): ?>
          <tr>
            <td><strong><?= e($loc['name'] ?? '—') ?></strong></td>
            <td class="muted"><?= e($loc['slug'] ?? '') ?></td>
            <td class="muted"><?= (int)($loc['order'] ?? 0) ?></td>
            <td>
              <?php if (!empty($loc['active'])): ?>
                <span class="chip" style="background:#16a34a22;color:#16a34a">ACTIVE</span>
              <?php else: ?>
                <span class="chip">HIDDEN</span>
              <?php endif; ?>
            </td>
            <td style="text-align:right">
              <a href="/admin/locations/<?= e($loc['id']) ?>/edit" class="va-link-arrow">Edit</a>
              <form method="post" action="/admin/locations/<?= e($loc['id']) ?>/delete"
                    style="display:inline"
                    onsubmit="return confirm('Delete <?= e($loc['name'] ?? '') ?>?')">
                <?= csrf_field() ?>
                <button class="btn btn-ghost" style="padding:6px 12px;font-size:11px">×</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<?php $view->endSection(); ?>
