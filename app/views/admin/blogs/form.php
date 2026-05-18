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
$existingGallery = [];
if (!empty($b['gallery']) && is_array($b['gallery'])) $existingGallery = $b['gallery'];
elseif (!empty($b['images']) && is_array($b['images'])) $existingGallery = $b['images'];
?>

<form action="<?= $isEdit ? '/admin/blogs/' . e($b['id']) : '/admin/blogs' ?>" method="post" class="admin-card" enctype="multipart/form-data">
  <?= csrf_field() ?>
  <div class="grid cols-2" style="gap:18px">
    <div class="form-group"><label>Title</label><input class="form-control" name="title" value="<?= e($b['title'] ?? '') ?>" required></div>
    <div class="form-group"><label>Slug</label><input class="form-control" name="slug" value="<?= e($b['slug'] ?? '') ?>"></div>
    <div class="form-group"><label>Category</label><input class="form-control" name="category" value="<?= e($b['category'] ?? 'General') ?>"></div>
    <div class="form-group"><label>Read Time</label><input class="form-control" name="readTime" value="<?= e($b['readTime'] ?? '') ?>" placeholder="e.g. 6 min read"></div>
    <div class="form-group"><label>Cover Image URL</label><input class="form-control" name="cover" value="<?= e($b['cover'] ?? '') ?>" placeholder="Paste image URL or use uploads below"></div>
    <div class="form-group"><label>Cover Upload</label><input class="form-control" type="file" name="cover_file" accept="image/*"></div>

    <div class="form-group" style="grid-column:1 / -1"><label>Excerpt</label><textarea class="form-control" name="excerpt" rows="2"><?= e($b['excerpt'] ?? '') ?></textarea></div>

    <div class="form-group" style="grid-column:1 / -1">
      <label>Gallery — additional images (multiple)</label>
      <div class="va-bloggallery-input">
        <input class="form-control" type="file" name="gallery_files[]" accept="image/*" multiple>
        <small>Upload several images at once — they appear on the blog detail page as a gallery. You can also paste URLs below (one per line).</small>
        <textarea class="form-control" name="gallery_urls" rows="3" placeholder="https://image1.jpg&#10;https://image2.jpg"><?= e(implode("\n", $existingGallery)) ?></textarea>
        <?php if (!empty($existingGallery)): ?>
          <div class="va-bloggallery-preview" style="margin-top:10px">
            <?php foreach ($existingGallery as $img): ?>
              <div class="va-bloggallery-thumb"><img src="<?= e($img) ?>" alt=""></div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="form-group" style="grid-column:1 / -1"><label>Body (HTML allowed)</label><textarea class="form-control" name="body" rows="14"><?= e($b['body'] ?? '') ?></textarea></div>

    <div class="form-group">
      <label style="display:flex;align-items:center;gap:8px;text-transform:none;letter-spacing:0">
        <input type="checkbox" name="published" <?= !empty($b['published']) ? 'checked' : '' ?>> Published
      </label>
    </div>
  </div>
  <button class="btn btn-primary"><?= $isEdit ? 'Update' : 'Publish' ?></button>
</form>

<?php $view->endSection(); ?>
