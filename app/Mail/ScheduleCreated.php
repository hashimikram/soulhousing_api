<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ScheduleCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $scheduling;

    public function __construct($scheduling)
    {
        Log::info('Constructing email...');
        $this->scheduling = $scheduling;
    }

    public function build()
    {
        Log::info('Building email...');
        return $this->subject('New Schedule Created')
            ->view('Emails.schedule_created')
            ->with(['scheduling' => $this->scheduling]);
    }
}
