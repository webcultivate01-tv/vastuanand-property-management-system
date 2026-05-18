<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<div class="admin-page-head">
  <div>
    <h1>Reviews</h1>
    <p>Approved testimonials shown across the site.</p>
  </div>
</div>

<div class="grid cols-2" style="gap:24px">
  <form method="post" action="/admin/testimonials" class="admin-card">
    <?= csrf_field() ?>
    <h2 style="font-size:18px;margin:0 0 18px">Add Review</h2>
    <div class="form-group"><label>Name</label><input class="form-control" name="name" required></div>
    <div class="form-group"><label>Role / Location</label><input class="form-control" name="role" placeholder="Home Buyer, Bandra"></div>
    <div class="form-group"><label>Message</label><textarea class="form-control" name="message" rows="4" required></textarea></div>
    <div class="form-group"><label>Rating (1–5)</label><input class="form-control" name="rating" type="number" min="1" max="5" value="5"></div>
    <div class="form-group">
      <label style="display:flex;align-items:center;gap:8px;text-transform:none;letter-spacing:0">
        <input type="checkbox" name="approved" checked> Approve immediately
      </label>
    </div>
    <button class="btn btn-primary">Add</button>
  </form>

  <div>
    <?php foreach ($items as $t): ?>
      <div class="admin-card" style="margin-bottom:14px">
        <div class="flex justify-between items-center mb-8">
          <div><strong><?= e($t['name']) ?></strong> <span class="muted">· <?= e($t['role'] ?? '') ?></span></div>
          <form method="post" action="/admin/testimonials/<?= e($t['id']) ?>/delete"><button class="btn btn-ghost" style="padding:6px 12px;font-size:11px">×</button></form>
        </div>
        <p class="muted" style="font-size:14px;line-height:1.6">"<?= e($t['message']) ?>"</p>
        <div style="margin-top:8px;color:var(--gold)"><?= str_repeat('★', (int)($t['rating'] ?? 5)) ?></div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php $view->endSection(); ?>
