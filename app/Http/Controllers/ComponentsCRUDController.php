<?php

namespace App\Http\Controllers;

use App\Models\Components;
use App\Models\ComponentTypes;
use Illuminate\Http\Request;

class ComponentsCRUDController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('componentsCRUD.index', [
            'components' => Components::with('componentTypes')->orderBy('id')->get()
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
            'componentTypes' => ComponentTypes::orderBy('id')->get()
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
        $component = new Components;
        $component->component_number = $request->componentNumber;
        $component->type_id = $request->componentType;
        $component->measure = $request->measure;
        $component->created_by = auth()->user()->id;
        $component->updated_by = auth()->user()->id;
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
     * @param  \App\Models\Components  $component
     * @return \Illuminate\Http\Response
     */
    public function edit(Components $component)
    {
        return view('componentsCRUD.edit', compact('component'), [
            'componentTypes' => ComponentTypes::orderBy('id')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Components  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'componentNumber' => 'required',
            'componentType' => 'required',
            'measure' => 'required'
        ]);
        $component = Components::find($id);
        $component->component_number = $request->componentNumber;
        $component->type_id = $request->componentType;
        $component->measure = $request->measure;
        $component->updated_by = auth()->user()->id;
        $component->save();
        return redirect()->route('components.index')
            ->with('success', 'The component has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Components  $component
     * @return \Illuminate\Http\Response
     */
    public function destroy(Components $component)
    {
        $component->delete();
        return redirect()->route('components.index')
            ->with('success', 'The component has been deleted successfully.');
    }
}
