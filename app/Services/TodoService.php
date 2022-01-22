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
            ->editColumn('sending_status', function ($item) {
                return $item['sending_status'];
            })
            ->rawColumns(['sending_status', 'action'])
            ->make(true);
    }

    /**
     * @throws JsonException
     */
    public function CreateEmailRemainderQueue(): string
    {
        $response = Http::get('https://jsonplaceholder.typicode.com/posts/?_limit=10');

        $response = json_decode($response->body(), true, 512, JSON_THROW_ON_ERROR);

        $data = [];
        foreach ($response as $res) {
            $data [] = $res['title'];
        }

        if (!File::exists(public_path() . "/email-attachments")) {
            File::makeDirectory(public_path() . "/email-attachments");
        }

        $filename = public_path("/email-attachments/sample.csv");
        $handle = fopen($filename, 'wb');

        fputcsv($handle, ['Title']);

        foreach ($data as $d) {
            fputcsv($handle, [$d]);
        }

        fclose($handle);

        $now = Carbon::now();
        $todayDate = $now->copy()->toDateString();
        $time1 = $now->copy()->addMinutes(10)->toTimeString();
        $time2 = $now->copy()->toTimeString();

        $todos = Todo::Query()
            ->with(['user'])
            ->where('sending_status', 0)
            ->whereDate('date', $todayDate)
            ->where('time', '<=', $time1)
            ->where('time', '>', $time2)
            ->get();

        $i = 0;
        foreach ($todos as $todo) {
            SendTodoRemainderEmail::dispatch($todo,$filename);
            $i++;
        }

        return 'processed: ' . $i;

    }

}
