<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Lead;
use App\Models\Subscriber;
use App\Models\User;
use App\Models\PropertyView;
use App\Models\Testimonial;
use App\Helpers\Mailer;

final class ContactController extends Controller
{
    public function index(): void
    {
        $this->view('pages.contact', [
            'title'       => 'Contact Vastu Anand Real Estate | Get in Touch',
            'description' => 'Contact Vastu Anand for premium real estate services in Mumbai. Schedule a consultation, property viewing, or get expert advice.',
        ]);
    }

    public function submit(): void
    {
        $data = $this->validate([
            'name'    => 'required|min:2|max:80',
            'email'   => 'required|email',
            'phone'   => 'required|phone',
            'subject' => 'max:120',
            'message' => 'required|min:10|max:2000',
        ]);

        $lead = $data + [
            'source' => 'contact_form',
            'status' => 'new',
            'ip'     => $this->request->ip(),
            'ua'     => $this->request->userAgent(),
        ];

        try { Lead::create($lead); } catch (\Throwable $e) { logger('lead_error', $e->getMessage()); }

        $this->notifyTeam('Contact Form', $lead);

        if ($this->request->isAjax()) $this->json(['ok' => true, 'message' => 'Thank you. Our team will reach out within 24 hours.']);
        $this->flash('success', 'Thank you. Our team will reach out within 24 hours.');
        $this->redirect('/contact?sent=1');
    }

    public function inquiry(): void
    {
        $data = $this->validate([
            'name'        => 'required',
            'phone'       => 'required|phone',
            'email'       => 'email',
            'property_id' => 'required',
            'message'     => 'max:1000',
        ]);
        $data['property']      = (string)$this->request->input('property', '');
        $data['property_slug'] = (string)$this->request->input('property_slug', '');
        $data['source']        = 'property_inquiry';
        $data['status']        = 'new';
        try { Lead::create($data); } catch (\Throwable $e) { logger('lead_error', $e->getMessage()); }
        $this->notifyTeam('Property Inquiry', $data);
        $this->json(['ok' => true, 'message' => 'Inquiry received. Our advisor will call you shortly.']);
    }

    public function scheduleVisit(): void
    {
        $data = $this->validate([
            'name'        => 'required',
            'phone'       => 'required|phone',
            'email'       => 'email',
            'property_id' => 'required',
            'visit_date'  => 'required',
            'visit_time'  => 'required',
        ]);
        $data['source'] = 'schedule_visit';
        $data['status'] = 'new';
        try { Lead::create($data); } catch (\Throwable $e) { logger('lead_error', $e->getMessage()); }
        $this->notifyTeam('Site Visit Request', $data);
        $this->json(['ok' => true, 'message' => 'Visit scheduled. We will confirm on WhatsApp shortly.']);
    }

