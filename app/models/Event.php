<?php
namespace App\Models;

use App\Core\Model;

final class Event extends Model
{
    protected static string $collection = 'events';

    /**
     * Active events whose scheduled window includes "now".
     * - active flag must be on
     * - starts_at, if set, must be <= now
     * - ends_at, if set, must be >= now
     */
    public static function live(int $limit = 5): array
    {
        $now = date('Y-m-d H:i:s');
        $items = self::all(['active' => true], ['sort' => ['createdAt' => -1]]);
        $out = [];
        foreach ($items as $ev) {
            $start = trim((string)($ev['starts_at'] ?? ''));
            $end   = trim((string)($ev['ends_at']   ?? ''));
            if ($start !== '' && strcmp($start, $now) > 0) continue;
            if ($end   !== '' && strcmp($end,   $now) < 0) continue;
            $out[] = $ev;
            if (count($out) >= $limit) break;
        }
        return $out;
    }
}
