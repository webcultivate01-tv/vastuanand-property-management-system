<?php
namespace App\Models;

use App\Core\Model;

/**
 * Unified search-filter field definition.
 *
 * One document per filter field on the home / listing search box.
 *
 * Shape:
 *   key             string  — machine key (used as URL param + field name)
 *   label           string  — display label
 *   type            string  — 'select' | 'text' | 'number'
 *   placeholder     string  — optional placeholder for text fields
 *   options         array   — [{label, value, hide: [keys]}] (only for type=select)
 *   show_in_hero    bool    — render on home page quick-search
 *   show_in_listing bool    — render on /properties listing filter
 *   order           int
 *   active          bool
 */
final class FilterField extends Model
{
    protected static string $collection = 'filter_fields';

    public static function hero(): array {
        return self::all(
            ['active' => true, 'show_in_hero' => true],
            ['sort' => ['order' => 1, 'label' => 1]]
        );
    }

    public static function listing(): array {
        return self::all(
            ['active' => true, 'show_in_listing' => true],
            ['sort' => ['order' => 1, 'label' => 1]]
        );
    }

    public static function byKey(string $key): ?array {
        return self::findBy(['key' => $key]);
    }
}
