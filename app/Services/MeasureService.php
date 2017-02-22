<?php

namespace App\Services;

class MeasureService
{
    const TOTAL_WIDTH = 28.83740234375;
    const LAST_VERSION_WIDTH = 78.35888671875;
    const DAY_WIDTH = 24.87890625;
    const WEEK_WIDTH = 33.6123046875;
    const DOWNLOADS_WIDTH = 58.37841796875;

    function measureTextWidth($text)
    {
        $charWidths = [
            'k' => 6.509765625,
            'M' => 9.2705078125,
            '0' => 6.9931640625,
            '1' => 6.9931640625,
            '2' => 6.9931640625,
            '3' => 6.9931640625,
            '4' => 6.9931640625,
            '5' => 6.9931640625,
            '6' => 6.9931640625,
            '7' => 6.9931640625,
            '8' => 6.9931640625,
            '9' => 6.9931640625,
        ];

        $chars = str_split($text);
        $width = 0;

        foreach ($chars as $char) {
            if (isset($charWidths[$char])) {
                $width += $charWidths[$char];
            }
        }

        return $width;
    }
}