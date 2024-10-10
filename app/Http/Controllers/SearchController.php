<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        return view('search');
    }

    public function result(Request $request)
    {
        $request->validate([
            'nid' => 'required|string',
        ]);
        $nid = $request->nid;
        $member = Member::where('nid', $nid)->first();
        $status = '';
        $link = '';
        $date = '';
        $center = '';
        if (!$member) {
            $status = 'Not Registered';
            $link = route('register');
        }else if($member->schedule == null){
            $status = 'Not Scheduled';
        }else if($member->schedule->first()->date > now()){
            $status = 'Scheduled';
            $date = $member->schedule->first()->date->format('d M,Y');
            $center = $member->schedule->first()->vaccineCenter->name;
        }else{
            $status = 'Vaccinated';
        }
        return view('search', compact('status', 'link', 'date', 'center', 'member'));
    }
}
