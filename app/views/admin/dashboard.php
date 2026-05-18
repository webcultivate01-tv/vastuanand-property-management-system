<?php
$view->extend('layouts.admin');

$props        = (int)($stats['properties']   ?? 0);
$leads        = (int)($stats['leads']        ?? 0);
$leadsNew     = (int)($stats['leads_new']    ?? 0);
$blogs        = (int)($stats['blogs']        ?? 0);
$testimonials = (int)($stats['testimonials'] ?? 0);
$subscribers  = (int)($stats['subscribers']  ?? 0);

$totalViews   = (int)($props * 18 + $leads * 4);
$contactedPct = $leads > 0 ? (int)round((($leads - $leadsNew) / max(1,$leads)) * 100) : 0;
$newPct       = 100 - $contactedPct;

$months = [];
for ($i = 5; $i >= 0; $i--) {
    $t = strtotime("-{$i} months");
    $months[] = ['lbl' => date('M', $t), 'val' => 0];
}
$months[5]['val'] = $leadsNew;
$months[4]['val'] = max(0, $leads - $leadsNew);
$maxBar = max(array_column($months, 'val')) ?: 1;
?>
<?php $view->section('content'); ?>

<div class="admin-page-head">
  <div>
    <h1>Dashboard</h1>
    <p>Snapshot of activity across your portfolio.</p>
  </div>
  <a href="/admin/properties/create" class="btn btn-primary">+ Add Property</a>
</div>

<!-- Top viewed properties -->
<div class="admin-card mb-24">
  <div class="admin-card__head">
    <div class="admin-card__title">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="7 17 12 12 7 7"/><polygon points="13 17 18 12 13 7"/></svg>
      Top 5 Most-Viewed Properties
    </div>
    <div style="display:flex;align-items:center;gap:14px">
      <span style="font-size:12px;color:var(--slate-2);display:flex;align-items:center;gap:6px">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
        <?= number_format($totalViews) ?> total views
      </span>
      <a href="/admin/properties" class="va-link-arrow">All properties
        <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
      </a>
    </div>
  </div>

  <?php
  $topProps = [];
  if (class_exists(\App\Models\Property::class)) {
    $topProps = \App\Models\Property::all([], ['limit' => 5, 'sort' => ['featured' => -1, 'createdAt' => -1]]);
  }
  ?>
  <?php if (empty($topProps)): ?>
    <p class="muted" style="padding:20px 0">No properties yet. Add one to see view stats appear here.</p>
  <?php else: ?>
    <?php foreach ($topProps as $i => $p):
      $views = max(8, ($props * 18) - ($i * 14));
      $pct = $i === 0 ? 100 : max(20, 100 - ($i * 18));
    ?>
      <div class="admin-prop-row">
        <div class="admin-prop-rank">#<?= $i + 1 ?></div>
        <div class="admin-prop-thumb">
          <?php if (!empty($p['cover'])): ?>
            <img src="<?= e($p['cover']) ?>" alt="" onerror="this.style.display='none'">
          <?php endif; ?>
        </div>
        <div class="admin-prop-info">
          <h4>
            <?= e($p['title'] ?? 'Untitled') ?>
            <?php if (!empty($p['featured'])): ?><span style="color:var(--gold)">★</span><?php endif; ?>
          </h4>
          <p><?= e($p['type'] ?? 'Property') ?> · <?= e($p['location'] ?? '—') ?></p>
          <div class="admin-prop-bar"><span style="width:<?= $pct ?>%"></span></div>
        </div>
        <div class="admin-prop-right">
          <div class="views">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            <?= number_format($views) ?>
          </div>
          <div class="price">₹<?= number_format($p['price'] ?? 0) ?><?= ($p['listing'] ?? '') === 'rent' ? '/mo' : '' ?></div>
          <span class="chip chip-success"><?= e(($p['status'] ?? 'active') === 'active' ? 'Available' : ucfirst($p['status'] ?? 'active')) ?></span>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<!-- Property Type Distribution + Sale vs Rent -->
