<?php /** @var \App\Core\View $view */ $view->extend('layouts.main'); ?>
<?php $view->section('content'); ?>

<!-- Compact page header (no hero) -->
<div class="va-prop-header">
  <div class="container-lg">
    <div class="va-prop-header__inner">
      <div>
        <nav class="va-h-crumb" aria-label="Breadcrumb">
          <a href="/">Home</a>
          <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
          <strong>Properties</strong>
        </nav>
        <h1 class="va-prop-header__title">Properties in <span class="va-h-accent">Mumbai</span></h1>
        <p class="va-prop-header__sub">RERA-verified listings across Mumbai's prime micro-markets — transparently priced.</p>
      </div>
      <div class="va-prop-header__meta">
        <div class="va-prop-header__stat">
          <strong><?= (int)($result['total'] ?? count($result['data'] ?? [])) ?></strong>
          <span>Listings</span>
        </div>
        <div class="va-prop-header__stat">
          <strong>4.9<em>★</em></strong>
          <span>Client Rating</span>
        </div>
        <a href="/contact" class="va-cta va-cta--ghost va-prop-header__cta">Talk to Advisor</a>
      </div>
    </div>
  </div>
</div>

<!-- Professional search + filter bar -->
<div class="va-pf-wrap">
  <div class="container-lg">
    <form class="va-pf" id="filterForm" method="get" action="/properties">

      <!-- Listing type tabs -->
      <div class="va-pf__tabs" role="tablist">
        <?php
        $cur = $filters['listing'] ?? '';
        $tabs = ['' => 'All Listings', 'sale' => 'For Sale', 'rent' => 'For Rent', 'lease' => 'For Lease'];
        foreach ($tabs as $val => $label):
        ?>
          <button type="button" class="va-pf__tab <?= $cur === $val ? 'active' : '' ?>" data-listing="<?= e($val) ?>"><?= e($label) ?></button>
        <?php endforeach; ?>
        <input type="hidden" name="listing" value="<?= e($cur) ?>">
      </div>

      <!-- Main filter bar -->
      <div class="va-pf__bar">

        <!-- Search -->
        <div class="va-pf__field va-pf__field--search">
          <svg class="va-pf__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <div style="flex:1;min-width:0">
            <div class="va-pf__label">Search</div>
            <input type="text" name="q" value="<?= e($filters['q'] ?? '') ?>" placeholder="Project, area, builder…" autocomplete="off">
          </div>
          <?php if (!empty($filters['q'])): ?>
          <button type="button" class="va-pf__clear-input" onclick="this.closest('form').querySelector('[name=q]').value=''; this.remove();" aria-label="Clear search">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
          </button>
          <?php endif; ?>
        </div>

        <!-- Property Type -->
        <div class="va-pf__field va-pf__field--select">
          <div class="va-pf__label">Type</div>
          <select name="type">
            <option value="">Any type</option>
            <?php foreach ($types as $t): ?>
              <option <?= ($filters['type'] ?? '') === $t ? 'selected' : '' ?>><?= e($t) ?></option>
            <?php endforeach; ?>
          </select>
          <svg class="va-pf__chevron" width="10" height="6" viewBox="0 0 10 6" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M1 1l4 4 4-4"/></svg>
        </div>

        <!-- Location -->
        <div class="va-pf__field va-pf__field--select">
          <div class="va-pf__label">Location</div>
          <select name="location">
            <option value="">Any area</option>
            <?php foreach ($locations as $l): ?>
              <option <?= ($filters['location'] ?? '') === $l ? 'selected' : '' ?>><?= e($l) ?></option>
            <?php endforeach; ?>
          </select>
          <svg class="va-pf__chevron" width="10" height="6" viewBox="0 0 10 6" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M1 1l4 4 4-4"/></svg>
        </div>

        <!-- BHK -->
        <div class="va-pf__field va-pf__field--select">
          <div class="va-pf__label">BHK</div>
          <select name="bhk">
            <option value="">Any</option>
            <?php foreach ([1,2,3,4,5] as $b): ?>
              <option value="<?= $b ?>" <?= (int)($filters['bhk'] ?? 0) === $b ? 'selected' : '' ?>><?= $b ?><?= $b === 5 ? '+' : '' ?> BHK</option>
            <?php endforeach; ?>
          </select>
          <svg class="va-pf__chevron" width="10" height="6" viewBox="0 0 10 6" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M1 1l4 4 4-4"/></svg>
        </div>

        <!-- Budget -->
        <div class="va-pf__field va-pf__field--select">
          <div class="va-pf__label">Budget</div>
          <select id="budgetPreset" onchange="vaApplyBudget(this)">
            <option value="">Any budget</option>
            <option value="0,5000000" <?= (($filters['max']??'')==='5000000')?'selected':'' ?>>Under ₹50L</option>
            <option value="5000000,10000000" <?= (($filters['min']??'')==='5000000'&&($filters['max']??'')==='10000000')?'selected':'' ?>>₹50L – 1Cr</option>
            <option value="10000000,30000000" <?= (($filters['min']??'')==='10000000'&&($filters['max']??'')==='30000000')?'selected':'' ?>>₹1Cr – 3Cr</option>
            <option value="30000000,80000000" <?= (($filters['min']??'')==='30000000'&&($filters['max']??'')==='80000000')?'selected':'' ?>>₹3Cr – 8Cr</option>
            <option value="80000000," <?= (($filters['min']??'')==='80000000'&&empty($filters['max']))?'selected':'' ?>>₹8Cr+</option>
          </select>
          <svg class="va-pf__chevron" width="10" height="6" viewBox="0 0 10 6" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M1 1l4 4 4-4"/></svg>
          <input type="hidden" name="min" id="budgetMin" value="<?= e($filters['min'] ?? '') ?>">
          <input type="hidden" name="max" id="budgetMax" value="<?= e($filters['max'] ?? '') ?>">
        </div>

        <!-- Submit -->
        <button type="submit" class="va-pf__submit">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          Search
        </button>
      </div>

      <!-- Footer: active badge + sort -->
      <div class="va-pf__foot">
        <div class="va-pf__foot-left">
          <?php
          $activeCount = 0;
          foreach (['q','type','location','bhk','min','max'] as $k) if (!empty($filters[$k])) $activeCount++;
          if (!empty($filters['listing'])) $activeCount++;
          ?>
          <?php if ($activeCount > 0): ?>
            <span class="va-pf__badge"><?= $activeCount ?> filter<?= $activeCount > 1 ? 's' : '' ?> active</span>
            <a href="/properties" class="va-pf__clear-all">Clear all</a>
          <?php else: ?>
            <span class="va-pf__hint">Use filters above to narrow your search</span>
          <?php endif; ?>
        </div>
        <div class="va-pf__sort">
          <label>Sort by</label>
          <select name="sort" onchange="this.form.submit()">
            <option value="">Newest first</option>
            <option value="price_low"  <?= ($filters['sort'] ?? '') === 'price_low'  ? 'selected' : '' ?>>Price: Low → High</option>
            <option value="price_high" <?= ($filters['sort'] ?? '') === 'price_high' ? 'selected' : '' ?>>Price: High → Low</option>
            <option value="oldest"     <?= ($filters['sort'] ?? '') === 'oldest'     ? 'selected' : '' ?>>Oldest first</option>
          </select>
        </div>
      </div>

    </form>
  </div>
