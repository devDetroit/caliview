<?php

namespace App\Http\Controllers;

use App\Models\Calipers;
use App\Models\CaliperFamilies;
use App\Models\CaliperPhotos;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

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
            'caliperFamilies' => CaliperFamilies::orderBy('id')->get()
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
            'caliperNumber' => 'required',
            'caliperFamily' => 'required'
        ]);
        $caliper = new Calipers;
        $caliper->part_number = $request->caliperNumber;
        $caliper->family_id = $request->caliperFamily;
        $caliper->created_by = auth()->user()->id;
        $caliper->updated_by = auth()->user()->id;
        //$caliper->save();
        if(count($request->caliperPhotos) > 0)
        {
            $photos = new CaliperPhotos;
            foreach($request->caliperPhotos as $reqPhoto)
            {
                /* $photos->caliper_id = $caliper->id;
                $photos->path = '/storage/calipers/' . $caliper->part_number . date('YmdHis') . $reqPhoto->extension();
                $photos->created_by = auth()->user()->id;
                $photos->updated_by = auth()->user()->id; */
                $request->file($reqPhoto)->storeAs('calipers', $request->caliperNumber .''. date('YmdHis') .''. $reqPhoto->extension());
            }
        }
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
        return view('calipersCRUD.show', compact('caliper'));
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
            'caliperFamilies' => CaliperFamilies::orderBy('id')->get()
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
        $request->validate([
            'caliperNumber' => 'required',
            'caliperFamily' => 'required'
        ]);
        $caliper = Calipers::find($id);
        $caliper->part_number = $request->caliperNumber;
        $caliper->family_id = $request->caliperFamily;
        $caliper->updated_by = auth()->user()->id;
        $caliper->save();
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
