<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportantDate extends Model
{
    protected $fillable = [
        'title',
        'calendar',
        'lunar_day',
        'lunar_month',
        'lunar_year',
        'solar_date',
        'type',
        'description',
    ];
    public static function checkUpcoming($days = 30)
    {
        $dates = self::all();
        foreach ($dates as $date) {
            $currentYear = now()->year;
            $solar = null;

            if ($date->calendar == 'solar') {
                // For Solar, use the stored day/month directly
                try {
                    $solar = \Carbon\Carbon::createFromDate($currentYear, $date->lunar_month, $date->lunar_day);
                } catch (\Exception $e) {
                    $solar = null;
                }
            } else {
                // Lunar
                $solar = \App\Helpers\LunarHelper::getSolarDateForYear($date->lunar_day, $date->lunar_month, $currentYear);
            }

            if ($solar) {
                if ($solar->isPast()) {
                    // Check next year if passed
                    if ($date->calendar == 'solar') {
                        try {
                            $solar = \Carbon\Carbon::createFromDate($currentYear + 1, $date->lunar_month, $date->lunar_day);
                        } catch (\Exception $e) {
                            $solar = null;
                        }
                    } else {
                        $solar = \App\Helpers\LunarHelper::getSolarDateForYear($date->lunar_day, $date->lunar_month, $currentYear + 1);
                    }
                }

                if ($solar) {
                    $diff = now()->diffInDays($solar, false);
                    if ($diff >= 0 && $diff <= $days) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
}
