<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<?php
// Reuse the current filter state in any export link so admins get a filtered file.
$exportQS = http_build_query(array_filter([
  'status' => $_GET['status'] ?? '',
  'source' => $_GET['source'] ?? '',
  'from'   => $_GET['from']   ?? '',
  'to'     => $_GET['to']     ?? '',
]));
?>
<div class="admin-page-head">
  <div>
    <h1>Inquiries</h1>
    <p>All leads captured across contact forms, WhatsApp and chat. Use filters then export.</p>
  </div>
  <div style="display:flex;gap:8px;flex-wrap:wrap">
    <a href="/admin/leads/export?format=csv<?= $exportQS ? '&'.$exportQS : '' ?>" class="btn btn-ghost">Export CSV</a>
    <a href="/admin/leads/export?format=excel<?= $exportQS ? '&'.$exportQS : '' ?>" class="btn btn-ghost">Excel</a>
    <a href="/admin/leads/export?format=pdf<?= $exportQS ? '&'.$exportQS : '' ?>" target="_blank" class="btn btn-primary">PDF</a>
  </div>
</div>

<form method="get" class="flex gap-16 mb-24" style="flex-wrap:wrap;align-items:end">
  <div>
    <label class="form-label" style="font-size:11px">Status</label>
    <select name="status" class="form-control" style="max-width:200px">
      <option value="">All Statuses</option>
      <?php foreach ($statuses as $s): ?>
        <option value="<?= $s ?>" <?= ($_GET['status'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div>
    <label class="form-label" style="font-size:11px">Source</label>
    <select name="source" class="form-control" style="max-width:240px">
      <option value="">All Sources</option>
      <?php foreach ($sources as $s): ?>
        <option value="<?= $s ?>" <?= ($_GET['source'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div>
    <label class="form-label" style="font-size:11px">From</label>
    <input type="date" name="from" class="form-control" value="<?= e($_GET['from'] ?? '') ?>" style="max-width:170px">
  </div>
  <div>
    <label class="form-label" style="font-size:11px">To</label>
    <input type="date" name="to" class="form-control" value="<?= e($_GET['to'] ?? '') ?>" style="max-width:170px">
  </div>
  <button type="submit" class="btn btn-primary">Apply</button>
  <?php if ($exportQS): ?><a href="/admin/leads" class="btn btn-ghost">Reset</a><?php endif; ?>
</form>

<div class="admin-card" style="padding:0;overflow:hidden">
  <table class="admin-table">
    <thead><tr><th>Date</th><th>Name</th><th>Phone</th><th>Email</th><th>Property / Source</th><th>Status</th><th style="text-align:right">Quick actions</th></tr></thead>
    <tbody>
      <?php foreach ($result['data'] as $l):
        $phoneDigits = preg_replace('/\D/', '', (string)($l['phone'] ?? ''));
        $waNumber    = $phoneDigits ? ltrim($phoneDigits, '0') : '';
        $name        = trim((string)($l['name'] ?? ''));
        $brandName   = config('app.brand.name') ?? 'Vastu Anand';
        $waMsg       = rawurlencode("Hi {$name}, thanks for your enquiry with {$brandName}. May I share a few options that match your requirement?");
        $emailSubj   = rawurlencode("{$brandName} — following up on your enquiry");
        $emailBody   = rawurlencode("Hi {$name},\n\nThank you for reaching out to {$brandName}. I'd love to learn a bit more about what you're looking for and share matching properties.\n\nWarm regards,\n{$brandName} Team");
      ?>
        <tr>
          <td class="muted"><?= e($l['createdAt'] ?? '') ?></td>
          <td><strong><?= e($l['name'] ?? '') ?></strong><?php if (!empty($l['message'])): ?><br><span class="muted" style="font-size:12px"><?= e(mb_strimwidth($l['message'], 0, 80, '…')) ?></span><?php endif; ?></td>
          <td><a href="tel:<?= e($l['phone'] ?? '') ?>" class="gold"><?= e($l['phone'] ?? '—') ?></a></td>
          <td class="muted"><?= e($l['email'] ?? '—') ?></td>
          <td>
            <?php if (!empty($l['property'])): ?>
              <?php if (!empty($l['property_slug'])): ?>
                <a href="/property/<?= e($l['property_slug']) ?>" target="_blank" rel="noopener" class="gold" style="font-weight:500;text-decoration:none"><?= e($l['property']) ?></a>
              <?php else: ?>
                <strong style="font-size:13px"><?= e($l['property']) ?></strong>
              <?php endif; ?>
              <br>
            <?php endif; ?>
            <span class="chip"><?= e($l['source'] ?? '') ?></span>
          </td>
          <td>
            <form method="post" action="/admin/leads/<?= e($l['id']) ?>/status" style="display:inline">
              <select name="status" class="form-control" onchange="this.form.submit()" style="padding:6px;font-size:12px">
                <?php foreach ($statuses as $s): ?>
                  <option value="<?= $s ?>" <?= ($l['status'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
                <?php endforeach; ?>
              </select>
            </form>
          </td>
          <td style="text-align:right">
            <div class="admin-quick-actions">
              <?php if ($waNumber): ?>
                <a class="admin-qa admin-qa--wa" href="https://wa.me/<?= e($waNumber) ?>?text=<?= $waMsg ?>" target="_blank" rel="noopener" title="Open WhatsApp">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M20.5 3.5A11 11 0 0 0 3 17.2L1.5 22.5l5.4-1.4A11 11 0 1 0 20.5 3.5ZM12 20a8 8 0 0 1-4.1-1.1l-.3-.2-3.2.8.9-3.2-.2-.3a8 8 0 1 1 6.9 4Zm4.5-6c-.2-.1-1.4-.7-1.6-.8-.2-.1-.4-.1-.5.1l-.7.9c-.1.2-.3.2-.5.1a6.5 6.5 0 0 1-3.2-2.8c-.2-.4.2-.4.6-1.2 0-.2 0-.3-.1-.4l-.7-1.7c-.2-.4-.4-.4-.5-.4h-.5a1 1 0 0 0-.7.3 3 3 0 0 0-.9 2.2c0 1.3 1 2.6 1.1 2.8.1.2 1.9 3 4.7 4.2 1.7.7 2.3.7 3.1.6.5-.1 1.4-.6 1.6-1.1.2-.6.2-1 .1-1.1Z"/></svg>
                </a>
              <?php endif; ?>
              <?php if (!empty($l['phone'])): ?>
                <a class="admin-qa admin-qa--call" href="tel:<?= e($l['phone']) ?>" title="Call">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
                </a>
              <?php endif; ?>
              <?php if (!empty($l['email'])): ?>
                <a class="admin-qa admin-qa--email" href="mailto:<?= e($l['email']) ?>?subject=<?= $emailSubj ?>&body=<?= $emailBody ?>" title="Email">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><polyline points="3 7 12 13 21 7"/></svg>
                </a>
              <?php endif; ?>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php $view->endSection(); ?>