    /**
     * Gate the property detail page. Captures visitor info (name/email/phone)
     * before they can see the full listing, persists a User + PropertyView,
     * AND records an inquiry-style Lead linked to the property.
     */
    public function propertyAccess(): void
    {
        $data = $this->validate([
            'name'  => 'required|min:2|max:80',
            'email' => 'required|email',
            'phone' => 'required|phone',
        ]);
        $email = strtolower(trim($data['email']));
        $property      = trim((string)$this->request->input('property', ''));
        $propertySlug  = trim((string)$this->request->input('property_slug', ''));
        $propertyId    = trim((string)$this->request->input('property_id', ''));

        // Upsert user — match by email
        try {
            $existing = User::byEmail($email);
            $payload = [
                'name'               => $data['name'],
                'email'              => $email,
                'phone'              => $data['phone'],
                'last_property'      => $property,
                'last_property_slug' => $propertySlug,
                'last_property_id'   => $propertyId,
                'last_seen'          => date('Y-m-d H:i:s'),
                'ip'                 => $this->request->ip(),
                'ua'                 => $this->request->userAgent(),
            ];
            if ($existing) {
                $payload['views_count'] = (int)($existing['views_count'] ?? 0) + 1;
                User::update($existing['id'], $payload);
                $userId = $existing['id'];
            } else {
                $payload['views_count'] = 1;
                $created = User::create($payload);
                $userId  = (string)($created['id'] ?? '');
            }
        } catch (\Throwable $e) {
            $userId = '';
            logger('user_capture_error', $e->getMessage());
        }

        // Record this specific property view
        try {
            PropertyView::create([
                'user_id'        => $userId,
                'name'           => $data['name'],
                'email'          => $email,
                'phone'          => $data['phone'],
                'property_id'    => $propertyId,
                'property_title' => $property,
                'property_slug'  => $propertySlug,
                'ip'             => $this->request->ip(),
            ]);
        } catch (\Throwable $e) { logger('property_view_error', $e->getMessage()); }

        // Mirror into Leads so this becomes a normal inquiry too
        try {
            Lead::create([
                'name'          => $data['name'],
                'email'         => $email,
                'phone'         => $data['phone'],
                'property'      => $property,
                'property_slug' => $propertySlug,
                'property_id'   => $propertyId,
                'subject'       => 'Property detail viewed',
                'message'       => 'Visitor unlocked the detail page for "' . $property . '".',
                'source'        => 'property_view',
                'status'        => 'new',
                'ip'            => $this->request->ip(),
                'ua'            => $this->request->userAgent(),
            ]);
        } catch (\Throwable $e) { logger('lead_error', $e->getMessage()); }

        // Mark the visitor as having unlocked detail pages (cookie + session)
        $_SESSION['va_unlocked'] = true;
        $_SESSION['va_visitor']  = ['name' => $data['name'], 'email' => $email, 'phone' => $data['phone']];
        setcookie('va_unlocked', '1', [
            'expires'  => time() + 60 * 60 * 24 * 30,
            'path'     => '/',
            'samesite' => 'Lax',
        ]);

        if ($this->request->isAjax()) {
            $this->json(['ok' => true, 'message' => 'Thanks — full details are now visible.']);
        }
        $this->redirect($propertySlug ? '/property/' . $propertySlug : '/properties');
    }

    public function submitReview(): void
    {
        $data = $this->validate([
            'name'    => 'required|min:2|max:80',
            'role'    => 'max:120',
            'message' => 'required|min:10|max:1000',
            'rating'  => 'required|numeric',
        ]);

        $rating = max(1, min(5, (int)($data['rating'] ?? 5)));

        $payload = [
            'name'     => $data['name'],
            'role'     => trim((string)($data['role'] ?? '')),
            'message'  => $data['message'],
            'rating'   => $rating,
            'approved' => false,
            'avatar'   => '',
            'source'   => 'public_form',
            'ip'       => $this->request->ip(),
            'ua'       => $this->request->userAgent(),
        ];

        try { Testimonial::create($payload); } catch (\Throwable $e) { logger('review_error', $e->getMessage()); }
        $this->notifyTeam('New Review (pending approval)', $payload);

        if ($this->request->isAjax()) {
            $this->json(['ok' => true, 'message' => 'Thank you! Your review has been submitted and will be published after approval.']);
        }
        $this->flash('success', 'Thank you! Your review has been submitted and will be published after approval.');
        $this->redirect('/?review=submitted#testimonials');
    }

    public function newsletter(): void
    {
        $data = $this->validate(['email' => 'required|email']);
        try {
            Subscriber::create(['email' => strtolower($data['email']), 'active' => true]);
        } catch (\Throwable $e) { logger('news_error', $e->getMessage()); }
        if ($this->request->isAjax()) $this->json(['ok' => true, 'message' => 'Subscribed. Welcome to the Vastu Anand circle.']);
        $this->redirect('/?subscribed=1');
    }

    private function notifyTeam(string $kind, array $data): void
    {
        $to   = config('app.brand.email');
        $body = "<h3 style='color:#C9A35B'>New {$kind} — Vastu Anand</h3><table cellpadding='6'>";
        foreach ($data as $k => $v) {
            if (is_array($v)) $v = json_encode($v);
            $body .= "<tr><td><b>" . e(ucwords(str_replace('_',' ',$k))) . "</b></td><td>" . e((string)$v) . "</td></tr>";
        }
        $body .= "</table>";
        Mailer::send($to, "[Lead] {$kind} — {$data['name']}", $body);
    }
}
