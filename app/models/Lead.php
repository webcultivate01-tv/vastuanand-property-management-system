<?php
namespace App\Models;

use App\Core\Model;

final class Lead extends Model
{
    protected static string $collection = 'leads';

    public static function sources(): array {
        return ['contact_form', 'property_inquiry', 'schedule_visit', 'newsletter', 'whatsapp', 'phone', 'chat', 'mortgage_calc'];
    }
    public static function statusList(): array {
        return ['new', 'contacted', 'qualified', 'visit_scheduled', 'negotiation', 'won', 'lost'];
    }
}
