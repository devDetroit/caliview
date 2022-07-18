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
            'types' => ComponentType::orderBy('id')->get()
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
        $type = new ComponentType;
        $type->type = $request->type;
        $type->save();
        return redirect()->route('componentTypes.index')
            ->with('success', 'Type has been created successfully.');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\ComponentType  $type
     * @return \Illuminate\Http\Response
     */
    public function show(ComponentType $type)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(ComponentType $type)
    {
        return view('componentTypesCRUD.edit', compact('type'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ComponentType  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required'
        ]);
        $type = ComponentType::find($id);
        $type->type = $request->type;
        $type->save();
        return redirect()->route('componentTypes.index')
            ->with('success', 'Type Has Been updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ComponentType  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComponentType $type)
    {
        $type->delete();
        return redirect()->route('componentTypes.index')
            ->with('success', 'Type has been deleted successfully');
    }
}
