<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use JsonException;

class TodoRemainderEmailQueue extends Mailable
{
    use Queueable, SerializesModels;

    protected $todo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($todo)
    {
        $this->todo = $todo;
    }

    /**
     * Build the message.
     *
     * @return $this
     * @throws JsonException
     */
    public function build()
    {
        $response = Http::get('https://jsonplaceholder.typicode.com/posts/?_limit=10');

        $response = json_decode($response->body(), true, 512, JSON_THROW_ON_ERROR);

        $data = [];
        foreach ($response as $res) {
            $data [] = $res['title'];
        }

        $fileName ='sample.csv';
        $file = fopen('php://temp', 'wb+');
        fputcsv($file, ['Title']);

        foreach ($data as $d) {
            fputcsv($file, [$d]);
        }
        rewind($file);

        $email = $this->from('no-reply@naowas.me', 'Demo Mail')
            ->subject('Email from todo app')
            ->view('todo.remainder-email-template')->with([
                'todo' => $this->todo
            ]);

        $email->attachData(stream_get_contents($file), $fileName);

        fclose($file);

        return $email;

    }
}
