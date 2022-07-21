<?php

namespace App\Http\Controllers;

use App\Models\CaliperFamilies;
use Illuminate\Http\Request;

class CaliperFamiliesCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('caliperFamiliesCRUD.index', [
            'caliperFamilies' => CaliperFamilies::orderBy('id')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('caliperFamiliesCRUD.create');
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
            'family' => 'required'
        ]);
        $caliperFamily = new CaliperFamilies;
        $caliperFamily->family = $request->family;
        $caliperFamily->save();
        return redirect()->route('caliperFamilies.index')
            ->with('success', 'Family has been created successfully.');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CaliperFamilies $caliperFamily)
    {
        return view('caliperFamiliesCRUD.edit', compact('caliperFamily'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'family' => 'required'
        ]);
        $caliperFamily = CaliperFamilies::find($id);
        $caliperFamily->family = $request->family;
        $caliperFamily->save();
        return redirect()->route('caliperFamilies.index')
            ->with('success', 'Family has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CaliperFamilies $caliperFamily)
    {
        $caliperFamily->delete();
        return redirect()->route('caliperFamilies.index')
            ->with('success', 'Family has been deleted successfully.');
    }
}
