<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApprovedCandidateEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected $candidate;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($candidate)
    {
        $this->candidate = $candidate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd($this->candidate);
        return $this->view('emails.candidate.approvedMail',['candidate'=>$this->candidate]);
    }
}
