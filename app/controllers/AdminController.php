<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Response;
use App\Models\Admin;
use App\Models\Property;
use App\Models\Lead;
use App\Models\Blog;
use App\Models\Testimonial;
use App\Models\Setting;
use App\Models\Location;
use App\Models\PropertyType;
use App\Models\FilterField;
use App\Models\Subscriber;
use App\Models\User;
use App\Models\Event;
use App\Models\PropertyView;

final class AdminController extends Controller
{
    /* ── AUTH ────────────────────────────── */

    public function index(): void {
        parent::redirect(!empty($_SESSION['admin']) ? '/admin/dashboard' : '/admin/login');
    }

    public function loginForm(): void {
        if (!empty($_SESSION['admin'])) $this->redirect('/admin/dashboard');
        $this->view('admin.login', ['title' => 'Admin Login — Vastu Anand']);
    }

    public function login(): void {
        $data = $this->validate(['email' => 'required|email', 'password' => 'required|min:6']);

        $admin = Admin::byEmail($data['email']);

        // Bootstrap: allow .env-defined admin to log in even before DB seed
        if (!$admin
            && strtolower(env('ADMIN_EMAIL', '')) === strtolower($data['email'])
            && env('ADMIN_PASSWORD', '') === $data['password']) {
            $_SESSION['admin'] = ['email' => $data['email'], 'name' => 'Vastu Anand Admin', 'role' => 'super'];
            $this->redirect('/admin/dashboard');
        }

        if (!$admin || !password_verify($data['password'], $admin['password'] ?? '')) {
            $_SESSION['_errors'] = ['email' => ['Invalid credentials.']];
            $this->redirect('/admin/login');
        }

        $_SESSION['admin'] = ['id' => $admin['id'], 'email' => $admin['email'], 'name' => $admin['name'] ?? 'Admin', 'role' => $admin['role'] ?? 'admin'];
        $this->redirect('/admin/dashboard');
    }

    public function logout(): void {
        unset($_SESSION['admin']);
        $this->redirect('/admin/login');
    }

    /* ── DASHBOARD ─────────────────────────── */

    public function dashboard(): void {
        $stats = [
            'properties'   => Property::count(),
            'leads'        => Lead::count(),
            'leads_new'    => Lead::count(['status' => 'new']),
            'blogs'        => Blog::count(),
            'testimonials' => Testimonial::count(),
            'subscribers'  => \App\Models\Subscriber::count(),
            'users'        => User::count(),
            'events_live'  => count(Event::live(99)),
        ];
        $recentLeads = Lead::all([], ['limit' => 10, 'sort' => ['createdAt' => -1]]);

        // Activity feed — unified timeline pulled from existing collections (no new storage)
        $activity = $this->buildActivityFeed(12);

        $this->view('admin.dashboard', [
            'title'       => 'Dashboard — Vastu Anand Admin',
            'stats'       => $stats,
            'recentLeads' => $recentLeads,
            'activity'    => $activity,
        ]);
    }

    /**
     * Merge recent items from leads / properties / blogs / testimonials into a
     * single chronological feed. Reads only — no writes, no new collection.
     */
    private function buildActivityFeed(int $limit = 12): array {
        $events = [];

        foreach (Lead::all([], ['limit' => 8, 'sort' => ['createdAt' => -1]]) as $l) {
            $events[] = [
                'when'  => $l['createdAt'] ?? '',
                'type'  => 'lead',
                'title' => ($l['name'] ?? 'Anonymous') . ' submitted an inquiry',
                'meta'  => ($l['source'] ?? 'web') . ' · ' . ($l['phone'] ?? '—'),
                'href'  => '/admin/leads',
            ];
        }
        foreach (Property::all([], ['limit' => 5, 'sort' => ['createdAt' => -1]]) as $p) {
            $events[] = [
                'when'  => $p['createdAt'] ?? '',
                'type'  => 'property',
                'title' => 'Property listed · ' . ($p['title'] ?? 'Untitled'),
                'meta'  => ($p['location'] ?? '—') . ' · ' . ucfirst($p['listing'] ?? 'sale'),
                'href'  => !empty($p['id']) ? '/admin/properties/' . $p['id'] . '/edit' : '/admin/properties',
            ];
        }
        foreach (Blog::all([], ['limit' => 4, 'sort' => ['createdAt' => -1]]) as $b) {
            $events[] = [
                'when'  => $b['createdAt'] ?? '',
                'type'  => 'blog',
                'title' => 'Blog post · ' . ($b['title'] ?? 'Untitled'),
                'meta'  => ($b['category'] ?? 'General') . (!empty($b['published']) ? ' · Published' : ' · Draft'),
                'href'  => !empty($b['id']) ? '/admin/blogs/' . $b['id'] . '/edit' : '/admin/blogs',
            ];
        }
        foreach (Testimonial::all([], ['limit' => 3, 'sort' => ['createdAt' => -1]]) as $t) {
            $events[] = [
                'when'  => $t['createdAt'] ?? '',
                'type'  => 'review',
                'title' => 'Review from ' . ($t['name'] ?? 'a client'),
                'meta'  => str_repeat('★', (int)($t['rating'] ?? 5)) . ' · ' . ($t['role'] ?? ''),
                'href'  => '/admin/testimonials',
            ];
        }

        // Sort by date desc, take top N
        usort($events, fn($a, $b) => strcmp((string)$b['when'], (string)$a['when']));
        return array_slice($events, 0, $limit);
    }

    /* ── PROFILE (current admin) ───────────── */

    public function profile(): void {
        $id = $_SESSION['admin']['id'] ?? null;
        $admin = $id ? Admin::find((string)$id) : null;
        // .env-bootstrap admin (no DB record) — synthesize a read-only record so the form still loads
        if (!$admin) {
            $admin = [
                'id'    => null,
                'name'  => $_SESSION['admin']['name']  ?? 'Vastu Anand Admin',
                'email' => $_SESSION['admin']['email'] ?? env('ADMIN_EMAIL', ''),
                'role'  => $_SESSION['admin']['role']  ?? 'super',
                '_bootstrap' => true,
            ];
        }
        $this->view('admin.profile', ['title' => 'My Profile — Admin', 'admin' => $admin]);
    }

