<?php
namespace App\Models;

use App\Core\Model;

final class Setting extends Model
{
    protected static string $collection = 'settings';

    public static function get(string $key, $default = null) {
        $doc = self::findBy(['key' => $key]);
        return $doc['value'] ?? $default;
    }

    public static function put(string $key, $value): void {
        $coll = self::collection();
        $coll->updateOne(['key' => $key], ['$set' => ['key' => $key, 'value' => $value, 'updatedAt' => new \MongoDB\BSON\UTCDateTime()]], ['upsert' => true]);
    }
}
