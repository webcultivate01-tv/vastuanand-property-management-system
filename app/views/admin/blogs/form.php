<?php $view->extend('layouts.admin'); $b = $blog; $isEdit = !empty($b); ?>
<?php $view->section('content'); ?>

<div class="admin-page-head">
  <div>
    <h1><?= $isEdit ? 'Edit Post' : 'New Post' ?></h1>
    <p><?= $isEdit ? 'Update existing article content and metadata.' : 'Draft a new blog article for the public site.' ?></p>
  </div>
  <a href="/admin/blogs" class="btn btn-ghost">← Back</a>
</div>

<?php
// Merge cover + gallery into a single ordered list for the 5-slot uploader.
// Slot 0 = cover image (used on the blog card + detail hero).
// Slots 1-4 = gallery images shown in the article mosaic.
$existingGallery = [];
if (!empty($b['gallery']) && is_array($b['gallery'])) $existingGallery = $b['gallery'];
elseif (!empty($b['images']) && is_array($b['images'])) $existingGallery = $b['images'];

$existingImages = array_values(array_filter(array_merge(
  [trim((string)($b['cover'] ?? ''))],
  array_map(fn($v) => trim((string)$v), $existingGallery)
)));
$MAX_SLOTS = 5;
?>

<?php if (!\App\Helpers\Cloudinary::configured()): ?>
  <div class="admin-flash error" style="margin-bottom:18px">
    <strong>Cloudinary not configured.</strong> Add <code>CLOUDINARY_CLOUD_NAME</code>, <code>CLOUDINARY_API_KEY</code>, <code>CLOUDINARY_API_SECRET</code> to your <code>.env</code> to enable image uploads. You can still paste image URLs in the extra-images field below.
  </div>
<?php endif; ?>

<form action="<?= $isEdit ? '/admin/blogs/' . e($b['id']) : '/admin/blogs' ?>" method="post" class="admin-card" enctype="multipart/form-data">
  <?= csrf_field() ?>

  <div class="grid cols-2" style="gap:18px">
    <div class="form-group"><label>Title</label><input class="form-control" name="title" value="<?= e($b['title'] ?? '') ?>" required></div>
    <div class="form-group"><label>Slug</label><input class="form-control" name="slug" value="<?= e($b['slug'] ?? '') ?>" placeholder="auto from title"></div>
    <div class="form-group"><label>Category</label><input class="form-control" name="category" value="<?= e($b['category'] ?? 'General') ?>"></div>
    <div class="form-group"><label>Read Time</label><input class="form-control" name="readTime" value="<?= e($b['readTime'] ?? '') ?>" placeholder="e.g. 6 min read"></div>

    <div class="form-group" style="grid-column:1 / -1"><label>Excerpt</label><textarea class="form-control" name="excerpt" rows="2" placeholder="One or two sentences shown on the blog index card."><?= e($b['excerpt'] ?? '') ?></textarea></div>
  </div>

  <!-- ── Image uploads (5 slots: cover + 4 gallery) ───────────────── -->
  <div style="margin-top:28px;padding-top:24px;border-top:1px solid var(--line)">
    <div style="display:flex;justify-content:space-between;align-items:baseline;margin-bottom:14px;gap:16px;flex-wrap:wrap">
      <div>
        <h3 style="font-size:15px;font-weight:600;margin:0">Article Images</h3>
        <p class="muted" style="font-size:13px;margin:4px 0 0">Upload 4–5 images per article. The first one becomes the cover (used on the blog list + hero). The rest appear in the article gallery.</p>
      </div>
      <span class="chip" id="blogImgCount">0 / <?= $MAX_SLOTS ?> selected</span>
    </div>

    <div class="va-uploader va-uploader--blog" id="blogUploader">
      <?php for ($i = 0; $i < $MAX_SLOTS; $i++):
        $existing = $existingImages[$i] ?? null;
      ?>
        <label class="va-uploader__slot" data-slot="<?= $i ?>">
          <input type="file" name="images[]" accept="image/*" data-slot="<?= $i ?>">
          <input type="hidden" name="existing_images[]" value="<?= e($existing ?? '') ?>">
          <div class="va-uploader__preview" <?= $existing ? 'style="background-image:url(' . e(cld($existing, 480)) . ')"' : '' ?>>
            <?php if (!$existing): ?>
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
              <span><?= $i === 0 ? 'Cover image' : 'Image ' . ($i + 1) ?></span>
            <?php endif; ?>
            <button type="button" class="va-uploader__clear" aria-label="Remove image" <?= $existing ? '' : 'hidden' ?>>×</button>
          </div>
        </label>
      <?php endfor; ?>
    </div>

    <details style="margin-top:14px">
      <summary class="muted" style="font-size:12.5px;cursor:pointer">Or paste image URLs (one per line) — appended after the uploaded slots</summary>
      <textarea class="form-control" name="gallery_urls" rows="3" style="margin-top:10px" placeholder="https://image1.jpg&#10;https://image2.jpg"></textarea>
    </details>
  </div>

  <div class="grid cols-2" style="gap:18px;margin-top:28px;padding-top:24px;border-top:1px solid var(--line)">
    <div class="form-group" style="grid-column:1 / -1"><label>Body (HTML allowed)</label><textarea class="form-control" name="body" rows="14"><?= e($b['body'] ?? '') ?></textarea></div>

    <div class="form-group">
      <label style="display:flex;align-items:center;gap:8px;text-transform:none;letter-spacing:0">
        <input type="checkbox" name="published" <?= !empty($b['published']) ? 'checked' : '' ?>> Published
      </label>
    </div>
  </div>

  <button class="btn btn-primary" style="margin-top:24px"><?= $isEdit ? 'Update' : 'Publish' ?></button>
</form>

<script>
(function () {
  const root = document.getElementById('blogUploader');
  if (!root) return;
  const count = document.getElementById('blogImgCount');
  const MAX = <?= $MAX_SLOTS ?>;

  const update = () => {
    const filled = root.querySelectorAll('.va-uploader__preview.has-image, [data-has-existing="1"]').length;
    if (count) count.textContent = filled + ' / ' + MAX + ' selected';
  };

  root.querySelectorAll('input[type=file]').forEach(input => {
    const slot = input.closest('.va-uploader__slot');
    const preview = slot.querySelector('.va-uploader__preview');
    const clear = slot.querySelector('.va-uploader__clear');
    const hidden = slot.querySelector('input[type=hidden]');

    input.addEventListener('change', e => {
      const file = e.target.files[0];
      if (!file) return;
      const reader = new FileReader();
      reader.onload = ev => {
        preview.style.backgroundImage = `url(${ev.target.result})`;
        preview.classList.add('has-image');
        clear.hidden = false;
        if (hidden) hidden.value = '';
        update();
      };
      reader.readAsDataURL(file);
    });

    clear.addEventListener('click', e => {
      e.preventDefault(); e.stopPropagation();
      input.value = '';
      preview.style.backgroundImage = '';
      preview.classList.remove('has-image');
      if (hidden) hidden.value = '';
      clear.hidden = true;
      slot.removeAttribute('data-has-existing');
      update();
    });

    if (hidden && hidden.value) {
      preview.classList.add('has-image');
      slot.setAttribute('data-has-existing', '1');
    }
  });

  update();
})();
</script>

<?php $view->endSection(); ?>
