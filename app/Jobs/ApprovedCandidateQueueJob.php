<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\ApprovedCandidateEmail;
use App\Mail\RejectedCandidateEmail;
use App\Notifications\ApprovedCandidateNotification;
use App\Notifications\RejectedCandidateNotification;
use Illuminate\Support\Facades\Mail;
use Notification;

class ApprovedCandidateQueueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $candidate;
    protected $type;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($candidate,$type)
    {
        $this->candidate = $candidate;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $usersToMailed = collect([
            getPrimaryNotifiableUsers(),
            $this->candidate
        ])->flatten();
        if($this->type == 'approved'){
            foreach ($usersToMailed as $users) {
                // $approvedEmail = new ApprovedCandidateEmail($this->candidate);
                // Mail::to($users->email)->send($approvedEmail);
                Notification::send($users,( new ApprovedCandidateNotification($this->candidate))->onQueue('notifications'));
            }
        }else{
            foreach ($usersToMailed as $users) {
                // $approvedEmail = new RejectedCandidateEmail($this->candidate);
                // Mail::to($users->email)->send($approvedEmail);
                Notification::send($users,( new RejectedCandidateNotification($this->candidate))->onQueue('notifications'));
            }
        }
        
    }
}
