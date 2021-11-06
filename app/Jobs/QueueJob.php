<?php

namespace App\Jobs;

use App\Mail\QueueEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class QueueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email_list;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email_list)
    {
        $this->email_list = $email_list;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new QueueEmail($this->email_list['user'], $this->email_list['action']);

        if($this->email_list['action'] == 'create'){
            Mail::to($this->email_list['email'])->send($email);
        }
        else if($this->email_list['action'] == 'delete'){
            Mail::to(\config('values.email'))->send($email);
        }
        else if($this->email_list['action'] == 'edit'){
            Mail::to(\config('values.email'))->send($email);
        }
        
    }
}
