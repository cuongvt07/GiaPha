<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class ImportantDates extends Component
{
    // Attributes are used on methods, not as traits


    public $dates = [];
    public $showModal = false;

    // Unified Form fields
    public $newTitle;
    public $newCalendar = 'lunar'; // 'lunar' or 'solar'
    public $newDay;
    public $newMonth;
    public $newYear; // Optional

    public $newType = 'anniversary';
    public $newDescription;

    public function mount()
    {
        $this->loadDates();
    }

    #[On('open-important-dates')]
    public function open()
    {
        $this->showModal = true;
        // Reset form
        $this->newCalendar = 'lunar';
        $this->newDay = null;
        $this->newMonth = null;
        $this->newYear = null;
        $this->loadDates();
    }

    public function close()
    {
        $this->showModal = false;
    }

    public function loadDates()
    {
        // Fetch all dates
        $rawDates = \App\Models\ImportantDate::orderBy('lunar_month')->orderBy('lunar_day')->get();

        // Calculate next occurrence for each
        $this->dates = $rawDates->map(function ($date) {
            $currentYear = now()->year;
            $occurrences = [];

            // Forecast for 5 years
            for ($i = 0; $i < 5; $i++) {
                $y = $currentYear + $i;
                $solar = null;
                $lunarData = null;

                if ($date->calendar == 'solar') {
                    // For Solar Recurring, day/month stored in lunar_day/month columns
                    try {
                        $solar = \Carbon\Carbon::createFromDate($y, $date->lunar_month, $date->lunar_day);
                        // Convert this specific solar date to Lunar for display
                        $lunarData = \App\Helpers\LunarHelper::convertSolarToLunar($solar);
                    } catch (\Exception $e) {
                        $solar = null;
                    }
                } else {
                    // Lunar
                    $solar = \App\Helpers\LunarHelper::getSolarDateForYear($date->lunar_day, $date->lunar_month, $y);
                    $lunarData = [$date->lunar_day, $date->lunar_month, $y, false]; // Original input
                }

                if ($solar && $lunarData) {
                    $occurrences[] = [
                        'year' => $y,
                        'date' => $solar,
                        'formatted' => $solar->format('d/m/Y'),
                        'lunar_display' => $lunarData[0] . '/' . $lunarData[1],
                        'is_past' => $solar->lt(now()->startOfDay()) && $y == $currentYear,
                        'can_chi' => \App\Helpers\LunarHelper::getCanChi($solar, 'day'),
                        'lucky_hours' => \App\Helpers\LunarHelper::getLuckyHours($solar)
                    ];
                }
            }

            // Next valid occurrence
            $nextFuture = collect($occurrences)->firstWhere('is_past', false) ?? ($occurrences[0] ?? null);

            $date->occurrences = $occurrences;
            $date->next_occurrence = $nextFuture ? $nextFuture['date'] : null;
            $date->days_remaining = $date->next_occurrence ? (int) now()->diffInDays($date->next_occurrence, false) : 999;

            // For display in the main list, use the next occurrence's details
            if ($nextFuture) {
                $date->display_lunar = $nextFuture['lunar_display'];
                $date->display_solar = $nextFuture['formatted'];
                $date->can_chi_year = \App\Helpers\LunarHelper::getCanChi($nextFuture['date'], 'year');
                $date->can_chi_month = \App\Helpers\LunarHelper::getCanChi($nextFuture['date'], 'month');
                $date->can_chi_day = \App\Helpers\LunarHelper::getCanChi($nextFuture['date'], 'day');
            } else {
                // Fallback to stored values if no occurrence found (shouldn't happen with 5 year forecast)
                $date->display_lunar = $date->lunar_day . '/' . $date->lunar_month;
                $date->display_solar = '???';
            }

            return $date;
        })->sortBy('days_remaining')->values(); // Sort by upcoming
    }

    public function saveDate()
    {
        $this->validate([
            'newTitle' => 'required|string|max:255',
            'newCalendar' => 'required|in:lunar,solar',
            'newDay' => 'required|integer|min:1|max:31',
            'newMonth' => 'required|integer|min:1|max:12',
            'newYear' => 'nullable|integer|min:1800|max:2100',
        ]);

        \App\Models\ImportantDate::create([
            'title' => $this->newTitle,
            'calendar' => $this->newCalendar,
            'lunar_day' => $this->newDay,
            'lunar_month' => $this->newMonth,
            'lunar_year' => $this->newYear,
            'solar_date' => null,
            'type' => $this->newType,
            'description' => $this->newDescription,
        ]);

        $this->reset(['newTitle', 'newCalendar', 'newDay', 'newMonth', 'newYear', 'newType', 'newDescription']);
        $this->newCalendar = 'lunar'; // Default

        $this->loadDates();
        $this->dispatch('dates-updated'); // Notify parent components
    }

    public function deleteDate($id)
    {
        \App\Models\ImportantDate::destroy($id);
        $this->loadDates();
    }

    public function render()
    {
        $this->loadDates();
        return view('livewire.important-dates');
    }
}
