<?php

namespace App\Console\Commands;

use App\Mail\VaccinationReminder;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendVaccinationReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vaccination:reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send vaccination reminders to users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $members = Member::whereHas('schedule', function ($query) {
            $query->where('date', Carbon::tomorrow());
        })->get();
        foreach ($members as $member) {
            Mail::to($member->email)->send(new VaccinationReminder($member));
        }
    }
}
