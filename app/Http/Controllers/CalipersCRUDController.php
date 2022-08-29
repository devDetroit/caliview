<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Calipers;
use App\Models\CaliperFamilies;
use App\Models\CaliperPhotos;
use App\Models\CaliperComponents;
use App\Models\Components;
use App\Models\CaliperVehicles;
use App\Models\Vehicles;
use Illuminate\Http\Request;
use Throwable;

class CalipersCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('calipersCRUD.index', [
            'calipers' => Calipers::with(['caliperFamilies', 'createdBy', 'updatedBy'])->orderBy('id')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('calipersCRUD.create', [
            'caliperFamilies' => CaliperFamilies::orderBy('id')->get(),
            'components' => Components::orderBy('id')->get(),
            'vehicles' => Vehicles::orderBy('id')->get()
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
        DB::beginTransaction();
        try {
            $request->validate([
                'jhPN' => 'required',
                'cardonePN' => 'required',
                'centricPN' => 'required',
                'caliperFamily' => 'required',
                'componentNo' => 'required',
                'componentQuantity' => 'required'
            ]);
            $caliper = new Calipers;
            $caliper->jh_part_number = $request->jhPN;
            $caliper->cardone_part_number = $request->cardonePN;
            $caliper->centric_part_number = $request->centricPN;
            $caliper->family_id = $request->caliperFamily;
            $caliper->casting1 = $request->casting1;
            $caliper->casting2 = $request->casting2;
            $caliper->bracket_casting = $request->bracketCasting;
            $caliper->created_by = auth()->user()->id;
            $caliper->updated_by = auth()->user()->id;
            $caliper->save();
        } catch(Throwable $e) {
            return redirect()->route('calipers.index')
                ->with('failure', "There was an error creating the caliper, please try again or contact IT with the data you're trying to input.");
        }
        if(isset($request->caliperPhotos[0])) {
            try {
                foreach($request->caliperPhotos as $photo) {
                    $photos = new CaliperPhotos;
                    $photoName = $caliper->id . '_' . date('YmdHis') . '.' . $photo->extension();
                    $photos->caliper_id = $caliper->id;
                    $photos->filename = $photoName;
                    $photos->created_by = auth()->user()->id;
                    $photos->updated_by = auth()->user()->id;
                    $photo->storeAs('public/calipers', $photoName);
                    $photos->save();
                }
            } catch(Throwable $e) {
                DB::rollBack();
                return redirect()->route('calipers.index')
                    ->with('failure', "There was an issue uploading the photos, please try again or contact IT.");
            }
        }
        if(isset($request->componentNo[0])) {
            try {
                $component = array_values($request->componentNo);
                $quantity = array_values($request->componentQuantity);
                for($i = 0; $i < count($component); $i++) {
                    if(isset($component[$i])) {
                        $caliperComp = new CaliperComponents;
                        $caliperComp->caliper_id = $caliper->id;
                        $caliperComp->component_id = $component[$i];
                        $caliperComp->quantity = $quantity[$i];
                        $caliperComp->created_by = auth()->user()->id;
                        $caliperComp->updated_by = auth()->user()->id;
                        $caliperComp->save();
                    }
                }
            } catch(Throwable $e) {
                DB::rollBack();
                return redirect()->route('calipers.index')
                    ->with('failure', "There was an issue saving the components, please try again or contact IT.");
            }
        }
        if(isset($request->vehicleEngine[0])) {
            try {
                $vehicle = array_values($request->vehicleEngine);
                for($i = 0; $i < count($vehicle); $i++) {
                    if(isset($vehicle[$i])) {
                        $caliperVeh = new CaliperVehicles();
                        $caliperVeh->caliper_id = $caliper->id;
                        $caliperVeh->vehicle_id = $vehicle[$i];
                        $caliperVeh->created_by = auth()->user()->id;
                        $caliperVeh->updated_by = auth()->user()->id;
                        $caliperVeh->save();
                    }
                }
            } catch(Throwable $e) {
                DB::rollBack();
                return redirect()->route('calipers.index')
                    ->with('failure', "There was an issue saving the vehicles, please try again or contact IT.");
            }
        }
        DB::commit();
        return redirect()->route('calipers.index')
            ->with('success', 'The caliper has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Calipers  $caliper
     * @return \Illuminate\Http\Response
     */
    public function show(Calipers $caliper)
    {
        return view('calipersCRUD.show', compact('caliper'), [
            'caliperPhotos' => CaliperPhotos::where('caliper_id', $caliper->id)->orderBy('id')->get(),
            'caliperComponents' => CaliperComponents::with('components')->where('caliper_id', $caliper->id)->orderBy('id')->get(),
            'caliperVehicles' => CaliperVehicles::with('vehicles')->where('caliper_id', $caliper->id)->orderBy('id')->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Calipers  $caliper
     * @return \Illuminate\Http\Response
     */
    public function edit(Calipers $caliper)
    {
        return view('calipersCRUD.edit', compact('caliper'), [
            'caliperFamilies' => CaliperFamilies::orderBy('id')->get(),
            'caliperPhotos' => CaliperPhotos::where('caliper_id', $caliper->id)->orderBy('id')->get(),
            'caliperComponents' => CaliperComponents::with('components')->where('caliper_id', $caliper->id)->orderBy('id')->get(),
            'caliperVehicles' => CaliperVehicles::with('vehicles')->where('caliper_id', $caliper->id)->orderBy('id')->get(),
            'components' => Components::orderBy('id')->get(),
            'vehicles' => Vehicles::orderBy('id')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Calipers  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'jhPN' => 'required',
                'cardonePN' => 'required',
                'centricPN' => 'required',
                'caliperFamily' => 'required',
                'componentNo' => 'required',
                'componentQuantity' => 'required'
            ]);
            $caliper = Calipers::find($id);
            $caliper->jh_part_number = $request->jhPN;
            $caliper->cardone_part_number = $request->cardonePN;
            $caliper->centric_part_number = $request->centricPN;
            $caliper->family_id = $request->caliperFamily;
            $caliper->casting1 = $request->casting1;
            $caliper->casting2 = $request->casting2;
            $caliper->bracket_casting = $request->bracketCasting;
            $caliper->updated_by = auth()->user()->id;
            $caliper->save();
        } catch(Throwable $e) {
            DB::rollBack();
            return redirect()->route('calipers.show', compact('caliper'))
                ->with('failure', "There was an error updating the caliper, please try again or contact IT with the data you're trying to input.");
        }
        if(isset($request->newPhotos[0])) {
            try {
                foreach($request->newPhotos as $photo) {
                    $photos = new CaliperPhotos;
                    $photoName = $caliper->id . '_' . date('YmdHis') . '.' . $photo->extension();
                    $photos->caliper_id = $caliper->id;
                    $photos->filename = $photoName;
                    $photos->created_by = auth()->user()->id;
                    $photos->updated_by = auth()->user()->id;
                    $photo->storeAs('public/calipers', $photoName);
                    $photos->save();
                }
            } catch(Throwable $e) {
                DB::rollBack();
                return redirect()->route('calipers.show', compact('caliper'))
                    ->with('failure', "There was an issue uploading the photos, please try again or contact IT.");
            }
        }
        if(isset($request->componentNo[0])) {
            try {
                $component = array_values($request->componentNo);
                $quantity = array_values($request->componentQuantity);
                $caliperComponents = CaliperComponents::where('caliper_id', $id)->get();
                foreach($caliperComponents as $caliComp) {
                    CaliperComponents::where('caliper_id', $caliper->id)->delete();
                }
                for($i = 0; $i < count($component); $i++) {
                    if(isset($component[$i])) {
                        $caliperComp = new CaliperComponents;
                        $caliperComp->caliper_id = $caliper->id;
                        $caliperComp->component_id = $component[$i];
                        $caliperComp->quantity = $quantity[$i];
                        $caliperComp->created_by = auth()->user()->id;
                        $caliperComp->updated_by = auth()->user()->id;
                        $caliperComp->save();
                    }
                }
            } catch(Throwable $e) {
                DB::rollBack();
                return redirect()->route('calipers.show', compact('caliper'))
                    ->with('failure', "There was an issue saving the components, please try again or contact IT.");
            }
        }
        if(isset($request->vehicleEngine[0])) {
            try {
                $vehicle = array_values($request->vehicleEngine);
                $caliperVehicles = CaliperVehicles::where('caliper_id', $id)->get();
                foreach($caliperVehicles as $caliComp) {
                    CaliperVehicles::where('caliper_id', $id)->delete();
                }
                for($i = 0; $i < count($vehicle); $i++) {
                    if(isset($vehicle[$i])) {
                        $caliperVeh = new CaliperVehicles();
                        $caliperVeh->caliper_id = $caliper->id;
                        $caliperVeh->vehicle_id = $vehicle[$i];
                        $caliperVeh->created_by = auth()->user()->id;
                        $caliperVeh->updated_by = auth()->user()->id;
                        $caliperVeh->save();
                    }
                }
            } catch(Throwable $e) {
                DB::rollBack();
                return redirect()->route('calipers.show', compact('caliper'))
                    ->with('failure', "There was an issue saving the vehicles, please try again or contact IT.");
            }
        }
        DB::commit();
        return redirect()->route('calipers.show', compact('caliper'))
            ->with('success', 'The caliper has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Calipers  $caliper
     * @return \Illuminate\Http\Response
     */
    public function destroy(Calipers $caliper)
    {
        $caliper->delete();
        return redirect()->route('calipers.index')
            ->with('success', 'The caliper has been deleted successfully.');
    }
}
