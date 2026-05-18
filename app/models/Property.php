<?php
namespace App\Models;

use App\Core\Model;
use MongoDB\BSON\Regex;

final class Property extends Model
{
    protected static string $collection = 'properties';

    public static function statuses(): array { return ['sale', 'rent', 'lease']; }
    public static function types(): array {
        return ['Apartment', 'Villa', 'Penthouse', 'Builder Floor', 'Studio', 'Farmhouse', 'Townhouse', 'Commercial', 'Plot'];
    }
    public static function locations(): array {
        return [
            'Bandra West', 'Bandra East', 'Juhu', 'Powai', 'Worli', 'Lower Parel',
            'Andheri West', 'Andheri East', 'BKC', 'Malad', 'Goregaon',
            'Thane', 'Navi Mumbai', 'Panvel', 'Kalyan', 'Amravati',
        ];
    }

    public static function filter(array $query, int $page = 1, int $perPage = 12): array
    {
        $filter = ['status' => ['$ne' => 'archived']];

        if (!empty($query['listing']))   $filter['listing']   = $query['listing'];                        // sale/rent/lease
        if (!empty($query['type']))      $filter['type']      = $query['type'];
        if (!empty($query['location']))  $filter['location']  = new Regex(preg_quote($query['location']), 'i');
        if (!empty($query['bhk']))       $filter['bhk']       = (int) $query['bhk'];
        if (!empty($query['featured']))  $filter['featured']  = true;

        if (!empty($query['min']) || !empty($query['max'])) {
            $price = [];
            if (!empty($query['min'])) $price['$gte'] = (float) $query['min'];
            if (!empty($query['max'])) $price['$lte'] = (float) $query['max'];
            $filter['price'] = $price;
        }

        if (!empty($query['q'])) {
            $rx = new Regex(preg_quote($query['q']), 'i');
            $filter['$or'] = [
                ['title'       => $rx],
                ['location'    => $rx],
                ['description' => $rx],
                ['tags'        => $rx],
            ];
        }

        $sort = match ($query['sort'] ?? '') {
            'price_low'  => ['price' => 1],
            'price_high' => ['price' => -1],
            'oldest'     => ['createdAt' => 1],
            default      => ['createdAt' => -1],
        };

        return self::paginate($filter, $page, $perPage, $sort);
    }

    public static function featured(int $limit = 6): array
    {
        return self::all(['featured' => true, 'status' => ['$ne' => 'archived']], ['limit' => $limit, 'sort' => ['createdAt' => -1]]);
    }

    public static function similar(array $property, int $limit = 4): array
    {
        if (empty($property) || !\App\Core\Database::available()) return [];
        $filter = [
            'type'    => $property['type']    ?? null,
            'listing' => $property['listing'] ?? null,
        ];
        try {
            if (!empty($property['id'])) {
                $filter['_id'] = ['$ne' => new \MongoDB\BSON\ObjectId($property['id'])];
            }
        } catch (\Throwable $e) {
            // demo id — skip the _id filter
        }
        return self::all(array_filter($filter), ['limit' => $limit, 'sort' => ['createdAt' => -1]]);
    }

    public static function bySlug(string $slug): ?array
    {
        return self::findBy(['slug' => $slug]);
    }
}
