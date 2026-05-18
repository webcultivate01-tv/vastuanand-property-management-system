<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Response;
use App\Models\Admin;
use App\Models\Property;
use App\Models\Lead;
use App\Models\Blog;
use App\Models\Testimonial;
use App\Models\Gallery;
use App\Models\Career;
use App\Models\Setting;

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
        ];
        $recentLeads = Lead::all([], ['limit' => 10, 'sort' => ['createdAt' => -1]]);
        $this->view('admin.dashboard', ['title'=>'Dashboard — Vastu Anand Admin', 'stats'=>$stats, 'recentLeads'=>$recentLeads]);
    }

    /* ── PROPERTIES ────────────────────────── */

    public function properties(): void {
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $result = Property::paginate([], $page, 20, ['createdAt' => -1]);
        $this->view('admin.properties.index', ['title'=>'Properties — Admin', 'result'=>$result]);
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
        $result = Lead::paginate($filter, $page, 25);
        $this->view('admin.leads', ['title'=>'Leads — Admin', 'result'=>$result, 'statuses'=>Lead::statusList(), 'sources'=>Lead::sources()]);
    }

    public function leadStatus(string $id): void {
        Lead::update($id, ['status' => $this->request->input('status', 'new'), 'note' => $this->request->input('note')]);
        $this->back();
    }

    public function leadsExport(): void {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=vastuanand_leads_' . date('Ymd') . '.csv');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['Date','Name','Phone','Email','Source','Status','Subject','Message']);
        foreach (Lead::all([], ['sort' => ['createdAt' => -1]]) as $lead) {
            fputcsv($out, [
                $lead['createdAt'] ?? '',
                $lead['name'] ?? '',
                $lead['phone'] ?? '',
                $lead['email'] ?? '',
                $lead['source'] ?? '',
                $lead['status'] ?? '',
                $lead['subject'] ?? '',
                $lead['message'] ?? '',
            ]);
        }
        fclose($out);
        exit;
    }

    /* ── BLOGS / TESTIMONIALS / GALLERY / CAREERS (minimal CRUD) ── */

    public function blogs(): void {
        $result = Blog::paginate([], (int)($_GET['page'] ?? 1), 20);
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
     * Handles single cover upload (cover_file) and multi-image gallery (gallery_files[] + gallery_urls).
     */
    private function blogData(): array {
        $r = $this->request->all();

        // Cover: prefer freshly uploaded file, fall back to URL field
        $cover = trim((string)($r['cover'] ?? ''));
        $coverTmp = $_FILES['cover_file']['tmp_name'] ?? '';
        $coverErr = $_FILES['cover_file']['error']    ?? UPLOAD_ERR_NO_FILE;
        if (!empty($coverTmp) && $coverErr === UPLOAD_ERR_OK) {
            $uploaded = \App\Helpers\Cloudinary::upload($coverTmp, 'vastuanand/blogs');
            if ($uploaded) $cover = $uploaded;
        }

        // Gallery: combine uploaded files + URL list (one per line)
        $gallery = [];
        $urlLines = preg_split('/\r?\n/', trim((string)($r['gallery_urls'] ?? '')));
        foreach ($urlLines as $line) {
            $line = trim($line);
            if ($line !== '') $gallery[] = $line;
        }
        if (!empty($_FILES['gallery_files']) && is_array($_FILES['gallery_files']['tmp_name'] ?? null)) {
            foreach ($_FILES['gallery_files']['tmp_name'] as $i => $tmp) {
                $err = $_FILES['gallery_files']['error'][$i] ?? UPLOAD_ERR_NO_FILE;
                if (!empty($tmp) && $err === UPLOAD_ERR_OK) {
                    $uploaded = \App\Helpers\Cloudinary::upload($tmp, 'vastuanand/blogs');
                    if ($uploaded) $gallery[] = $uploaded;
                }
            }
        }
        $gallery = array_values(array_unique(array_filter($gallery)));

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
        $items = Testimonial::all([], ['sort'=>['createdAt'=>-1]]);
        $this->view('admin.testimonials', ['title'=>'Testimonials — Admin', 'items'=>$items]);
    }
    public function testimonialStore(): void {
        $r = $this->request->all();
        Testimonial::create([
            'name'=>$r['name'], 'role'=>$r['role'] ?? '', 'message'=>$r['message'],
            'rating'=>(int)($r['rating'] ?? 5), 'approved'=>isset($r['approved']),
            'avatar'=>$r['avatar'] ?? '',
        ]);
        $this->redirect('/admin/testimonials');
    }
    public function testimonialDelete(string $id): void { Testimonial::delete($id); $this->redirect('/admin/testimonials'); }

    public function gallery(): void {
        $items = Gallery::all([], ['sort'=>['createdAt'=>-1]]);
        $this->view('admin.gallery', ['title'=>'Gallery — Admin', 'items'=>$items]);
    }
    public function galleryStore(): void {
        $r = $this->request->all();
        Gallery::create(['image' => $r['image'], 'caption' => $r['caption'] ?? '', 'category' => $r['category'] ?? 'General']);
        $this->redirect('/admin/gallery');
    }
    public function galleryDelete(string $id): void { Gallery::delete($id); $this->redirect('/admin/gallery'); }

    public function careers(): void { $this->view('admin.careers', ['title'=>'Careers — Admin','items'=>Career::all([],['sort'=>['createdAt'=>-1]])]); }
    public function careerStore(): void {
        $r = $this->request->all();
        Career::create(['title'=>$r['title'],'dept'=>$r['dept'] ?? '','location'=>$r['location'] ?? 'Mumbai','type'=>$r['type'] ?? 'Full-time','description'=>$r['description'] ?? '','active'=>isset($r['active'])]);
        $this->redirect('/admin/careers');
    }

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

    public function popups(): void {
        $items = \App\Core\Database::available() ? iterator_to_array(\App\Core\Database::collection('popups')->find(), false) : [];
        $this->view('admin.popups', ['title'=>'Popups — Admin','items'=>$items]);
    }
    public function popupStore(): void {
        $r = $this->request->all();
        if (\App\Core\Database::available()) {
            \App\Core\Database::collection('popups')->insertOne([
                'title'   => $r['title'] ?? '',
                'image'   => $r['image'] ?? '',
                'cta'     => $r['cta'] ?? '',
                'link'    => $r['link'] ?? '',
                'active'  => isset($r['active']),
                'createdAt' => new \MongoDB\BSON\UTCDateTime(),
            ]);
        }
        $this->redirect('/admin/popups');
    }
}
