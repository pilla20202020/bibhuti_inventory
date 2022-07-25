<?php

namespace App\Http\Controllers;

use App\Modules\Models\Candidate\Candidate;
use App\Notifications\BirthDayNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Notification;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return redirect()->route('dashboard');
    }

    public function birthdayNotification()
    {
        // $candidates = DB::select("SELECT * FROM candidates WHERE MONTH(dob) = MONTH(CURRENT_DATE()) AND DAY(dob) = DAY(CURRENT_DATE())");
       $candidates = Candidate::whereRaw('MONTH(dob) = MONTH(CURRENT_DATE()) AND DAY(dob) = DAY(CURRENT_DATE())')
    ->get();
        // dd($candidates);
        // $candidates = json_decode(json_encode($candidates,true));
        // dd(getPrimaryNotifiableUsers());
        foreach ($candidates as $candidate) {
            $usersToMailed = collect([
                getPrimaryNotifiableUsers(),
                $candidate
            ])->flatten();
            Notification::send($usersToMailed, (new BirthDayNotification($candidate))->onQueue('notifications'));
        }
    }
}
