<?php
/**
 * Vastu Anand — database seed.
 *
 * Usage:
 *   php database/seed.php
 *
 * Idempotent — re-running drops existing seed data and re-inserts.
 */

require_once __DIR__ . '/../app/core/Env.php';
require_once __DIR__ . '/../app/core/App.php';

\App\Core\App::boot(dirname(__DIR__));

use App\Core\Database;
use MongoDB\BSON\UTCDateTime;

if (!Database::available()) {
    fwrite(STDERR, "ERROR: MongoDB is not available. Check MONGO_URI in .env and that ext-mongodb is installed.\n");
    exit(1);
}

$now = new UTCDateTime();

echo "▶ Seeding Vastu Anand database…\n";

/* ───────── ADMIN USER ───────── */
$adminColl = Database::collection('admins');
$adminColl->deleteOne(['email' => strtolower(env('ADMIN_EMAIL', 'admin@vastuanandm.com'))]);
$adminColl->insertOne([
    'name'      => 'Vastu Anand Admin',
    'email'     => strtolower(env('ADMIN_EMAIL', 'admin@vastuanandm.com')),
    'password'  => password_hash(env('ADMIN_PASSWORD', 'ChangeMeNow#2025'), PASSWORD_BCRYPT),
    'role'      => 'super',
    'createdAt' => $now,
]);
echo "  ✓ Admin user created\n";

