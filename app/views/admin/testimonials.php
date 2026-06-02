<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<div class="admin-page-head">
  <div>
    <h1>Reviews</h1>
    <p>User-submitted reviews appear here for approval before going live on the website.</p>
  </div>
  <?php if (!empty($pending)): ?>
    <span class="badge" style="background:#C9A35B;color:#1A1A1A;padding:6px 12px;border-radius:14px;font-weight:600">
      <?= count($pending) ?> pending
    </span>
  <?php endif; ?>
</div>

<!-- ── Pending reviews ── -->
<div class="admin-card" style="margin-bottom:24px">
  <h2 style="font-size:18px;margin:0 0 14px">Pending Reviews <span class="muted" style="font-size:13px;font-weight:400">— awaiting approval</span></h2>

  <?php if (empty($pending)): ?>
    <p class="muted" style="font-size:14px;margin:0">No pending reviews. New user submissions will appear here.</p>
  <?php else: ?>
    <div class="grid cols-2" style="gap:14px">
      <?php foreach ($pending as $t): ?>
        <div class="admin-card" style="border:1px solid #C9A35B33;background:#FFF8EC">
          <div class="flex justify-between items-center mb-8">
            <div>
              <strong><?= e($t['name'] ?? '') ?></strong>
              <span class="muted">· <?= e($t['role'] ?? '') ?></span>
            </div>
            <div style="color:var(--gold)"><?= str_repeat('★', (int)($t['rating'] ?? 5)) ?></div>
          </div>
          <p class="muted" style="font-size:14px;line-height:1.6">"<?= e($t['message'] ?? '') ?>"</p>
          <div class="muted" style="font-size:11px;margin-top:8px">
            Submitted <?= e($t['createdAt'] ?? '') ?>
          </div>
          <div style="display:flex;gap:8px;margin-top:12px">
            <form method="post" action="/admin/testimonials/<?= e($t['id']) ?>/approve" style="margin:0">
              <?= csrf_field() ?>
              <button class="btn btn-primary" style="padding:8px 16px;font-size:12px">✓ Approve</button>
            </form>
            <form method="post" action="/admin/testimonials/<?= e($t['id']) ?>/delete" style="margin:0"
                  onsubmit="return confirm('Delete this review permanently?')">
              <?= csrf_field() ?>
              <button class="btn btn-ghost" style="padding:8px 16px;font-size:12px">✕ Reject</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<!-- ── Approved (live on site) ── -->
<div class="admin-card">
  <h2 style="font-size:18px;margin:0 0 14px">Approved Reviews <span class="muted" style="font-size:13px;font-weight:400">— live on website</span></h2>
  <?php if (empty($approved)): ?>
    <p class="muted" style="font-size:14px;margin:0">No approved reviews yet.</p>
  <?php else: ?>
    <div class="grid cols-2" style="gap:14px">
      <?php foreach ($approved as $t): ?>
        <div class="admin-card" style="margin:0">
          <div class="flex justify-between items-center mb-8">
            <div><strong><?= e($t['name']) ?></strong> <span class="muted">· <?= e($t['role'] ?? '') ?></span></div>
            <div style="display:flex;gap:6px">
              <form method="post" action="/admin/testimonials/<?= e($t['id']) ?>/unapprove" style="margin:0">
                <?= csrf_field() ?>
                <button class="btn btn-ghost" style="padding:6px 10px;font-size:11px" title="Hide from website">Unapprove</button>
              </form>
              <form method="post" action="/admin/testimonials/<?= e($t['id']) ?>/delete" style="margin:0"
                    onsubmit="return confirm('Delete this review permanently?')">
                <?= csrf_field() ?>
                <button class="btn btn-ghost" style="padding:6px 12px;font-size:11px">×</button>
              </form>
            </div>
          </div>
          <p class="muted" style="font-size:14px;line-height:1.6">"<?= e($t['message']) ?>"</p>
          <div style="margin-top:8px;color:var(--gold)"><?= str_repeat('★', (int)($t['rating'] ?? 5)) ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php $view->endSection(); ?>