    public function profileUpdate(): void {
        $id = $_SESSION['admin']['id'] ?? null;
        if (!$id) {
            $this->flash('success', 'The .env bootstrap admin cannot be edited. Create a real admin first under Admin Users.');
            $this->redirect('/admin/profile');
        }

        $rules = [
            'name'  => 'required|min:2|max:60',
            'email' => 'required|email',
        ];
        $newPassword     = trim((string)$this->request->input('password', ''));
        $currentPassword = trim((string)$this->request->input('current_password', ''));
        if ($newPassword !== '') {
            $rules['password']         = 'min:8';
            $rules['current_password'] = 'required';
        }
        $data = $this->validate($rules);

        $admin = Admin::find((string)$id);
        if (!$admin) Response::notFound();

        // Verify current password if changing password
        if ($newPassword !== '') {
            if (!password_verify($currentPassword, $admin['password'] ?? '')) {
                $_SESSION['_errors'] = ['current_password' => ['Current password is incorrect.']];
                $this->redirect('/admin/profile');
            }
        }

        $email = strtolower($data['email']);
        if ($email !== strtolower($admin['email'] ?? '')) {
            $existing = Admin::byEmail($email);
            if ($existing && (string)($existing['id'] ?? '') !== (string)$id) {
                $_SESSION['_errors'] = ['email' => ['That email is already in use.']];
                $this->redirect('/admin/profile');
            }
        }

        $update = ['name' => $data['name'], 'email' => $email];
        if ($newPassword !== '') {
            $update['password'] = password_hash($newPassword, PASSWORD_BCRYPT);
        }
        Admin::update((string)$id, $update);

        $_SESSION['admin']['name']  = $update['name'];
        $_SESSION['admin']['email'] = $update['email'];

        $this->flash('success', 'Profile updated.');
        $this->redirect('/admin/profile');
    }

    /* ── EXPORTS (filtered, multi-format) ───── */

