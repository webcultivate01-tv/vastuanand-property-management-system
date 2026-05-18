<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Lead;
use App\Models\Subscriber;
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
        $data['source'] = 'property_inquiry';
        $data['status'] = 'new';
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
