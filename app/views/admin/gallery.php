<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<h1 style="font-family:'Cormorant Garamond',serif;font-size:44px;margin:0 0 32px">Gallery</h1>

<form method="post" action="/admin/gallery" class="admin-card mb-32">
  <?= csrf_field() ?>
  <div class="grid cols-3" style="gap:14px">
    <div class="form-group" style="margin-bottom:0"><label>Image URL</label><input class="form-control" name="image" required></div>
    <div class="form-group" style="margin-bottom:0"><label>Caption</label><input class="form-control" name="caption"></div>
    <div class="form-group" style="margin-bottom:0"><label>Category</label><input class="form-control" name="category" value="General"></div>
  </div>
  <button class="btn btn-primary" style="margin-top:14px">Add Image</button>
</form>

<div class="grid cols-4" style="gap:14px">
  <?php foreach ($items as $g): ?>
    <div class="admin-card" style="padding:0;overflow:hidden">
      <div style="aspect-ratio:4/3"><img src="<?= e($g['image']) ?>" style="width:100%;height:100%;object-fit:cover"></div>
      <div style="padding:12px;display:flex;justify-content:space-between;align-items:center">
        <span class="muted" style="font-size:12px"><?= e($g['caption'] ?? '') ?></span>
        <form method="post" action="/admin/gallery/<?= e($g['id']) ?>/delete"><button class="btn btn-ghost" style="padding:4px 10px;font-size:11px">×</button></form>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php $view->endSection(); ?>
