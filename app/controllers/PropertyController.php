<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Response;
use App\Models\Property;

final class PropertyController extends Controller
{
    public function index(): void { $this->listing(); }
    public function buy(): void   { $this->listing(['listing' => 'sale']); }
    public function rent(): void  { $this->listing(['listing' => 'rent']); }
    public function commercial(): void { $this->listing(['type' => 'Commercial']); }

    private function listing(array $defaults = []): void
    {
        $query   = array_merge($defaults, $_GET);
        $page    = max(1, (int)($query['page'] ?? 1));
        $perPage = (int) config('app.pagination.per_page', 12);

        $result = Property::filter($query, $page, $perPage);

        $this->view('pages.properties', [
            'title'       => 'Premium Properties in Mumbai | Vastu Anand',
            'description' => 'Browse premium properties for sale & rent in Mumbai. RERA-verified luxury apartments, villas, penthouses & commercial spaces.',
            'result'      => $result,
            'filters'     => $query,
            'types'       => Property::types(),
            'locations'   => Property::locations(),
        ]);
    }

    public function show(string $slug): void
    {
        $property = Property::bySlug($slug);
        if (!$property) {
            // graceful demo fallback so the page works without DB during dev
            $property = $this->demoProperty($slug);
            if (!$property) Response::notFound('Property not found');
        }
        $similar = Property::similar($property, 4);

        $this->view('pages.property-detail', [
            'title'       => $property['title'] . ' | Vastu Anand',
            'description' => $property['description'] ?? 'Premium property in Mumbai with Vastu Anand.',
            'property'    => $property,
            'similar'     => $similar,
        ]);
    }

    private function demoProperty(string $slug): ?array
    {
        $demos = [
            'luxury-apartment-bandra-west' => [
                'id' => 'demo-1', 'slug' => 'luxury-apartment-bandra-west',
                'title' => 'Luxury Apartment in Bandra West',
                'location' => 'Bandra West, Mumbai',
                'listing' => 'sale', 'type' => 'Apartment', 'bhk' => 4, 'baths' => 4,
                'area' => 2400, 'price' => 95000000,
                'cover' => asset('images/p1.jpg'),
                'gallery' => [asset('images/p1.jpg'), asset('images/p2.jpg'), asset('images/p4.jpg')],
                'tags' => ['Sea Facing', 'Ready to Move', 'Premium'],
                'description' => 'A premium luxury apartment located in the heart of Bandra West with excellent connectivity and breathtaking sea-facing views. Fully furnished, top-floor unit with private elevator and dedicated parking.',
                'amenities' => ['Swimming Pool','Gym','24x7 Security','Power Backup','Clubhouse','CCTV Surveillance','Private Elevator','Parking'],
                'nearby' => [['Metro','0.5 km'],['School','1.2 km'],['Hospital','0.8 km'],['Shopping','0.6 km']],
                'amenityIcons' => [], 'featured' => true,
            ],
        ];
        return $demos[$slug] ?? null;
    }
}