/* ───────── PROPERTIES ───────── */
$props = Database::collection('properties');
$props->deleteMany([]);
$properties = [
    [
        'slug'=>'luxury-apartment-bandra-west','title'=>'Luxury Apartment in Bandra West',
        'location'=>'Bandra West, Mumbai','listing'=>'sale','type'=>'Apartment',
        'bhk'=>4,'baths'=>4,'area'=>2400,'price'=>95000000,
        'cover'=>'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1200&q=80',
        'gallery'=>[
            'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1600&q=80',
            'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1600&q=80',
            'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1600&q=80',
        ],
        'description'=>'A premium luxury apartment located in the heart of Bandra West with excellent connectivity and breathtaking sea-facing views. Fully furnished, top-floor unit with private elevator and dedicated parking.',
        'amenities'=>['Swimming Pool','Gym','24x7 Security','Power Backup','Clubhouse','CCTV Surveillance','Private Elevator','Parking'],
        'tags'=>['Sea Facing','Ready to Move','Premium'],
        'featured'=>true,'status'=>'active',
    ],
    [
        'slug'=>'premium-villa-juhu','title'=>'Premium Villa in Juhu',
        'location'=>'Juhu, Mumbai','listing'=>'sale','type'=>'Villa',
        'bhk'=>5,'baths'=>6,'area'=>5200,'price'=>280000000,
        'cover'=>'https://images.unsplash.com/photo-1613490493576-7fde63acd811?auto=format&fit=crop&w=1200&q=80',
        'gallery'=>['https://images.unsplash.com/photo-1613490493576-7fde63acd811?auto=format&fit=crop&w=1600&q=80'],
        'description'=>'A magnificent private villa minutes from Juhu beach. Private pool, garden, home theatre, staff quarters and a 4-car garage.',
        'amenities'=>['Private Pool','Private Garden','Home Theatre','Staff Quarters','Smart Home','Solar'],
        'tags'=>['Private Pool','Garden','Beach Proximity'],
        'featured'=>true,'status'=>'active',
    ],
    [
        'slug'=>'commercial-office-bkc','title'=>'Commercial Office Space in BKC',
        'location'=>'BKC, Mumbai','listing'=>'lease','type'=>'Commercial',
        'bhk'=>0,'baths'=>4,'area'=>3500,'price'=>18000000,
        'cover'=>'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1200&q=80',
        'description'=>'Grade-A commercial office space in Bandra Kurla Complex suitable for corporates. IT-ready with raised flooring, on-site parking, and premium facility management.',
        'amenities'=>['IT Ready','Raised Flooring','Reserved Parking','24x7 Security','Cafeteria','High-speed Lifts'],
        'tags'=>['Grade A','IT Ready','Prime Location'],
        'featured'=>true,'status'=>'active',
    ],
    [
        'slug'=>'spacious-family-home-powai','title'=>'Spacious Family Home in Powai',
        'location'=>'Powai, Mumbai','listing'=>'sale','type'=>'Apartment',
        'bhk'=>3,'baths'=>3,'area'=>1750,'price'=>42000000,
        'cover'=>'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1200&q=80',
        'description'=>'Beautiful 3 BHK in a gated community overlooking Powai lake. Premium fittings, modular kitchen, balcony with lake view.',
        'amenities'=>['Lake View','Swimming Pool','Gym','Kids Play Area','Clubhouse','24x7 Security'],
        'tags'=>['Lake View','Family Home','Gated Community'],
        'featured'=>true,'status'=>'active',
    ],
    [
        'slug'=>'luxury-farmhouse-panvel','title'=>'Luxury Farmhouse near Panvel',
        'location'=>'Panvel, Navi Mumbai','listing'=>'sale','type'=>'Farmhouse',
        'bhk'=>4,'baths'=>4,'area'=>8000,'price'=>65000000,
        'cover'=>'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?auto=format&fit=crop&w=1200&q=80',
        'description'=>'Private 1-acre farmhouse with infinity pool, lawns, fruit orchard and guest cottage. Perfect weekend retreat from Mumbai.',
        'amenities'=>['Private Pool','1-Acre Plot','Guest Cottage','Fruit Orchard','Backup Generator'],
        'tags'=>['Greenery','Private Pool','Weekend Home'],
        'featured'=>true,'status'=>'active',
    ],
    [
        'slug'=>'studio-lower-parel','title'=>'Compact Studio Apartment in Lower Parel',
        'location'=>'Lower Parel, Mumbai','listing'=>'rent','type'=>'Studio',
        'bhk'=>1,'baths'=>1,'area'=>480,'price'=>75000,
        'cover'=>'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=1200&q=80',
        'description'=>'Fully furnished studio in the heart of Lower Parel — walking distance to Phoenix and Kamala Mills.',
        'amenities'=>['Fully Furnished','Gym','Security','Power Backup','High-speed Lifts'],
        'tags'=>['Furnished','Near Metro','Quick Occupancy'],
        'featured'=>true,'status'=>'active',
    ],
    [
        'slug'=>'penthouse-worli','title'=>'Sky Penthouse in Worli Sea Face',
        'location'=>'Worli, Mumbai','listing'=>'sale','type'=>'Penthouse',
        'bhk'=>5,'baths'=>5,'area'=>6500,'price'=>650000000,
        'cover'=>'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=1200&q=80',
        'description'=>'A landmark sky-residence on Worli Sea Face. Private rooftop, infinity pool, panoramic Bandra-Worli sea link views.',
        'amenities'=>['Infinity Pool','Private Terrace','Sea View','Smart Home','Concierge'],
        'tags'=>['Sea View','Sky Residence','Limited Edition'],
        'featured'=>true,'status'=>'active',
    ],
    [
        'slug'=>'andheri-east-3bhk','title'=>'Modern 3 BHK in Andheri East',
        'location'=>'Andheri East, Mumbai','listing'=>'sale','type'=>'Apartment',
        'bhk'=>3,'baths'=>3,'area'=>1450,'price'=>27500000,
        'cover'=>'https://images.unsplash.com/photo-1502672023488-70e25813eb80?auto=format&fit=crop&w=1200&q=80',
        'description'=>'Smart-home-ready 3 BHK with reserved parking, kid-friendly amenities and proximity to airport and metro.',
        'amenities'=>['Reserved Parking','Smart Home','Kids Area','Gym','Yoga Deck'],
        'tags'=>['Near Metro','Family','Smart Home'],
        'featured'=>false,'status'=>'active',
    ],
];
foreach ($properties as &$p) { $p['createdAt'] = $now; $p['updatedAt'] = $now; }
$props->insertMany($properties);
echo "  ✓ " . count($properties) . " properties seeded\n";

