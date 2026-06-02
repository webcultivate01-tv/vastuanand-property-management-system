<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<?php
$q        = $query ?? [];
$hasFilter = !empty(array_filter($q, fn($v) => $v !== ''));
$total    = (int)($result['total'] ?? 0);
?>

<div class="admin-page-head">
  <div>
    <h1>Properties</h1>
    <p>Manage your catalog of listings, statuses and featured picks.</p>
  </div>
  <?php $exportQS = http_build_query(array_filter($q, fn($v) => $v !== '')); ?>
  <div style="display:flex;gap:8px;flex-wrap:wrap">
    <a href="/admin/properties/export?format=csv<?= $exportQS ? '&'.$exportQS : '' ?>" class="btn btn-ghost" title="Download filtered properties as CSV">CSV</a>
    <a href="/admin/properties/export?format=excel<?= $exportQS ? '&'.$exportQS : '' ?>" class="btn btn-ghost">Excel</a>
    <a href="/admin/properties/export?format=pdf<?= $exportQS ? '&'.$exportQS : '' ?>" target="_blank" class="btn btn-ghost">PDF</a>
    <a href="/admin/properties/create" class="btn btn-primary">+ New Property</a>
  </div>
</div>

<!-- ── Filter bar ─────────────────────────── -->
<form method="get" class="admin-filters" id="adminPropFilters">
  <div class="admin-filters__row">
    <div class="admin-filters__search">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" name="q" placeholder="Search title, location, description or tags…" value="<?= e($q['q'] ?? '') ?>" autocomplete="off">
    </div>
    <select name="listing" class="form-control" onchange="this.form.submit()">
      <option value="">All listings</option>
      <?php foreach ($listings as $l): ?>
        <option value="<?= e($l) ?>" <?= ($q['listing'] ?? '') === $l ? 'selected' : '' ?>><?= e(ucfirst($l)) ?></option>
      <?php endforeach; ?>
    </select>
    <select name="type" class="form-control" onchange="this.form.submit()">
      <option value="">All types</option>
      <?php foreach ($types as $t): ?>
        <option value="<?= e($t) ?>" <?= ($q['type'] ?? '') === $t ? 'selected' : '' ?>><?= e($t) ?></option>
      <?php endforeach; ?>
    </select>
    <select name="location" class="form-control" onchange="this.form.submit()">
      <option value="">All locations</option>
      <?php foreach ($locations as $loc): ?>
        <option value="<?= e($loc) ?>" <?= ($q['location'] ?? '') === $loc ? 'selected' : '' ?>><?= e($loc) ?></option>
      <?php endforeach; ?>
    </select>
    <select name="sort" class="form-control" onchange="this.form.submit()">
      <option value="">Newest first</option>
      <option value="oldest"     <?= ($q['sort'] ?? '') === 'oldest'     ? 'selected' : '' ?>>Oldest first</option>
      <option value="price_high" <?= ($q['sort'] ?? '') === 'price_high' ? 'selected' : '' ?>>Price: high to low</option>
      <option value="price_low"  <?= ($q['sort'] ?? '') === 'price_low'  ? 'selected' : '' ?>>Price: low to high</option>
    </select>
  </div>

  <div class="admin-filters__row admin-filters__row--secondary">
    <select name="bhk" class="form-control" onchange="this.form.submit()">
      <option value="">Any BHK</option>
      <?php for ($i = 1; $i <= 6; $i++): ?>
        <option value="<?= $i ?>" <?= (int)($q['bhk'] ?? 0) === $i ? 'selected' : '' ?>><?= $i ?> BHK</option>
      <?php endfor; ?>
    </select>
    <div class="admin-filters__price">
      <input type="number" name="min" class="form-control" placeholder="Min price ₹" value="<?= e($q['min'] ?? '') ?>" min="0" step="100000">
      <span>—</span>
      <input type="number" name="max" class="form-control" placeholder="Max price ₹" value="<?= e($q['max'] ?? '') ?>" min="0" step="100000">
    </div>
    <label class="admin-filters__check">
      <input type="checkbox" name="featured" value="1" <?= !empty($q['featured']) ? 'checked' : '' ?> onchange="this.form.submit()">
      <span>★ Featured only</span>
    </label>
    <div class="admin-filters__actions">
      <button type="submit" class="btn btn-primary">Apply</button>
      <?php if ($hasFilter): ?>
        <a href="/admin/properties" class="btn btn-ghost" title="Clear all filters">Clear</a>
      <?php endif; ?>
    </div>
  </div>
</form>

