<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<div class="admin-page-head">
  <div>
    <h1>Edit Property Type</h1>
    <p>Toggle <strong>Hide BHK</strong> for non-residential types like Plot, Land or Commercial.</p>
  </div>
  <a href="/admin/property-types" class="btn btn-ghost">← Back</a>
</div>

<form method="post" action="/admin/property-types/<?= e($item['id']) ?>" class="admin-card" style="max-width:560px">
  <?= csrf_field() ?>

  <div style="margin-bottom:16px">
    <label class="form-label">Type name</label>
    <input type="text" name="name" class="form-control" value="<?= e($item['name'] ?? '') ?>" required>
  </div>

  <div style="margin-bottom:16px">
    <label class="form-label">Display order</label>
    <input type="number" name="order" class="form-control" value="<?= (int)($item['order'] ?? 0) ?>">
    <small class="muted">Lower numbers appear first in the dropdown.</small>
  </div>

  <div style="margin-bottom:14px">
    <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
      <input type="checkbox" name="hide_bhk" value="1" <?= !empty($item['hide_bhk']) ? 'checked' : '' ?>>
      <span>Hide BHK selector when this type is chosen</span>
    </label>
    <small class="muted">Use this for Plot, Land, Commercial Office, Warehouse etc.</small>
  </div>

  <div style="margin-bottom:20px">
    <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
      <input type="checkbox" name="active" value="1" <?= !empty($item['active']) ? 'checked' : '' ?>>
      <span>Active (visible on the home page)</span>
    </label>
  </div>

  <div style="display:flex;gap:10px">
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="/admin/property-types" class="btn btn-ghost">Cancel</a>
  </div>
</form>

<?php $view->endSection(); ?>
