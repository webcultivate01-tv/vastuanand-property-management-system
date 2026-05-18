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
        $featured     = array_slice(Property::featured(6) ?: $this->fallbackProperties(), 0, 3);
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
            ['id' => 'demo-1', 'slug' => 'luxury-apartment-bandra-west', 'title' => 'Luxury Apartment in Bandra West', 'location' => 'Bandra West, Mumbai', 'listing' => 'sale', 'type' => 'Apartment', 'bhk' => 4, 'area' => 2400, 'price' => 95000000,
                'cover' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=900&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=900&q=80',
                ],
                'tags' => ['Sea Facing', 'Ready to Move'], 'featured' => true],
            ['id' => 'demo-2', 'slug' => 'premium-villa-juhu', 'title' => 'Premium Villa in Juhu', 'location' => 'Juhu, Mumbai', 'listing' => 'sale', 'type' => 'Villa', 'bhk' => 5, 'area' => 5200, 'price' => 280000000,
                'cover' => 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?auto=format&fit=crop&w=900&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=900&q=80',
                ],
                'tags' => ['Private Pool', 'Garden'], 'featured' => true],
            ['id' => 'demo-3', 'slug' => 'commercial-office-bkc', 'title' => 'Commercial Office Space in BKC', 'location' => 'BKC, Mumbai', 'listing' => 'lease', 'type' => 'Commercial', 'bhk' => 0, 'area' => 3500, 'price' => 18000000,
                'cover' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=900&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1486325212027-8081e485255e?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1431540015161-0bf868a2d407?auto=format&fit=crop&w=900&q=80',
                ],
                'tags' => ['Grade A', 'IT Ready'], 'featured' => true],
            ['id' => 'demo-4', 'slug' => 'spacious-family-home-powai', 'title' => 'Spacious Family Home in Powai', 'location' => 'Powai, Mumbai', 'listing' => 'sale', 'type' => 'Apartment', 'bhk' => 3, 'area' => 1750, 'price' => 42000000,
                'cover' => 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=900&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1493809842364-78817add7ffb?auto=format&fit=crop&w=900&q=80',
                ],
                'tags' => ['Lake View'], 'featured' => true],
            ['id' => 'demo-5', 'slug' => 'luxury-farmhouse-panvel', 'title' => 'Luxury Farmhouse near Panvel', 'location' => 'Panvel, Navi Mumbai', 'listing' => 'sale', 'type' => 'Farmhouse', 'bhk' => 4, 'area' => 8000, 'price' => 65000000,
                'cover' => 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=900&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1582407947304-fd86f028f716?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1542621334-a254cf47733d?auto=format&fit=crop&w=900&q=80',
                ],
                'tags' => ['Greenery', 'Private Pool'], 'featured' => true],
            ['id' => 'demo-6', 'slug' => 'studio-lower-parel', 'title' => 'Compact Studio in Lower Parel', 'location' => 'Lower Parel, Mumbai', 'listing' => 'rent', 'type' => 'Studio', 'bhk' => 1, 'area' => 480, 'price' => 75000,
                'cover' => 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=900&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1502672023488-70e25813eb80?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=900&q=80',
                ],
                'tags' => ['Furnished'], 'featured' => true],
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