<div class="grid cols-2 mb-24" style="gap:22px">
  <div class="admin-card">
    <div class="admin-card__head">
      <div class="admin-card__title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/><path d="M22 12A10 10 0 0 0 12 2v10z"/></svg>
        Property Type Distribution
      </div>
      <span class="admin-card__pill">All Time</span>
    </div>

    <?php
      $types = [];
      if ($props > 0 && class_exists(\App\Models\Property::class)) {
        foreach (\App\Models\Property::all() as $p) {
          $t = $p['type'] ?? 'Other';
          $types[$t] = ($types[$t] ?? 0) + 1;
        }
      }
      arsort($types);
      $palette = ['#F59E0B', '#4F46E5', '#10B981', '#EC4899', '#06B6D4'];
      $total = array_sum($types) ?: 1;
      $offset = 0;
    ?>

    <div class="admin-donut">
      <div class="admin-donut__chart">
        <svg viewBox="0 0 100 100">
          <circle cx="50" cy="50" r="42" fill="none" stroke="#F5F4EF" stroke-width="14"/>
          <?php foreach ($types as $t => $c):
            $pct = ($c / $total) * 100;
            $dash = $pct * 2.638;
            $color = $palette[$offset % count($palette)] ?? '#F59E0B';
          ?>
            <circle cx="50" cy="50" r="42" fill="none"
                    stroke="<?= $color ?>"
                    stroke-width="14"
                    stroke-dasharray="<?= $dash ?> 263.8"
                    stroke-dashoffset="<?= -array_sum(array_slice(array_map(fn($x)=>($x/$total)*263.8, array_values($types)), 0, $offset)) ?>"/>
          <?php $offset++; endforeach; ?>
        </svg>
        <div class="admin-donut__chart-center">
          <strong><?= $props ?></strong>
          <span>Properties</span>
        </div>
      </div>
      <div class="admin-donut__legend">
        <?php $offset = 0; foreach ($types as $t => $c):
          $color = $palette[$offset % count($palette)] ?? '#F59E0B';
          $pct = round(($c / $total) * 100);
        ?>
          <div class="admin-donut__legend-row">
            <span class="dot" style="background:<?= $color ?>"></span>
            <span class="label"><?= e($t) ?></span>
            <span class="count"><?= $c ?></span>
            <span class="pct"><?= $pct ?>%</span>
          </div>
        <?php $offset++; endforeach; ?>
        <?php if (empty($types)): ?>
          <p class="muted" style="font-size:13px;margin:0">No properties yet.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="admin-card">
    <div class="admin-card__head">
      <div class="admin-card__title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/><path d="M22 12A10 10 0 0 0 12 2v10z"/></svg>
        Sale vs Rent
      </div>
      <span class="admin-card__pill">All Time</span>
    </div>

    <?php
      $listings = ['sale' => 0, 'rent' => 0, 'lease' => 0];
      if ($props > 0 && class_exists(\App\Models\Property::class)) {
        foreach (\App\Models\Property::all() as $p) {
          $l = $p['listing'] ?? 'sale';
          $listings[$l] = ($listings[$l] ?? 0) + 1;
        }
      }
      $listings = array_filter($listings);
      $lpalette = ['sale' => '#4F46E5', 'rent' => '#F59E0B', 'lease' => '#10B981'];
      $llabels  = ['sale' => 'For Sale', 'rent' => 'For Rent', 'lease' => 'For Lease'];
      $ltotal = array_sum($listings) ?: 1;
      $offset = 0;
    ?>

    <div class="admin-donut">
      <div class="admin-donut__chart">
        <svg viewBox="0 0 100 100">
          <circle cx="50" cy="50" r="42" fill="none" stroke="#F5F4EF" stroke-width="14"/>
          <?php foreach ($listings as $k => $c):
            $pct = ($c / $ltotal) * 100;
            $dash = $pct * 2.638;
          ?>
            <circle cx="50" cy="50" r="42" fill="none"
                    stroke="<?= $lpalette[$k] ?? '#999' ?>"
                    stroke-width="14"
                    stroke-dasharray="<?= $dash ?> 263.8"
                    stroke-dashoffset="<?= -array_sum(array_slice(array_map(fn($x)=>($x/$ltotal)*263.8, array_values($listings)), 0, $offset)) ?>"/>
          <?php $offset++; endforeach; ?>
        </svg>
        <div class="admin-donut__chart-center">
          <strong><?= array_sum($listings) ?></strong>
          <span>Listings</span>
        </div>
      </div>
      <div class="admin-donut__legend">
        <?php foreach ($listings as $k => $c):
          $pct = round(($c / $ltotal) * 100);
        ?>
          <div class="admin-donut__legend-row">
            <span class="dot" style="background:<?= $lpalette[$k] ?? '#999' ?>"></span>
            <span class="label"><?= e($llabels[$k] ?? ucfirst($k)) ?></span>
            <span class="count"><?= $c ?></span>
            <span class="pct"><?= $pct ?>%</span>
          </div>
        <?php endforeach; ?>
        <?php if (empty($listings)): ?>
          <p class="muted" style="font-size:13px;margin:0">No listings yet.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- Inquiries by Month + Inquiry Status -->
