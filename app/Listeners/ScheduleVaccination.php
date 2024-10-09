<?php

namespace App\Listeners;

use App\Models\Member;
use App\Models\Schedule;
use App\Models\VaccineCenter;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ScheduleVaccination
{
    /**
     * Handle the event.
     */
    public function handle(Member $member): void
    {
        $vaccineCenters = VaccineCenter::all();

        $vaccineCenter = $this->getNextAvailableVaccineCenter($vaccineCenters, $member);
        if($vaccineCenter){
            $this->scheduleVaccination($member, $vaccineCenter);
        }
    }

    private function getNextAvailableVaccineCenter($vaccineCenters, $member)
    {
        foreach ($vaccineCenters as $vaccineCenter) {
            if ($vaccineCenter->capacity_per_day > $vaccineCenter->members()->count()) {
                $nextWeekday = $this->getNextWeekday();
                if ($nextWeekday) {
                    return $vaccineCenter;
                }
            }
        }
        return null;
    }
    
    private function getNextWeekday()
    {
        $today = today();
        $nextWeekday = $today->addDay();

        while (!$this->isWeekday($nextWeekday)) {
            $nextWeekday = $nextWeekday->addDay();
        }

        return $nextWeekday;
    }

    private function isWeekday($date)
    {
        return $date->dayOfWeek <= 4;
    }

    private function scheduleVaccination(Member $member, VaccineCenter $vaccineCenter)
    {
        $schedule = new Schedule();
        $schedule->member_id = $member->id;
        $schedule->vaccine_center_id = $vaccineCenter->id;
        $schedule->vaccination_date = $this->getNextWeekday();
        $schedule->save();
    }
}
