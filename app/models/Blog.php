<?php
namespace App\Models;

use App\Core\Model;

final class Blog extends Model
{
    protected static string $collection = 'blogs';

    public static function bySlug(string $slug): ?array {
        return self::findBy(['slug' => $slug, 'published' => true]);
    }

    public static function latest(int $limit = 3): array {
        return self::all(['published' => true], ['limit' => $limit, 'sort' => ['publishedAt' => -1]]);
    }
}
