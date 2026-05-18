<?php
namespace App\Controllers\Api;

use App\Core\Controller;
use App\Models\Lead;
use App\Models\Subscriber;
use App\Helpers\Mailer;

final class LeadApi extends Controller
{
    public function contact(): void  { $this->capture('contact_form'); }
    public function inquiry(): void  { $this->capture('property_inquiry'); }
    public function scheduleVisit(): void { $this->capture('schedule_visit'); }

    public function newsletter(): void
    {
        $data = $this->validate(['email' => 'required|email']);
        Subscriber::create(['email' => strtolower($data['email']), 'active' => true]);
        $this->json(['ok' => true, 'message' => 'Subscribed.']);
    }

    private function capture(string $source): void
    {
        $data = $this->validate([
            'name'    => 'required|min:2|max:80',
            'phone'   => 'required|phone',
            'email'   => 'email',
            'message' => 'max:2000',
        ]);
        $data['source'] = $source;
        $data['status'] = 'new';
        $data['ip']     = $this->request->ip();
        try { Lead::create($data); } catch (\Throwable $e) { logger('lead_api', $e->getMessage()); }
        Mailer::send(config('app.brand.email'), "[Lead] {$source}", json_encode($data));
        $this->json(['ok' => true, 'message' => 'Received. Our advisor will reach out shortly.']);
    }
}
