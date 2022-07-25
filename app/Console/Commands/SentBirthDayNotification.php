<?php

namespace App\Console\Commands;

use App\Modules\Models\Candidate\Candidate;
use Illuminate\Console\Command;
use App\Notifications\BirthDayNotification;
use Illuminate\Support\Facades\DB;
use Notification;

class SentBirthDayNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:birthday-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sent Birthday Wishes to users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $candidates = DB::select("SELECT * FROM candidates WHERE MONTH(dob) = MONTH(CURRENT_DATE()) AND DAY(dob) = DAY(CURRENT_DATE())");
        // // $candidates = $candidates->toArray();
        // $candidates = json_decode(json_encode($candidates,true));
        $candidates = Candidate::whereRaw('MONTH(dob) = MONTH(CURRENT_DATE()) AND DAY(dob) = DAY(CURRENT_DATE())')
    ->get();
        foreach ($candidates as $candidate) {
            $usersToMailed = collect([
                getPrimaryNotifiableUsers(),
                $candidates
            ])->flatten();
            Notification::send($usersToMailed, (new BirthDayNotification($candidate))->onQueue('notifications'));
        }
    }
}