/* ───────── TESTIMONIALS ───────── */
$tColl = Database::collection('testimonials');
$tColl->deleteMany([]);
$tColl->insertMany([
    ['name'=>'Priya Sharma','role'=>'Home Buyer, Bandra','rating'=>5,'approved'=>true,'message'=>'Buying property in Mumbai can be stressful, but Vastu Anand made everything easy. Highly recommend their consultation services.','createdAt'=>$now],
    ['name'=>'Rajesh Kumar','role'=>'Investor, BKC','rating'=>5,'approved'=>true,'message'=>'Their market insights helped me time my BKC investment perfectly. Transparent, ethical and deeply knowledgeable.','createdAt'=>$now],
    ['name'=>'Sneha Deshmukh','role'=>'Home Buyer, Andheri','rating'=>5,'approved'=>true,'message'=>'Amazing experience buying our apartment in Andheri. The team guided us through every step and made the process very smooth.','createdAt'=>$now],
    ['name'=>'Rohan Gupta','role'=>'NRI Investor, Dubai','rating'=>5,'approved'=>true,'message'=>'As an NRI, I needed someone trustworthy in Mumbai. Vastu Anand delivered beyond expectations on the legal and documentation side.','createdAt'=>$now],
    ['name'=>'Amit Patel','role'=>'Tenant, Powai','rating'=>5,'approved'=>true,'message'=>'Found a beautiful lake-view rental in Powai in just 4 days. Zero brokerage, full transparency.','createdAt'=>$now],
    ['name'=>'Neha Kulkarni','role'=>'Seller, Worli','rating'=>5,'approved'=>true,'message'=>'They valued my Worli flat fairly and closed the deal in under 8 weeks. Professional from start to finish.','createdAt'=>$now],
    ['name'=>'Priya Verma','role'=>'Home Buyer, Thane','rating'=>5,'approved'=>true,'message'=>'A truly luxury-first experience. Patient, transparent and genuinely interested in finding the right home — not just any home.','createdAt'=>$now],
    ['name'=>'Rahul Sharma','role'=>'Investor, Navi Mumbai','rating'=>5,'approved'=>true,'message'=>'Their Navi Mumbai market research was the most thorough I have seen. Helped me pick a clear winner for the next 5 years.','createdAt'=>$now],
]);
echo "  ✓ 8 testimonials seeded\n";

/* ───────── BLOGS ───────── */
$bColl = Database::collection('blogs');
$bColl->deleteMany([]);
$bColl->insertMany([
    [
        'slug'=>'first-time-home-buyers-mumbai',
        'title'=>'10 Tips for First-Time Home Buyers in Mumbai',
        'excerpt'=>'Essential guide for first-time home buyers in Mumbai. Learn about budgeting, pre-approvals, location selection, builder verification and legal documentation for a confident property purchase.',
        'cover'=>'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1200&q=80',
        'category'=>'Buying Guide',
        'readTime'=>'8 min',
        'author'=>'Vastu Anand Team',
        'body'=>'<p>Buying your first home in Mumbai is both an emotional milestone and a significant financial commitment. With rising property prices, complex documentation, and endless project choices, many first-time buyers feel overwhelmed before they even begin.</p><p>A pre-approved loan gives clarity on eligibility and strengthens your position during negotiations. It also saves time once you finalize a property.</p><p>Compare properties based on carpet area — the actual usable space inside your home — rather than built-up or super built-up area.</p><p>Ensure the project is RERA registered and all approvals are in place. Legal clarity protects your investment in the long run.</p>',
        'published'=>true,'publishedAt'=>$now,'createdAt'=>$now,
    ],
    [
        'slug'=>'mumbaiInvestment',
        'title'=>'Mumbai\'s Best Investment Neighborhoods 2025',
        'excerpt'=>'Discover the best Mumbai neighborhoods for real estate investment in 2025. Analysis of Bandra, Powai, Thane, and Navi Mumbai with rental yields, pricing, and growth potential.',
        'cover'=>'https://images.unsplash.com/photo-1570168007204-dfb528c6958f?auto=format&fit=crop&w=1200&q=80',
        'category'=>'Investment',
        'readTime'=>'10 min',
        'author'=>'Vastu Anand Team',
        'body'=>'<p>Choosing the right neighborhood based on your risk appetite, budget, and investment horizon can help you build a resilient real estate portfolio in Mumbai\'s evolving market.</p><h3>Bandra — Premium &amp; Stable Returns</h3><p>Bandra continues to attract high-net-worth individuals and corporate tenants due to its central location, lifestyle amenities, and strong social infrastructure.</p><h3>Powai — Balanced Yield</h3><p>Entry prices remain relatively lower than South Mumbai, while rental yields average between 3–3.5%, making Powai a balanced option.</p><p>Each of these micro-markets serves a different investor profile.</p>',
        'published'=>true,'publishedAt'=>$now,'createdAt'=>$now,
    ],
    [
        'slug'=>'propertydocumentation',
        'title'=>'Property Documentation in India — A Complete Guide',
        'excerpt'=>'Complete guide to property documentation in India. Learn about sale deeds, title search, encumbrance certificates, RERA registration, and common legal red flags to avoid.',
        'cover'=>'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1200&q=80',
        'category'=>'Legal',
        'readTime'=>'12 min',
        'author'=>'Vastu Anand Team',
        'body'=>'<p>A title search verifies whether the seller has a clear and marketable title. Lawyers typically examine ownership records over the past 30 years.</p><p>An Encumbrance Certificate (EC) confirms whether the property is free from loans, legal disputes, or liabilities. Buyers should also verify occupancy certificates, building approvals, and RERA registration.</p>',
        'published'=>true,'publishedAt'=>$now,'createdAt'=>$now,
    ],
]);
echo "  ✓ 3 blog articles seeded\n";

