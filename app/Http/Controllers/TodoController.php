<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Models\Todo;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables as YajraDatatable;

class TodoController extends Controller
{
    protected YajraDatatable $dataTable;
    protected string $url = 'todo';

    public function __construct(YajraDatatable $dataTable)
    {
        $this->dataTable = $dataTable;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $data = [
            'url' => $this->url,
        ];

        return view('todo.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('todo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreTodoRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTodoRequest $request): \Illuminate\Http\RedirectResponse
    {
        $data = [
            'sending_status' => Todo::EMAIL_NOT_SENT,
            'user_id' => Auth::id(),
        ];

        $save = Todo::create(array_merge($request->all(), $data));

        return redirect()->route('todo.index')->with('message', 'Data added Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param Todo $todo
     * @return Application|Factory|View
     */
    public function show(Todo $todo): View|Factory|Application
    {
        return  view('todo.show',$todo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Todo $todo
     * @return Application|Factory|View
     */
    public function edit(Todo $todo)
    {
        return view('todo.edit', $todo);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateTodoRequest $request
     * @param Todo $todo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTodoRequest $request, Todo $todo)
    {
        $data = [
            'sending_status' => Todo::EMAIL_NOT_SENT,
            'user_id' => Auth::id(),
        ];

        $save = Todo::findOrFail($todo->id)->update(array_merge($request->all(), $data));

        return redirect()->route('todo.index')->with('message', 'Data updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Todo $todo
     * @return JsonResponse
     */
    public function destroy(Todo $todo): JsonResponse
    {
        $todoToBeDeleted = Todo::findOrFail($todo->id);

        if ($todoToBeDeleted !== null) {
            if ($todoToBeDeleted->delete()) {
                return response()->json([
                    'status' => 'success',
                    'data' => null
                ], 200);
            }

            return response()->json([
                'status' => 'warning',
                'data' => null
            ], 200);
        }
    }

    /**
     * @throws Exception
     */
    public function data(Request $request)
    {
        $query = Todo::orderBY('id', 'DESC')->select();
        return $this->dataTable->eloquent($query)
            ->addColumn('action', function ($item) {
                $action = '<td>';
                $action .= ' <a href="' . url($this->url . '/' . $item->id ) . '" class="btn btn-xs btn-primary button-view" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></a>';
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
            ->rawColumns(['sending_status','action'])
            ->make(true);
    }

}
