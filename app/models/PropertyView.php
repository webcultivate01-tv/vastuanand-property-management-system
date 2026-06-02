<?php
namespace App\Models;

use App\Core\Model;

/**
 * Audit trail of who unlocked a property detail page and when.
 * Each row links a captured visitor (User) to the property they viewed.
 */
final class PropertyView extends Model
{
    protected static string $collection = 'property_views';
}
