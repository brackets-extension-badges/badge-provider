<?php

namespace App\Services;

class BadgeUtils
{
    const TOTAL = 'total';
    const LAST_VERSION = 'last-version';
    const WEEK = 'week';
    const DAY = 'day';

    const TOTAL_SUFFIX = ' total';
    const LAST_VERSION_SUFFIX = ' latest version';
    const WEEK_SUFFIX = '/week';
    const DAY_SUFFIX = '/day';

    const DOWNLOADS_WIDTH = 58.37841796875;
    const TOTAL_WIDTH = 28.83740234375;
    const LAST_VERSION_WIDTH = 78.35888671875;
    const WEEK_WIDTH = 33.6123046875;
    const DAY_WIDTH = 24.87890625;

    public static function measureTextWidth($text)
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

    public static function formatNumber($number)
    {
        if ($number < 10000) {
            $formatted = number_format(floor($number), 0, '', '');
        } else if ($number < 10000000) {
            $formatted = number_format(floor($number / 1000), 0, '', '') . 'k';
        } else {
            $formatted = number_format(floor($number / 1000000), 0, '', '') . 'M';
        }
        return $formatted;
    }

    public static function getSuffix($method)
    {
        switch ($method) {
            case self::TOTAL:
                return self::TOTAL_SUFFIX;
            case self::LAST_VERSION:
                return self::LAST_VERSION_SUFFIX;
            case self::WEEK:
                return self::WEEK_SUFFIX;
            case self::DAY:
                return self::DAY_SUFFIX;
        }
        return null;
    }

    public static function getSuffixWidth($method)
    {
        switch ($method) {
            case self::TOTAL:
                return self::TOTAL_WIDTH;
            case self::LAST_VERSION:
                return self::LAST_VERSION_WIDTH;
            case self::WEEK:
                return self::WEEK_WIDTH;
            case self::DAY:
                return self::DAY_WIDTH;
        }
        return null;
    }
}