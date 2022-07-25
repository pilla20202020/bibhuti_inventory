<?php

namespace App\Notifications;

use App\Mail\ApprovedCandidateEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApprovedCandidateNotification extends Notification
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
        // return (new MailMessage)
        //             ->line('The introduction to the notification.')
        //             ->action('Notification Action', url('/'))
        //             ->line('Thank you for using our application!');
        // return (new MailMessage)                    
        //     ->name($this->offerData['name'])
        //     ->line($this->offerData['body'])
        //     ->action($this->offerData['offerText'], $this->offerData['offerUrl'])
        //     ->line($this->offerData['thanks']);
        //     $mail = (new MailMessage);

        // return (new MailMessage)->to($notifiable->routeNotificationFor('mail'))
        //     ->subject('You are selected to apply on Company')
        //     ->view('emails.webprovision', ['provision' => $this->provision]);

        // return $mail;

        // $address = $notifiable->routeNotificationFor('mail')?? $notifiable->email;
        // dd($notifiable);
        $address = $notifiable->routeNotificationFor('mail')?? $notifiable->email;

        return (new ApprovedCandidateEmail($this->candidate))
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
            'message'      => 'Dear '. $this->candidate['first_name'].' '.$this->candidate['last_name'].' You are approved for further process to  your documents to Company',
            'link'         => '#'
        ];
    }
}
