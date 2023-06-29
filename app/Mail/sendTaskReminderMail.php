<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class sendTaskReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Tareas pendientes del vendedor";

    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Collection $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.pendingTasks', ["user" => $this->user[0]]);
    }
}
