<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Career;
use App\Models\Testimonial;
use App\Models\Gallery;

final class PageController extends Controller
{
    public function about(): void {
        $this->view('pages.about', [
            'title' => 'About Us — Vastu Anand Real Estate | 4+ Years of Excellence',
            'description' => 'Learn about Vastu Anand, Mumbai\'s trusted real estate partner. Our journey, values and commitment to transparent, insight-led property decisions.',
        ]);
    }

    public function services(): void {
        $this->view('pages.services', [
            'title' => 'Real Estate Services in Mumbai | Vastu Anand',
            'description' => 'Comprehensive real estate services — Property Buying, Selling, Consultation, Rentals & Property Management across Mumbai.',
        ]);
    }

    public function serviceDetail(string $slug): void {
        $services = [
            'property-buying' => [
                'title' => 'Property Buying', 'icon' => 'home',
                'hero' => 'Find and acquire your dream home in Mumbai\'s prime locations.',
                'body' => 'Luxury property buying service across Bandra, Powai, BKC, Worli, Andheri, Navi Mumbai and more — handled end to end by a dedicated advisor.',
                'features' => ['Curated property shortlist','RERA-verified listings','Site visits coordinated','Price negotiation','Legal & documentation support','Loan & finance assistance'],
            ],
            'property-selling' => [
                'title' => 'Property Selling', 'icon' => 'tag',
                'hero' => 'Sell at the right price, in the right time, to the right buyer.',
                'body' => 'Accurate valuation, premium marketing and qualified-buyer screening — backed by our network of 350+ active buyer relationships.',
                'features' => ['Free professional valuation','Premium marketing photography','Verified buyer screening','Negotiation expertise','Paperwork & registration','Tax & capital-gains advisory'],
            ],
            'property-consultation' => [
                'title' => 'Property Consultation', 'icon' => 'lightbulb',
                'hero' => 'Make confident property decisions with expert local advisors.',
                'body' => 'Deep-dive consultations covering location strategy, builder reputation, micro-market trends, rental yield and 5-year appreciation outlook.',
                'features' => ['Investment strategy','Micro-market analysis','Builder due-diligence','Rental yield projection','Vastu compatibility','Personalised roadmap'],
            ],
            'rental-services' => [
                'title' => 'Rental Services', 'icon' => 'key',
                'hero' => 'Premium rental properties with zero-brokerage assistance.',
                'body' => 'Whether you\'re looking to rent or rent-out, we handle tenant screening, agreements and ongoing property management — fully transparent.',
                'features' => ['Verified tenant screening','Rental agreements','Property handover','Maintenance coordination','Renewal & vacate support','NRI landlord services'],
            ],
        ];
        $service = $services[$slug] ?? null;
        if (!$service) \App\Core\Response::notFound();
        $this->view('pages.service-detail', [
            'title' => $service['title'] . ' — Vastu Anand',
            'description' => $service['hero'],
            'service' => $service,
        ]);
    }

    public function propertyManagement(): void { $this->serviceDetail('rental-services'); }
    public function commercial(): void {
        $this->view('pages.commercial', [
            'title' => 'Commercial Real Estate in Mumbai | Vastu Anand',
            'description' => 'Grade-A commercial office spaces in BKC, Lower Parel, Andheri & Worli. Lease, buy or invest with Vastu Anand.',
        ]);
    }
    public function luxuryHomes(): void {
        $this->view('pages.luxury-homes', [
            'title' => 'Luxury Homes Mumbai | Vastu Anand',
            'description' => 'Curated luxury apartments, sea-facing penthouses and private villas across Mumbai\'s most prestigious addresses.',
        ]);
    }
    public function nri(): void {
        $this->view('pages.nri', [
            'title' => 'NRI Property Investment Mumbai | Vastu Anand',
            'description' => 'Trusted NRI property services in Mumbai — investment advisory, legal compliance, property management & remote ownership.',
        ]);
    }
    public function careers(): void {
        $jobs = Career::open() ?: [
            ['title'=>'Senior Property Advisor','location'=>'Mumbai','type'=>'Full-time','dept'=>'Sales'],
            ['title'=>'Luxury Sales Specialist','location'=>'BKC, Mumbai','type'=>'Full-time','dept'=>'Sales'],
            ['title'=>'Marketing Manager','location'=>'Mumbai','type'=>'Full-time','dept'=>'Marketing'],
            ['title'=>'Property Photographer','location'=>'Mumbai','type'=>'Freelance','dept'=>'Creative'],
        ];
        $this->view('pages.careers', ['title'=>'Careers — Vastu Anand', 'jobs'=>$jobs]);
    }
    public function faq(): void { $this->view('pages.faq', ['title'=>'FAQ — Vastu Anand']); }
    public function privacy(): void { $this->view('pages.privacy', ['title'=>'Privacy Policy — Vastu Anand']); }
    public function terms(): void { $this->view('pages.terms', ['title'=>'Terms & Conditions — Vastu Anand']); }

    public function gallery(): void {
        $items = Gallery::all() ?: array_map(fn($i)=>['image'=>asset("images/g{$i}.jpg"), 'caption'=>"Vastu Anand Gallery {$i}"], range(1,12));
        $this->view('pages.gallery', ['title'=>'Gallery — Vastu Anand', 'items'=>$items]);
    }

    public function testimonials(): void {
        $items = Testimonial::approved(24);
        if (empty($items)) {
            $items = [
                ['name'=>'Priya Sharma','role'=>'Home Buyer, Bandra','rating'=>5,'message'=>'Buying property in Mumbai can be stressful, but Vastu Anand made everything easy. Highly recommend their consultation services.'],
                ['name'=>'Rajesh Kumar','role'=>'Investor, BKC','rating'=>5,'message'=>'Their market insights helped me time my BKC investment perfectly. Transparent, ethical and deeply knowledgeable.'],
                ['name'=>'Sneha Deshmukh','role'=>'Home Buyer, Andheri','rating'=>5,'message'=>'Amazing experience buying our apartment in Andheri. The team guided us through every step.'],
                ['name'=>'Rohan Gupta','role'=>'NRI Investor, Dubai','rating'=>5,'message'=>'As an NRI, I needed someone trustworthy in Mumbai. Vastu Anand delivered beyond expectations.'],
                ['name'=>'Amit Patel','role'=>'Tenant, Powai','rating'=>5,'message'=>'Found a beautiful lake-view rental in Powai in just 4 days. Zero brokerage, full transparency.'],
                ['name'=>'Neha Kulkarni','role'=>'Seller, Worli','rating'=>5,'message'=>'They valued my Worli flat fairly and closed the deal in under 8 weeks. Professional from start to finish.'],
            ];
        }
        $this->view('pages.testimonials', ['title'=>'Client Testimonials — Vastu Anand', 'items'=>$items]);
    }
}
