<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<div class="flex justify-between items-center mb-32">
  <div><span class="eyebrow">CRM</span><h1 style="font-family:'Cormorant Garamond',serif;font-size:44px;margin:8px 0 0">Leads</h1></div>
  <a href="/admin/leads/export" class="btn btn-primary">⬇ Export CSV</a>
</div>

<form method="get" class="flex gap-16 mb-24">
  <select name="status" class="form-control" style="max-width:200px" onchange="this.form.submit()">
    <option value="">All Statuses</option>
    <?php foreach ($statuses as $s): ?>
      <option value="<?= $s ?>" <?= ($_GET['status'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
    <?php endforeach; ?>
  </select>
  <select name="source" class="form-control" style="max-width:240px" onchange="this.form.submit()">
    <option value="">All Sources</option>
    <?php foreach ($sources as $s): ?>
      <option value="<?= $s ?>" <?= ($_GET['source'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
    <?php endforeach; ?>
  </select>
</form>

<div class="admin-card">
  <table class="admin-table">
    <thead><tr><th>Date</th><th>Name</th><th>Phone</th><th>Email</th><th>Source</th><th>Status</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($result['data'] as $l): ?>
        <tr>
          <td class="muted"><?= e($l['createdAt'] ?? '') ?></td>
          <td><strong><?= e($l['name'] ?? '') ?></strong><?php if (!empty($l['message'])): ?><br><span class="muted" style="font-size:12px"><?= e(mb_strimwidth($l['message'], 0, 80, '…')) ?></span><?php endif; ?></td>
          <td><a href="tel:<?= e($l['phone'] ?? '') ?>" class="gold"><?= e($l['phone'] ?? '') ?></a></td>
          <td class="muted"><?= e($l['email'] ?? '—') ?></td>
          <td><span class="chip"><?= e($l['source'] ?? '') ?></span></td>
          <td>
            <form method="post" action="/admin/leads/<?= e($l['id']) ?>/status" style="display:inline">
              <select name="status" class="form-control" onchange="this.form.submit()" style="padding:6px;font-size:12px">
                <?php foreach ($statuses as $s): ?>
                  <option value="<?= $s ?>" <?= ($l['status'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
                <?php endforeach; ?>
              </select>
            </form>
          </td>
          <td><a href="https://wa.me/<?= e(preg_replace('/\D/','',$l['phone']??'')) ?>" target="_blank" class="va-link-arrow">WhatsApp</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php $view->endSection(); ?>
