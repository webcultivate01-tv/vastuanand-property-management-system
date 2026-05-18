<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<div class="flex justify-between items-center mb-32">
  <div><span class="eyebrow">CATALOG</span><h1 style="font-family:'Cormorant Garamond',serif;font-size:44px;margin:8px 0 0">Properties</h1></div>
  <a href="/admin/properties/create" class="btn btn-primary">+ New Property</a>
</div>

<div class="admin-card">
  <table class="admin-table">
    <thead><tr><th>Title</th><th>Location</th><th>Listing</th><th>Price</th><th>Featured</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($result['data'] as $p): ?>
        <tr>
          <td><strong><?= e($p['title']) ?></strong><br><span class="muted" style="font-size:12px"><?= e($p['slug'] ?? '') ?></span></td>
          <td class="muted"><?= e($p['location'] ?? '') ?></td>
          <td><span class="chip"><?= e($p['listing'] ?? '') ?></span></td>
          <td class="gold"><?= format_price($p['price'] ?? 0) ?></td>
          <td><?= !empty($p['featured']) ? '★' : '—' ?></td>
          <td style="text-align:right">
            <a href="/admin/properties/<?= e($p['id']) ?>/edit" class="va-link-arrow">Edit</a>
            <form method="post" action="/admin/properties/<?= e($p['id']) ?>/delete" style="display:inline" onsubmit="return confirm('Delete this property?')"><button class="btn btn-ghost" style="padding:6px 12px;font-size:11px">×</button></form>
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
