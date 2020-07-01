<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $address = env('MAIL_FROM_ADDRESS');
        $name = env('MAIL_FROM_NAME');
        if($this->data['attach_data'] != ''){
            return $this->view($this->data['view_name'])
                    ->from($address, $name)
                    ->subject($this->data['subject'])
                    ->with($this->data['message'])
                    ->attachData($this->data['attach_data']->output(), $this->data['attach_name']);
        } else {
            return $this->view($this->data['view_name'])
                    ->from($address, $name)
                    ->subject($this->data['subject'])
                    ->with($this->data['message']);
        }
    }
}