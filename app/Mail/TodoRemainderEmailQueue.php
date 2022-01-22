<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TodoRemainderEmailQueue extends Mailable
{
    use Queueable, SerializesModels;

    protected $todo;
    protected $fileName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($todo,$fileName)
    {
        $this->todo = $todo;
        $this->fileName = $fileName;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->from('no-reply@naowas.me', 'Demo Mail')
            ->subject('Email from todo app')
            ->view('todo.remainder-email-template')->with([
                'todo' => $this->todo
            ]);

        $email->attach($this->fileName, [
            'as' => 'sample.csv',
            'mime' => 'application/vnd.ms-excel',
        ]);

        return $email;


    }
}
