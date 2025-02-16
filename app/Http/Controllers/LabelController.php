<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labels = Label::paginate();

        return view('label.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::check()) {
            return view('label.create');
        }

        return abort(401);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $dataFill = $request->validate([
            'name' => 'required|unique:labels|max:20',
            'description' => 'max:100',
        ], [''], ['name' => __('label.label')]);

        $label = new Label();
        $label->fill($dataFill);
        $label->save();

        flash(__('label.flashCreate'))->success();

        return redirect()->route('label.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Label $label)
    {
        if (Auth::check()) {
            return view('label.edit', ['label' => $label]);
        }

        return abort(401);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Label $label): RedirectResponse
    {
        $data = $request->validate([
            'name' => "required|max:20|unique:labels,name,{$label->id}",
            'description' => 'max:100',
        ], [''], ['name' => __('label.label')]);

        $label->fill($data);
        $label->save();

        flash(__('label.flashChange'))->success();

        return redirect()->route('label.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Label $label)
    {
        if (Auth::check()) {
            try {
                $label->delete();
            } catch (\Exception $e) {
                flash(__('label.flashNotDelete'))->error();

                return redirect()->route('label.index');
            }

            flash(__('label.flashDelete'))->success();

            return redirect()->route('label.index');
        }

        return abort(401);
    }
}
