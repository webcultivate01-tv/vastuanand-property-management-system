<?php
namespace App\Core;

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

/**
 * Base ActiveRecord-lite model for MongoDB.
 * Subclasses just declare static $collection.
 */
abstract class Model
{
    protected static string $collection = '';

    public static function collection() {
        return Database::collection(static::$collection);
    }

    /** ------------- READ ------------- */

    public static function all(array $filter = [], array $options = []): array
    {
        if (!Database::available()) return [];
        $cur = static::collection()->find($filter, $options);
        return array_map([static::class, 'cast'], iterator_to_array($cur, false));
    }

    public static function paginate(array $filter = [], int $page = 1, int $perPage = 12, array $sort = ['createdAt' => -1]): array
    {
        if (!Database::available()) return ['data' => [], 'total' => 0, 'page' => $page, 'pages' => 0, 'per_page' => $perPage];
        $page = max(1, $page);
        $total = static::collection()->countDocuments($filter);
        $cur   = static::collection()->find($filter, [
            'skip'  => ($page - 1) * $perPage,
            'limit' => $perPage,
            'sort'  => $sort,
        ]);
        return [
            'data'     => array_map([static::class, 'cast'], iterator_to_array($cur, false)),
            'total'    => $total,
            'page'     => $page,
            'pages'    => max(1, (int) ceil($total / $perPage)),
            'per_page' => $perPage,
        ];
    }

    public static function find(string $id): ?array
    {
        if (!Database::available()) return null;
        try { $oid = new ObjectId($id); } catch (\Throwable $e) { return null; }
        $doc = static::collection()->findOne(['_id' => $oid]);
        return $doc ? static::cast($doc) : null;
    }

    public static function findBy(array $filter): ?array
    {
        if (!Database::available()) return null;
        $doc = static::collection()->findOne($filter);
        return $doc ? static::cast($doc) : null;
    }

    public static function count(array $filter = []): int
    {
        if (!Database::available()) return 0;
        return (int) static::collection()->countDocuments($filter);
    }

    /** ------------- WRITE ------------- */

    public static function create(array $data): array
    {
        $now = new UTCDateTime();
        $data['createdAt'] = $now;
        $data['updatedAt'] = $now;
        $result = static::collection()->insertOne($data);
        $data['_id'] = $result->getInsertedId();
        return static::cast($data);
    }

    public static function update(string $id, array $data): bool
    {
        try { $oid = new ObjectId($id); } catch (\Throwable $e) { return false; }
        $data['updatedAt'] = new UTCDateTime();
        $r = static::collection()->updateOne(['_id' => $oid], ['$set' => $data]);
        return $r->getModifiedCount() > 0;
    }

    public static function delete(string $id): bool
    {
        try { $oid = new ObjectId($id); } catch (\Throwable $e) { return false; }
        return static::collection()->deleteOne(['_id' => $oid])->getDeletedCount() > 0;
    }

    /** ------------- AGGREGATE / SEARCH ------------- */

    public static function aggregate(array $pipeline): array
    {
        if (!Database::available()) return [];
        return iterator_to_array(static::collection()->aggregate($pipeline), false);
    }

    /** ------------- CASTING ------------- */

    public static function cast($doc): array
    {
        $doc = is_object($doc) ? (array) $doc : $doc;
        if (isset($doc['_id']) && $doc['_id'] instanceof ObjectId) {
            $doc['id']  = (string) $doc['_id'];
            $doc['_id'] = (string) $doc['_id'];
        }
        foreach ($doc as $k => $v) {
            if ($v instanceof UTCDateTime)        $doc[$k] = $v->toDateTime()->format('Y-m-d H:i:s');
            elseif (is_object($v))                $doc[$k] = json_decode(json_encode($v), true);
        }
        return $doc;
    }
}
