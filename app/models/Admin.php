<?php
namespace App\Models;

use App\Core\Model;

final class Admin extends Model
{
    protected static string $collection = 'admins';

    public static function byEmail(string $email): ?array {
        return self::findBy(['email' => strtolower(trim($email))]);
    }
}
