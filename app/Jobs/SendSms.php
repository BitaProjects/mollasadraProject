<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\Api\V1\SmsController;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $userPhone;
    protected  $phoneVerificationCode;
    public function __construct($userPhone,$phoneVerificationCode)
    {
        $this->userPhone = $userPhone;
        $this->phoneVerificationCode = $phoneVerificationCode;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        SmsController::lookUp($this->userPhone, $this->phoneVerificationCode);
    }
}
