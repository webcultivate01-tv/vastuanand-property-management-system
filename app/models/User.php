<?php
namespace App\Models;

use App\Core\Model;

final class User extends Model
{
    protected static string $collection = 'users';

    public static function byEmail(string $email): ?array {
        return self::findBy(['email' => strtolower(trim($email))]);
    }
}
