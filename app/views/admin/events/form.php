<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<?php
$isEdit = !empty($item);
$action = $isEdit ? '/admin/events/' . e($item['id']) : '/admin/events';
$existingImages = $isEdit ? array_values(array_filter(array_merge([$item['image'] ?? ''], (array)($item['gallery'] ?? [])))) : [];
$slots = 4;
?>

<div class="admin-page-head">
  <div>
    <h1><?= $isEdit ? 'Edit Event' : 'New Event' ?></h1>
    <p>Create a scheduled, image-rich event with a clear call-to-action.</p>
  </div>
  <a href="/admin/events" class="btn btn-ghost">← Back</a>
</div>

<form method="post" action="<?= $action ?>" enctype="multipart/form-data" class="admin-card" style="max-width:880px">
  <?= csrf_field() ?>

  <div class="grid cols-2" style="gap:18px">
    <div class="form-group" style="grid-column:1/-1">
      <label class="form-label">Event Name <span style="color:#e53e3e">*</span></label>
      <input class="form-control" name="title" value="<?= e($item['title'] ?? '') ?>" placeholder="e.g. Bandra Open House — Sunday Brunch Edition" required>
    </div>

    <div class="form-group" style="grid-column:1/-1">
      <label class="form-label">Description</label>
      <textarea class="form-control" name="description" rows="3" placeholder="Short summary visitors will see in the popup."><?= e($item['description'] ?? '') ?></textarea>
    </div>

    <div class="form-group">
      <label class="form-label">Starts At</label>
      <input class="form-control" type="datetime-local" name="starts_at" value="<?= e(str_replace(' ', 'T', substr((string)($item['starts_at'] ?? ''), 0, 16))) ?>">
      <small class="muted">Event hides before this time. Leave blank to start immediately.</small>
    </div>
    <div class="form-group">
      <label class="form-label">Ends At</label>
      <input class="form-control" type="datetime-local" name="ends_at" value="<?= e(str_replace(' ', 'T', substr((string)($item['ends_at'] ?? ''), 0, 16))) ?>">
      <small class="muted">Event hides after this time. Leave blank to run indefinitely.</small>
    </div>

    <div class="form-group">
      <label class="form-label">CTA Label</label>
      <input class="form-control" name="cta" value="<?= e($item['cta'] ?? '') ?>" placeholder="RSVP Now / View Properties">
    </div>
    <div class="form-group">
      <label class="form-label">CTA Link</label>
      <input class="form-control" name="link" value="<?= e($item['link'] ?? '') ?>" placeholder="/properties or https://...">
    </div>

    <div class="form-group" style="grid-column:1/-1">
      <label class="form-label">Location (optional)</label>
      <input class="form-control" name="location" value="<?= e($item['location'] ?? '') ?>" placeholder="e.g. Bandra West Sales Lounge">
    </div>

    <div class="form-group" style="grid-column:1/-1">
      <label class="form-label">Event Images</label>
      <small class="muted" style="display:block;margin-bottom:10px">First image is the cover. Up to <?= $slots ?> images.</small>
      <div class="grid cols-4" style="gap:12px">
        <?php for ($i = 0; $i < $slots; $i++):
          $existingUrl = $existingImages[$i] ?? '';
        ?>
          <div style="border:1px dashed rgba(255,255,255,0.18);border-radius:10px;padding:8px;background:rgba(255,255,255,0.02)">
            <?php if ($existingUrl): ?>
              <div style="aspect-ratio:1/1;border-radius:8px;overflow:hidden;margin-bottom:8px">
                <img src="<?= e(cld($existingUrl, 400)) ?>" style="width:100%;height:100%;object-fit:cover">
              </div>
              <input type="hidden" name="existing_images[]" value="<?= e($existingUrl) ?>">
            <?php else: ?>
              <div style="aspect-ratio:1/1;border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:12px;margin-bottom:8px;background:rgba(255,255,255,0.04)">Slot <?= $i + 1 ?></div>
              <input type="hidden" name="existing_images[]" value="">
            <?php endif; ?>
            <input class="form-control" type="file" name="images[]" accept="image/*" style="padding:6px;font-size:11px">
          </div>
        <?php endfor; ?>
      </div>
      <small class="muted" style="display:block;margin-top:10px">Or paste a single image URL:</small>
      <input class="form-control" name="image" placeholder="https://...">
    </div>

    <div class="form-group" style="grid-column:1/-1">
      <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
        <input type="checkbox" name="active" value="1" <?= ($isEdit ? !empty($item['active']) : true) ? 'checked' : '' ?>>
        <span>Active (publish on site within schedule window)</span>
      </label>
    </div>
  </div>

  <div style="display:flex;gap:10px;margin-top:8px">
    <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Save Changes' : 'Create Event' ?></button>
    <a href="/admin/events" class="btn btn-ghost">Cancel</a>
  </div>
</form>

<?php $view->endSection(); ?>
