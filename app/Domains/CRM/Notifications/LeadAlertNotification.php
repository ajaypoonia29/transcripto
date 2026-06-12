<?php

declare(strict_types=1);

namespace App\Domains\CRM\Notifications;

use App\Domains\CRM\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeadAlertNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected readonly Lead $lead
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('New Lead Ingested: ' . $this->lead->full_name)
            ->greeting('Hello!')
            ->line('A new lead has been captured on Transcripto.')
            ->line('Name: ' . $this->lead->full_name)
            ->line('Email: ' . $this->lead->email_address)
            ->line('Phone: ' . $this->lead->phone_number)
            ->line('Preferred Program: ' . $this->lead->preferred_program_type)
            ->line('Status: ' . $this->lead->pipeline_status)
            ->line('Thank you for using our application!');
    }
}
