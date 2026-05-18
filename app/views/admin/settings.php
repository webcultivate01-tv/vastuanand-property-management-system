<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<h1 style="font-family:'Cormorant Garamond',serif;font-size:44px;margin:0 0 32px">Site Settings</h1>

<form method="post" action="/admin/settings" class="admin-card">
  <?= csrf_field() ?>
  <div class="grid cols-2" style="gap:18px">
    <?php foreach ([
      'hero_headline'      => 'Hero Headline',
      'hero_subtitle'      => 'Hero Subtitle',
      'phone_primary'      => 'Primary Phone',
      'phone_secondary'    => 'Secondary Phone',
      'whatsapp_number'    => 'WhatsApp Number',
      'email_primary'      => 'Primary Email',
      'instagram_url'      => 'Instagram URL',
      'facebook_url'       => 'Facebook URL',
      'youtube_url'        => 'YouTube URL',
      'linkedin_url'       => 'LinkedIn URL',
      'rera_number'        => 'RERA Number',
      'seo_default_title'  => 'Default SEO Title',
      'seo_default_desc'   => 'Default SEO Description',
    ] as $key => $label): ?>
      <div class="form-group">
        <label><?= e($label) ?></label>
        <input class="form-control" name="<?= e($key) ?>" value="<?= e($settings[$key] ?? '') ?>">
      </div>
    <?php endforeach; ?>
  </div>
  <button class="btn btn-primary">Save Settings</button>
</form>

<?php $view->endSection(); ?>
