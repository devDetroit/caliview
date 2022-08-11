<?php

namespace App\Http\Controllers;

use App\Models\Vehicles;
use Illuminate\Http\Request;

class VehiclesCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('vehiclesCRUD.index', [
            'vehicles' => Vehicles::orderBy('id')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vehiclesCRUD.create');
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
            'maker' => 'required',
            'model' => 'required',
            'year' => 'required',
            'engine' => 'required'
        ]);
        $vehicle = new Vehicles;
        $vehicle->maker = $request->maker;
        $vehicle->model = $request->model;
        $vehicle->year = $request->year;
        $vehicle->engine = $request->engine;
        $vehicle->save();
        return redirect()->route('vehicles.index')
            ->with('success', 'The vehicle has been added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicles  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicles $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vehicles  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicles $vehicle)
    {
        return view('vehiclesCRUD.edit', compact('vehicle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehicles  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'maker' => 'required',
            'model' => 'required',
            'year' => 'required',
            'engine' => 'required'
        ]);
        $vehicle = Vehicles::find($id);
        $vehicle->maker = $request->maker;
        $vehicle->model = $request->model;
        $vehicle->year = $request->year;
        $vehicle->engine = $request->engine;
        $vehicle->save();
        return redirect()->route('vehicles.index')
            ->with('success', 'The vehicle has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicles  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicles $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')
            ->with('success', 'The vehicle has been removed successfully.');
    }
}
