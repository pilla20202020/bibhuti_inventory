<?php

namespace App\Notifications;

use App\Mail\RejectedCandidateEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RejectedCandidateNotification extends Notification
{
    use Queueable;
    private $candidate;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($candidate)
    {
        $this->candidate = $candidate;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        
        $address = $notifiable->routeNotificationFor('mail')?? $notifiable->email;

        return (new RejectedCandidateEmail($this->candidate))
            ->to($address);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'name' => $this->candidate['first_name'].' '.$this->candidate['last_name'],
            'priority'     => 7,
            'title'        => 'Doucment Approved',
            'message'      => 'Dear '. $this->candidate['first_name'].' '.$this->candidate['last_name'].' Sorry to said that you are rejected for further process to continue.',
            'link'         => '#'
        ];
    }
}
