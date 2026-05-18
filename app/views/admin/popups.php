<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<div class="admin-page-head">
  <div>
    <h1>Popups</h1>
    <p>Site-wide promotional modals and announcement banners.</p>
  </div>
</div>

<form method="post" action="/admin/popups" class="admin-card mb-32">
  <?= csrf_field() ?>
  <div class="grid cols-2" style="gap:18px">
    <div class="form-group"><label>Title</label><input class="form-control" name="title" required></div>
    <div class="form-group"><label>Image URL</label><input class="form-control" name="image"></div>
    <div class="form-group"><label>CTA Label</label><input class="form-control" name="cta" placeholder="View Properties"></div>
    <div class="form-group"><label>CTA Link</label><input class="form-control" name="link" placeholder="/properties"></div>
    <div class="form-group"><label style="display:flex;align-items:center;gap:8px;text-transform:none;letter-spacing:0"><input type="checkbox" name="active" checked> Active</label></div>
  </div>
  <button class="btn btn-primary">Add Popup</button>
</form>

<div class="grid cols-3" style="gap:14px">
  <?php foreach ($items as $p): ?>
    <div class="admin-card">
      <strong><?= e($p['title'] ?? '') ?></strong>
      <?php if (!empty($p['image'])): ?><img src="<?= e($p['image']) ?>" style="margin-top:10px;border-radius:8px;width:100%;max-height:140px;object-fit:cover"><?php endif; ?>
      <p class="muted" style="font-size:13px;margin-top:8px"><?= e($p['cta'] ?? '') ?> → <?= e($p['link'] ?? '') ?></p>
    </div>
  <?php endforeach; ?>
</div>

<?php $view->endSection(); ?>
