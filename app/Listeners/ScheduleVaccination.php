<?php

namespace App\Listeners;

use App\Events\ScheduleVaccine;
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
    public function handle(ScheduleVaccine $event): void
    {
        $vaccineCenters = VaccineCenter::all();

        $vaccineCenter = $this->getNextAvailableVaccineCenter($vaccineCenters, $event->member);
        if($vaccineCenter){
            $this->scheduleVaccination($event->member, $vaccineCenter);
        }
    }

    private function getNextAvailableVaccineCenter($vaccineCenters, $member)
    {
        $nextWeekday = $this->getNextWeekday();
        $selectedCenter = $member->center_id;        
        $selectedCenterCapacity = VaccineCenter::find($selectedCenter)->capacity_per_day;        
        $totalRegistered = Schedule::where('vaccine_center_id', $selectedCenter)
            ->whereDate('date', $nextWeekday->format('Y-m-d'))
            ->count();

        if ($totalRegistered < $selectedCenterCapacity) {
            return VaccineCenter::find($selectedCenter);
        } else {
            session()->flash('another-center-message', 'The selected center is full. System will automatically select another center.');
        }

        foreach ($vaccineCenters as $vaccineCenter) {
            if ($vaccineCenter->id != $selectedCenter) {
                $totalRegistered = Schedule::where('vaccine_center_id', $vaccineCenter->id)
                    ->whereDate('date', $nextWeekday->format('Y-m-d'))
                    ->count();
                if ($totalRegistered < $vaccineCenter->capacity_per_day) {
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
        $schedule->date = $this->getNextWeekday();
        $schedule->save();
    }
}
