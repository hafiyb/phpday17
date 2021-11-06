<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QueueEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $action)
    {
        //
        $this->data = $email;
        $this->action = $action;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->action == 'create'){
            return $this->view('emails.testQueueMail')->with('data', $this->data);
        }
        else if($this->action == 'delete'){
            return $this->view('emails.testQueueMaildelete')->with('data', $this->data);
        }
        else if($this->action == 'edit'){
            return $this->view('emails.testQueueMailedit')->with('data', $this->data);
        }
    }
}
