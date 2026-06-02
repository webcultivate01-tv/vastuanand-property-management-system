<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<div class="admin-page-head">
  <div>
    <h1>Search Filters</h1>
    <p>Manage every field shown in the home search box and the properties listing filter. Add fields, define options and configure dependency rules (e.g. selecting "Plot" hides "BHK").</p>
  </div>
  <a href="/admin/filters/create" class="btn btn-primary">+ New Filter</a>
</div>

<?php if (empty($items)): ?>
  <div class="admin-card">
    <p class="muted" style="margin:0">No filter fields yet. Click <strong>+ New Filter</strong> to build your first one.</p>
  </div>
<?php else: ?>
  <div class="admin-card" style="padding:0;overflow:hidden">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Label</th>
          <th>Key</th>
          <th>Type</th>
          <th>Options</th>
          <th>Hero</th>
          <th>Listing</th>
          <th>Status</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($items as $f):
          $optCount = is_array($f['options'] ?? null) ? count($f['options']) : 0;
        ?>
          <tr>
            <td>
              <strong><?= e($f['label'] ?? '—') ?></strong>
              <?php if (!empty($f['placeholder'])): ?>
                <div class="muted" style="font-size:11px"><?= e($f['placeholder']) ?></div>
              <?php endif; ?>
            </td>
            <td class="muted"><code><?= e($f['key'] ?? '') ?></code></td>
            <td><span class="chip"><?= e(strtoupper($f['type'] ?? '')) ?></span></td>
            <td class="muted"><?= $optCount ?: '—' ?></td>
            <td>
              <?php if (!empty($f['show_in_hero'])): ?>
                <span class="chip" style="background:#16a34a22;color:#16a34a">ON</span>
              <?php else: ?>
                <span class="chip">OFF</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if (!empty($f['show_in_listing'])): ?>
                <span class="chip" style="background:#16a34a22;color:#16a34a">ON</span>
              <?php else: ?>
                <span class="chip">OFF</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if (!empty($f['active'])): ?>
                <span class="chip" style="background:#16a34a22;color:#16a34a">ACTIVE</span>
              <?php else: ?>
                <span class="chip">DISABLED</span>
              <?php endif; ?>
            </td>
            <td style="text-align:right;white-space:nowrap">
              <a href="/admin/filters/<?= e($f['id']) ?>/edit" class="va-link-arrow">Edit</a>
              <form method="post" action="/admin/filters/<?= e($f['id']) ?>/delete"
                    style="display:inline"
                    onsubmit="return confirm('Delete filter \'<?= e($f['label'] ?? '') ?>\'? This cannot be undone.')">
                <?= csrf_field() ?>
                <button class="btn btn-ghost" style="padding:6px 12px;font-size:11px">×</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<?php $view->endSection(); ?>
