<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Response;
use App\Models\Blog;

final class BlogController extends Controller
{
    public function index(): void
    {
        $page    = max(1, (int)($_GET['page'] ?? 1));
        $result  = Blog::paginate(['published' => true], $page, 9, ['publishedAt' => -1]);
        if (empty($result['data'])) $result['data'] = $this->fallback();
        $this->view('pages.blog', [
            'title'  => 'Real Estate Blog — Vastu Anand',
            'description' => 'Mumbai property market insights, investment guides, legal articles & home-buying advice from Vastu Anand experts.',
            'result' => $result,
        ]);
    }

    public function show(string $slug): void
    {
        $blog = Blog::bySlug($slug);
        if (!$blog) {
            $blog = array_filter($this->fallback(), fn($b) => $b['slug'] === $slug);
            $blog = $blog ? array_values($blog)[0] : null;
        }
        if (!$blog) Response::notFound();
        $this->view('pages.blog-detail', ['title' => $blog['title'] . ' — Vastu Anand', 'blog' => $blog]);
    }

    private function fallback(): array
    {
        return [
            ['slug'=>'first-time-home-buyers-mumbai','title'=>'10 Tips for First-Time Home Buyers in Mumbai','excerpt'=>'Essential guide for first-time home buyers — budgeting, pre-approvals, location, builder verification & legal documentation.','cover'=>asset('images/b1.jpg'),'publishedAt'=>'2025-01-15','readTime'=>'8 min','category'=>'Buying Guide','author'=>'Vastu Anand Team','body'=>'<p>Buying your first home in Mumbai is both an emotional milestone and a significant financial commitment...</p>'],
            ['slug'=>'mumbaiInvestment','title'=>'Mumbai\'s Best Investment Neighborhoods 2025','excerpt'=>'Bandra, Powai, Thane, Navi Mumbai — entry prices, rental yields and 3–5 year outlook.','cover'=>asset('images/b2.jpg'),'publishedAt'=>'2025-01-10','readTime'=>'10 min','category'=>'Investment','author'=>'Vastu Anand Team','body'=>'<p>Choosing the right neighborhood based on your risk appetite, budget, and investment horizon can help you build a resilient real estate portfolio...</p>'],
            ['slug'=>'propertydocumentation','title'=>'Property Documentation in India — A Complete Guide','excerpt'=>'Sale deeds, title search, encumbrance certificates, RERA registration and common legal red flags.','cover'=>asset('images/b3.jpg'),'publishedAt'=>'2025-01-05','readTime'=>'12 min','category'=>'Legal','author'=>'Vastu Anand Team','body'=>'<p>Complete guide to property documentation in India. Learn about sale deeds, title search...</p>'],
        ];
    }
}
