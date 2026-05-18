<?php
namespace App\Controllers\Api;

use App\Core\Controller;
use App\Models\Property;

final class PropertyApi extends Controller
{
    public function index(): void
    {
        $page    = max(1, (int)($_GET['page'] ?? 1));
        $perPage = min(50, (int)($_GET['per_page'] ?? 12));
        $this->json(['ok' => true, 'data' => Property::filter($_GET, $page, $perPage)]);
    }

    public function featured(): void
    {
        $this->json(['ok' => true, 'data' => Property::featured((int)($_GET['limit'] ?? 6))]);
    }

    public function show(string $slug): void
    {
        $p = Property::bySlug($slug);
        if (!$p) $this->json(['ok' => false, 'message' => 'Not found'], 404);
        $this->json(['ok' => true, 'data' => $p, 'similar' => Property::similar($p, 4)]);
    }

    public function locations(): void
    {
        $this->json(['ok' => true, 'data' => Property::locations()]);
    }
}
