<?php

namespace App\Services;

use App\Jobs\SendTodoRemainderEmail;
use App\Models\Todo;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use JsonException;
use Yajra\DataTables\DataTables as YajraDatatable;

class TodoService
{
    protected YajraDatatable $dataTable;
    protected string $url = 'todo';

    public function __construct(YajraDatatable $dataTable)
    {
        $this->dataTable = $dataTable;
    }

    /**
     * @throws Exception
     */
    public function data($request): JsonResponse
    {
        $query = Todo::orderBY('id', 'DESC')->select();
        return $this->dataTable->eloquent($query)
            ->addColumn('action', function ($item) {
                $action = '<td>';
                $action .= ' <a href="' . url($this->url . '/' . $item->id) . '" class="btn btn-xs btn-primary button-view" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></a>';
                $action .= ' <a href="' . url($this->url . '/' . $item->id . '/edit') . '" class="btn btn-xs btn-warning button-edit" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>';
                $action .= ' <a href="' . url($this->url . '/' . $item->id) . '" class="btn btn-xs btn-danger button-delete" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>';
                $action .= '<td>';
                return $action;
            })
            ->editColumn('title', function ($item) {
                return $item['title'];
            })
            ->editColumn('description', function ($item) {
                return $item['description'];
            })
            ->editColumn('notification_status', function ($item) {
                return $item['notification_status'];
            })
            ->rawColumns(['notification_status', 'action']) // for rendering HTML
            ->make(true);
    }

    /**
     * The scheduler will call this method every minute. and it will make queue for sending remainder email 10 minutes earlier of that task.
     */
    public function CreateEmailRemainderQueue(): string
    {

        $now = Carbon::now();
        $todayDate = $now->copy()->toDateString();
        $time1 = $now->copy()->addMinutes(10)->toTimeString();
        $time2 = $now->copy()->toTimeString();

        $todos = Todo::Query()
            ->with(['user'])
            ->where('notification_status', 0)
            ->whereDate('date', $todayDate)
            ->where('time', '<=', $time1)
            ->where('time', '>', $time2)
            ->get();

        $i = 0;
        foreach ($todos as $todo) {
            SendTodoRemainderEmail::dispatch($todo);
            $i++;
        }

        return 'processed: ' . $i;

    }

}
