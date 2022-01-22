<?php

namespace App\Console\Commands;

use App\Services\TodoService;
use Illuminate\Console\Command;

class CreateTodoEmailRemainderQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:todoEmailRemainderQueue';

    /**
     * The console command description.y
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(TodoService $todoService)
    {
        $response = $todoService->CreateEmailRemainderQueue();
        echo $response;
    }
}
