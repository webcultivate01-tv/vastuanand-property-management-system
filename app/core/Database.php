<?php
namespace App\Core;

use MongoDB\Client;
use MongoDB\Database as MongoDatabase;

/**
 * MongoDB Atlas singleton.
 * Falls back gracefully if the extension or driver is unavailable so the
 * frontend can still render. Production deploys MUST install ext-mongodb
 * and the mongodb/mongodb composer package.
 */
final class Database
{
    private static ?Client $client = null;
    private static ?MongoDatabase $db = null;
    private static bool $available = false;

    public static function init(): void
    {
        if (self::$client !== null) return;
        if (!extension_loaded('mongodb') || !class_exists(Client::class)) {
            self::$available = false;
            return;
        }
        try {
            $cfg = config('database.connections.mongodb');
            self::$client = new Client($cfg['uri'], $cfg['options'] ?? [], $cfg['driverOptions'] ?? []);
            self::$db = self::$client->selectDatabase($cfg['database']);
            // smoke ping
            self::$db->command(['ping' => 1]);
            self::$available = true;
        } catch (\Throwable $e) {
            logger('error', 'MongoDB connect failed: ' . $e->getMessage());
            self::$available = false;
        }
    }

    public static function available(): bool {
        if (self::$client === null) self::init();
        return self::$available;
    }

    public static function db(): MongoDatabase
    {
        if (self::$client === null) self::init();
        if (!self::$available) {
            throw new \RuntimeException('MongoDB is not available. Check MONGO_URI and ext-mongodb.');
        }
        return self::$db;
    }

    public static function collection(string $name) {
        $map = config('database.collections', []);
        $resolved = $map[$name] ?? $name;
        return self::db()->selectCollection($resolved);
    }
}
