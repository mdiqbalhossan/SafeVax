<?php

namespace App\Http\Controllers;

use App\Events\ScheduleVaccine;
use App\Models\Member;
use App\Models\VaccineCenter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function index()
    {
        $vaccineCenters = VaccineCenter::all();
        return view('register', compact('vaccineCenters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'center_id' => 'required|exists:vaccine_centers,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'nid' => 'required|string|max:255 |unique:members,nid',
            'birthday' => 'required|date',
            'email' => 'required|email|max:255 |unique:members,email',
            'phone' => 'required|string|max:255 |unique:members,phone',
        ],
            [
                'nid.unique' => 'Maybe you registered before this nid',
                'email.unique' => 'Maybe you registered before this email',
                'phone.unique' => 'Maybe you registered before this phone',
            ]);
        DB::beginTransaction();
        try {
            $member = Member::create([
                'center_id' => $request->center_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'nid' => $request->nid,
                'birthday' => $request->birthday,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            event(new ScheduleVaccine($member));
            DB::commit();
            return redirect()->route('register.success', $member);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function success(Member $member)
    {
        $center = VaccineCenter::find($member->schedule->vaccine_center_id);
        $scheduleDate = Carbon::parse($member->schedule->date)->format('d M, Y');
        return view('success', compact('center', 'scheduleDate'));
    }
}