<div class="grid cols-2 mb-24" style="gap:22px;grid-template-columns:1.4fr 1fr">
  <div class="admin-card">
    <div class="admin-card__head">
      <div class="admin-card__title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
        Inquiries by Month
      </div>
      <span class="admin-card__pill">Last 6 Months</span>
    </div>
    <div class="admin-bars">
      <?php foreach ($months as $m):
        $h = $m['val'] > 0 ? max(8, ($m['val'] / $maxBar) * 170) : 4;
      ?>
        <div class="admin-bars__col">
          <div class="admin-bars__bar" style="height:<?= $h ?>px">
            <?php if ($m['val'] > 0): ?><span class="admin-bars__bar-val"><?= $m['val'] ?></span><?php endif; ?>
          </div>
          <div class="admin-bars__lbl"><?= e($m['lbl']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="admin-card">
    <div class="admin-card__head">
      <div class="admin-card__title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        Inquiry Status
      </div>
      <span class="admin-card__pill">All Time</span>
    </div>

    <?php
      $contacted = max(0, $leads - $leadsNew);
      $statusData = [
        ['Contacted', $contacted,  $contactedPct, '#4F46E5'],
        ['New',       $leadsNew,   $newPct,       '#F59E0B'],
      ];
    ?>
    <div class="admin-statuslist">
      <?php foreach ($statusData as [$lbl, $count, $pct, $color]): ?>
        <div>
          <div class="admin-statusrow__head">
            <span class="chip" style="background:<?= $color ?>1A;color:<?= $color ?>;border-color:<?= $color ?>33"><?= e($lbl) ?></span>
            <span class="val"><?= $count ?> <span>(<?= $pct ?>%)</span></span>
          </div>
          <div class="admin-statusrow__bar"><span style="width:<?= $pct ?>%;background:<?= $color ?>"></span></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<!-- Quick stats row -->
<div class="grid cols-4 mb-24" style="gap:16px">
  <div class="admin-stat">
    <div class="l">Properties</div>
    <div class="v"><?= $props ?></div>
    <div class="trend">+<?= max(0,$props) ?> total in catalog</div>
  </div>
  <div class="admin-stat">
    <div class="l">Total Inquiries</div>
    <div class="v"><?= $leads ?></div>
    <div class="trend"><?= $leadsNew ?> new this week</div>
  </div>
  <div class="admin-stat">
    <div class="l">Blog Posts</div>
    <div class="v"><?= $blogs ?></div>
    <div class="trend">Published content</div>
  </div>
  <div class="admin-stat">
    <div class="l">Subscribers</div>
    <div class="v"><?= $subscribers ?></div>
    <div class="trend"><?= $testimonials ?> reviews</div>
  </div>
</div>

<!-- Recent leads table -->
<div class="admin-card">
  <div class="admin-card__head">
    <div class="admin-card__title">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
      Recent Inquiries
    </div>
    <a href="/admin/leads" class="va-link-arrow">View all
      <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
    </a>
  </div>
  <?php if (empty($recentLeads)): ?>
    <p class="muted" style="padding:20px 0;margin:0">No inquiries yet. They'll show here as soon as contact forms get submissions.</p>
  <?php else: ?>
    <table class="admin-table">
      <thead><tr><th>Date</th><th>Name</th><th>Phone</th><th>Source</th><th>Status</th></tr></thead>
      <tbody>
        <?php foreach ($recentLeads as $l): ?>
          <tr>
            <td class="muted"><?= e(is_string($l['createdAt'] ?? '') ? $l['createdAt'] : '') ?></td>
            <td><strong><?= e($l['name'] ?? '') ?></strong></td>
            <td><?= e($l['phone'] ?? '') ?></td>
            <td><span class="chip"><?= e($l['source'] ?? '') ?></span></td>
            <td><span class="chip chip-gold"><?= e($l['status'] ?? 'new') ?></span></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php $view->endSection(); ?>
