<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabelRequest;
use App\Models\Label;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LabelController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Label $label)
    {
        $this->authorize('view', $label);
        $labels = Label::all();

        return view('labels.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->authorize('create', Label::class);
        $backUrl = $request->input('backUrl', route('labels.index'));

        return view('labels.create', ['label' => new Label(), 'backUrl' => $backUrl]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LabelRequest $request)
    {
        $this->authorize('create', Label::class);
        $this->saveLabel(new Label(), $request);
        flash('Метка успешно создана')->success();
        $backUrl = $request->input('backUrl', route('labels.index'));

        return redirect($backUrl);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Label $label, Request $request)
    {
        $this->authorize('update', $label);
        $backUrl = $request->input('backUrl', route('labels.index'));

        return view('labels.edit', ['label' => $label, 'backUrl' => $backUrl]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LabelRequest $request, Label $label)
    {
        $this->authorize('update', $label);
        $this->saveLabel($label, $request);
        flash(__('Метка успешно изменена'))->success();
        $backUrl = $request->input('backUrl', route('labels.index'));

        return redirect($backUrl);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Label $label)
    {
        $this->authorize('delete', $label);
        try {
            $label->delete();
            flash(__('Метка успешно удалена'))->success();
        } catch (\Exception $e) {
            flash(__('Не удалось удалить метку'))->error();
        }

        return redirect()->route('labels.index');
    }

    private function saveLabel(Label $label, LabelRequest $request)
    {
        $validated = $request->validated();
        $label->fill($validated);
        $label->save();
    }
}
