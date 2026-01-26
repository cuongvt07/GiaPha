<?php

namespace App\Helpers;

use Carbon\Carbon;
use LucNham\LunarCalendar\LunarDateTime;
use LucNham\LunarCalendar\Sexagenary;
use LucNham\LunarCalendar\Terms\VnBranchIdentifier;
use LucNham\LunarCalendar\Terms\VnStemIdentifier;

class LunarHelper
{
    /**
     * Convert Solar date to Lunar date array [day, month, year, isLeap]
     */
    public static function convertSolarToLunar($solarDate)
    {
        if (is_string($solarDate)) {
            $solarDate = Carbon::parse($solarDate);
        }

        $lunar = LunarDateTime::fromGregorian($solarDate->format('Y-m-d H:i:s'));

        return [
            $lunar->day,
            $lunar->month,
            $lunar->year,
            $lunar->isLeapMonth
        ];
    }

    /**
     * Get the Solar date for a specific Lunar Day/Month in a target Solar Year
     */
    public static function getSolarDateForYear($lunarDay, $lunarMonth, $year)
    {
        try {
            // Use Y-m-d format for better compatibility with date_parse
            $lunarStr = sprintf('%04d-%02d-%02d', $year, $lunarMonth, $lunarDay);
            $lunar = new LunarDateTime($lunarStr);

            $solarStr = $lunar->toDateTimeString();
            $solar = Carbon::parse($solarStr);

            // Handle edge cases where the converted solar date falls outside the desired year
            if ($solar->year < $year) {
                $lunarNext = new LunarDateTime(sprintf('%04d-%02d-%02d', $year + 1, $lunarMonth, $lunarDay));
                $solar = Carbon::parse($lunarNext->toDateTimeString());
            } elseif ($solar->year > $year) {
                $lunarPrev = new LunarDateTime(sprintf('%04d-%02d-%02d', $year - 1, $lunarMonth, $lunarDay));
                $solar = Carbon::parse($lunarPrev->toDateTimeString());
            }

            return $solar;
        } catch (\Exception $e) {
            \Log::error("Lunar conversion error for $lunarDay/$lunarMonth/$year: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get the Can Chi (Sexagenary) name for a date
     */
    public static function getCanChi($date, $type = 'year')
    {
        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        $lunar = LunarDateTime::fromGregorian($date->format('Y-m-d H:i:s'));
        $sexagenary = new Sexagenary(
            lunar: $lunar,
            stemIdetifier: VnStemIdentifier::class,
            branchIdentifier: VnBranchIdentifier::class
        );

        return match ($type) {
            'year' => $sexagenary->format('[Y+]'),
            'month' => $sexagenary->format('[M+]'),
            'day' => $sexagenary->format('[D+]'),
            'hour' => $sexagenary->format('[H+]'),
            default => $sexagenary->format('[Y+]'),
        };
    }

    /**
     * Get Lucky Hours (Giờ Hoàng Đạo) for a given date
     */
    public static function getLuckyHours($date)
    {
        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        $lunar = LunarDateTime::fromGregorian($date->format('Y-m-d H:i:s'));
        $sexagenary = new Sexagenary(
            lunar: $lunar,
            stemIdetifier: VnStemIdentifier::class,
            branchIdentifier: VnBranchIdentifier::class
        );

        // Branch of the day
        $dayBranch = $sexagenary->d->name; // e.g., "Tý", "Sửu"...

        // Standard Hoang Dao mapping
        $mapping = [
            'Tý' => ['Tý', 'Sửu', 'Mão', 'Ngọ', 'Thân', 'Dậu'],
            'Ngọ' => ['Tý', 'Sửu', 'Mão', 'Ngọ', 'Thân', 'Dậu'],
            'Sửu' => ['Dần', 'Mão', 'Tỵ', 'Thân', 'Tuất', 'Hợi'],
            'Mùi' => ['Dần', 'Mão', 'Tỵ', 'Thân', 'Tuất', 'Hợi'],
            'Dần' => ['Tý', 'Sửu', 'Thìn', 'Tỵ', 'Mùi', 'Tuất'],
            'Thân' => ['Tý', 'Sửu', 'Thìn', 'Tỵ', 'Mùi', 'Tuất'],
            'Mão' => ['Dần', 'Thìn', 'Tỵ', 'Thân', 'Dậu', 'Hợi'],
            'Dậu' => ['Dần', 'Thìn', 'Tỵ', 'Thân', 'Dậu', 'Hợi'],
            'Thìn' => ['Dần', 'Thìn', 'Tỵ', 'Mùi', 'Dậu', 'Hợi'],
            'Tuất' => ['Dần', 'Thìn', 'Tỵ', 'Mùi', 'Dậu', 'Hợi'],
            'Tỵ' => ['Sửu', 'Thìn', 'Ngọ', 'Mùi', 'Tuất', 'Hợi'],
            'Hợi' => ['Sửu', 'Thìn', 'Ngọ', 'Mùi', 'Tuất', 'Hợi'],
        ];

        return $mapping[$dayBranch] ?? [];
    }
}
