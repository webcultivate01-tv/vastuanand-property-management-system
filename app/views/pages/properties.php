<?php /** @var \App\Core\View $view */ $view->extend('layouts.main'); ?>
<?php $view->section('content'); ?>

<section class="va-hero-prop">
  <div class="container-lg">
    <div class="va-hero-prop__grid">
      <div class="va-hero-prop__copy" data-reveal="left">
        <div class="va-h-crumb">
          <a href="/">Home</a> <span>/</span> <strong>Properties</strong>
        </div>
        <span class="eyebrow">OUR PORTFOLIO · MUMBAI</span>
        <h1>Premium properties in <span class="va-h-accent">Mumbai</span>.</h1>
        <p class="lede">Curated residential and commercial inventory across Mumbai's prime micro-markets — RERA-verified, transparently priced, with zero brokerage on select listings.</p>
        <div class="flex gap-16" style="flex-wrap:wrap">
          <a href="#filterForm" class="va-cta">Explore Listings</a>
          <a href="/contact" class="va-cta va-cta--ghost">Talk to Advisor</a>
        </div>

        <div class="va-hero-prop__stats">
          <div>
            <strong>500<em>+</em></strong>
            <span>Curated Listings</span>
          </div>
          <div>
            <strong>15<em>min</em></strong>
            <span>WhatsApp Response</span>
          </div>
          <div>
            <strong>4.9<em>★</em></strong>
            <span>Client Rating</span>
          </div>
        </div>
      </div>

      <div data-reveal="right">
        <div class="va-hero-prop__collage">
          <div class="va-hero-prop__tile va-hero-prop__tile--lg">
            <img loading="lazy" src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=900&q=80" alt="Sea-facing residence">
          </div>
          <div class="va-hero-prop__tile va-hero-prop__tile--sm">
            <img loading="lazy" src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=600&q=80" alt="Modern interior">
          </div>
          <div class="va-hero-prop__tile va-hero-prop__tile--md">
            <img loading="lazy" src="https://images.unsplash.com/photo-1613490493576-7fde63acd811?auto=format&fit=crop&w=900&q=80" alt="Penthouse view">
          </div>
          <div class="va-hero-prop__floater">
            <span class="dot"></span>
            <div>
              <strong>Live inventory</strong>
              <span style="display:block">Updated 5 min ago</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section style="padding:0 0 80px">
  <div class="container-lg">
    <form class="va-prop-filters" id="filterForm" data-reveal>
      <div class="va-prop-filters__tabs" role="tablist">
        <?php
        $cur = $filters['listing'] ?? '';
        $tabs = [
          ''      => 'All Listings',
          'sale'  => 'For Sale',
          'rent'  => 'For Rent',
          'lease' => 'For Lease',
        ];
        foreach ($tabs as $val => $label):
        ?>
          <button type="button" class="va-prop-filters__tab <?= $cur === $val ? 'active' : '' ?>" data-listing="<?= e($val) ?>"><?= e($label) ?></button>
        <?php endforeach; ?>
      </div>
      <input type="hidden" name="listing" value="<?= e($cur) ?>">

      <div class="va-prop-filters__grid">
        <label class="va-prop-filters__field">
          <span>Search</span>
          <input type="text" name="q" value="<?= e($filters['q'] ?? '') ?>" placeholder="Project, area, builder…">
        </label>

        <label class="va-prop-filters__field">
          <span>Property Type</span>
          <select name="type">
            <option value="">Any type</option>
            <?php foreach ($types as $t): ?>
              <option <?= ($filters['type'] ?? '')===$t?'selected':'' ?>><?= e($t) ?></option>
            <?php endforeach; ?>
          </select>
        </label>

        <label class="va-prop-filters__field">
          <span>Location</span>
          <select name="location">
            <option value="">Any location</option>
            <?php foreach ($locations as $l): ?>
              <option <?= ($filters['location'] ?? '')===$l?'selected':'' ?>><?= e($l) ?></option>
            <?php endforeach; ?>
          </select>
        </label>

        <label class="va-prop-filters__field">
          <span>BHK</span>
          <select name="bhk">
            <option value="">Any</option>
            <?php foreach ([1,2,3,4,5] as $b): ?>
              <option value="<?= $b ?>" <?= (int)($filters['bhk'] ?? 0)===$b?'selected':'' ?>><?= $b ?> BHK<?= $b===5?'+':'' ?></option>
            <?php endforeach; ?>
          </select>
        </label>

        <div class="va-prop-filters__field">
          <span>Budget (₹)</span>
          <div class="va-prop-filters__range">
            <input name="min" type="number" value="<?= e($filters['min'] ?? '') ?>" placeholder="Min" inputmode="numeric">
            <span>–</span>
            <input name="max" type="number" value="<?= e($filters['max'] ?? '') ?>" placeholder="Max" inputmode="numeric">
          </div>
        </div>

        <button type="submit" class="va-prop-filters__submit">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          Apply Filters
        </button>
      </div>

      <div class="va-prop-filters__foot">
        <div>
          <label for="sort-select" style="margin-right:6px;font-weight:600">Sort by:</label>
          <select id="sort-select" name="sort" style="background:transparent;border:none;font:inherit;font-weight:600;color:var(--ink);outline:none;cursor:pointer">
            <option value="">Newest first</option>
            <option value="price_low" <?= ($filters['sort'] ?? '')==='price_low'?'selected':'' ?>>Price: Low → High</option>
            <option value="price_high" <?= ($filters['sort'] ?? '')==='price_high'?'selected':'' ?>>Price: High → Low</option>
            <option value="oldest" <?= ($filters['sort'] ?? '')==='oldest'?'selected':'' ?>>Oldest first</option>
          </select>
        </div>
        <a href="/properties">Clear all filters</a>
      </div>
    </form>

    <div class="va-prop-results__bar" data-reveal>
      <p class="va-prop-results__count">
        Showing <strong><?= (int)($result['total'] ?? count($result['data'] ?? [])) ?></strong> properties
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
</section>

<?php $view->endSection(); ?>
