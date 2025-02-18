<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStatusRequest;
use App\Models\TaskStatus;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;

class TaskStatusController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(TaskStatus $taskStatuses)
    {
        $this->authorize('view', $taskStatuses);
        $taskStatuses = TaskStatus::all();

        return view('taskStatuses.index', compact('taskStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', TaskStatus::class);

        return view('taskStatuses.create', ['taskStatus' => new TaskStatus()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStatusRequest $request)
    {
        $this->authorize('create', TaskStatus::class);
        $this->saveTaskStatus(new TaskStatus(), $request);
        flash(__('Статус успешно создан'))->success();

        return redirect()->route('task_statuses.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskStatus $taskStatus)
    {
        $this->authorize('update', $taskStatus);

        return view('taskStatuses.edit', compact('taskStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskStatusRequest $request, TaskStatus $taskStatus)
    {
        $this->authorize('update', $taskStatus);
        $this->saveTaskStatus($taskStatus, $request);
        flash(__('Статус успешно изменён'))->success();

        return redirect()->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskStatus $taskStatus)
    {
        $this->authorize('delete', $taskStatus);

        try {
            $taskStatus->delete();
            flash(__('Статус успешно удалён'))->success();
        } catch (\Exception $e) {
            flash(__('Не удалось удалить статус'))->error();
        }

        return redirect()->route('task_statuses.index');
    }

    /**
     * Save the task status to the database.
     */
    private function saveTaskStatus(TaskStatus $taskStatus, TaskStatusRequest $request)
    {
        $validated = $request->validated();
        $taskStatus->fill($validated);
        $taskStatus->save();
    }
}
