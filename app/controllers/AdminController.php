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
            'cover'       => $r['cover'] ?? '',
            'gallery'     => array_filter(array_map('trim', explode("\n", $r['gallery'] ?? ''))),
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
        $r = $this->request->all();
        Blog::create([
            'title' => $r['title'], 'slug' => slug($r['slug'] ?? $r['title']),
            'excerpt' => $r['excerpt'] ?? '', 'body' => $r['body'] ?? '',
            'cover' => $r['cover'] ?? '', 'category' => $r['category'] ?? 'General',
            'published' => isset($r['published']),
            'publishedAt' => new \MongoDB\BSON\UTCDateTime(),
        ]);
        $this->redirect('/admin/blogs');
    }
    public function blogEdit(string $id): void { $this->view('admin.blogs.form', ['title'=>'Edit Blog','blog'=>Blog::find($id)]); }
    public function blogUpdate(string $id): void {
        $r = $this->request->all();
        Blog::update($id, [
            'title'=>$r['title'],'slug'=>slug($r['slug'] ?? $r['title']),
            'excerpt'=>$r['excerpt'] ?? '','body'=>$r['body'] ?? '',
            'cover'=>$r['cover'] ?? '','category'=>$r['category'] ?? 'General',
            'published'=>isset($r['published']),
        ]);
        $this->redirect('/admin/blogs');
    }
    public function blogDelete(string $id): void { Blog::delete($id); $this->redirect('/admin/blogs'); }

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
