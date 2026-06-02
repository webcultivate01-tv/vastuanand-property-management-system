<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<div class="admin-page-head">
  <div>
    <h1>Events</h1>
    <p>Site-wide event banners and modals. Schedule a start &amp; end time and they appear on the home page automatically.</p>
  </div>
  <div style="display:flex;gap:10px">
    <a href="/admin/events/export?format=csv" class="btn btn-ghost">Export CSV</a>
    <a href="/admin/events/create" class="btn btn-primary">+ New Event</a>
  </div>
</div>

<?php
$now = date('Y-m-d H:i:s');
$liveCount = 0; $scheduledCount = 0; $expiredCount = 0;
foreach ($items as $ev) {
    $start = (string)($ev['starts_at'] ?? '');
    $end   = (string)($ev['ends_at']   ?? '');
    $isActive = !empty($ev['active']);
    if (!$isActive) continue;
    $started = $start === '' || strcmp($start, $now) <= 0;
    $ended   = $end   !== '' && strcmp($end,   $now) <  0;
    if ($ended) $expiredCount++;
    elseif (!$started) $scheduledCount++;
    else $liveCount++;
}
?>
<div class="grid cols-3" style="gap:14px;margin-bottom:24px">
  <div class="va-stat"><div class="va-stat__val"><?= $liveCount ?></div><span class="va-stat__lbl">Live Now</span></div>
  <div class="va-stat"><div class="va-stat__val"><?= $scheduledCount ?></div><span class="va-stat__lbl">Scheduled</span></div>
  <div class="va-stat"><div class="va-stat__val"><?= $expiredCount ?></div><span class="va-stat__lbl">Expired</span></div>
</div>

<?php if (empty($items)): ?>
  <div class="admin-card">
    <p class="muted" style="margin:0">No events yet. Create your first event — give it a name, an image, optional CTA and a start/end schedule.</p>
  </div>
<?php else: ?>
  <div class="grid cols-3" style="gap:18px">
    <?php foreach ($items as $ev):
      $start = (string)($ev['starts_at'] ?? '');
      $end   = (string)($ev['ends_at']   ?? '');
      $isActive = !empty($ev['active']);
      $started  = $start === '' || strcmp($start, $now) <= 0;
      $ended    = $end   !== '' && strcmp($end,   $now) <  0;
      $statusLabel = !$isActive ? 'PAUSED' : ($ended ? 'EXPIRED' : (!$started ? 'SCHEDULED' : 'LIVE'));
      $statusBg    = $statusLabel === 'LIVE' ? '#16a34a' : ($statusLabel === 'SCHEDULED' ? '#4F46E5' : ($statusLabel === 'EXPIRED' ? '#94a3b8' : '#e53e3e'));
    ?>
      <div class="admin-card" style="padding:0;overflow:hidden">
        <div style="position:relative;aspect-ratio:16/9;background:#0E0E0E">
          <?php if (!empty($ev['image'])): ?>
            <img src="<?= e(cld($ev['image'], 700)) ?>" alt="<?= e($ev['title'] ?? '') ?>" style="width:100%;height:100%;object-fit:cover">
          <?php endif; ?>
          <span class="chip" style="position:absolute;top:12px;left:12px;background:<?= $statusBg ?>22;color:<?= $statusBg ?>;border-color:<?= $statusBg ?>55"><?= $statusLabel ?></span>
        </div>
        <div style="padding:16px">
          <strong style="font-size:16px;display:block;margin-bottom:6px"><?= e($ev['title'] ?? '—') ?></strong>
          <?php if (!empty($ev['description'])): ?>
            <p class="muted" style="font-size:13px;margin:0 0 10px;line-height:1.5"><?= e(mb_strimwidth((string)$ev['description'], 0, 120, '…')) ?></p>
          <?php endif; ?>
          <div class="muted" style="font-size:12px;display:grid;gap:4px">
            <?php if ($start !== ''): ?><div>▶ Start: <?= e($start) ?></div><?php endif; ?>
            <?php if ($end   !== ''): ?><div>⏹ End: <?= e($end) ?></div><?php endif; ?>
            <?php if (!empty($ev['cta'])): ?><div>CTA: <strong><?= e($ev['cta']) ?></strong> → <?= e($ev['link'] ?? '#') ?></div><?php endif; ?>
          </div>
          <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:14px">
            <a href="/admin/events/<?= e($ev['id']) ?>/edit" class="btn btn-ghost" style="padding:6px 14px;font-size:12px">Edit</a>
            <form method="post" action="/admin/events/<?= e($ev['id']) ?>/delete" style="display:inline" onsubmit="return confirm('Delete event \'<?= e($ev['title'] ?? '') ?>\'?');">
              <?= csrf_field() ?>
              <button class="btn btn-ghost" style="padding:6px 12px;font-size:12px;color:#e53e3e">Delete</button>
            </form>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php $view->endSection(); ?>
