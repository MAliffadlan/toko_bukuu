<?php
/**
 * Generate Google-style avatar colors based on string
 * Returns a consistent color for the same string
 */
if (!function_exists('getAvatarColor')) {
    function getAvatarColor(string $str): array
    {
        // Google-style color palette
        $colors = [
            ['from' => '#f44336', 'to' => '#e91e63'], // Red
            ['from' => '#e91e63', 'to' => '#9c27b0'], // Pink
            ['from' => '#9c27b0', 'to' => '#673ab7'], // Purple
            ['from' => '#673ab7', 'to' => '#3f51b5'], // Deep Purple
            ['from' => '#3f51b5', 'to' => '#2196f3'], // Indigo
            ['from' => '#2196f3', 'to' => '#03a9f4'], // Blue
            ['from' => '#03a9f4', 'to' => '#00bcd4'], // Light Blue
            ['from' => '#00bcd4', 'to' => '#009688'], // Cyan
            ['from' => '#009688', 'to' => '#4caf50'], // Teal
            ['from' => '#4caf50', 'to' => '#8bc34a'], // Green
            ['from' => '#8bc34a', 'to' => '#cddc39'], // Light Green
            ['from' => '#ff9800', 'to' => '#ff5722'], // Orange
            ['from' => '#ff5722', 'to' => '#795548'], // Deep Orange
            ['from' => '#607d8b', 'to' => '#455a64'], // Blue Grey
        ];
        
        // Generate consistent index based on string hash
        $hash = crc32(strtolower($str));
        $index = abs($hash) % count($colors);
        
        return $colors[$index];
    }
}

if (!function_exists('getAvatarGradient')) {
    function getAvatarGradient(string $str): string
    {
        $color = getAvatarColor($str);
        return "background: linear-gradient(135deg, {$color['from']}, {$color['to']});";
    }
}

if (!function_exists('getAvatarTailwind')) {
    function getAvatarTailwind(string $str): string
    {
        // Tailwind color pairs for gradient
        $colors = [
            'from-red-500 to-pink-500',
            'from-pink-500 to-purple-500',
            'from-purple-500 to-indigo-500',
            'from-indigo-500 to-blue-500',
            'from-blue-500 to-cyan-500',
            'from-cyan-500 to-teal-500',
            'from-teal-500 to-green-500',
            'from-green-500 to-lime-500',
            'from-orange-500 to-red-500',
            'from-amber-500 to-orange-500',
            'from-lime-500 to-green-500',
            'from-emerald-500 to-teal-500',
            'from-sky-500 to-blue-500',
            'from-violet-500 to-purple-500',
            'from-fuchsia-500 to-pink-500',
            'from-rose-500 to-red-500',
        ];
        
        $hash = crc32(strtolower($str));
        $index = abs($hash) % count($colors);
        
        return $colors[$index];
    }
}

if (!function_exists('getInitials')) {
    function getInitials(string $name, int $length = 1): string
    {
        $words = explode(' ', trim($name));
        $initials = '';
        
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(mb_substr($word, 0, 1));
                if (strlen($initials) >= $length) break;
            }
        }
        
        return $initials ?: '?';
    }
}