</div>

<!-- Results -->
<div class="va-prop-results-wrap">
  <div class="container-lg">

    <div class="va-prop-results__bar" data-reveal>
      <p class="va-prop-results__count">
        Showing <strong><?= (int)($result['total'] ?? count($result['data'] ?? [])) ?></strong>
        propert<?= ($result['total'] ?? count($result['data'] ?? [])) === 1 ? 'y' : 'ies' ?>
        <?php if (!empty($filters['location'])): ?> in <strong><?= e($filters['location']) ?></strong><?php endif; ?>
      </p>
      <a href="/contact" class="va-link-arrow">
        Need help? Talk to an advisor
        <svg width="14" height="10" viewBox="0 0 14 10" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M0 5h13M9 1l4 4-4 4"/></svg>
      </a>
    </div>

    <?php if (empty($result['data'])): ?>
      <div class="va-empty" data-reveal>
        <div class="va-empty__icon">
          <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </div>
        <h3>No properties match your filters</h3>
        <p>Try expanding your budget, BHK, or location — or talk to one of our advisors for a private match from our off-market inventory.</p>
        <div class="flex gap-16" style="justify-content:center;flex-wrap:wrap">
          <a href="/properties" class="btn btn-ghost">Reset filters</a>
          <a href="/contact" class="btn btn-primary">Talk to advisor</a>
        </div>
      </div>
    <?php else: ?>
      <div class="va-prop-grid" data-stagger>
        <?php foreach ($result['data'] as $p) $view->include('components.property-card', ['p' => $p]); ?>
      </div>
    <?php endif; ?>

    <?php if (($result['pages'] ?? 1) > 1): ?>
      <nav class="va-pagination" aria-label="Pagination">
        <?php for ($i = 1; $i <= $result['pages']; $i++): ?>
          <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"
             class="<?= $i === ($result['page'] ?? 1) ? 'is-active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
      </nav>
    <?php endif; ?>

  </div>
</div>

<script>
function vaApplyBudget(sel) {
  const parts = sel.value.split(',');
  document.getElementById('budgetMin').value = parts[0] || '';
  document.getElementById('budgetMax').value = parts[1] !== undefined ? parts[1] : '';
}
(function () {
  const tabs = document.querySelectorAll('.va-pf__tab');
  const inp  = document.querySelector('.va-pf input[name="listing"]');
  tabs.forEach(function(tab) {
    tab.addEventListener('click', function() {
      tabs.forEach(function(t) { t.classList.remove('active'); });
      tab.classList.add('active');
      inp.value = tab.dataset.listing;
    });
  });
}());
</script>

<?php $view->endSection(); ?>
