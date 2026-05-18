<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<h1 style="font-family:'Cormorant Garamond',serif;font-size:44px;margin:0 0 32px">Careers</h1>

<div class="grid cols-2" style="gap:24px">
  <form method="post" action="/admin/careers" class="admin-card">
    <?= csrf_field() ?>
    <h2 style="font-family:'Cormorant Garamond',serif;font-size:24px;margin:0 0 18px">Post Job</h2>
    <div class="form-group"><label>Title</label><input class="form-control" name="title" required></div>
    <div class="form-group"><label>Department</label><input class="form-control" name="dept"></div>
    <div class="form-group"><label>Location</label><input class="form-control" name="location" value="Mumbai"></div>
    <div class="form-group"><label>Type</label>
      <select class="form-control" name="type"><option>Full-time</option><option>Part-time</option><option>Freelance</option><option>Internship</option></select>
    </div>
    <div class="form-group"><label>Description</label><textarea class="form-control" name="description" rows="5"></textarea></div>
    <div class="form-group"><label style="display:flex;align-items:center;gap:8px;text-transform:none;letter-spacing:0"><input type="checkbox" name="active" checked> Active</label></div>
    <button class="btn btn-primary">Publish</button>
  </form>

  <div>
    <?php foreach ($items as $j): ?>
      <div class="admin-card" style="margin-bottom:14px">
        <strong><?= e($j['title']) ?></strong>
        <p class="muted" style="font-size:13px;margin-top:6px"><?= e($j['location'] ?? '') ?> · <?= e($j['type'] ?? '') ?> · <?= e($j['dept'] ?? '') ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php $view->endSection(); ?>
