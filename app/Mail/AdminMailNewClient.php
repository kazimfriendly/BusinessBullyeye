<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminMailNewClient extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    protected $user;
    protected $package;
    public function __construct($user,$package)
    {
        $this->user=$user;
        $this->package=$package;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.admin_new_client_added')
                ->from("no-reply@business-bullseye.com", "Business BullsEye Admin")
                ->subject("Business BullsEye - You are assigned to a New Package")
                ->with('user',  $this->user)
                ->with('package',  $this->package);
    }
}
