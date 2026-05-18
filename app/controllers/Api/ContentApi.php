<?php
namespace App\Controllers\Api;

use App\Core\Controller;
use App\Models\Blog;
use App\Models\Testimonial;
use App\Models\Gallery;

final class ContentApi extends Controller
{
    public function blogs(): void {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $this->json(['ok' => true, 'data' => Blog::paginate(['published' => true], $page, 9, ['publishedAt' => -1])]);
    }
    public function blog(string $slug): void {
        $b = Blog::bySlug($slug);
        $b ? $this->json(['ok' => true, 'data' => $b]) : $this->json(['ok' => false], 404);
    }
    public function testimonials(): void {
        $this->json(['ok' => true, 'data' => Testimonial::approved((int)($_GET['limit'] ?? 12))]);
    }
    public function gallery(): void {
        $this->json(['ok' => true, 'data' => Gallery::all()]);
    }
    public function faqs(): void {
        $this->json(['ok' => true, 'data' => self::FAQS]);
    }

    public const FAQS = [
        ['q' => 'Can you help if I\'m looking to rent a property?', 'a' => 'Absolutely. We assist with rentals across Bandra, Andheri, Powai, Worli & Navi Mumbai — with verified tenant screening, legal agreements and zero-brokerage options.'],
        ['q' => 'Are all properties RERA verified?', 'a' => 'Every project listed on Vastu Anand goes through a RERA-registration check and legal-title verification before being published.'],
        ['q' => 'Do you offer services for NRI clients?', 'a' => 'Yes — we offer end-to-end NRI services: virtual site visits, video walkthroughs, legal & tax compliance, ongoing property management and remote ownership support.'],
        ['q' => 'How do you price a property when I want to sell?', 'a' => 'We conduct a free professional valuation using recent transaction data, micro-market trends, project quality, floor premium and view premium.'],
        ['q' => 'What documents are required to buy a property in Mumbai?', 'a' => 'Sale agreement, title deed, encumbrance certificate, RERA registration, occupancy certificate, society NOC, parking allocation letter and bank loan documents if applicable.'],
        ['q' => 'How long does the buying process take?', 'a' => 'Typically 4–8 weeks from offer to registration, depending on bank loan timelines and society approvals.'],
    ];
}
