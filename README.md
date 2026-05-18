# Vastu Anand — Luxury Real Estate Platform

Premium, cinematic real-estate platform for **Vastu Anand Real Estate &amp; Property Management Mumbai**. Built on a clean PHP 8 MVC architecture with MongoDB Atlas, JWT auth, a luxury front-end (GSAP / Lenis / Swiper / Tailwind) and a complete admin dashboard.

> Mumbai's most trusted real estate partner for transparent and insight-led property decisions.

---

## ✨ Highlights

- **Cinematic luxury UI** — dark theme, gold accents, pearl typography, glassmorphism, smooth scroll, GSAP reveals.
- **Pro MVC architecture** — clean routing, controllers, models, middleware, views, partials & components.
- **MongoDB Atlas** — flexible document storage with paginated queries, regex search, indexed filters.
- **JWT authentication** — built-in, with admin/auth/CORS middleware.
- **Complete admin dashboard** — properties, leads, blogs, testimonials, gallery, careers, popups, settings.
- **REST API v1** — properties, leads, calculators, chatbot, content, admin.
- **Conversion features** — sticky navbar, floating WhatsApp, AI concierge chatbot, EMI &amp; ROI calculators, smart inquiry forms, schedule-visit, newsletter capture.
- **SEO ready** — schema.org JSON-LD, Open Graph, semantic HTML, dynamic titles & descriptions.
- **Production-grade security** — CSRF, prepared filters, password hashing, JWT signing, secure headers.

---

## 🏛 Tech Stack

| Layer        | Technology |
|--------------|------------|
| Frontend     | HTML5 · Tailwind CDN · GSAP · Lenis smooth scroll · Swiper.js · Custom luxury CSS |
| Backend      | PHP 8.1+ · Custom MVC (zero framework lock-in) · OOP |
| Database     | MongoDB Atlas (via `ext-mongodb` + `mongodb/mongodb`) |
| Auth         | JWT (HS256) for API · Session for admin web |
| Mail         | PHPMailer (SMTP) with native `mail()` fallback |
| Maps         | Google Maps embed (key optional) |

---

## 📁 Folder Structure

```
vastuanand/
├── app/
│   ├── config/                 # app, database, mail
│   ├── controllers/            # Web + Api/* controllers
│   ├── core/                   # App, Router, Request, Response, View, Database, Model, Env
│   ├── helpers/                # functions, JWT, Mailer
│   ├── middleware/             # Auth, Admin, CORS, CSRF
│   ├── models/                 # Property, Lead, User, Admin, Blog, Testimonial, …
│   └── views/
│       ├── layouts/            # main, admin
│       ├── pages/              # home, properties, about, contact, blog, …
│       ├── admin/              # dashboard, leads, properties, blogs, …
│       ├── components/         # property-card, testimonial, section-head
│       └── partials/           # navbar, footer, chatbot, whatsapp, schema-org
├── routes/
│   ├── web.php                 # site + admin routes
│   └── api.php                 # REST API v1
├── public/
│   ├── index.php               # front controller
│   ├── .htaccess               # rewrite, security headers, gzip, cache
│   ├── assets/{css,js,images}/ # luxury.css, luxury.js, branding
│   └── uploads/{properties,blogs,gallery,users}/
├── database/
│   └── seed.php                # one-shot seeder (real Vastu Anand data)
├── storage/logs/               # app log
├── .env.example
└── composer.json
```

---

## 🚀 Quick Start

### 1. Prerequisites

- PHP **8.1+** with `ext-mongodb` extension
- MongoDB Atlas connection string (free tier works)
- Composer (recommended) — falls back to a built-in autoloader if absent

### 2. Install

```bash
git clone <your-repo> vastuanand && cd vastuanand
cp .env.example .env
# edit .env — set MONGO_URI, JWT_SECRET, ADMIN_PASSWORD, etc.
composer install            # installs MongoDB driver + JWT + PHPMailer + dotenv
```

> No Composer? The app uses a built-in PSR-4 fallback autoloader and a vendored JWT/Env so it still boots. You'll just lose PHPMailer and the official MongoDB library — install `ext-mongodb` and Composer in production.

### 3. Seed (optional but recommended)

```bash
php database/seed.php
```

This populates the database with:
- 8 luxury properties across Bandra, Juhu, BKC, Powai, Worli, Andheri, Panvel and Lower Parel
- 8 client testimonials
- 3 expert-authored blog articles
- 12 gallery images
- 4 open career postings
- All site settings (hero text, contact info, social links, RERA)
- An admin user with the credentials from your `.env`

### 4. Serve

```bash
composer serve              # PHP built-in server on :8000
# or
php -S localhost:8000 -t public
```

Visit:
- **Site:**  http://localhost:8000
- **Admin:** http://localhost:8000/admin/login

Default admin credentials come from `.env` — change them before going live.

---

## 🔐 Routing Map

