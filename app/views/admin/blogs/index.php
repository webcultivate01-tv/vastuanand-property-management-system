<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<div class="flex justify-between items-center mb-32">
  <div><span class="eyebrow">CONTENT</span><h1 style="font-family:'Cormorant Garamond',serif;font-size:44px;margin:8px 0 0">Blog Posts</h1></div>
  <a href="/admin/blogs/create" class="btn btn-primary">+ New Post</a>
</div>

<div class="admin-card">
  <table class="admin-table">
    <thead><tr><th>Title</th><th>Category</th><th>Published</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($result['data'] ?? [] as $b): ?>
        <tr>
          <td><strong><?= e($b['title']) ?></strong><br><span class="muted" style="font-size:12px">/blog/<?= e($b['slug'] ?? '') ?></span></td>
          <td><span class="chip"><?= e($b['category'] ?? 'General') ?></span></td>
          <td class="muted"><?= !empty($b['published']) ? '✓ Published' : 'Draft' ?></td>
          <td style="text-align:right">
            <a href="/admin/blogs/<?= e($b['id']) ?>/edit" class="va-link-arrow">Edit</a>
            <form method="post" action="/admin/blogs/<?= e($b['id']) ?>/delete" style="display:inline" onsubmit="return confirm('Delete?')"><button class="btn btn-ghost" style="padding:6px 12px;font-size:11px">×</button></form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php $view->endSection(); ?>