<!-- ── Result summary ─────────────────────── -->
<div class="admin-filters__summary">
  <strong><?= number_format($total) ?></strong> <?= $total === 1 ? 'property' : 'properties' ?>
  <?php if ($hasFilter): ?>
    <span class="muted">matching your filters</span>
    <?php
    $chips = [];
    if (!empty($q['q']))        $chips[] = ['q',        'Search: "' . $q['q'] . '"'];
    if (!empty($q['listing']))  $chips[] = ['listing',  ucfirst($q['listing'])];
    if (!empty($q['type']))     $chips[] = ['type',     $q['type']];
    if (!empty($q['location'])) $chips[] = ['location', $q['location']];
    if (!empty($q['bhk']))      $chips[] = ['bhk',      $q['bhk'] . ' BHK'];
    if (!empty($q['min']))      $chips[] = ['min',      'Min ₹' . number_format((float)$q['min'])];
    if (!empty($q['max']))      $chips[] = ['max',      'Max ₹' . number_format((float)$q['max'])];
    if (!empty($q['featured'])) $chips[] = ['featured', '★ Featured'];
    if (!empty($q['sort']) && $q['sort'] !== '') $chips[] = ['sort', 'Sort: ' . str_replace('_', ' ', $q['sort'])];
    foreach ($chips as [$key, $label]):
      $remaining = $q; unset($remaining[$key]);
      $url = '/admin/properties' . (!empty($remaining) ? '?' . http_build_query($remaining) : '');
    ?>
      <a class="admin-filters__chip" href="<?= e($url) ?>" title="Remove this filter">
        <?= e($label) ?>
        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </a>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<!-- ── Results table ──────────────────────── -->
<div class="admin-card" style="padding:0;overflow:hidden">
  <table class="admin-table">
    <thead><tr><th>Title</th><th>Location</th><th>Listing</th><th>Type</th><th>BHK</th><th>Price</th><th>Featured</th><th style="text-align:right">Actions</th></tr></thead>
    <tbody>
      <?php foreach ($result['data'] as $p): ?>
        <tr>
          <td>
            <strong><?= e($p['title']) ?></strong>
            <br><span class="muted" style="font-size:12px"><?= e($p['slug'] ?? '') ?></span>
          </td>
          <td class="muted"><?= e($p['location'] ?? '') ?></td>
          <td><span class="chip"><?= e(ucfirst($p['listing'] ?? 'sale')) ?></span></td>
          <td class="muted"><?= e($p['type'] ?? '—') ?></td>
          <td><?= !empty($p['bhk']) ? (int)$p['bhk'] : '—' ?></td>
          <td><strong><?= format_price($p['price'] ?? 0) ?></strong></td>
          <td><?= !empty($p['featured']) ? '<span style="color:var(--gold)">★</span>' : '—' ?></td>
          <td style="text-align:right;white-space:nowrap">
            <a href="/admin/properties/<?= e($p['id']) ?>/edit" class="btn btn-ghost btn-sm">Edit</a>
            <form method="post" action="/admin/properties/<?= e($p['id']) ?>/delete" style="display:inline" onsubmit="return confirm('Delete this property?')"><button class="btn btn-sm" style="color:var(--danger);border-color:var(--line)">Delete</button></form>
          </td>
        </tr>
      <?php endforeach; ?>
      <?php if (empty($result['data'])): ?>
        <tr><td colspan="8" class="muted text-center" style="padding:60px 0">
          <?php if ($hasFilter): ?>
            No properties match your filters. <a href="/admin/properties" class="gold">Clear filters →</a>
          <?php else: ?>
            No properties yet. <a href="/admin/properties/create" class="gold">Add the first one →</a>
          <?php endif; ?>
        </td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- ── Pagination ─────────────────────────── -->
<?php if (($result['pages'] ?? 1) > 1):
  $page   = (int)($result['page'] ?? 1);
  $pages  = (int)($result['pages'] ?? 1);
  $params = $q;
  $linkFor = function(int $p) use ($params) {
    $params['page'] = $p;
    return '/admin/properties?' . http_build_query($params);
  };
?>
  <nav class="admin-pagination">
    <?php if ($page > 1): ?>
      <a href="<?= e($linkFor($page - 1)) ?>" class="btn btn-ghost btn-sm">← Prev</a>
    <?php endif; ?>
    <span class="muted">Page <strong><?= $page ?></strong> of <?= $pages ?></span>
    <?php if ($page < $pages): ?>
      <a href="<?= e($linkFor($page + 1)) ?>" class="btn btn-ghost btn-sm">Next →</a>
    <?php endif; ?>
  </nav>
<?php endif; ?>

<script>
  // Debounce text-search submit to avoid hammering the server while typing
  (function () {
    const input = document.querySelector('#adminPropFilters input[name="q"]');
    if (!input) return;
    let t = null;
    input.addEventListener('input', () => {
      clearTimeout(t);
      t = setTimeout(() => input.form.submit(), 450);
    });
  })();
</script>

<?php $view->endSection(); ?>
