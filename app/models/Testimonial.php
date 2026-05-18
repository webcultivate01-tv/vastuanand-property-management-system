<?php
namespace App\Models;

use App\Core\Model;

final class Testimonial extends Model
{
    protected static string $collection = 'testimonials';

    public static function approved(int $limit = 9): array {
        return self::all(['approved' => true], ['limit' => $limit, 'sort' => ['createdAt' => -1]]);
    }
}
