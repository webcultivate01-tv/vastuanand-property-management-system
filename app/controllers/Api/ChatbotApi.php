<?php
namespace App\Controllers\Api;

use App\Core\Controller;

/**
 * Lightweight rule-based concierge chatbot.
 * Provides instant first-touch responses and captures intent for the lead system.
 * Swap with an LLM provider in production by overriding reply().
 */
final class ChatbotApi extends Controller
{
    public function reply(): void
    {
        $msg = strtolower(trim((string)$this->request->input('message', '')));
        $reply = $this->match($msg);
        $this->json(['ok' => true, 'reply' => $reply]);
    }

    private function match(string $m): string
    {
        return match (true) {
            str_contains($m, 'buy')      => 'Lovely. Which area are you considering — Bandra, BKC, Powai, Worli or Navi Mumbai? Share your budget and we will curate a shortlist within 24 hours.',
            str_contains($m, 'rent')     => 'We have premium rentals across Mumbai with zero brokerage. Tell us your preferred location, budget and move-in date.',
            str_contains($m, 'sell')     => 'We can do a complimentary valuation. Please share the property address and approximate carpet area.',
            str_contains($m, 'nri')      => 'Our dedicated NRI desk handles virtual tours, legal, taxation and property management. Shall I connect you with our NRI advisor?',
            str_contains($m, 'emi') || str_contains($m, 'loan')
                                          => 'You can use our EMI calculator on the page, or share property cost and tenure — we will help you with pre-approved offers from leading banks.',
            str_contains($m, 'rera')      => 'Every property we list is RERA-verified. Visit the property page to view the RERA registration number.',
            str_contains($m, 'visit')     => 'Sure — share your phone number, preferred date and time. We will arrange a site visit with our advisor.',
            str_contains($m, 'contact') || str_contains($m, 'call')
                                          => 'Call us at +91 98765 43210 or WhatsApp the same number. We respond within 15 minutes during business hours.',
            default                       => 'Hi! I\'m Anand — your Vastu Anand concierge. Ask me about buying, renting, selling, NRI services or share your phone number to talk to a human advisor.',
        };
    }
}
