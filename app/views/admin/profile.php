<?php $view->extend('layouts.admin'); ?>
<?php $view->section('content'); ?>

<?php
$old      = $_SESSION['_old']    ?? [];
$errors   = $_SESSION['_errors'] ?? [];
unset($_SESSION['_old'], $_SESSION['_errors']);
$bootstrap = !empty($admin['_bootstrap']);
$val = fn(string $k, $f = '') => $old[$k] ?? $admin[$k] ?? $f;
$err = fn(string $k) => $errors[$k][0] ?? null;
?>

<div class="admin-page-head">
  <div>
    <h1>My Profile</h1>
    <p>Update your name, email or password. Changes apply to your current login.</p>
  </div>
  <a href="/admin/dashboard" class="btn btn-ghost">← Dashboard</a>
</div>

<?php if ($bootstrap): ?>
  <div class="admin-card" style="border-left:3px solid var(--gold);margin-bottom:18px">
    <strong style="display:block;color:var(--gold);font-size:12px;letter-spacing:0.14em;text-transform:uppercase;margin-bottom:6px">Bootstrap account</strong>
    <p style="margin:0;font-size:14px;color:var(--slate)">
      You are signed in as the <code>.env</code> bootstrap admin. To edit your profile, first create a real admin user under
      <a href="/admin/admins" class="gold">Admin Users</a>, sign in with that account, then return here.
    </p>
  </div>
<?php endif; ?>

<form action="/admin/profile" method="post" class="admin-card" style="max-width:640px" autocomplete="off">
  <?= csrf_field() ?>

  <div class="form-group">
    <label>Name</label>
    <input class="form-control" name="name" value="<?= e($val('name')) ?>" required <?= $bootstrap ? 'disabled' : '' ?>>
    <?php if ($err('name')): ?><small style="color:#c00"><?= e($err('name')) ?></small><?php endif; ?>
  </div>

  <div class="form-group">
    <label>Email</label>
    <input class="form-control" type="email" name="email" value="<?= e($val('email')) ?>" required <?= $bootstrap ? 'disabled' : '' ?>>
    <?php if ($err('email')): ?><small style="color:#c00"><?= e($err('email')) ?></small><?php endif; ?>
  </div>

  <div class="form-group">
    <label>Role</label>
    <input class="form-control" value="<?= e(strtoupper($val('role', 'admin'))) ?>" disabled>
    <small class="muted">Roles can be reassigned by a super-admin via <a href="/admin/admins" class="gold">Admin Users</a>.</small>
  </div>

  <hr style="border:0;border-top:1px solid var(--line);margin:24px 0">

  <h3 style="font-size:14px;letter-spacing:0.16em;text-transform:uppercase;color:var(--slate-2);margin:0 0 14px">Change Password</h3>

  <div class="form-group">
    <label>Current Password</label>
    <input class="form-control" type="password" name="current_password" autocomplete="current-password" <?= $bootstrap ? 'disabled' : '' ?>>
    <small class="muted">Required only when setting a new password.</small>
    <?php if ($err('current_password')): ?><br><small style="color:#c00"><?= e($err('current_password')) ?></small><?php endif; ?>
  </div>

  <div class="form-group">
    <label>New Password</label>
    <input class="form-control" type="password" name="password" autocomplete="new-password" minlength="8" <?= $bootstrap ? 'disabled' : '' ?>>
    <small class="muted">Minimum 8 characters. Leave blank to keep current password.</small>
    <?php if ($err('password')): ?><br><small style="color:#c00"><?= e($err('password')) ?></small><?php endif; ?>
  </div>

  <div style="display:flex;gap:12px;margin-top:8px">
    <button class="btn btn-primary" <?= $bootstrap ? 'disabled' : '' ?>>Save Changes</button>
    <a href="/admin/dashboard" class="btn btn-ghost">Cancel</a>
  </div>
</form>

<?php $view->endSection(); ?>
