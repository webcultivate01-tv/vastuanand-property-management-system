<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<div class="flex justify-between items-center mb-32">
  <div>
    <span class="eyebrow">ADMIN</span>
    <h1 style="font-family:'Cormorant Garamond',serif;font-size:44px;margin:8px 0 0">Dashboard</h1>
  </div>
  <a href="/" target="_blank" class="btn btn-ghost">View Site →</a>
</div>

<div class="grid cols-3" style="gap:16px;margin-bottom:32px">
  <div class="admin-stat"><div class="v"><?= (int)$stats['properties'] ?></div><div class="l">Properties</div></div>
  <div class="admin-stat"><div class="v"><?= (int)$stats['leads'] ?></div><div class="l">Total Leads</div></div>
  <div class="admin-stat"><div class="v" style="color:#7ee787"><?= (int)$stats['leads_new'] ?></div><div class="l">New This Week</div></div>
  <div class="admin-stat"><div class="v"><?= (int)$stats['blogs'] ?></div><div class="l">Blog Posts</div></div>
  <div class="admin-stat"><div class="v"><?= (int)$stats['testimonials'] ?></div><div class="l">Testimonials</div></div>
  <div class="admin-stat"><div class="v"><?= (int)$stats['subscribers'] ?></div><div class="l">Subscribers</div></div>
</div>

<div class="admin-card">
  <div class="flex justify-between items-center mb-24">
    <h2 style="font-family:'Cormorant Garamond',serif;font-size:28px;margin:0">Recent Leads</h2>
    <a href="/admin/leads" class="va-link-arrow">View all</a>
  </div>
  <?php if (empty($recentLeads)): ?>
    <p class="muted">No leads yet. Once your contact forms get submissions, they will show here.</p>
  <?php else: ?>
    <table class="admin-table">
      <thead><tr><th>Date</th><th>Name</th><th>Phone</th><th>Source</th><th>Status</th></tr></thead>
      <tbody>
        <?php foreach ($recentLeads as $l): ?>
          <tr>
            <td class="muted"><?= e($l['createdAt'] ?? '') ?></td>
            <td><?= e($l['name'] ?? '') ?></td>
            <td><?= e($l['phone'] ?? '') ?></td>
            <td><span class="chip"><?= e($l['source'] ?? '') ?></span></td>
            <td><span class="chip" style="color:var(--gold);border-color:var(--gold)"><?= e($l['status'] ?? 'new') ?></span></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php $view->endSection(); ?>
