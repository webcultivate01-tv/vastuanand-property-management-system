<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<?php
  $isNew    = empty($item);
  $action   = $isNew ? '/admin/filters' : '/admin/filters/' . e($item['id']);
  $errors   = $_SESSION['_errors'] ?? []; unset($_SESSION['_errors']);
  $old      = $_SESSION['_old']    ?? []; unset($_SESSION['_old']);
  $val      = fn($k, $default = '') => e((string)($old[$k] ?? $item[$k] ?? $default));
  $checked  = fn($k, $default = false) => (!empty($old[$k]) || (!isset($old[$k]) && !empty($item[$k] ?? $default))) ? 'checked' : '';
  $type     = $old['type'] ?? ($item['type'] ?? 'select');
  $options  = $item['options'] ?? [['label' => '', 'value' => '', 'hide' => []]];
  if (empty($options)) $options = [['label' => '', 'value' => '', 'hide' => []]];
?>

<div class="admin-page-head">
  <div>
    <h1><?= $isNew ? 'New Filter Field' : 'Edit Filter' ?></h1>
    <p>Define a field that appears in the home search box or properties listing filter.</p>
  </div>
  <a href="/admin/filters" class="btn btn-ghost">← Back</a>
</div>

<form method="post" action="<?= $action ?>" class="grid" style="grid-template-columns:1fr 320px;gap:20px;align-items:start">
  <?= csrf_field() ?>

  <div class="admin-card">
    <h3 style="margin-top:0;margin-bottom:16px">Field Definition</h3>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px">
      <div>
        <label class="form-label">Label</label>
        <input type="text" name="label" class="form-control" value="<?= $val('label') ?>" placeholder="e.g. Possession Status" required>
        <?php if (!empty($errors['label'])): ?><small style="color:#ef4444"><?= e($errors['label'][0]) ?></small><?php endif; ?>
      </div>
      <div>
        <label class="form-label">Key <small class="muted">(URL param name)</small></label>
        <input type="text" name="key" class="form-control" value="<?= $val('key') ?>" placeholder="e.g. possession" required>
        <?php if (!empty($errors['key'])): ?><small style="color:#ef4444"><?= e($errors['key'][0]) ?></small><?php endif; ?>
      </div>
    </div>

    <div style="display:grid;grid-template-columns:200px 1fr 110px;gap:14px;margin-bottom:14px">
      <div>
        <label class="form-label">Type</label>
        <select name="type" id="filterType" class="form-control">
          <option value="select" <?= $type === 'select' ? 'selected' : '' ?>>Dropdown (select)</option>
          <option value="text"   <?= $type === 'text'   ? 'selected' : '' ?>>Text input</option>
          <option value="number" <?= $type === 'number' ? 'selected' : '' ?>>Number input</option>
        </select>
      </div>
      <div>
        <label class="form-label">Placeholder</label>
        <input type="text" name="placeholder" class="form-control" value="<?= $val('placeholder') ?>" placeholder="e.g. Any location">
      </div>
      <div>
        <label class="form-label">Order</label>
        <input type="number" name="order" class="form-control" value="<?= $val('order', '0') ?>">
      </div>
    </div>

    <div id="optionsPanel" style="<?= $type === 'select' ? '' : 'display:none' ?>">
      <h4 style="margin:24px 0 10px;font-size:13px;letter-spacing:.06em;text-transform:uppercase;color:var(--ink)">Options</h4>
      <p class="muted" style="font-size:12px;margin:0 0 12px">
        Each row is one option. <strong>Hide other fields</strong> takes a comma-separated list of filter keys to hide when this option is selected (e.g. <code>bhk,furnishing</code>). Leave blank for no rule.
      </p>

      <div id="optionRows" style="display:grid;gap:8px">
        <?php foreach ($options as $i => $opt): ?>
          <div class="opt-row" style="display:grid;grid-template-columns:1fr 160px 1fr auto;gap:8px;align-items:center">
            <input type="text" name="opt_label[]" class="form-control" placeholder="Label (e.g. Plot)" value="<?= e($opt['label'] ?? '') ?>">
            <input type="text" name="opt_value[]" class="form-control" placeholder="Value (optional)" value="<?= e($opt['value'] ?? '') ?>">
            <input type="text" name="opt_hide[]"  class="form-control" placeholder="Hide keys (e.g. bhk)" value="<?= e(is_array($opt['hide'] ?? null) ? implode(',', $opt['hide']) : '') ?>">
            <button type="button" class="btn btn-ghost" onclick="this.closest('.opt-row').remove()" title="Remove">×</button>
          </div>
        <?php endforeach; ?>
      </div>

      <button type="button" class="btn btn-ghost" id="addOption" style="margin-top:10px">+ Add option</button>
    </div>
  </div>

  <div class="admin-card">
    <h3 style="margin-top:0;margin-bottom:16px">Visibility</h3>

    <label style="display:flex;align-items:center;gap:8px;padding:10px 0;border-bottom:1px solid var(--line);cursor:pointer">
      <input type="checkbox" name="active" value="1" <?= $checked('active', true) ?>>
      <span><strong>Active</strong><br><small class="muted">Disable to remove from the site without losing config.</small></span>
    </label>

    <label style="display:flex;align-items:center;gap:8px;padding:10px 0;border-bottom:1px solid var(--line);cursor:pointer">
      <input type="checkbox" name="show_in_hero" value="1" <?= $checked('show_in_hero', true) ?>>
      <span><strong>Show in home search</strong><br><small class="muted">Render in the hero quick-search box on the homepage.</small></span>
    </label>

    <label style="display:flex;align-items:center;gap:8px;padding:10px 0;cursor:pointer">
      <input type="checkbox" name="show_in_listing" value="1" <?= $checked('show_in_listing', true) ?>>
      <span><strong>Show in listing filter</strong><br><small class="muted">Render on the /properties page filter panel.</small></span>
    </label>

    <div style="margin-top:18px;display:flex;gap:10px">
      <button type="submit" class="btn btn-primary" style="flex:1">Save</button>
      <a href="/admin/filters" class="btn btn-ghost">Cancel</a>
    </div>

    <?php if (!$isNew && !empty($all)): ?>
      <hr style="border:0;border-top:1px solid var(--line);margin:20px 0 12px">
      <h4 style="margin:0 0 8px;font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:var(--slate)">Available keys for hide rules</h4>
      <div style="display:flex;flex-wrap:wrap;gap:6px">
        <?php foreach ($all as $other): ?>
          <code style="font-size:11px;padding:3px 8px;background:var(--surface-2);border:1px solid var(--line);border-radius:6px"><?= e($other['key']) ?></code>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</form>

<script>
  (function () {
    var typeSel = document.getElementById('filterType');
    var panel   = document.getElementById('optionsPanel');
    var rows    = document.getElementById('optionRows');
    var addBtn  = document.getElementById('addOption');

    if (typeSel) {
      typeSel.addEventListener('change', function () {
        panel.style.display = this.value === 'select' ? '' : 'none';
      });
    }

    if (addBtn) {
      addBtn.addEventListener('click', function () {
        var row = document.createElement('div');
        row.className = 'opt-row';
        row.style.cssText = 'display:grid;grid-template-columns:1fr 160px 1fr auto;gap:8px;align-items:center';
        row.innerHTML =
          '<input type="text" name="opt_label[]" class="form-control" placeholder="Label">' +
          '<input type="text" name="opt_value[]" class="form-control" placeholder="Value (optional)">' +
          '<input type="text" name="opt_hide[]"  class="form-control" placeholder="Hide keys (csv)">' +
          '<button type="button" class="btn btn-ghost" onclick="this.closest(\'.opt-row\').remove()">×</button>';
        rows.appendChild(row);
        row.querySelector('input').focus();
      });
    }
  })();
</script>

<?php $view->endSection(); ?>
