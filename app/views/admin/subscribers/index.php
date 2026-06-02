<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<div class="admin-page-head">
  <div>
    <h1>Subscribers</h1>
    <p>All emails captured through the newsletter and subscribe forms across the website.</p>
  </div>
  <?php $exportQS = http_build_query(array_filter(['q' => $q, 'active' => $_GET['active'] ?? ''])); ?>
  <div style="display:flex;gap:8px;flex-wrap:wrap">
    <a href="/admin/subscribers/export?format=csv<?= $exportQS ? '&'.$exportQS : '' ?>" class="btn btn-ghost">CSV</a>
    <a href="/admin/subscribers/export?format=excel<?= $exportQS ? '&'.$exportQS : '' ?>" class="btn btn-ghost">Excel</a>
    <a href="/admin/subscribers/export?format=pdf<?= $exportQS ? '&'.$exportQS : '' ?>" target="_blank" class="btn btn-primary">PDF</a>
  </div>
</div>

<div class="grid cols-3" style="gap:14px;margin-bottom:24px">
  <div class="va-stat">
    <div class="va-stat__val"><?= number_format($total) ?></div>
    <span class="va-stat__lbl">Total Subscribers</span>
  </div>
  <div class="va-stat">
    <div class="va-stat__val"><?= number_format(count(array_filter($result['data'], fn($s) => !empty($s['active'])))) ?></div>
    <span class="va-stat__lbl">Active (this page)</span>
  </div>
  <div class="va-stat">
    <div class="va-stat__val"><?= number_format($result['pages'] ?? 1) ?></div>
    <span class="va-stat__lbl">Pages</span>
  </div>
</div>

<form method="get" class="flex gap-16 mb-24">
  <input type="text" name="q" value="<?= e($q) ?>" class="form-control" placeholder="Search by email…" style="max-width:320px">
  <button type="submit" class="btn btn-ghost">Search</button>
  <?php if ($q !== ''): ?>
    <a href="/admin/subscribers" class="btn btn-ghost">Clear</a>
  <?php endif; ?>
</form>

<div class="admin-card" style="padding:0;overflow:hidden">
  <table class="admin-table">
    <thead>
      <tr>
        <th>Date Subscribed</th>
        <th>Email</th>
        <th>Status</th>
        <th style="text-align:right">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($result['data'])): ?>
        <tr>
          <td colspan="4" style="text-align:center;padding:48px 20px" class="muted">
            <?php if ($q !== ''): ?>
              No subscribers match "<?= e($q) ?>".
            <?php else: ?>
              No subscribers yet. They will appear here as visitors sign up.
            <?php endif; ?>
          </td>
        </tr>
      <?php else: ?>
        <?php foreach ($result['data'] as $s): ?>
          <tr>
            <td class="muted"><?= e($s['createdAt'] ?? '') ?></td>
            <td>
              <a href="mailto:<?= e($s['email'] ?? '') ?>" class="gold" style="font-weight:500"><?= e($s['email'] ?? '') ?></a>
            </td>
            <td>
              <?php if (!empty($s['active'])): ?>
                <span class="chip" style="background:rgba(72,187,120,0.14);color:#48bb78;border-color:rgba(72,187,120,0.3)">Active</span>
              <?php else: ?>
                <span class="chip">Inactive</span>
              <?php endif; ?>
            </td>
            <td style="text-align:right">
              <div class="admin-quick-actions">
                <a class="admin-qa admin-qa--email" href="mailto:<?= e($s['email'] ?? '') ?>" title="Email">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><polyline points="3 7 12 13 21 7"/></svg>
                </a>
                <form method="post" action="/admin/subscribers/<?= e($s['id']) ?>/delete" style="display:inline" onsubmit="return confirm('Remove this subscriber?');">
                  <?= csrf_field() ?>
                  <button type="submit" class="admin-qa" title="Remove" style="background:rgba(229,62,62,0.12);color:#e53e3e;border-color:rgba(229,62,62,0.25);cursor:pointer">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php if (($result['pages'] ?? 1) > 1): ?>
  <div class="flex items-center gap-8" style="justify-content:center;margin-top:24px">
    <?php for ($i = 1; $i <= $result['pages']; $i++): ?>
      <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"
         class="btn <?= ($result['page'] ?? 1) === $i ? 'btn-primary' : 'btn-ghost' ?>"
         style="padding:6px 14px;font-size:13px"><?= $i ?></a>
    <?php endfor; ?>
  </div>
<?php endif; ?>

<?php $view->endSection(); ?>
