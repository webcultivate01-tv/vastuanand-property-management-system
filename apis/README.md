# REST API v1

The REST API is implemented through controllers in:
- [`app/controllers/Api/`](../app/controllers/Api/) — AuthApi, PropertyApi, LeadApi, ContentApi, CalculatorApi, ChatbotApi, AdminApi

Routes are registered in [`routes/api.php`](../routes/api.php) under the `/api/v1/*` prefix.

## Quick reference

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/v1/auth/login`      | JWT login (user / admin) |
| POST | `/api/v1/auth/register`   | New end-user account |
| POST | `/api/v1/auth/refresh`    | Refresh JWT |
| GET  | `/api/v1/auth/me`         | Current user (auth) |
| GET  | `/api/v1/properties`      | List / filter properties |
| GET  | `/api/v1/properties/featured` | Featured listings |
| GET  | `/api/v1/properties/{slug}` | Detail |
| GET  | `/api/v1/locations`       | Mumbai locations served |
| POST | `/api/v1/contact`         | Capture contact form |
| POST | `/api/v1/inquiry`         | Property inquiry |
| POST | `/api/v1/schedule-visit`  | Schedule a site visit |
| POST | `/api/v1/newsletter`      | Newsletter subscription |
| POST | `/api/v1/chatbot`         | Concierge chatbot reply |
| POST | `/api/v1/calc/emi`        | EMI calculator |
| POST | `/api/v1/calc/roi`        | ROI projection |
| GET  | `/api/v1/blogs`           | List blog posts |
| GET  | `/api/v1/blogs/{slug}`    | Blog detail |
| GET  | `/api/v1/testimonials`    | Approved testimonials |
| GET  | `/api/v1/gallery`         | Gallery images |
| GET  | `/api/v1/faqs`            | FAQs |
| GET  | `/api/v1/admin/stats`     | Dashboard stats (admin) |
| GET  | `/api/v1/admin/leads`     | Leads list (admin) |
| POST | `/api/v1/admin/leads/{id}` | Update lead (admin) |
| POST | `/api/v1/admin/properties` | Create property (admin) |
| POST | `/api/v1/admin/properties/{id}` | Update property (admin) |
| POST | `/api/v1/admin/upload`    | File upload (admin) |

## Auth

Send `Authorization: Bearer <token>` on protected endpoints, or rely on the `vt_token` cookie set after login.
