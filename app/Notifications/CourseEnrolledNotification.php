<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\User;
use App\Models\Enrollment;
use Illuminate\Notifications\Messages\MailMessage;

class CourseEnrolledNotification extends BaseNotification
{
    public function __construct(
        public readonly Enrollment $enrollment
    ) {}

    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("You're enrolled in {$this->enrollment->course->title}!")
            ->greeting("Hello {$notifiable->name},")
            ->line("You have successfully enrolled in {$this->enrollment->course->title}.")
            ->action('Start Learning', route('courses.show', $this->enrollment->course->slug))
            ->line('Thank you for using our learning platform!');
    }
}
