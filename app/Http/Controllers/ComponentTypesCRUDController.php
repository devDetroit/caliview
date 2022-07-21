<?php

namespace App\Http\Controllers;

use App\Models\ComponentTypes;
use Illuminate\Http\Request;

class ComponentTypesCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('componentTypesCRUD.index', [
            'componentTypes' => ComponentTypes::orderBy('id')->get()
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('componentTypesCRUD.create');
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
            'type' => 'required'
        ]);
        $componentType = new ComponentTypes;
        $componentType->type = $request->type;
        $componentType->save();
        return redirect()->route('componentTypes.index')
            ->with('success', 'Type has been created successfully.');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ComponentTypes  $componentType
     * @return \Illuminate\Http\Response
     */
    public function show(ComponentTypes $componentType)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ComponentTypes  $componentType
     * @return \Illuminate\Http\Response
     */
    public function edit(ComponentTypes $componentType)
    {
        return view('componentTypesCRUD.edit', compact('componentType'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ComponentTypes  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required'
        ]);
        $componentType = ComponentTypes::find($id);
        $componentType->type = $request->type;
        $componentType->save();
        return redirect()->route('componentTypes.index')
            ->with('success', 'Type has been updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ComponentTypes  $componentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComponentTypes $componentType)
    {
        $componentType->delete();
        return redirect()->route('componentTypes.index')
            ->with('success', 'Type has been deleted successfully.');
    }
}
