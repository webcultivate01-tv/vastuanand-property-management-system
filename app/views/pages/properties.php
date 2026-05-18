<?php /** @var \App\Core\View $view */ $view->extend('layouts.main'); ?>
<?php $view->section('content'); ?>

<section style="padding:140px 0 60px;background:linear-gradient(180deg,#000,var(--ink-2))">
  <div class="container-lg" data-reveal>
    <span class="eyebrow">OUR PORTFOLIO</span>
    <h1 class="display" style="font-size:clamp(40px,5vw,72px);margin:18px 0 16px">Premium Properties in Mumbai</h1>
    <p class="muted" style="max-width:680px;font-size:16px;line-height:1.7">Browse our exclusive collection of premium residential and commercial properties across Mumbai. Every listing is RERA-verified with transparent pricing.</p>
  </div>
</section>

<section style="padding:30px 0 60px">
  <div class="container-lg">
    <form class="glass" style="padding:24px;display:grid;grid-template-columns:repeat(2,1fr);gap:12px" id="filterForm">
      <input type="text" name="q" value="<?= e($filters['q'] ?? '') ?>" placeholder="Search by name or area" class="form-control">
      <select name="listing" class="form-control">
        <option value="">All Listings</option>
        <option value="sale" <?= ($filters['listing'] ?? '')==='sale'?'selected':'' ?>>For Sale</option>
        <option value="rent" <?= ($filters['listing'] ?? '')==='rent'?'selected':'' ?>>For Rent</option>
        <option value="lease" <?= ($filters['listing'] ?? '')==='lease'?'selected':'' ?>>For Lease</option>
      </select>
      <select name="type" class="form-control">
        <option value="">All Types</option>
        <?php foreach ($types as $t): ?>
          <option <?= ($filters['type'] ?? '')===$t?'selected':'' ?>><?= e($t) ?></option>
        <?php endforeach; ?>
      </select>
      <select name="location" class="form-control">
        <option value="">All Locations</option>
        <?php foreach ($locations as $l): ?>
          <option <?= ($filters['location'] ?? '')===$l?'selected':'' ?>><?= e($l) ?></option>
        <?php endforeach; ?>
      </select>
      <select name="bhk" class="form-control">
        <option value="">BHK</option>
        <?php foreach ([1,2,3,4,5] as $b): ?>
          <option value="<?= $b ?>" <?= (int)($filters['bhk'] ?? 0)===$b?'selected':'' ?>><?= $b ?> BHK<?= $b===5?'+':'' ?></option>
        <?php endforeach; ?>
      </select>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
        <input class="form-control" name="min" type="number" value="<?= e($filters['min'] ?? '') ?>" placeholder="Min ₹">
        <input class="form-control" name="max" type="number" value="<?= e($filters['max'] ?? '') ?>" placeholder="Max ₹">
      </div>
      <select name="sort" class="form-control">
        <option value="">Sort: Newest</option>
        <option value="price_low" <?= ($filters['sort'] ?? '')==='price_low'?'selected':'' ?>>Price: Low → High</option>
        <option value="price_high" <?= ($filters['sort'] ?? '')==='price_high'?'selected':'' ?>>Price: High → Low</option>
        <option value="oldest" <?= ($filters['sort'] ?? '')==='oldest'?'selected':'' ?>>Oldest</option>
      </select>
      <button type="submit" class="btn btn-primary" style="grid-column:1 / -1">Apply Filters</button>
    </form>

    <div class="flex justify-between items-center" style="margin:40px 0 24px">
      <p class="muted">Showing <strong style="color:var(--gold)"><?= (int)($result['total'] ?? count($result['data'] ?? [])) ?></strong> properties</p>
    </div>

    <?php if (empty($result['data'])): ?>
      <div class="glass" style="padding:80px;text-align:center">
        <h3 style="font-family:'Cormorant Garamond',serif;font-size:32px;color:var(--gold)">No properties match your filters yet.</h3>
        <p class="muted" style="margin-top:12px">Try expanding your budget, BHK or location — or <a href="/contact" class="gold">talk to an advisor</a> for a private match.</p>
      </div>
    <?php else: ?>
      <div class="grid cols-3">
        <?php foreach ($result['data'] as $p) $view->include('components.property-card', ['p' => $p]); ?>
      </div>
    <?php endif; ?>

    <?php if (($result['pages'] ?? 1) > 1): ?>
      <div class="flex gap-8" style="justify-content:center;margin-top:60px">
        <?php for ($i = 1; $i <= $result['pages']; $i++): ?>
          <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"
             class="<?= $i === ($result['page'] ?? 1) ? 'btn btn-primary' : 'btn btn-ghost' ?>"
             style="padding:10px 16px;font-size:13px"><?= $i ?></a>
        <?php endfor; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php $view->endSection(); ?>