/* ───────── GALLERY ───────── */
$gColl = Database::collection('gallery');
$gColl->deleteMany([]);
$gallery = [];
foreach ([
    'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9',
    'https://images.unsplash.com/photo-1613490493576-7fde63acd811',
    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c',
    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c',
    'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688',
    'https://images.unsplash.com/photo-1497366216548-37526070297c',
    'https://images.unsplash.com/photo-1502672023488-70e25813eb80',
    'https://images.unsplash.com/photo-1582407947304-fd86f028f716',
    'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3',
    'https://images.unsplash.com/photo-1600585154526-990dced4db0d',
    'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00',
    'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde',
] as $i => $img) {
    $gallery[] = ['image'=>$img.'?auto=format&fit=crop&w=900&q=80','caption'=>"Vastu Anand Portfolio #" . ($i+1),'category'=>'Properties','createdAt'=>$now];
}
$gColl->insertMany($gallery);
echo "  ✓ " . count($gallery) . " gallery images seeded\n";

/* ───────── CAREERS ───────── */
$cColl = Database::collection('careers');
$cColl->deleteMany([]);
$cColl->insertMany([
    ['title'=>'Senior Property Advisor','dept'=>'Sales','location'=>'Mumbai','type'=>'Full-time','description'=>'Lead client relationships across Bandra, BKC and Worli. 5+ years luxury sales experience.','active'=>true,'createdAt'=>$now],
    ['title'=>'Luxury Sales Specialist','dept'=>'Sales','location'=>'BKC, Mumbai','type'=>'Full-time','description'=>'Off-market & pre-launch luxury inventory. RERA-trained. HNI experience preferred.','active'=>true,'createdAt'=>$now],
    ['title'=>'Marketing Manager','dept'=>'Marketing','location'=>'Mumbai','type'=>'Full-time','description'=>'Own brand, content and performance marketing for Mumbai\'s most discerning real-estate brand.','active'=>true,'createdAt'=>$now],
    ['title'=>'Property Photographer','dept'=>'Creative','location'=>'Mumbai','type'=>'Freelance','description'=>'Premium architectural & interior photography for luxury listings. Drone licence a plus.','active'=>true,'createdAt'=>$now],
]);
echo "  ✓ 4 career postings seeded\n";

/* ───────── SETTINGS ───────── */
$sColl = Database::collection('settings');
foreach ([
    'hero_headline' => 'Find Your Perfect Address in Mumbai\'s Finest Locations.',
    'hero_subtitle' => 'Curated luxury apartments, sea-facing penthouses and private villas — handpicked across Bandra, BKC, Powai, Worli and beyond.',
    'phone_primary' => '+91 9876543210',
    'whatsapp_number' => '919876543210',
    'email_primary' => 'info@vastuanandm.com',
    'instagram_url' => 'https://instagram.com/vastuanand',
    'facebook_url'  => 'https://facebook.com/vastuanand',
    'linkedin_url'  => 'https://linkedin.com/company/vastuanand',
    'youtube_url'   => 'https://youtube.com/@vastuanand',
    'rera_number'   => 'A51900012345',
    'seo_default_title' => 'Vastu Anand — Luxury Real Estate Mumbai',
    'seo_default_desc'  => 'Premium real estate in Mumbai. RERA-verified luxury apartments, villas, penthouses & commercial spaces.',
] as $k => $v) {
    $sColl->updateOne(['key' => $k], ['$set' => ['key' => $k, 'value' => $v, 'updatedAt' => $now]], ['upsert' => true]);
}
echo "  ✓ Site settings seeded\n";

echo "\n✅ Done. Visit http://localhost:8000 to view the site.\n";
echo "   Admin: http://localhost:8000/admin/login\n";
echo "   Email: " . env('ADMIN_EMAIL') . "\n";
echo "   Pass:  " . env('ADMIN_PASSWORD') . "\n";
