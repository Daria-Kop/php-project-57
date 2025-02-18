<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Label;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Illuminate\Routing\Controller;

class TaskController extends Controller
{
    use AuthorizesRequests;

    protected Collection $taskStatuses;
    protected Collection $users;
    protected Collection $labels;

    public function __construct()
    {
        $this->taskStatuses = TaskStatus::all();
        $this->users = User::all();
        $this->labels = Label::all();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Task $task)
    {
        $this->authorize('view', $task);
        $filters = $request->input('filter', []);

        $tasks = Task::query()
            ->filterByStatus($filters['status_id'] ?? null)
            ->filterByCreatedBy($filters['created_by_id'] ?? null)
            ->filterByAssignedTo($filters['assigned_to_id'] ?? null)
            ->paginate(15);

        return view('tasks.index', [
            'task' => new Task(),
            'tasks' => $tasks,
            'taskStatuses' => $this->taskStatuses,
            'users' => $this->users,
            'filters' => $filters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Task::class);

        return view('tasks.create', [
            'task' => new Task(),
            'taskStatuses' => $this->taskStatuses,
            'users' => $this->users,
            'labels' => $this->labels
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $this->authorize('create', Task::class);
        $this->saveTask(new Task(), $request, auth()->id());
        flash(__('Задача успешно создана'))->success();

        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);
        $task = Task::findOrFail($task->id);

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        return view('tasks.edit', [
            'task' => Task::findOrFail($task->id),
            'taskStatuses' => $this->taskStatuses,
            'users' => $this->users,
            'labels' => $this->labels
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);
        $this->saveTask($task, $request);
        flash(__('Задача успешно изменена'))->success();

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        try {
            $task->delete();
            flash(__('Задача успешно удалена'))->success();
        } catch (\Exception $e) {
            flash(__('Не удалось удалить задачу'))->error();
        }

        return redirect()->route('tasks.index');
    }

    /**
     * Save the task to the database.
     */
    private function saveTask(Task $task, TaskRequest $request, mixed $author_id = null)
    {
        $validated = $request->validated();
        $task->fill($validated);
        if ($author_id !== null) {
            $task->created_by_id = $author_id;
        }
        $task->save();
        $task->labels()->sync($validated['labels']);
    }
}
