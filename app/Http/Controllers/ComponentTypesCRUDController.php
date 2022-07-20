<?php

namespace App\Http\Controllers;

use App\Models\ComponentType;
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
            'componentType' => ComponentType::orderBy('id')->get()
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
        $componentType = new ComponentType;
        $componentType->type = $request->type;
        $componentType->save();
        return redirect()->route('componentTypes.index')
            ->with('success', 'Type has been created successfully.');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\ComponentType  $componentType
     * @return \Illuminate\Http\Response
     */
    public function show(ComponentType $componentType)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ComponentType  $componentType
     * @return \Illuminate\Http\Response
     */
    public function edit(ComponentType $componentType)
    {
        return view('componentTypesCRUD.edit', compact('componentType'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ComponentType  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required'
        ]);
        $componentType = ComponentType::find($id);
        $componentType->type = $request->type;
        $componentType->save();
        return redirect()->route('componentTypes.index')
            ->with('success', 'Type has been updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ComponentType  $componentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComponentType $componentType)
    {
        $componentType->delete();
        return redirect()->route('componentTypes.index')
            ->with('success', 'Type has been deleted successfully.');
    }
}
