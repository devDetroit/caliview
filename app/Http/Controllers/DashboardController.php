<?php

namespace App\Http\Controllers;

use App\Models\Calipers;
use App\Models\CaliperComponents;
use App\Models\CaliperVehicles;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard', [
            'calipers' => Calipers::with(['caliperFamilies', 'caliperComponents', 'caliperVehicles'])->orderBy('id')->get()
        ]);
    }
}
