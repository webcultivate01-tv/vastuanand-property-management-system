<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<div class="admin-page-head">
  <div>
    <h1>Properties</h1>
    <p>Manage your catalog of listings, statuses and featured picks.</p>
  </div>
  <a href="/admin/properties/create" class="btn btn-primary">+ New Property</a>
</div>

<div class="admin-card" style="padding:0;overflow:hidden">
  <table class="admin-table">
    <thead><tr><th>Title</th><th>Location</th><th>Listing</th><th>Price</th><th>Featured</th><th style="text-align:right">Actions</th></tr></thead>
    <tbody>
      <?php foreach ($result['data'] as $p): ?>
        <tr>
          <td><strong><?= e($p['title']) ?></strong><br><span class="muted" style="font-size:12px"><?= e($p['slug'] ?? '') ?></span></td>
          <td class="muted"><?= e($p['location'] ?? '') ?></td>
          <td><span class="chip"><?= e($p['listing'] ?? '') ?></span></td>
          <td><strong><?= format_price($p['price'] ?? 0) ?></strong></td>
          <td><?= !empty($p['featured']) ? '<span style="color:var(--gold)">★</span>' : '—' ?></td>
          <td style="text-align:right;white-space:nowrap">
            <a href="/admin/properties/<?= e($p['id']) ?>/edit" class="btn btn-ghost btn-sm">Edit</a>
            <form method="post" action="/admin/properties/<?= e($p['id']) ?>/delete" style="display:inline" onsubmit="return confirm('Delete this property?')"><button class="btn btn-sm" style="color:var(--danger);border-color:var(--line)">Delete</button></form>
          </td>
        </tr>
      <?php endforeach; ?>
      <?php if (empty($result['data'])): ?>
        <tr><td colspan="6" class="muted text-center" style="padding:60px 0">No properties yet. <a href="/admin/properties/create" class="gold">Add the first one →</a></td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php $view->endSection(); ?>
