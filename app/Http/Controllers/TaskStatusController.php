<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = TaskStatus::paginate();
        return view('task_status.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::check()) {
            return view('task_status.create');
        }
        return abort(401);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|unique:task_statuses|max:20'
        ], [''], ['name' => __('task_status.status')]);
        $status = new TaskStatus();
        $status->fill($data);
        $status->save();
        flash(__('task_status.flashCreate'))->success();
        return redirect()
            ->route('status.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskStatus $taskStatus)
    {
        if (Auth::check()) {
            return view('task_status.edit', ['task_status' => $taskStatus]);
        }
        return abort(401);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskStatus $taskStatus): RedirectResponse
    {
        $data = $request->validate([
            'name' => "required|max:20|unique:task_statuses,name,{$taskStatus->id}"
        ], [''], ['name' => __('task_status.status')]);
        $taskStatus->fill($data);
        $taskStatus->save();
        flash(__('task_status.flashChange'))->success();
        return redirect()
            ->route('status.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskStatus $taskStatus)
    {
        if (Auth::check()) {
            try {
                $taskStatus->delete();
            } catch (\Exception $e) {
                flash(__('task_status.flashNotDelete'))->error();
                return redirect()
                    ->route('status.index');
            }
            flash(__('task_status.flashDelete'))->success();
            return redirect()->route('status.index');
        }
        return abort(401);
    }
}
