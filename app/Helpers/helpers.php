<?php

use App\Enums\SettingKey;
use App\Models\Admin\SiteSetting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;

/**
 * Single entry point: checks route name match (exact or wildcard)
 * and URL path match (for slash-based wildcards), so you only ever
 * call this one function from your views.
 *
 * Usage in blade:
 *   isActive('products.catalogue')   -> exact route name
 *   isActive('products.*')           -> wildcard route name (parent)
 *   isActive('products/*')           -> wildcard URL path (parent, alt format)
 */
function isActive($patterns): bool
{
    foreach ((array) $patterns as $pattern) {
        if (routePatternMatches($pattern)) {
            return true;
        }
    }
    return false;
}

/**
 * Internal helper — not used directly in views.
 * Decides whether the pattern is a route-name pattern or a URL-path pattern,
 * then runs the matching check.
 */
function routePatternMatches(string $pattern): bool
{
    // If it contains a slash, treat it as a URL path pattern (e.g. "products/*")
    if (str_contains($pattern, '/')) {
        return request()->is($pattern);
    }

    // Otherwise treat it as a route name pattern (e.g. "products.*" or "products.catalogue")
    return request()->routeIs($pattern);
}

if (! function_exists('setting')) {
    function setting(SettingKey|string $key, mixed $default = null): mixed
    {
        return SiteSetting::get($key, $default);
    }
}

if (!function_exists('format_date')) {
    function format_date($date, $format = 'd M Y', $blank = '--')
    {
        if (empty($date)) {
            return $blank;
        }

        try {
            return Carbon::parse($date)->format($format);
        } catch (Exception  $err) {
            return $blank;
        }
    }
}

if (! function_exists('getStatusRing')) {
    function getStatusRing(?string $status): string
    {
        return match (strtolower((string) $status)) {
            'active'    => 'avatar-active',
            'pending'   => 'avatar-pending',
            'rejected'  => 'avatar-rejected',
            'suspended' => 'avatar-suspended',
            'banned'    => 'avatar-banned',
            default     => '',
        };
    }
}

if (!function_exists('getImageUrl')) {
    /**
     * Public URL for a file on the "public" disk, or null when there is no image.
     * Full URLs (http/https) are passed through untouched.
     */
    function getImageUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        return Storage::url($path);
    }
}

if (!function_exists('getInitials')) {
    /**
     * First letter of the first and last name: "Cally Wiley" => "CW".
     * A single name gives one letter: "Vendor" => "V".
     */
    function getInitials(?string $name, string $fallback = 'V'): string
    {
        $parts = preg_split('/\s+/', trim((string) $name), -1, PREG_SPLIT_NO_EMPTY);

        if (!$parts) {
            return $fallback;
        }

        $first = mb_substr($parts[0], 0, 1);
        $last  = count($parts) > 1 ? mb_substr(end($parts), 0, 1) : '';

        return mb_strtoupper($first . $last);
    }
}

if (!function_exists('getAvatarColor')) {
    /**
     * Stable background/text colour pair for a seed (uuid or name),
     * so the same vendor always gets the same colour everywhere.
     */
    function getAvatarColor(?string $seed): array
    {
        $palette = [
            ['bg' => '#e0e7ff', 'text' => '#3730a3'],
            ['bg' => '#ede9fe', 'text' => '#6d28d9'],
            ['bg' => '#dbeafe', 'text' => '#1d4ed8'],
            ['bg' => '#d1fae5', 'text' => '#047857'],
            ['bg' => '#cffafe', 'text' => '#0e7490'],
            ['bg' => '#fef3c7', 'text' => '#b45309'],
            ['bg' => '#fce7f3', 'text' => '#be185d'],
            ['bg' => '#ffedd5', 'text' => '#c2410c'],
        ];

        return $palette[crc32((string) $seed) % count($palette)];
    }
}