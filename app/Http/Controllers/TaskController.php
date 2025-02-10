<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $statusId = $request->collect()->value('status_id');
        $createdId = $request->collect()->value('created_by_id');
        $assignedId = $request->collect()->value('assigned_to_id');
        $taskStatuses = TaskStatus::all();
        $users = User::all();
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id')
            ])
            ->get();
        return view('task.index', [
            'tasks' => $tasks,
            'users' => $users,
            'taskStatuses' => $taskStatuses,
            'statusId' => (int)$statusId,
            'createdId' => (int)$createdId,
            'assignedId' => (int)$assignedId,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::check()) {
            $taskStatuses = TaskStatus::all();
            $users = User::all();
            $labels = Label::all();
            return view(
                'task.create',
                [
                    'task_statuses' => $taskStatuses,
                    'users' => $users,
                    'labels' => $labels,
                ]
            );
        }
        return abort(401);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $dataFill = $request->validate([
            'name' => 'required|unique:tasks|max:20',
            'description' => 'max:100',
            'status_id' => 'required',
            'assigned_to_id' => '',
        ], [''], ['name' => __('task.task')]);
        $labelsReq = $request->input('labels');
        $labels = Label::find($labelsReq);
        $task = new Task();
        $task->fill($dataFill);
        $task->created_by_id = Auth::id();
        $task->save();
        $task->labels()->attach($labels);
        flash(__('task.flashCreate'))->success();
        return redirect()
            ->route('task.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $labels = $task->labels;
        return view(
            'task.show',
            [
                'task' => $task,
                'labels' => $labels,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        if (Auth::check()) {
            $taskStatuses = TaskStatus::all();
            $users = User::all();
            $labels = Label::all();
            return view(
                'task.edit',
                [
                    'task' => $task,
                    'task_statuses' => $taskStatuses,
                    'users' => $users,
                    'labels' => $labels,
                ]
            );
        }
        return abort(401);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        $dataFill = $request->validate([
            'name' => "required|max:20|unique:tasks,name,{$task->id}",
            'description' => 'max:100',
            'status_id' => 'required',
            'assigned_to_id' => '',
        ], [''], ['name' => __('task.task')]);
        $task->fill($dataFill);
        $task->save();
        $labelsReq = $request->input('labels');
        $labels = Label::find($labelsReq) ?? [];
        $task->labels()->sync($labels);
        flash(__('task.flashChange'))->success();
        return redirect()
            ->route('task.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if (Auth::check()) {
            $task->labels()->detach();
            $task->delete();
            flash(__('task.flashDelete'))->success();
            return redirect()->route('task.index');
        }
        return abort(401);
    }
}
