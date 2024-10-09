<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\VaccineCenter;
use Illuminate\Http\Request;

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
        ]);
        Member::create([
            'center_id' => $request->center_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'nid' => $request->nid,
            'birthday' => $request->birthday,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('register')->with('success', 'Member created successfully');
    }
}