    /**
     * Stream a tabular export to the browser in CSV, Excel (.xls), or PDF (printable HTML).
     * Format is picked from the request "format" parameter (default csv).
     */
    private function streamExport(string $slug, array $headers, array $rows, ?string $title = null): void
    {
        $format = strtolower(trim((string)$this->request->input('format', 'csv')));
        if (!in_array($format, ['csv', 'excel', 'pdf'], true)) $format = 'csv';
        $stamp = date('Ymd_His');
        $title = $title ?? ucwords(str_replace('_', ' ', $slug));

        if ($format === 'csv') {
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=vastuanand_' . $slug . '_' . $stamp . '.csv');
            $out = fopen('php://output', 'w');
            fputcsv($out, $headers);
            foreach ($rows as $r) fputcsv($out, $r);
            fclose($out);
            exit;
        }

        if ($format === 'excel') {
            // Excel reads HTML tables happily when served as .xls
            header('Content-Type: application/vnd.ms-excel; charset=utf-8');
            header('Content-Disposition: attachment; filename=vastuanand_' . $slug . '_' . $stamp . '.xls');
            echo "<html><head><meta charset='utf-8'></head><body>";
            echo "<table border='1' cellspacing='0' cellpadding='6'><thead><tr>";
            foreach ($headers as $h) echo "<th style='background:#1A1A1A;color:#C9A35B'>" . e((string)$h) . "</th>";
            echo "</tr></thead><tbody>";
            foreach ($rows as $r) {
                echo "<tr>";
                foreach ($r as $c) echo "<td>" . e((string)$c) . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table></body></html>";
            exit;
        }

        // PDF — render a printable HTML page that opens the print dialog (user picks "Save as PDF").
        header('Content-Type: text/html; charset=utf-8');
        $brand = config('app.brand.name') ?? 'Vastu Anand';
        echo "<!doctype html><html><head><meta charset='utf-8'><title>" . e($title) . " — " . e($brand) . "</title>";
        echo "<style>
            body{font-family:'Helvetica Neue',Arial,sans-serif;color:#222;margin:24px}
            h1{margin:0 0 4px;color:#1A1A1A;font-size:22px}
            .meta{color:#666;font-size:12px;margin-bottom:18px}
            table{width:100%;border-collapse:collapse;font-size:12px}
            thead th{background:#1A1A1A;color:#C9A35B;text-align:left;padding:8px;border:1px solid #1A1A1A}
            tbody td{padding:6px 8px;border:1px solid #DDD;vertical-align:top}
            tbody tr:nth-child(even){background:#FAFAFA}
            .actions{margin-bottom:16px}
            .actions button{background:#C9A35B;color:#fff;border:0;padding:8px 18px;border-radius:4px;cursor:pointer;font-size:13px}
            @media print{ .actions{display:none} }
        </style></head><body>";
        echo "<div class='actions'><button onclick='window.print()'>🖨️ Print / Save as PDF</button></div>";
        echo "<h1>" . e($title) . "</h1>";
        echo "<div class='meta'>Generated " . e(date('d M Y, h:i A')) . " · " . count($rows) . " record" . (count($rows) === 1 ? '' : 's') . " · " . e($brand) . "</div>";
        echo "<table><thead><tr>";
        foreach ($headers as $h) echo "<th>" . e((string)$h) . "</th>";
        echo "</tr></thead><tbody>";
        foreach ($rows as $r) {
            echo "<tr>";
            foreach ($r as $c) echo "<td>" . e((string)$c) . "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
        echo "<script>setTimeout(function(){window.print()},400);</script>";
        echo "</body></html>";
        exit;
    }

    /** Collect filter parameters used by the properties export, mirroring the listing screen. */
    private function propertiesExportFilter(): array
    {
        return array_filter([
            'q'        => trim((string)($_GET['q']        ?? '')),
            'listing'  => trim((string)($_GET['listing']  ?? '')),
            'type'     => trim((string)($_GET['type']     ?? '')),
            'location' => trim((string)($_GET['location'] ?? '')),
            'bhk'      => trim((string)($_GET['bhk']      ?? '')),
            'min'      => trim((string)($_GET['min']      ?? '')),
            'max'      => trim((string)($_GET['max']      ?? '')),
            'featured' => trim((string)($_GET['featured'] ?? '')),
        ], fn($v) => $v !== '');
    }

    public function propertiesExport(): void {
        $query   = $this->propertiesExportFilter();
        $result  = Property::filter($query, 1, 5000);
        $headers = ['Created','Title','Slug','Type','Listing','Location','BHK','Area (sqft)','Price','Status','Featured'];
        $rows = [];
        foreach ($result['data'] ?? [] as $p) {
            $rows[] = [
                $p['createdAt'] ?? '',
                $p['title']     ?? '',
                $p['slug']      ?? '',
                $p['type']      ?? '',
                $p['listing']   ?? '',
                $p['location']  ?? '',
                $p['bhk']       ?? '',
                $p['area']      ?? '',
                $p['price']     ?? '',
                $p['status']    ?? 'active',
                !empty($p['featured']) ? 'yes' : 'no',
            ];
        }
        $this->streamExport('properties', $headers, $rows, 'Properties Export');
    }

    public function blogsExport(): void {
        $filter = [];
        if (!empty($_GET['category'])) $filter['category'] = $_GET['category'];
        if (isset($_GET['published']) && $_GET['published'] !== '') {
            $filter['published'] = $_GET['published'] === 'yes';
        }
        $headers = ['Created','Title','Slug','Category','Read Time','Published','Excerpt'];
        $rows = [];
        foreach (Blog::all($filter, ['sort' => ['createdAt' => -1]]) as $b) {
            $rows[] = [
                $b['createdAt'] ?? '',
                $b['title']     ?? '',
                $b['slug']      ?? '',
                $b['category']  ?? '',
                $b['readTime']  ?? '',
                !empty($b['published']) ? 'yes' : 'no',
                mb_strimwidth((string)($b['excerpt'] ?? ''), 0, 200, '…'),
            ];
        }
        $this->streamExport('blogs', $headers, $rows, 'Blog Posts Export');
    }

    /* ── GLOBAL SEARCH (topbar Ctrl+K) ─────── */

    public function search(): void {
        $q = trim((string)$this->request->input('q', ''));
        if ($q === '' || mb_strlen($q) < 2) {
            $this->json(['ok' => true, 'results' => []]);
        }
        $needle = mb_strtolower($q);
        $matches = [];

        $score = function(array $hay, string $needle): bool {
            foreach ($hay as $v) {
                if ($v && str_contains(mb_strtolower((string)$v), $needle)) return true;
            }
            return false;
        };

        foreach (Property::all([], ['limit' => 200, 'sort' => ['createdAt' => -1]]) as $p) {
            if ($score([$p['title'] ?? '', $p['location'] ?? '', $p['type'] ?? ''], $needle)) {
                $matches[] = [
                    'type'  => 'Property',
                    'title' => $p['title'] ?? 'Untitled',
                    'meta'  => ($p['location'] ?? '—') . ' · ' . ucfirst($p['listing'] ?? 'sale'),
                    'href'  => !empty($p['id']) ? '/admin/properties/' . $p['id'] . '/edit' : '/admin/properties',
                ];
            }
            if (count($matches) >= 12) break;
        }
        foreach (Lead::all([], ['limit' => 200, 'sort' => ['createdAt' => -1]]) as $l) {
            if (count($matches) >= 18) break;
            if ($score([$l['name'] ?? '', $l['email'] ?? '', $l['phone'] ?? ''], $needle)) {
                $matches[] = [
                    'type'  => 'Lead',
                    'title' => $l['name'] ?? 'Anonymous',
                    'meta'  => ($l['email'] ?? $l['phone'] ?? '—') . ' · ' . ($l['status'] ?? 'new'),
                    'href'  => '/admin/leads',
                ];
            }
        }
        foreach (Blog::all([], ['limit' => 100, 'sort' => ['createdAt' => -1]]) as $b) {
            if (count($matches) >= 24) break;
            if ($score([$b['title'] ?? '', $b['category'] ?? ''], $needle)) {
                $matches[] = [
                    'type'  => 'Blog',
                    'title' => $b['title'] ?? 'Untitled',
                    'meta'  => ($b['category'] ?? 'General'),
                    'href'  => !empty($b['id']) ? '/admin/blogs/' . $b['id'] . '/edit' : '/admin/blogs',
                ];
            }
        }

        $this->json(['ok' => true, 'results' => $matches, 'query' => $q]);
    }

    /* ── PROPERTIES ────────────────────────── */

    public function properties(): void {
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $query  = array_filter([
            'q'        => trim((string)($_GET['q']        ?? '')),
            'listing'  => trim((string)($_GET['listing']  ?? '')),
            'type'     => trim((string)($_GET['type']     ?? '')),
            'location' => trim((string)($_GET['location'] ?? '')),
            'bhk'      => trim((string)($_GET['bhk']      ?? '')),
            'min'      => trim((string)($_GET['min']      ?? '')),
            'max'      => trim((string)($_GET['max']      ?? '')),
            'featured' => trim((string)($_GET['featured'] ?? '')),
            'sort'     => trim((string)($_GET['sort']     ?? '')),
        ], fn($v) => $v !== '');

        $result = Property::filter($query, $page, 20);
        $this->view('admin.properties.index', [
            'title'     => 'Properties — Admin',
            'result'    => $result,
            'query'     => $query,
            'types'     => Property::types(),
            'locations' => Property::locations(),
            'listings'  => Property::statuses(),
        ]);
    }

    public function propertyCreate(): void {
        $this->view('admin.properties.form', ['title'=>'New Property', 'property'=>null]);
    }

    public function propertyStore(): void {
        $data = $this->propertyData();
        Property::create($data);
        $this->flash('success', 'Property created.');
        $this->redirect('/admin/properties');
    }

    public function propertyEdit(string $id): void {
        $property = Property::find($id);
        if (!$property) Response::notFound();
        $this->view('admin.properties.form', ['title'=>'Edit Property', 'property'=>$property]);
    }

    public function propertyUpdate(string $id): void {
        Property::update($id, $this->propertyData());
        $this->flash('success', 'Property updated.');
        $this->redirect('/admin/properties');
    }

    public function propertyDelete(string $id): void {
        Property::delete($id);
        $this->redirect('/admin/properties');
    }

    private function propertyData(): array {
        $r = $this->request->all();

        // Build the image list in slot order: prefer freshly uploaded files,
        // otherwise keep whatever URL was already in that slot (existing_images).
        $images   = [];
        $existing = $r['existing_images'] ?? [];
        $files    = $_FILES['images'] ?? null;
        $slotCount = max(count($existing), is_array($files['tmp_name'] ?? null) ? count($files['tmp_name']) : 0);

        for ($i = 0; $i < $slotCount; $i++) {
            $newTmp = $files['tmp_name'][$i] ?? '';
            $newErr = $files['error'][$i] ?? UPLOAD_ERR_NO_FILE;
            if (!empty($newTmp) && $newErr === UPLOAD_ERR_OK) {
                $url = \App\Helpers\Cloudinary::upload($newTmp, 'vastuanand/properties');
                if ($url) { $images[] = $url; continue; }
            }
            if (!empty($existing[$i])) {
                $images[] = trim((string)$existing[$i]);
            }
        }

        // Optional power-user URL textarea, appended after the 4 slot images
        $extra = array_filter(array_map('trim', explode("\n", $r['gallery_urls'] ?? '')));
        $images = array_values(array_unique(array_merge($images, $extra)));

        $cover   = $images[0] ?? '';
        $gallery = array_slice($images, 1);

        return [
            'title'       => trim($r['title'] ?? ''),
            'slug'        => slug($r['slug'] ?? $r['title'] ?? ''),
            'listing'     => $r['listing']  ?? 'sale',
            'type'        => $r['type']     ?? 'Apartment',
            'location'    => $r['location'] ?? '',
            'address'     => $r['address']  ?? '',
            'bhk'         => (int)($r['bhk'] ?? 0),
            'baths'       => (int)($r['baths'] ?? 0),
            'area'        => (float)($r['area'] ?? 0),
            'price'       => (float)($r['price'] ?? 0),
            'description' => $r['description'] ?? '',
            'cover'       => $cover,
            'gallery'     => $gallery,
            'video_url'   => trim((string)($r['video_url'] ?? '')),
            'tags'        => array_filter(array_map('trim', explode(',', $r['tags'] ?? ''))),
            'amenities'   => array_filter(array_map('trim', explode(',', $r['amenities'] ?? ''))),
            'featured'    => isset($r['featured']),
            'status'      => $r['status'] ?? 'active',
        ];
    }

    /* ── LEADS ─────────────────────────────── */

    public function leads(): void {
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $filter = [];
        if (!empty($_GET['status'])) $filter['status'] = $_GET['status'];
        if (!empty($_GET['source'])) $filter['source'] = $_GET['source'];
        if (!empty($_GET['from']) || !empty($_GET['to'])) {
            $range = [];
            if (!empty($_GET['from'])) $range['$gte'] = trim((string)$_GET['from']) . ' 00:00:00';
            if (!empty($_GET['to']))   $range['$lte'] = trim((string)$_GET['to'])   . ' 23:59:59';
            $filter['createdAt'] = $range;
        }
        $result = Lead::paginate($filter, $page, 25);
        $this->view('admin.leads', ['title'=>'Leads — Admin', 'result'=>$result, 'statuses'=>Lead::statusList(), 'sources'=>Lead::sources()]);
    }

    public function leadStatus(string $id): void {
        Lead::update($id, ['status' => $this->request->input('status', 'new'), 'note' => $this->request->input('note')]);
        $this->back();
    }

    public function leadsExport(): void {
        $filter = [];
        if (!empty($_GET['status']))   $filter['status']   = $_GET['status'];
        if (!empty($_GET['source']))   $filter['source']   = $_GET['source'];
        if (!empty($_GET['from']) || !empty($_GET['to'])) {
            // Filter by createdAt string ranges (createdAt is stored as ISO string after cast)
            $range = [];
            if (!empty($_GET['from'])) $range['$gte'] = trim((string)$_GET['from']) . ' 00:00:00';
            if (!empty($_GET['to']))   $range['$lte'] = trim((string)$_GET['to'])   . ' 23:59:59';
            $filter['createdAt'] = $range;
        }
        $headers = ['Date','Name','Phone','Email','Source','Property','Status','Subject','Message'];
        $rows = [];
        foreach (Lead::all($filter, ['sort' => ['createdAt' => -1]]) as $lead) {
            $rows[] = [
                $lead['createdAt'] ?? '',
                $lead['name'] ?? '',
                $lead['phone'] ?? '',
                $lead['email'] ?? '',
                $lead['source'] ?? '',
                $lead['property'] ?? '',
                $lead['status'] ?? '',
                $lead['subject'] ?? '',
                $lead['message'] ?? '',
            ];
        }
        $this->streamExport('leads', $headers, $rows, 'Inquiries / Leads Export');
    }

    /* ── SUBSCRIBERS ──────────────────────── */

    public function subscribers(): void {
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $filter = [];
        $q = trim((string)($_GET['q'] ?? ''));
        if ($q !== '') $filter['email'] = ['$regex' => preg_quote($q, '/'), '$options' => 'i'];
        $result = Subscriber::paginate($filter, $page, 25, ['createdAt' => -1]);
        $this->view('admin.subscribers.index', [
            'title'  => 'Subscribers — Admin',
            'result' => $result,
            'q'      => $q,
            'total'  => Subscriber::count(),
        ]);
    }

    public function subscriberDelete(string $id): void {
        Subscriber::delete($id);
        $this->flash('success', 'Subscriber removed.');
        $this->redirect('/admin/subscribers');
    }

    public function subscribersExport(): void {
        $filter = [];
        $q = trim((string)($_GET['q'] ?? ''));
        if ($q !== '') $filter['email'] = ['$regex' => preg_quote($q, '/'), '$options' => 'i'];
        if (isset($_GET['active']) && $_GET['active'] !== '') $filter['active'] = $_GET['active'] === 'yes';
        $headers = ['Date Subscribed', 'Email', 'Status'];
        $rows = [];
        foreach (Subscriber::all($filter, ['sort' => ['createdAt' => -1]]) as $s) {
            $rows[] = [
                $s['createdAt'] ?? '',
                $s['email']     ?? '',
                !empty($s['active']) ? 'active' : 'inactive',
            ];
        }
        $this->streamExport('subscribers', $headers, $rows, 'Subscribers Export');
    }

    /* ── BLOGS / TESTIMONIALS / GALLERY / CAREERS (minimal CRUD) ── */

    public function blogs(): void {
        $filter = [];
        if (!empty($_GET['category'])) $filter['category'] = $_GET['category'];
        if (isset($_GET['published']) && $_GET['published'] !== '') {
            $filter['published'] = $_GET['published'] === 'yes';
        }
        $result = Blog::paginate($filter, (int)($_GET['page'] ?? 1), 20);
        $this->view('admin.blogs.index', ['title'=>'Blogs — Admin', 'result'=>$result]);
    }
    public function blogCreate(): void { $this->view('admin.blogs.form', ['title'=>'New Blog', 'blog'=>null]); }
    public function blogStore(): void {
        $data = $this->blogData();
        $data['publishedAt'] = new \MongoDB\BSON\UTCDateTime();
        Blog::create($data);
        $this->flash('success', 'Blog post created.');
        $this->redirect('/admin/blogs');
    }
    public function blogEdit(string $id): void { $this->view('admin.blogs.form', ['title'=>'Edit Blog','blog'=>Blog::find($id)]); }
    public function blogUpdate(string $id): void {
        Blog::update($id, $this->blogData());
        $this->flash('success', 'Blog post updated.');
        $this->redirect('/admin/blogs');
    }
    public function blogDelete(string $id): void { Blog::delete($id); $this->redirect('/admin/blogs'); }

    /**
     * Build a blog data payload from the current request.
     * Slot-based uploader: images[] (new files) + existing_images[] (URLs already saved),
     * one pair per visual slot. Slot 0 = cover, slots 1..N = gallery. Power-user
     * gallery_urls textarea is appended after the slot images.
     */
    private function blogData(): array {
        $r = $this->request->all();

        $images   = [];
        $existing = $r['existing_images'] ?? [];
        $files    = $_FILES['images'] ?? null;
        $slotCount = max(
            is_array($existing) ? count($existing) : 0,
            is_array($files['tmp_name'] ?? null) ? count($files['tmp_name']) : 0
        );

        for ($i = 0; $i < $slotCount; $i++) {
            $newTmp = $files['tmp_name'][$i] ?? '';
            $newErr = $files['error'][$i] ?? UPLOAD_ERR_NO_FILE;
            if (!empty($newTmp) && $newErr === UPLOAD_ERR_OK) {
                $url = \App\Helpers\Cloudinary::upload($newTmp, 'vastuanand/blogs');
                if ($url) { $images[] = $url; continue; }
            }
            if (!empty($existing[$i])) {
                $images[] = trim((string)$existing[$i]);
            }
        }

        // Optional URL textarea — appended after the slot images
        $extra = array_filter(array_map('trim', preg_split('/\r?\n/', (string)($r['gallery_urls'] ?? ''))));
        $images = array_values(array_unique(array_merge($images, $extra)));

        $cover   = $images[0] ?? '';
        $gallery = array_slice($images, 1);

        return [
            'title'     => $r['title'] ?? '',
            'slug'      => slug($r['slug'] ?? $r['title'] ?? ''),
            'excerpt'   => $r['excerpt'] ?? '',
            'body'      => $r['body'] ?? '',
            'cover'     => $cover,
            'gallery'   => $gallery,
            'category'  => $r['category'] ?? 'General',
            'readTime'  => trim((string)($r['readTime'] ?? '')),
            'published' => isset($r['published']),
        ];
    }

    public function testimonials(): void {
        $pending  = Testimonial::pending(100);
        $approved = Testimonial::all(['approved' => true], ['sort'=>['createdAt'=>-1]]);
        $this->view('admin.testimonials', [
            'title'    => 'Reviews — Admin',
            'pending'  => $pending,
            'approved' => $approved,
        ]);
    }
    public function testimonialStore(): void {
        $r = $this->request->all();
        Testimonial::create([
            'name'=>$r['name'], 'role'=>$r['role'] ?? '', 'message'=>$r['message'],
            'rating'=>(int)($r['rating'] ?? 5), 'approved'=>isset($r['approved']),
            'avatar'=>$r['avatar'] ?? '',
        ]);
        $this->flash('success', 'Review added.');
        $this->redirect('/admin/testimonials');
    }
    public function testimonialApprove(string $id): void {
        Testimonial::update($id, ['approved' => true]);
        $this->flash('success', 'Review approved and now visible on the website.');
        $this->redirect('/admin/testimonials');
    }
    public function testimonialUnapprove(string $id): void {
        Testimonial::update($id, ['approved' => false]);
        $this->flash('success', 'Review moved back to pending.');
        $this->redirect('/admin/testimonials');
    }
    public function testimonialDelete(string $id): void { Testimonial::delete($id); $this->redirect('/admin/testimonials'); }

    /* ── SETTINGS / POPUPS ─────────────────── */

    public function settings(): void {
        $items = \App\Models\Setting::all();
        $map   = [];
        foreach ($items as $i) $map[$i['key']] = $i['value'] ?? '';
        $this->view('admin.settings', ['title'=>'Settings — Admin', 'settings'=>$map]);
    }
    public function settingsUpdate(): void {
        foreach ($this->request->all() as $k => $v) {
            if (in_array($k, ['_csrf','_method'])) continue;
            Setting::put($k, $v);
        }
        $this->flash('success','Settings saved.');
        $this->redirect('/admin/settings');
    }

    /* ── EVENTS (formerly Popups — site-wide event banners/modals) ─── */

    public function events(): void {
        $items = Event::all([], ['sort' => ['createdAt' => -1]]);
        $this->view('admin.events.index', ['title' => 'Events — Admin', 'items' => $items]);
    }

    public function eventCreate(): void {
        $this->view('admin.events.form', ['title' => 'New Event', 'item' => null]);
    }

    public function eventStore(): void {
        Event::create($this->eventData());
        $this->flash('success', 'Event created.');
        $this->redirect('/admin/events');
    }

    public function eventEdit(string $id): void {
        $item = Event::find($id);
        if (!$item) Response::notFound();
        $this->view('admin.events.form', ['title' => 'Edit Event', 'item' => $item]);
    }

    public function eventUpdate(string $id): void {
        Event::update($id, $this->eventData());
        $this->flash('success', 'Event updated.');
        $this->redirect('/admin/events');
    }

    public function eventDelete(string $id): void {
        Event::delete($id);
        $this->flash('success', 'Event deleted.');
        $this->redirect('/admin/events');
    }

    /** Build an event payload — supports file uploads (multiple) and URL fallback. */
    private function eventData(): array
    {
        $r = $this->request->all();
        $existing = $r['existing_images'] ?? [];
        $files    = $_FILES['images'] ?? null;

        $images = [];
        $slotCount = max(
            is_array($existing) ? count($existing) : 0,
            is_array($files['tmp_name'] ?? null) ? count($files['tmp_name']) : 0
        );
        for ($i = 0; $i < $slotCount; $i++) {
            $tmp = $files['tmp_name'][$i] ?? '';
            $err = $files['error'][$i] ?? UPLOAD_ERR_NO_FILE;
            if (!empty($tmp) && $err === UPLOAD_ERR_OK) {
                $url = \App\Helpers\Cloudinary::upload($tmp, 'vastuanand/events');
                if ($url) { $images[] = $url; continue; }
            }
            if (!empty($existing[$i])) $images[] = trim((string)$existing[$i]);
        }
        $singleUrl = trim((string)($r['image'] ?? ''));
        if ($singleUrl !== '' && !in_array($singleUrl, $images, true)) $images[] = $singleUrl;

        return [
            'title'       => trim((string)($r['title'] ?? '')),
            'description' => trim((string)($r['description'] ?? '')),
            'image'       => $images[0] ?? '',
            'gallery'     => count($images) > 1 ? array_slice($images, 1) : [],
            'cta'         => trim((string)($r['cta'] ?? '')),
            'link'        => trim((string)($r['link'] ?? '')),
            'location'    => trim((string)($r['location'] ?? '')),
            'starts_at'   => trim((string)($r['starts_at'] ?? '')),
            'ends_at'     => trim((string)($r['ends_at'] ?? '')),
            'active'      => isset($r['active']),
        ];
    }

    public function eventsExport(): void {
        $headers = ['Created','Title','Starts','Ends','CTA','Link','Active'];
        $rows = [];
        foreach (Event::all([], ['sort' => ['createdAt' => -1]]) as $ev) {
            $rows[] = [
                $ev['createdAt']  ?? '',
                $ev['title']      ?? '',
                $ev['starts_at']  ?? '',
                $ev['ends_at']    ?? '',
                $ev['cta']        ?? '',
                $ev['link']       ?? '',
                !empty($ev['active']) ? 'yes' : 'no',
            ];
        }
        $this->streamExport('events', $headers, $rows, 'Events Export');
    }

    /* ── USERS (captured via property detail unlock modal) ──────── */

    public function users(): void {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $filter = [];
        $q = trim((string)($_GET['q'] ?? ''));
        if ($q !== '') {
            $rx = ['$regex' => preg_quote($q, '/'), '$options' => 'i'];
            $filter['$or'] = [
                ['name'  => $rx],
                ['email' => $rx],
                ['phone' => $rx],
            ];
        }
        $result = User::paginate($filter, $page, 25, ['createdAt' => -1]);
        $this->view('admin.users.index', [
            'title'  => 'Users — Admin',
            'result' => $result,
            'q'      => $q,
            'total'  => User::count(),
        ]);
    }

    public function userShow(string $id): void {
        $user = User::find($id);
        if (!$user) Response::notFound();
        $views = PropertyView::all(['user_id' => $id], ['sort' => ['createdAt' => -1]]);
        $leads = Lead::all(['email' => $user['email'] ?? '__nope__'], ['sort' => ['createdAt' => -1]]);
        $this->view('admin.users.show', [
            'title' => ($user['name'] ?? 'User') . ' — Users',
            'user'  => $user,
            'views' => $views,
            'leads' => $leads,
        ]);
    }

    public function userDelete(string $id): void {
        User::delete($id);
        $this->flash('success', 'User removed.');
        $this->redirect('/admin/users');
    }

    public function usersExport(): void {
        $filter = [];
        $q = trim((string)($_GET['q'] ?? ''));
        if ($q !== '') {
            $rx = ['$regex' => preg_quote($q, '/'), '$options' => 'i'];
            $filter['$or'] = [
                ['name'  => $rx],
                ['email' => $rx],
                ['phone' => $rx],
            ];
        }
        $headers = ['Captured','Name','Email','Phone','Properties Viewed','Last Property'];
        $rows = [];
        foreach (User::all($filter, ['sort' => ['createdAt' => -1]]) as $u) {
            $rows[] = [
                $u['createdAt']        ?? '',
                $u['name']             ?? '',
                $u['email']            ?? '',
                $u['phone']            ?? '',
                (int)($u['views_count'] ?? 0),
                $u['last_property']    ?? '',
            ];
        }
        $this->streamExport('users', $headers, $rows, 'Captured Users Export');
    }

    /* ── ADMIN USER MANAGEMENT ─────────────── */

    public function admins(): void {
        $items = Admin::all([], ['sort' => ['createdAt' => -1]]);
        $this->view('admin.admins.index', ['title' => 'Admin Users — Admin', 'items' => $items]);
    }

    public function adminCreate(): void {
        $this->view('admin.admins.form', ['title' => 'New Admin User', 'admin' => null]);
    }

    public function adminStore(): void {
        $data = $this->validate([
            'name'     => 'required|min:2|max:60',
            'email'    => 'required|email',
            'password' => 'required|min:8',
            'role'     => 'required|in:super,admin,editor',
        ]);

        $email = strtolower($data['email']);
        if (Admin::byEmail($email)) {
            $_SESSION['_errors'] = ['email' => ['An admin with this email already exists.']];
            $_SESSION['_old']    = $this->request->all();
            $this->redirect('/admin/admins/create');
        }

        Admin::create([
            'name'     => $data['name'],
            'email'    => $email,
            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
            'role'     => $data['role'],
        ]);

        $this->flash('success', 'Admin user created.');
        $this->redirect('/admin/admins');
    }

    public function adminEdit(string $id): void {
        $admin = Admin::find($id);
        if (!$admin) Response::notFound();
        $this->view('admin.admins.form', ['title' => 'Edit Admin User', 'admin' => $admin]);
    }

    public function adminUpdate(string $id): void {
        $admin = Admin::find($id);
        if (!$admin) Response::notFound();

        $rules = [
            'name'  => 'required|min:2|max:60',
            'email' => 'required|email',
            'role'  => 'required|in:super,admin,editor',
        ];
        $newPassword = trim((string)$this->request->input('password', ''));
        if ($newPassword !== '') {
            $rules['password'] = 'min:8';
        }
        $data = $this->validate($rules);

        $email = strtolower($data['email']);
        // Email uniqueness — allow if unchanged or no conflict
        if ($email !== strtolower($admin['email'])) {
            if (Admin::byEmail($email)) {
                $_SESSION['_errors'] = ['email' => ['That email is already in use.']];
                $_SESSION['_old']    = $this->request->all();
                $this->redirect('/admin/admins/' . $id . '/edit');
            }
        }

        $update = [
            'name'  => $data['name'],
            'email' => $email,
            'role'  => $data['role'],
        ];
        if ($newPassword !== '') {
            $update['password'] = password_hash($newPassword, PASSWORD_BCRYPT);
        }

        Admin::update($id, $update);

        // Keep the session in sync if the logged-in admin edited their own row
        if (!empty($_SESSION['admin']['id']) && (string)$_SESSION['admin']['id'] === (string)$id) {
            $_SESSION['admin']['name']  = $update['name'];
            $_SESSION['admin']['email'] = $update['email'];
            $_SESSION['admin']['role']  = $update['role'];
        }

        $this->flash('success', 'Admin user updated.');
        $this->redirect('/admin/admins');
    }

    public function adminDelete(string $id): void {
        // Lockout protection — never let the last admin be deleted
        if (Admin::count() <= 1) {
            $this->flash('success', 'Cannot delete the last remaining admin.');
            $this->redirect('/admin/admins');
        }

        // Self-deletion protection — would log the current user out and orphan the panel
        if (!empty($_SESSION['admin']['id']) && (string)$_SESSION['admin']['id'] === (string)$id) {
            $this->flash('success', 'You cannot delete your own account while logged in.');
            $this->redirect('/admin/admins');
        }

        Admin::delete($id);
        $this->flash('success', 'Admin user deleted.');
        $this->redirect('/admin/admins');
    }

    /* ── LOCATIONS ─────────────────────────── */

    public function locations(): void {
        $items = Location::all([], ['sort' => ['order' => 1, 'name' => 1]]);
        $this->view('admin.locations.index', ['title' => 'Locations — Admin', 'items' => $items]);
    }

    public function locationStore(): void {
        $data = $this->validate([
            'name'  => 'required|min:2|max:80',
            'order' => '',
        ]);
        Location::create([
            'name'   => trim($data['name']),
            'slug'   => slug($data['name']),
            'order'  => (int)($data['order'] ?? 0),
            'active' => true,
        ]);
        $this->flash('success', 'Location added.');
        $this->redirect('/admin/locations');
    }

    public function locationEdit(string $id): void {
        $item = Location::find($id);
        if (!$item) Response::notFound();
        $this->view('admin.locations.form', ['title' => 'Edit Location', 'item' => $item]);
    }

    public function locationUpdate(string $id): void {
        $item = Location::find($id);
        if (!$item) Response::notFound();
        $data = $this->validate([
            'name'  => 'required|min:2|max:80',
            'order' => '',
        ]);
        Location::update($id, [
            'name'   => trim($data['name']),
            'slug'   => slug($data['name']),
            'order'  => (int)($data['order'] ?? 0),
            'active' => !empty($this->request->input('active')),
        ]);
        $this->flash('success', 'Location updated.');
        $this->redirect('/admin/locations');
    }

    public function locationDelete(string $id): void {
        Location::delete($id);
        $this->flash('success', 'Location deleted.');
        $this->redirect('/admin/locations');
    }

    /* ── PROPERTY TYPES ────────────────────── */

    public function propertyTypes(): void {
        $items = PropertyType::all([], ['sort' => ['order' => 1, 'name' => 1]]);
        $this->view('admin.property-types.index', ['title' => 'Property Types — Admin', 'items' => $items]);
    }

    public function propertyTypeStore(): void {
        $data = $this->validate([
            'name'  => 'required|min:2|max:60',
            'order' => '',
        ]);
        PropertyType::create([
            'name'     => trim($data['name']),
            'slug'     => slug($data['name']),
            'order'    => (int)($data['order'] ?? 0),
            'hide_bhk' => !empty($this->request->input('hide_bhk')),
            'active'   => true,
        ]);
        $this->flash('success', 'Property type added.');
        $this->redirect('/admin/property-types');
    }

    public function propertyTypeEdit(string $id): void {
        $item = PropertyType::find($id);
        if (!$item) Response::notFound();
        $this->view('admin.property-types.form', ['title' => 'Edit Property Type', 'item' => $item]);
    }

    public function propertyTypeUpdate(string $id): void {
        $item = PropertyType::find($id);
        if (!$item) Response::notFound();
        $data = $this->validate([
            'name'  => 'required|min:2|max:60',
            'order' => '',
        ]);
        PropertyType::update($id, [
            'name'     => trim($data['name']),
            'slug'     => slug($data['name']),
            'order'    => (int)($data['order'] ?? 0),
            'hide_bhk' => !empty($this->request->input('hide_bhk')),
            'active'   => !empty($this->request->input('active')),
        ]);
        $this->flash('success', 'Property type updated.');
        $this->redirect('/admin/property-types');
    }

    public function propertyTypeDelete(string $id): void {
        PropertyType::delete($id);
        $this->flash('success', 'Property type deleted.');
        $this->redirect('/admin/property-types');
    }

    /* ── SEARCH FILTERS (unified builder) ─────────────── */

    public function filters(): void {
        $this->seedDefaultFilters();
        $items = FilterField::all([], ['sort' => ['order' => 1, 'label' => 1]]);
        $this->view('admin.filters.index', [
            'title' => 'Search Filters — Admin',
            'items' => $items,
        ]);
    }

    public function filterCreate(): void {
        $this->view('admin.filters.form', [
            'title' => 'New Filter Field',
            'item'  => null,
            'all'   => FilterField::all([], ['sort' => ['order' => 1]]),
        ]);
    }

    public function filterStore(): void {
        $data = $this->validate([
            'key'   => 'required|min:2|max:40',
            'label' => 'required|min:2|max:60',
            'type'  => 'required|in:select,text,number',
        ]);

        $key = slug($data['key']);
        if (FilterField::byKey($key)) {
            $_SESSION['_errors'] = ['key' => ['A filter with this key already exists.']];
            $_SESSION['_old']    = $this->request->all();
            $this->redirect('/admin/filters/create');
        }

        FilterField::create($this->buildFilterPayload($data, $key));

        $this->flash('success', 'Filter field created.');
        $this->redirect('/admin/filters/' . (string)FilterField::byKey($key)['id'] . '/edit');
    }

    public function filterEdit(string $id): void {
        $item = FilterField::find($id);
        if (!$item) Response::notFound();
        $this->view('admin.filters.form', [
            'title' => 'Edit Filter — ' . ($item['label'] ?? ''),
            'item'  => $item,
            'all'   => FilterField::all(['_id' => ['$ne' => new \MongoDB\BSON\ObjectId($id)]], ['sort' => ['order' => 1]]),
        ]);
    }

    public function filterUpdate(string $id): void {
        $item = FilterField::find($id);
        if (!$item) Response::notFound();

        $data = $this->validate([
            'key'   => 'required|min:2|max:40',
            'label' => 'required|min:2|max:60',
            'type'  => 'required|in:select,text,number',
        ]);

        $key = slug($data['key']);
        if ($key !== ($item['key'] ?? '') && FilterField::byKey($key)) {
            $_SESSION['_errors'] = ['key' => ['That key is already in use by another filter.']];
            $_SESSION['_old']    = $this->request->all();
            $this->redirect('/admin/filters/' . $id . '/edit');
        }

        FilterField::update($id, $this->buildFilterPayload($data, $key));
        $this->flash('success', 'Filter updated.');
        $this->redirect('/admin/filters/' . $id . '/edit');
    }

    public function filterDelete(string $id): void {
        FilterField::delete($id);
        $this->flash('success', 'Filter deleted.');
        $this->redirect('/admin/filters');
    }

    /** Build the doc payload from a validated POST. Handles inline options + hide-rules. */
    private function buildFilterPayload(array $data, string $key): array {
        $payload = [
            'key'             => $key,
            'label'           => trim($data['label']),
            'type'            => $data['type'],
            'placeholder'     => trim((string)$this->request->input('placeholder', '')),
            'order'           => (int)$this->request->input('order', 0),
            'active'          => !empty($this->request->input('active')),
            'show_in_hero'    => !empty($this->request->input('show_in_hero')),
            'show_in_listing' => !empty($this->request->input('show_in_listing')),
            'options'         => [],
        ];

        if ($payload['type'] === 'select') {
            $labels   = (array)$this->request->input('opt_label', []);
            $values   = (array)$this->request->input('opt_value', []);
            $hideRows = (array)$this->request->input('opt_hide', []);  // arr of CSV strings

            foreach ($labels as $i => $lbl) {
                $lbl = trim((string)$lbl);
                if ($lbl === '') continue;
                $val = trim((string)($values[$i] ?? '')) ?: $lbl;
                $hideCsv = (string)($hideRows[$i] ?? '');
                $hideKeys = array_values(array_filter(array_map('trim', explode(',', $hideCsv))));
                $payload['options'][] = [
                    'label' => $lbl,
                    'value' => $val,
                    'hide'  => $hideKeys,
                ];
            }
        }

        return $payload;
    }

    /** Seeds initial filter fields once if the collection is empty. */
    private function seedDefaultFilters(): void {
        if (FilterField::count() > 0) return;

        $seed = [
            [
                'key' => 'q', 'label' => 'Location', 'type' => 'select',
                'placeholder' => 'Any location', 'order' => 10,
                'active' => true, 'show_in_hero' => true, 'show_in_listing' => true,
                'options' => array_map(fn($n) => ['label' => $n, 'value' => $n, 'hide' => []], [
                    'Bandra West', 'Juhu', 'BKC', 'Powai', 'Worli', 'Lower Parel',
                    'Andheri', 'Thane', 'Navi Mumbai', 'Panvel',
                ]),
            ],
            [
                'key' => 'type', 'label' => 'Property Type', 'type' => 'select',
                'placeholder' => 'Any type', 'order' => 20,
                'active' => true, 'show_in_hero' => true, 'show_in_listing' => true,
                'options' => [
                    ['label' => 'Apartment',     'value' => 'Apartment',     'hide' => []],
                    ['label' => 'Villa',         'value' => 'Villa',         'hide' => []],
                    ['label' => 'Penthouse',     'value' => 'Penthouse',     'hide' => []],
                    ['label' => 'Studio',        'value' => 'Studio',        'hide' => []],
                    ['label' => 'Builder Floor', 'value' => 'Builder Floor', 'hide' => []],
                    ['label' => 'Farmhouse',     'value' => 'Farmhouse',     'hide' => []],
                    ['label' => 'Plot',          'value' => 'Plot',          'hide' => ['bhk']],
                    ['label' => 'Commercial',    'value' => 'Commercial',    'hide' => ['bhk']],
                ],
            ],
            [
                'key' => 'bhk', 'label' => 'BHK', 'type' => 'select',
                'placeholder' => 'Any', 'order' => 30,
                'active' => true, 'show_in_hero' => true, 'show_in_listing' => true,
                'options' => [
                    ['label' => '1 BHK',  'value' => '1', 'hide' => []],
                    ['label' => '2 BHK',  'value' => '2', 'hide' => []],
                    ['label' => '3 BHK',  'value' => '3', 'hide' => []],
                    ['label' => '4 BHK',  'value' => '4', 'hide' => []],
                    ['label' => '5+ BHK', 'value' => '5', 'hide' => []],
                ],
            ],
            [
                'key' => 'max', 'label' => 'Budget', 'type' => 'select',
                'placeholder' => 'Any', 'order' => 40,
                'active' => true, 'show_in_hero' => true, 'show_in_listing' => true,
                'options' => [
                    ['label' => 'Up to ₹50 L',  'value' => '5000000',   'hide' => []],
                    ['label' => 'Up to ₹1 Cr',  'value' => '10000000',  'hide' => []],
                    ['label' => 'Up to ₹3 Cr',  'value' => '30000000',  'hide' => []],
                    ['label' => 'Up to ₹7 Cr',  'value' => '70000000',  'hide' => []],
                    ['label' => 'Up to ₹20 Cr', 'value' => '200000000', 'hide' => []],
                ],
            ],
        ];

        foreach ($seed as $doc) FilterField::create($doc);
    }
}
