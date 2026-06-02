<?php $view->extend('layouts.admin'); $a = $admin; $isEdit = !empty($a); ?>
<?php $view->section('content'); ?>

<?php
$old    = $_SESSION['_old']    ?? [];
$errors = $_SESSION['_errors'] ?? [];
unset($_SESSION['_old'], $_SESSION['_errors']);

$val = function(string $key, $fallback = '') use ($old, $a) {
    if (array_key_exists($key, $old)) return $old[$key];
    return $a[$key] ?? $fallback;
};
$err = fn(string $k) => $errors[$k][0] ?? null;

$action = $isEdit ? '/admin/admins/' . e($a['id']) : '/admin/admins';
?>

<div class="admin-page-head">
  <div>
    <h1><?= $isEdit ? 'Edit Admin User' : 'New Admin User' ?></h1>
    <p><?= $isEdit ? 'Update profile, role, or reset password.' : 'Create a new login for the admin console.' ?></p>
  </div>
  <a href="/admin/admins" class="btn btn-ghost">← Back</a>
</div>

<form action="<?= $action ?>" method="post" class="admin-card" style="max-width:640px">
  <?= csrf_field() ?>

  <div class="form-group">
    <label>Name</label>
    <input class="form-control" name="name" value="<?= e($val('name')) ?>" required>
    <?php if ($err('name')): ?><small style="color:#c00"><?= e($err('name')) ?></small><?php endif; ?>
  </div>

  <div class="form-group">
    <label>Email</label>
    <input class="form-control" type="email" name="email" value="<?= e($val('email')) ?>" required>
    <?php if ($err('email')): ?><small style="color:#c00"><?= e($err('email')) ?></small><?php endif; ?>
  </div>

  <div class="form-group">
    <label>Password <?php if ($isEdit): ?><span class="muted" style="text-transform:none;letter-spacing:0;font-size:12px">— leave blank to keep current</span><?php endif; ?></label>
    <input class="form-control" type="password" name="password" autocomplete="new-password" <?= $isEdit ? '' : 'required' ?> minlength="8">
    <small class="muted">Minimum 8 characters. Stored as a bcrypt hash.</small>
    <?php if ($err('password')): ?><br><small style="color:#c00"><?= e($err('password')) ?></small><?php endif; ?>
  </div>

  <div class="form-group">
    <label>Role</label>
    <select class="form-control" name="role" required>
      <?php
        $currentRole = $val('role', 'admin');
        $roles = ['super' => 'Super Admin (full access)', 'admin' => 'Admin (standard)', 'editor' => 'Editor (content only)'];
        foreach ($roles as $k => $label):
      ?>
        <option value="<?= e($k) ?>" <?= $currentRole === $k ? 'selected' : '' ?>><?= e($label) ?></option>
      <?php endforeach; ?>
    </select>
    <?php if ($err('role')): ?><small style="color:#c00"><?= e($err('role')) ?></small><?php endif; ?>
  </div>

  <div style="display:flex;gap:12px;margin-top:8px">
    <button class="btn btn-primary"><?= $isEdit ? 'Update Admin' : 'Create Admin' ?></button>
    <a href="/admin/admins" class="btn btn-ghost">Cancel</a>
  </div>
</form>

<?php $view->endSection(); ?>
