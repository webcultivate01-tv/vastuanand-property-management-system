<?php $view->extend('layouts.admin'); $p = $property; $isEdit = !empty($p); ?>
<?php $view->section('content'); ?>

<div class="admin-page-head">
  <div>
    <h1><?= $isEdit ? 'Edit Property' : 'New Property' ?></h1>
    <p><?= $isEdit ? e($p['title']) : 'Add a new listing to the catalog.' ?></p>
  </div>
  <a href="/admin/properties" class="btn btn-ghost">← Back</a>
</div>

<form action="<?= $isEdit ? '/admin/properties/' . e($p['id']) : '/admin/properties' ?>" method="post" class="admin-card">
  <?= csrf_field() ?>
  <div class="grid cols-2" style="gap:18px">
    <div class="form-group"><label>Title</label><input class="form-control" name="title" required value="<?= e($p['title'] ?? '') ?>"></div>
    <div class="form-group"><label>Slug</label><input class="form-control" name="slug" value="<?= e($p['slug'] ?? '') ?>" placeholder="auto from title"></div>

    <div class="form-group"><label>Listing</label>
      <select class="form-control" name="listing">
        <?php foreach (['sale','rent','lease'] as $l): ?>
          <option <?= ($p['listing'] ?? '') === $l ? 'selected' : '' ?>><?= $l ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group"><label>Type</label>
      <select class="form-control" name="type">
        <?php foreach (\App\Models\Property::types() as $t): ?>
          <option <?= ($p['type'] ?? '') === $t ? 'selected' : '' ?>><?= e($t) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group"><label>Location</label><input class="form-control" name="location" value="<?= e($p['location'] ?? '') ?>" placeholder="e.g. Bandra West, Mumbai"></div>
    <div class="form-group"><label>Address</label><input class="form-control" name="address" value="<?= e($p['address'] ?? '') ?>"></div>

    <div class="form-group"><label>BHK</label><input class="form-control" name="bhk" type="number" value="<?= e($p['bhk'] ?? 0) ?>"></div>
    <div class="form-group"><label>Baths</label><input class="form-control" name="baths" type="number" value="<?= e($p['baths'] ?? 0) ?>"></div>
    <div class="form-group"><label>Area (sqft)</label><input class="form-control" name="area" type="number" value="<?= e($p['area'] ?? 0) ?>"></div>
    <div class="form-group"><label>Price (₹)</label><input class="form-control" name="price" type="number" required value="<?= e($p['price'] ?? 0) ?>"></div>

    <div class="form-group" style="grid-column:1 / -1"><label>Cover Image URL</label><input class="form-control" name="cover" value="<?= e($p['cover'] ?? '') ?>"></div>
    <div class="form-group" style="grid-column:1 / -1"><label>Gallery URLs (one per line)</label><textarea class="form-control" name="gallery" rows="4"><?= e(implode("\n", $p['gallery'] ?? [])) ?></textarea></div>

    <div class="form-group"><label>Tags (comma separated)</label><input class="form-control" name="tags" value="<?= e(implode(',', $p['tags'] ?? [])) ?>" placeholder="Sea Facing, Ready to Move"></div>
    <div class="form-group"><label>Amenities (comma separated)</label><input class="form-control" name="amenities" value="<?= e(implode(',', $p['amenities'] ?? [])) ?>" placeholder="Pool, Gym, Security"></div>

    <div class="form-group" style="grid-column:1 / -1"><label>Description</label><textarea class="form-control" name="description" rows="5"><?= e($p['description'] ?? '') ?></textarea></div>

    <div class="form-group">
      <label style="display:flex;align-items:center;gap:10px;text-transform:none;letter-spacing:0">
        <input type="checkbox" name="featured" <?= !empty($p['featured']) ? 'checked' : '' ?>>
        Mark as Featured Property
      </label>
    </div>
    <div class="form-group">
      <label>Status</label>
      <select class="form-control" name="status">
        <?php foreach (['active','draft','archived','sold','rented'] as $s): ?>
          <option <?= ($p['status'] ?? 'active') === $s ? 'selected' : '' ?>><?= $s ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>

  <button class="btn btn-primary" style="margin-top:20px"><?= $isEdit ? 'Update' : 'Create' ?> Property</button>
</form>

<?php $view->endSection(); ?>
