<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Property;
use App\Models\Testimonial;
use App\Models\Blog;

final class HomeController extends Controller
{
    public function index(): void
    {
        $featured     = Property::featured(6) ?: $this->fallbackProperties();
        $testimonials = Testimonial::approved(6) ?: $this->fallbackTestimonials();
        $blogs        = Blog::latest(3) ?: $this->fallbackBlogs();

        $stats = [
            ['value' => '500+', 'label' => 'Properties Listed'],
            ['value' => '350+', 'label' => 'Happy Clients'],
            ['value' => '120+', 'label' => 'Properties Sold'],
            ['value' => '4+',   'label' => 'Years Experience'],
        ];

        $this->view('pages.home', [
            'title'        => 'Luxury Real Estate Mumbai | Vastu Anand',
            'description'  => 'Discover premium luxury apartments, villas, penthouses & commercial properties in Mumbai with Vastu Anand — RERA-verified, transparent and insight-led.',
            'featured'     => $featured,
            'testimonials' => $testimonials,
            'blogs'        => $blogs,
            'stats'        => $stats,
        ]);
    }

    /** Demo data used when MongoDB is empty or unreachable. */
    private function fallbackProperties(): array
    {
        return [
            ['id' => 'demo-1', 'slug' => 'luxury-apartment-bandra-west', 'title' => 'Luxury Apartment in Bandra West', 'location' => 'Bandra West, Mumbai', 'listing' => 'sale', 'type' => 'Apartment', 'bhk' => 4, 'area' => 2400, 'price' => 95000000, 'cover' => asset('images/p1.jpg'), 'tags' => ['Sea Facing', 'Ready to Move'], 'featured' => true],
            ['id' => 'demo-2', 'slug' => 'premium-villa-juhu',           'title' => 'Premium Villa in Juhu',           'location' => 'Juhu, Mumbai',         'listing' => 'sale', 'type' => 'Villa',     'bhk' => 5, 'area' => 5200, 'price' => 280000000,'cover' => asset('images/p2.jpg'), 'tags' => ['Private Pool', 'Garden'], 'featured' => true],
            ['id' => 'demo-3', 'slug' => 'commercial-office-bkc',        'title' => 'Commercial Office Space in BKC', 'location' => 'BKC, Mumbai',          'listing' => 'lease','type' => 'Commercial','bhk' => 0, 'area' => 3500, 'price' => 18000000, 'cover' => asset('images/p3.jpg'), 'tags' => ['Grade A', 'IT Ready'], 'featured' => true],
            ['id' => 'demo-4', 'slug' => 'spacious-family-home-powai',   'title' => 'Spacious Family Home in Powai',  'location' => 'Powai, Mumbai',        'listing' => 'sale', 'type' => 'Apartment', 'bhk' => 3, 'area' => 1750, 'price' => 42000000, 'cover' => asset('images/p4.jpg'), 'tags' => ['Lake View'], 'featured' => true],
            ['id' => 'demo-5', 'slug' => 'luxury-farmhouse-panvel',      'title' => 'Luxury Farmhouse near Panvel',   'location' => 'Panvel, Navi Mumbai',  'listing' => 'sale', 'type' => 'Farmhouse', 'bhk' => 4, 'area' => 8000, 'price' => 65000000, 'cover' => asset('images/p5.jpg'), 'tags' => ['Greenery', 'Private Pool'], 'featured' => true],
            ['id' => 'demo-6', 'slug' => 'studio-lower-parel',           'title' => 'Compact Studio in Lower Parel',  'location' => 'Lower Parel, Mumbai',  'listing' => 'rent', 'type' => 'Studio',    'bhk' => 1, 'area' => 480,  'price' => 75000,    'cover' => asset('images/p6.jpg'), 'tags' => ['Furnished'], 'featured' => true],
        ];
    }

    private function fallbackTestimonials(): array
    {
        return [
            ['name' => 'Priya Sharma',    'role' => 'Home Buyer, Bandra',  'rating' => 5, 'message' => 'Buying property in Mumbai can be stressful, but Vastu Anand made everything easy. Highly recommend their consultation services.'],
            ['name' => 'Rajesh Kumar',    'role' => 'Investor, BKC',       'rating' => 5, 'message' => 'Their market insights helped me time my BKC investment perfectly. Transparent, ethical and deeply knowledgeable.'],
            ['name' => 'Sneha Deshmukh',  'role' => 'Home Buyer, Andheri', 'rating' => 5, 'message' => 'Amazing experience buying our apartment in Andheri. The team guided us through every step and made the process very smooth.'],
            ['name' => 'Rohan Gupta',     'role' => 'NRI Investor, Dubai', 'rating' => 5, 'message' => 'As an NRI, I needed someone trustworthy in Mumbai. Vastu Anand delivered beyond expectations on the legal and documentation side.'],
            ['name' => 'Amit Patel',      'role' => 'Tenant, Powai',       'rating' => 5, 'message' => 'Found a beautiful lake-view rental in Powai in just 4 days. Zero brokerage, full transparency.'],
            ['name' => 'Neha Kulkarni',   'role' => 'Seller, Worli',       'rating' => 5, 'message' => 'They valued my Worli flat fairly and closed the deal in under 8 weeks. Professional from start to finish.'],
        ];
    }

    private function fallbackBlogs(): array
    {
        return [
            ['slug' => 'first-time-home-buyers-mumbai', 'title' => '10 Tips for First-Time Home Buyers in Mumbai', 'excerpt' => 'Essential guide for first-time home buyers — budgeting, pre-approvals, location, builder verification & legal documentation.', 'cover' => asset('images/b1.jpg'), 'publishedAt' => '2025-01-15', 'readTime' => '8 min'],
            ['slug' => 'mumbaiInvestment',              'title' => 'Mumbai\'s Best Investment Neighborhoods 2025', 'excerpt' => 'Bandra, Powai, Thane, Navi Mumbai — entry prices, rental yields and 3–5 year outlook for each micro-market.', 'cover' => asset('images/b2.jpg'), 'publishedAt' => '2025-01-10', 'readTime' => '10 min'],
            ['slug' => 'propertydocumentation',         'title' => 'Property Documentation in India — A Complete Guide', 'excerpt' => 'Sale deeds, title search, encumbrance certificates, RERA registration and common legal red flags to avoid.', 'cover' => asset('images/b3.jpg'), 'publishedAt' => '2025-01-05', 'readTime' => '12 min'],
        ];
    }
}
