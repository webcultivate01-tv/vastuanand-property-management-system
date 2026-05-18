<?php $view->extend('layouts.admin'); $p = $property; $isEdit = !empty($p); $existingImages = array_values(array_filter(array_merge([$p['cover'] ?? null], $p['gallery'] ?? []))); ?>
<?php $view->section('content'); ?>

<div class="admin-page-head">
  <div>
    <h1><?= $isEdit ? 'Edit Property' : 'New Property' ?></h1>
    <p><?= $isEdit ? e($p['title']) : 'Add a new listing to the catalog.' ?></p>
  </div>
  <a href="/admin/properties" class="btn btn-ghost">← Back</a>
</div>

<?php if (!\App\Helpers\Cloudinary::configured()): ?>
  <div class="admin-flash error" style="margin-bottom:18px">
    <strong>Cloudinary not configured.</strong> Add <code>CLOUDINARY_CLOUD_NAME</code>, <code>CLOUDINARY_API_KEY</code>, <code>CLOUDINARY_API_SECRET</code> to your <code>.env</code> to enable image uploads. You can still paste image URLs in the gallery field.
  </div>
<?php endif; ?>

<form action="<?= $isEdit ? '/admin/properties/' . e($p['id']) : '/admin/properties' ?>" method="post" enctype="multipart/form-data" class="admin-card">
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
  </div>

  <!-- ── Image uploads (4 slots) ────────────────────────── -->
  <div style="margin-top:28px;padding-top:24px;border-top:1px solid var(--line)">
    <div style="display:flex;justify-content:space-between;align-items:baseline;margin-bottom:14px">
      <div>
        <h3 style="font-size:15px;font-weight:600;margin:0">Property Images</h3>
        <p class="muted" style="font-size:13px;margin:4px 0 0">Upload up to 4 images. The first one becomes the cover. Stored on Cloudinary; only URLs are saved.</p>
      </div>
      <span class="chip" id="imgCount">0 / 4 selected</span>
    </div>

    <div class="va-uploader" id="propUploader">
      <?php for ($i = 0; $i < 4; $i++):
        $existing = $existingImages[$i] ?? null;
      ?>
        <label class="va-uploader__slot" data-slot="<?= $i ?>">
          <input type="file" name="images[]" accept="image/*" data-slot="<?= $i ?>">
          <input type="hidden" name="existing_images[]" value="<?= e($existing ?? '') ?>">
          <div class="va-uploader__preview" <?= $existing ? 'style="background-image:url(' . e($existing) . ')"' : '' ?>>
            <?php if (!$existing): ?>
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
              <span>Image <?= $i + 1 ?><?= $i === 0 ? ' (cover)' : '' ?></span>
            <?php endif; ?>
            <button type="button" class="va-uploader__clear" aria-label="Remove image" <?= $existing ? '' : 'hidden' ?>>×</button>
          </div>
        </label>
      <?php endfor; ?>
    </div>
  </div>

  <div class="grid cols-2" style="gap:18px;margin-top:28px;padding-top:24px;border-top:1px solid var(--line)">
    <div class="form-group" style="grid-column:1 / -1"><label>Gallery URLs (one per line) — optional, in addition to uploads</label><textarea class="form-control" name="gallery_urls" rows="3" placeholder="https://..."><?= e(implode("\n", $p['gallery_urls'] ?? [])) ?></textarea></div>

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

  <button class="btn btn-primary" style="margin-top:24px"><?= $isEdit ? 'Update' : 'Create' ?> Property</button>
</form>

<script>
(function () {
  const root = document.getElementById('propUploader');
  if (!root) return;
  const count = document.getElementById('imgCount');
  const update = () => {
    const filled = root.querySelectorAll('.va-uploader__preview.has-image, [data-has-existing="1"]').length;
    if (count) count.textContent = filled + ' / 4 selected';
  };
  root.querySelectorAll('input[type=file]').forEach(input => {
    input.addEventListener('change', e => {
      const file = e.target.files[0];
      const slot = input.closest('.va-uploader__slot');
      const preview = slot.querySelector('.va-uploader__preview');
      const clear = slot.querySelector('.va-uploader__clear');
      const hidden = slot.querySelector('input[type=hidden]');
      if (file) {
        const reader = new FileReader();
        reader.onload = ev => {
          preview.style.backgroundImage = `url(${ev.target.result})`;
          preview.classList.add('has-image');
          clear.hidden = false;
          if (hidden) hidden.value = ''; // new file replaces existing
          update();
        };
        reader.readAsDataURL(file);
      }
    });
    const slot = input.closest('.va-uploader__slot');
    const clear = slot.querySelector('.va-uploader__clear');
    clear.addEventListener('click', e => {
      e.preventDefault(); e.stopPropagation();
      input.value = '';
      const preview = slot.querySelector('.va-uploader__preview');
      preview.style.backgroundImage = '';
      preview.classList.remove('has-image');
      const hidden = slot.querySelector('input[type=hidden]');
      if (hidden) hidden.value = '';
      clear.hidden = true;
      update();
    });
    if (slot.querySelector('input[type=hidden]')?.value) {
      slot.querySelector('.va-uploader__preview').classList.add('has-image');
      slot.setAttribute('data-has-existing','1');
    }
  });
  update();
})();
</script>

<?php $view->endSection(); ?>