### Public web
| Route | Purpose |
|-------|---------|
| `/` | Cinematic homepage |
| `/about` | Vision, mission, values |
| `/services` · `/services/{slug}` | Service catalogue + detail |
| `/properties` · `/properties/buy` · `/properties/rent` · `/properties/commercial` | Filterable listings |
| `/property/{slug}` | Dynamic property detail |
| `/luxury-homes` · `/commercial` · `/nri` · `/property-management` | Vertical landing pages |
| `/blog` · `/blog/{slug}` | Insights |
| `/gallery` · `/testimonials` · `/careers` · `/faq` | Brand pages |
| `/contact` (GET/POST) | Contact + form submit |
| `/inquiry` (POST) | Property inquiry |
| `/schedule-visit` (POST) | Visit request |
| `/newsletter` (POST) | Subscribe |
| `/privacy` · `/terms` | Legal |

### Admin (session-protected)
- `/admin/login`, `/admin/logout`
- `/admin/dashboard` — stats + recent leads
- `/admin/properties` — CRUD
- `/admin/leads` — filterable list, status updates, **CSV export**
- `/admin/blogs`, `/admin/testimonials`, `/admin/gallery`, `/admin/careers`, `/admin/popups`, `/admin/settings`

### REST API (`/api/v1/*`)
- `POST /auth/login` · `POST /auth/register` · `POST /auth/refresh` · `GET /auth/me`
- `GET  /properties` · `GET /properties/featured` · `GET /properties/{slug}` · `GET /locations`
- `POST /contact` · `POST /inquiry` · `POST /schedule-visit` · `POST /newsletter`
- `POST /chatbot` (rule-based concierge)
- `POST /calc/emi` · `POST /calc/roi`
- `GET  /blogs` · `GET /blogs/{slug}` · `GET /testimonials` · `GET /gallery` · `GET /faqs`
- Admin-protected: `/admin/stats`, `/admin/leads`, `/admin/properties`, `/admin/upload`

---

## 🗄 MongoDB Collections

| Collection | Notes |
|------------|-------|
| `properties` | Indexed on `slug`, `featured`, `status`, `location`, `listing` |
| `leads` | All form captures · CRM pipeline statuses |
| `admins` | Bcrypt-hashed passwords · role-based |
| `users` | End-user accounts (JWT) |
| `blogs` | `slug`, `published`, `publishedAt` |
| `testimonials` | `approved` flag |
| `gallery`, `careers`, `subscribers`, `settings`, `popups` | Generic |
| `audit_logs` | (placeholder — wire in for compliance) |

Recommended Atlas indexes:
```js
db.properties.createIndex({ slug: 1 }, { unique: true })
db.properties.createIndex({ featured: 1, status: 1 })
db.properties.createIndex({ price: 1, type: 1, listing: 1 })
db.leads.createIndex({ createdAt: -1 })
db.blogs.createIndex({ slug: 1 }, { unique: true })
db.admins.createIndex({ email: 1 }, { unique: true })
```

---

## 🚢 Production Deployment

### Apache / shared hosting (Hostinger, cPanel)
1. Upload the entire project; point your domain's webroot to `/public`.
2. Ensure `mod_rewrite` is enabled and `.htaccess` is read.
3. Set permissions: `storage/`, `public/uploads/` → writable (`775`).
4. Install Composer dependencies on the server (`composer install --no-dev --optimize-autoloader`).
5. Set environment variables (Hostinger → Advanced → Env Variables) or upload a `.env`.

### Nginx
```nginx
server {
  listen 443 ssl http2;
  server_name vastuanandm.com www.vastuanandm.com;
  root /var/www/vastuanand/public;
  index index.php;

  location / { try_files $uri $uri/ /index.php?$query_string; }

  location ~ \.php$ {
    fastcgi_pass unix:/run/php/php8.1-fpm.sock;
    fastcgi_index index.php;
    include fastcgi_params;
    fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
  }

  location ~ /\.(env|git|ht) { deny all; }
}
```

### Security checklist
- [x] `APP_DEBUG=false` in production
- [x] `APP_KEY` set to a fresh 32-byte base64 string
- [x] Rotate `JWT_SECRET`
- [x] Force HTTPS (uncomment the rule in `.htaccess`)
- [x] Restrict MongoDB Atlas IP allowlist
- [x] CSRF tokens (already wired) on web forms; JWT on API
- [x] Rate-limit `/contact`, `/inquiry`, `/auth/login` at the reverse-proxy or via fail2ban

### Performance
- Hostinger: enable LiteSpeed cache for static assets
- Tailwind CDN can be swapped for a built `tailwind.css` for tighter CSP
- Lazy-load images (already enabled via `loading="lazy"`)
- Compress hero images to WebP

---

## 🎨 Brand Tokens

```css
--ink:      #050505;   /* primary surface */
--graphite: #131313;   /* cards */
--gold:     #C9A35B;   /* accent */
--gold-2:   #E6C887;   /* hover accent */
--pearl:    #F5F2EC;   /* primary text */
```

Fonts: `Cormorant Garamond` (display, serif) + `Inter` (body, sans).

---

## 🛣 Roadmap (next sprint suggestions)

- Map-based property search (`/properties/map`) with Leaflet
- WhatsApp Business API for outbound campaigns + lead replies
- Image uploader directly inside admin (currently URL-based)
- LLM-powered concierge (replace `ChatbotApi::match()` with Claude API)
- Property comparison and "save listing" for logged-in users
- Multi-language (i18n) – architecture is ready, copy is centralised

---

© 2025 Vastu Anand Real Estate. All rights reserved.
