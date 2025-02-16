<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabelController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Label::class);
    }

    public function index()
    {
        $labels = Label::paginate();
        return view('label.index', compact('labels'));
    }

    public function create()
    {
        return view('label.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|unique:labels|max:20',
            'description' => 'max:100',
        ]);

        Label::create($data);

        flash(__('label.flashCreate'))->success();

        return redirect()->route('labels.index');
    }

    public function edit(Label $label)
    {
        return view('label.edit', ['label' => $label]);
    }

    public function update(Request $request, Label $label): RedirectResponse
    {
        $data = $request->validate([
            'name' => "required|max:20|unique:labels,name,{$label->id}",
            'description' => 'max:100',
        ]);

        $label->update($data);

        flash(__('label.flashChange'))->success();

        return redirect()->route('labels.index');
    }

    public function destroy(Label $label): RedirectResponse
    {
        $this->authorize('delete', $label);

        $label->delete();

        flash(__('label.flashDelete'))->success();

        return redirect()->route('labels.index');
    }
}
