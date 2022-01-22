<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Jobs\SendTodoRemainderEmail;
use App\Models\Todo;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables as YajraDatatable;
use App\Services\TodoService;

class TodoController extends Controller
{
    protected YajraDatatable $dataTable;
    protected string $url = 'todo';
    protected TodoService $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
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
     * @param StoreTodoRequest $request
     * @return RedirectResponse
     */
    public function store(StoreTodoRequest $request): RedirectResponse
    {
        $data = [
            'sending_status' => Todo::EMAIL_NOT_SENT,
            'user_id' => Auth::id(),
        ];

        $save = Todo::create(array_merge($request->validated(), $data));

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
        return view('todo.show', compact('todo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Todo $todo
     * @return Application|Factory|View
     */
    public function edit(Todo $todo): View|Factory|Application
    {
        return view('todo.edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTodoRequest $request
     * @param Todo $todo
     * @return RedirectResponse
     */
    public function update(UpdateTodoRequest $request, Todo $todo): RedirectResponse
    {

        $update = Todo::findOrFail($todo->id)->update($request->validated());

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

        if (($todoToBeDeleted !== null) && $todoToBeDeleted->delete()) {
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

    /**
     * @throws Exception
     */
    public function data(Request $request): JsonResponse
    {

        return $this->todoService->data($request);

    }

    public function sendMailRemainder()
    {

        return $this->todoService->CreateEmailRemainderQueue();

    }

}
