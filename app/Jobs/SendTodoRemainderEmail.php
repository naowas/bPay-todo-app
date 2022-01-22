<?php

namespace App\Jobs;

use App\Models\Todo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\TodoRemainderEmailQueue;
use Illuminate\Support\Facades\Mail;

class SendTodoRemainderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $todo;
    protected $fileName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($todo, $fileName)
    {
        $this->todo = $todo;
        $this->fileName = $fileName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new TodoRemainderEmailQueue($this->todo, $this->fileName);
        $changeStatus = Todo::find($this->todo->id);
        try {
            Mail::to($this->todo->user->email)->send($email);

            $changeStatus->sending_status = Todo::EMAIL_SENT;
        } catch (\Exception $e) {
            $changeStatus->sending_status = Todo::EMAIL_NOT_SENT;
        }

        $changeStatus->update();

    }
}
