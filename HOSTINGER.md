# Hostinger Deployment Guide — Vastu Anand

This is the step-by-step that **always works** on Hostinger **Premium / Business** shared hosting.

---

## 1. Set the correct document root (most critical step)

The default Hostinger document root is `public_html/`. But our front controller lives in `public_html/public/`. You **must** change the document root, or use the root `.htaccess` shim we ship (see step 4).

### Option A — Change the document root (recommended)

1. Log into **hPanel** → **Domains** → click your domain → **Manage**
2. Scroll to **Public Folder** (or **Document Root**) → click **Edit**
3. Change from `public_html` to **`public_html/public`**
4. Save

### Option B — Keep document root as `public_html`

Leave it default. The `.htaccess` shipped at the project root forwards everything correctly. No hPanel change needed.

Either option works — Option A is faster (one less redirect per request).

---

## 2. Upload your files

### Via File Manager
1. **hPanel → Files → File Manager**
2. Open `public_html/` and **delete the placeholder** `default.php` / `index.html`
3. Upload your `vastuanand` project as a ZIP, then **Extract** in place
4. Make sure the structure looks like this (Option B):
   ```
   public_html/
   ├── .env
   ├── .htaccess         ← from our project root
   ├── _check.php        ← diagnostic (delete after)
   ├── app/
   ├── routes/
   ├── public/
   │   ├── index.php
   │   ├── .htaccess
   │   └── assets/
   ├── database/
   ├── storage/
   └── composer.json
   ```

### Via SSH (Business plan only)
```bash
ssh u123456789@yoursite.com -p 65002
cd ~/domains/yoursite.com/public_html
git clone https://github.com/your/vastuanand.git .
cp .env.example .env
nano .env                 # set MONGO_URI, JWT_SECRET, etc.
composer install --no-dev --optimize-autoloader
```

---

## 3. Set the PHP version & enable MongoDB

1. **hPanel → Advanced → PHP Configuration**
2. Set PHP version to **8.1, 8.2 or 8.3**
3. Click the **PHP Extensions** tab
4. Tick **`mongodb`** (under "M" — it's listed; Premium and Business plans include it)
5. Save

> If you don't see `mongodb` in the list, you're on **Single Web Hosting** — upgrade or use the [MongoDB Realm Data API](https://www.mongodb.com/docs/atlas/api/data-api/) instead (HTTP-only, no driver needed).

---

## 4. Install Composer dependencies

### Via SSH (recommended)
```bash
cd ~/domains/yoursite.com/public_html
composer install --no-dev --optimize-autoloader
```

### Without SSH
1. Run `composer install --no-dev --optimize-autoloader` **locally**
2. Zip the resulting `vendor/` folder
3. Upload it via File Manager into `public_html/` and extract

Without `vendor/`, the site falls back to its built-in autoloader and skips PHPMailer + the MongoDB PHPLIB → **forms still send via `mail()` but DB will not work**. So `vendor/` is required for Mongo.

---

## 5. Configure `.env`

Edit `public_html/.env` via File Manager:

```env
APP_ENV=production
APP_DEBUG=true                         # ← keep TRUE until working, then flip to false
APP_URL=https://yoursite.com
APP_TIMEZONE=Asia/Kolkata

MONGO_URI="mongodb+srv://USER:PASS@cluster0.xxxx.mongodb.net/?retryWrites=true&w=majority"
MONGO_DB=vastuanand

JWT_SECRET=paste-a-64-char-random-string-here

ADMIN_EMAIL=admin@yoursite.com
ADMIN_PASSWORD=AStrongPassword!2025

MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=info@yoursite.com
MAIL_PASSWORD=your-email-password
MAIL_FROM_ADDRESS=info@yoursite.com
```

> ⚠️ **Whitelist Hostinger IPs in MongoDB Atlas**: Atlas → Network Access → Add IP Address → `0.0.0.0/0` (allow from anywhere) OR add Hostinger's outbound IPs.

---

## 6. Fix permissions

In File Manager, right-click → Permissions:

| Folder | Permission |
|---|---|
| `storage/logs/` | **775** (writable) |
| `public/uploads/` | **775** (writable) |
| `.env` | **600** (readable by owner only) |

Via SSH:
```bash
chmod -R 775 storage public/uploads
chmod 600 .env
```

---

## 7. Run the diagnostic page

Visit **https://yoursite.com/_check.php**

You'll see a panel that tells you exactly what's missing — PHP version, mongodb extension, `.env` values, Atlas ping result. Fix anything red.

**Delete `_check.php` from the server once everything is green** (security).

---

## 8. Seed the database

Via SSH:
```bash
php database/seed.php
```

Without SSH, run the seeder locally pointing at the same Atlas URI:
```powershell
# In c:\Users\USER\Desktop\vastuanand  (with your prod MONGO_URI in .env)
php database\seed.php
```

The data lives in Atlas — Hostinger doesn't need it locally.

---

## 9. Final security checklist

- [ ] `APP_DEBUG=false` in `.env`
- [ ] Strong, unique `ADMIN_PASSWORD`
- [ ] `JWT_SECRET` is a fresh 64-char random string
- [ ] `_check.php` deleted from the server
- [ ] `.env` is `chmod 600`
- [ ] Atlas IP allowlist is reasonable (not `0.0.0.0/0` long term)
- [ ] HTTPS forced (Hostinger SSL is free — enable in hPanel → Security → SSL)

---

## Common 500-error fixes

| Symptom | Fix |
|---------|-----|
| **Blank page, no error** | Set `APP_DEBUG=true` in `.env` → reload → see the real error |
| `Class "MongoDB\Client" not found` | Run `composer install` or upload `vendor/` |
| `Call to undefined function env()` | Use the updated `app/core/App.php` (helpers load first) |
| `Permission denied: storage/logs/app.log` | `chmod -R 775 storage` |
| Site shows file listing | Hostinger doc-root is wrong → use Option A or upload our root `.htaccess` |
| `404 Not Found` on every page | `mod_rewrite` not loaded or `.htaccess` not uploaded |
| `Connection timeout` to Atlas | Atlas IP allowlist doesn't include Hostinger |
| `mongodb extension not loaded` | hPanel → PHP Configuration → tick `mongodb` |

---

After step 7 returns all-green, point your browser at **https://yoursite.com/** and you should see the cinematic hero. Admin login at **https://yoursite.com/admin/login**.
