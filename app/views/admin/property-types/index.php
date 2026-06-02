<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<div class="admin-page-head">
  <div>
    <h1>Property Types</h1>
    <p>Manage the property-type options shown in the home page filter. Enable <strong>Hide BHK</strong> for types like Plot, Land or Commercial.</p>
  </div>
</div>

<div class="admin-card" style="margin-bottom:16px">
  <form method="post" action="/admin/property-types" class="grid" style="grid-template-columns:1fr 100px auto auto;gap:12px;align-items:end">
    <?= csrf_field() ?>
    <div>
      <label class="form-label">Type name</label>
      <input type="text" name="name" class="form-control" placeholder="e.g. Apartment, Plot, Villa" required>
    </div>
    <div>
      <label class="form-label">Order</label>
      <input type="number" name="order" class="form-control" value="0">
    </div>
    <label style="display:flex;align-items:center;gap:6px;padding-bottom:10px;cursor:pointer">
      <input type="checkbox" name="hide_bhk" value="1">
      <span style="font-size:12px">Hide BHK</span>
    </label>
    <button type="submit" class="btn btn-primary">+ Add</button>
  </form>
</div>

<?php if (empty($items)): ?>
  <div class="admin-card">
    <p class="muted" style="margin:0">No property types yet. Add your first one above.</p>
  </div>
<?php else: ?>
  <div class="admin-card" style="padding:0;overflow:hidden">
    <table class="admin-table">
      <thead><tr><th>Name</th><th>Slug</th><th>Order</th><th>BHK</th><th>Status</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($items as $t): ?>
          <tr>
            <td><strong><?= e($t['name'] ?? '—') ?></strong></td>
            <td class="muted"><?= e($t['slug'] ?? '') ?></td>
            <td class="muted"><?= (int)($t['order'] ?? 0) ?></td>
            <td>
              <?php if (!empty($t['hide_bhk'])): ?>
                <span class="chip" style="background:#ef444422;color:#ef4444">HIDDEN</span>
              <?php else: ?>
                <span class="chip">SHOWN</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if (!empty($t['active'])): ?>
                <span class="chip" style="background:#16a34a22;color:#16a34a">ACTIVE</span>
              <?php else: ?>
                <span class="chip">HIDDEN</span>
              <?php endif; ?>
            </td>
            <td style="text-align:right">
              <a href="/admin/property-types/<?= e($t['id']) ?>/edit" class="va-link-arrow">Edit</a>
              <form method="post" action="/admin/property-types/<?= e($t['id']) ?>/delete"
                    style="display:inline"
                    onsubmit="return confirm('Delete <?= e($t['name'] ?? '') ?>?')">
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
