<?php
namespace App\Models;

use App\Core\Model;

final class Career extends Model
{
    protected static string $collection = 'careers';

    public static function open(): array {
        return self::all(['active' => true], ['sort' => ['createdAt' => -1]]);
    }
}
