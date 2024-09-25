<?php

namespace App\Jobs;

use App\Mail\ScheduleCreated;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendScheduleEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $scheduling;
    protected $memberId;

    public function __construct($scheduling, $memberId)
    {
        $this->scheduling = $scheduling;
        $this->memberId = $memberId;
        Log::info('Member ID in Scheduling: ' . $this->memberId);
    }

    public function handle()
    {
        // Fetch the user's email based on the member_id
        $user = User::find($this->memberId);
        Log::info('User: ' . $user);
        if ($user) {
            Log::info('Sending email to ' . $user->email);
            Mail::to($user->email)->send(new ScheduleCreated($this->scheduling));
        }
    }
}


