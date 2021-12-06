<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Verify extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    protected $attachment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $attachment='')
    {
        $this->data = $data;
        $this->attachment = $attachment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->attachment && file_exists($this->attachment)){
            return $this->view('mails.verify')
                    ->attach($this->attachment);
        }else{
            return $this->view('mails.verify');
        }
        
    }
}
