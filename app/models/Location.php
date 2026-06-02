<?php
namespace App\Models;

use App\Core\Model;

final class Location extends Model
{
    protected static string $collection = 'locations';

    public static function active(): array {
        return self::all(['active' => true], ['sort' => ['order' => 1, 'name' => 1]]);
    }
}
