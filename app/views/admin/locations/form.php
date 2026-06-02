<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<div class="admin-page-head">
  <div>
    <h1>Edit Location</h1>
    <p>Update or hide this location from the home page filter.</p>
  </div>
  <a href="/admin/locations" class="btn btn-ghost">← Back</a>
</div>

<form method="post" action="/admin/locations/<?= e($item['id']) ?>" class="admin-card" style="max-width:560px">
  <?= csrf_field() ?>

  <div style="margin-bottom:16px">
    <label class="form-label">Location name</label>
    <input type="text" name="name" class="form-control" value="<?= e($item['name'] ?? '') ?>" required>
  </div>

  <div style="margin-bottom:16px">
    <label class="form-label">Display order</label>
    <input type="number" name="order" class="form-control" value="<?= (int)($item['order'] ?? 0) ?>">
    <small class="muted">Lower numbers appear first in the dropdown.</small>
  </div>

  <div style="margin-bottom:20px">
    <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
      <input type="checkbox" name="active" value="1" <?= !empty($item['active']) ? 'checked' : '' ?>>
      <span>Active (visible on the home page)</span>
    </label>
  </div>

  <div style="display:flex;gap:10px">
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="/admin/locations" class="btn btn-ghost">Cancel</a>
  </div>
</form>

<?php $view->endSection(); ?>
