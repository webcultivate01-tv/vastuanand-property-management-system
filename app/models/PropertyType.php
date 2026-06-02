<?php
namespace App\Models;

use App\Core\Model;

final class PropertyType extends Model
{
    protected static string $collection = 'property_types';

    public static function active(): array {
        return self::all(['active' => true], ['sort' => ['order' => 1, 'name' => 1]]);
    }
}
