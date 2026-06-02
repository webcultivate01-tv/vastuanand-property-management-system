<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<div class="admin-page-head">
  <div>
    <h1>Blog Posts</h1>
    <p>Editorial content driving SEO and engagement.</p>
  </div>
  <?php $exportQS = http_build_query(array_filter(['category' => $_GET['category'] ?? '', 'published' => $_GET['published'] ?? ''])); ?>
  <div style="display:flex;gap:8px;flex-wrap:wrap">
    <a href="/admin/blogs/export?format=csv<?= $exportQS ? '&'.$exportQS : '' ?>" class="btn btn-ghost">CSV</a>
    <a href="/admin/blogs/export?format=excel<?= $exportQS ? '&'.$exportQS : '' ?>" class="btn btn-ghost">Excel</a>
    <a href="/admin/blogs/export?format=pdf<?= $exportQS ? '&'.$exportQS : '' ?>" target="_blank" class="btn btn-ghost">PDF</a>
    <a href="/admin/blogs/create" class="btn btn-primary">+ New Post</a>
  </div>
</div>

<form method="get" class="flex gap-16 mb-24">
  <input type="text" name="category" value="<?= e($_GET['category'] ?? '') ?>" class="form-control" placeholder="Filter by category…" style="max-width:240px">
  <select name="published" class="form-control" style="max-width:180px">
    <option value="">Any status</option>
    <option value="yes" <?= ($_GET['published'] ?? '') === 'yes' ? 'selected' : '' ?>>Published</option>
    <option value="no"  <?= ($_GET['published'] ?? '') === 'no'  ? 'selected' : '' ?>>Draft</option>
  </select>
  <button type="submit" class="btn btn-ghost">Apply</button>
</form>

<div class="admin-card" style="padding:0;overflow:hidden">
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
