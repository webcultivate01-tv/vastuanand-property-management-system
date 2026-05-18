<?php
namespace App\Controllers\Api;

use App\Core\Controller;
use App\Models\Property;
use App\Models\Lead;
use App\Models\Blog;
use App\Models\Testimonial;

final class AdminApi extends Controller
{
    public function stats(): void
    {
        $this->json(['ok' => true, 'data' => [
            'properties'   => Property::count(),
            'leads'        => Lead::count(),
            'leads_new'    => Lead::count(['status' => 'new']),
            'leads_won'    => Lead::count(['status' => 'won']),
            'blogs'        => Blog::count(),
            'testimonials' => Testimonial::count(),
        ]]);
    }

    public function leads(): void
    {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $this->json(['ok' => true, 'data' => Lead::paginate([], $page, 20)]);
    }

    public function updateLead(string $id): void
    {
        Lead::update($id, $this->request->only(['status','note','assignedTo']));
        $this->json(['ok' => true]);
    }

    public function createProperty(): void
    {
        $r = $this->request->all();
        $r['slug']  = slug($r['slug'] ?? $r['title'] ?? '');
        $r['price'] = (float)($r['price'] ?? 0);
        $this->json(['ok' => true, 'data' => Property::create($r)]);
    }

    public function updateProperty(string $id): void
    {
        Property::update($id, $this->request->all());
        $this->json(['ok' => true]);
    }

    public function upload(): void
    {
        if (empty($_FILES['file'])) $this->json(['ok' => false, 'message' => 'No file'], 422);
        $file = $_FILES['file'];
        $max  = (int) env('UPLOAD_MAX_SIZE', 8 * 1024 * 1024);
        if ($file['size'] > $max) $this->json(['ok' => false, 'message' => 'File too large'], 413);

        $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $ok   = ['jpg','jpeg','png','webp','avif','svg','pdf'];
        if (!in_array($ext, $ok)) $this->json(['ok' => false, 'message' => 'Unsupported file type'], 415);

        $folder = preg_replace('/[^a-z0-9_-]/', '', (string)$this->request->input('folder', 'misc'));
        $dir    = public_path("uploads/{$folder}");
        @mkdir($dir, 0755, true);
        $name = uniqid('va_', true) . ".{$ext}";
        $path = "{$dir}/{$name}";
        if (!move_uploaded_file($file['tmp_name'], $path)) {
            $this->json(['ok' => false, 'message' => 'Upload failed'], 500);
        }
        $this->json(['ok' => true, 'url' => upload("{$folder}/{$name}")]);
    }
}
