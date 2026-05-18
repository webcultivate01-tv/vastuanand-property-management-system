<?php $view->extend('layouts.admin'); $b = $blog; $isEdit = !empty($b); ?>
<?php $view->section('content'); ?>

<div class="flex justify-between items-center mb-32">
  <h1 style="font-family:'Cormorant Garamond',serif;font-size:40px;margin:0"><?= $isEdit ? 'Edit Post' : 'New Post' ?></h1>
  <a href="/admin/blogs" class="btn btn-ghost">← Back</a>
</div>

<form action="<?= $isEdit ? '/admin/blogs/' . e($b['id']) : '/admin/blogs' ?>" method="post" class="admin-card">
  <?= csrf_field() ?>
  <div class="grid cols-2" style="gap:18px">
    <div class="form-group"><label>Title</label><input class="form-control" name="title" value="<?= e($b['title'] ?? '') ?>" required></div>
    <div class="form-group"><label>Slug</label><input class="form-control" name="slug" value="<?= e($b['slug'] ?? '') ?>"></div>
    <div class="form-group"><label>Category</label><input class="form-control" name="category" value="<?= e($b['category'] ?? 'General') ?>"></div>
    <div class="form-group"><label>Cover URL</label><input class="form-control" name="cover" value="<?= e($b['cover'] ?? '') ?>"></div>
    <div class="form-group" style="grid-column:1 / -1"><label>Excerpt</label><textarea class="form-control" name="excerpt" rows="2"><?= e($b['excerpt'] ?? '') ?></textarea></div>
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
