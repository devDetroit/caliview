<?php

namespace App\Http\Controllers;

use App\Models\Component;
use App\Models\ComponentType;
use Illuminate\Http\Request;

class ComponentsCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('componentsCRUD.index', [
            'component' => Component::orderBy('id')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('componentsCRUD.create', [
            'componentTypes' => ComponentType::orderBy('id')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'componentNumber' => 'required',
            'componentType' => 'required',
            'measure' => 'required'
        ]);
        $component = new Component;
        $component->component_number = $request->componentNumber;
        $component->type_id = $request->componentType;
        $component->measure = $request->measure;
        $component->save();
        return redirect()->route('components.index')
            ->with('success', 'The component has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Component  $component
     * @return \Illuminate\Http\Response
     */
    public function edit(Component $component)
    {
        return view('componentsCRUD.edit', compact('component'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Component  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'componentNumber' => 'required',
            'componentType' => 'required',
            'measure' => 'required'
        ]);
        $component = new Component;
        $component->component_number = $request->componentNumber;
        $component->type_id = $request->componentType;
        $component->measure = $request->measure;
        $component->save();
        return redirect()->route('components.index')
            ->with('success', 'The component has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Component  $component
     * @return \Illuminate\Http\Response
     */
    public function destroy(Component $component)
    {
        $component->delete();
        return redirect()->route('components.index')
            ->with('success', 'The component has been deleted successfully.');
    }
}
