<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Mail\VerificationEmail;
use App\Mail\ResetMail;

class SendEmailJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $details;

    public function __construct($details)
    {

        $this->details = $details;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $data  = $this->details;
        $email = null;

        switch ($data['type']) {

            case 'verification':

                $email = new VerificationEmail($data);
                break; 

            case 'reset':

                $email = new ResetMail($data);
                break;

        }

        Mail::to($data['email'])->send($email);
        
    }

}
