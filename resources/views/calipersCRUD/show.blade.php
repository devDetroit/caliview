@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <strong>{{ $caliper->jh_part_number }} / {{ $caliper->cardone_part_number }} / {{ $caliper->centric_part_number }} Caliper Details</strong>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row mb-3">    
                            <div class="col-sm-4">
                                <label for="jhPN" class="form-label">JH Part No.</label>
                                <input type="text" name="jhPN" value="{{ $caliper->jh_part_number }}" class="form-control" id="jhPN" readonly>
                            </div>
                            <div class="col-sm-4">
                                <label for="cardonePN" class="form-label">Cardone Part No.</label>
                                <input type="text" name="cardonePN" value="{{ $caliper->cardone_part_number }}" class="form-control" id="cardonePN" readonly>
                            </div>
                            <div class="col-sm-4">
                                <label for="centricPN" class="form-label">Centric Part No.</label>
                                <input type="text" name="centricPN" value="{{ $caliper->centric_part_number }}" class="form-control" id="centricPN" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="caliperFamily" class="form-label">Family</label>
                            <input type="text" name="caliperFamily" value="{{ $caliper->caliperFamilies->family }}" class="form-control" id="caliperFamily" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="casting1" class="form-label">Casting Number 1</label>
                            <input type="text" name="casting1" value="{{ $caliper->casting1 }}" class="form-control" id="casting1" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="casting2" class="form-label">Casting Number 2</label>
                            <input type="text" name="casting2" value="{{ $caliper->casting2 }}" class="form-control" id="casting2" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="bracketCasting" class="form-label">Bracket Casting Number</label>
                            <input type="text" name="bracketCasting" value="{{ $caliper->bracket_casting }}" class="form-control" id="bracketCasting" readonly>
                        </div>
                        @if(!empty($caliperComponents[0]))
                        <div class="row">
                            <h5 class="card-title"><strong>Related Components</strong></h5>
                            <div class="col-sm-4">
                                <label for="componentNo" class="form-label">Component</label>
                            </div>
                            <div class="col-sm-5">
                                <label for="componentMeasure" class="form-label">Measurements</label>
                            </div>
                            <div class="col-sm-3">
                                <label for="componentQuantity" class="form-label">Quantity</label>
                            </div>
                        </div>
                        @foreach($caliperComponents as $caliComp)
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <input type="text" name="componentNo" value="{{ $caliComp->components->component_number }}" class="form-control" id="componentNo" readonly>
                            </div>
                            <div class="col-sm-5">
                                <input type="text" name="componentMeasure" value="{{ $caliComp->components->measure }}" class="form-control" id="componentMeasure" readonly>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" name="componentQuantity" value="{{ $caliComp->quantity }}" class="form-control" id="componentQuantity" readonly>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        @if(!empty($caliperVehicles[0]))
                        <div class="row">
                            <h5 class="card-title"><strong>Compatible Vehicles</strong></h5>
                            <div class="col-sm-3">
                                <label for="vehicleYear" class="form-label">Year</label>
                            </div>
                            <div class="col-sm-3">
                                <label for="vehicleMaker" class="form-label">Maker</label>
                            </div>
                            <div class="col-sm-3">
                                <label for="vehicleModel" class="form-label">Model</label>
                            </div>
                            <div class="col-sm-3">
                                <label for="vehicleEngine" class="form-label">Engine</label>
                            </div>
                        </div>
                        @foreach($caliperVehicles as $caliVeh)
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <input type="text" name="vehicleYear" value="{{ $caliVeh->vehicles->year }}" class="form-control" id="vehicleYear" readonly>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" name="vehicleMaker" value="{{ $caliVeh->vehicles->maker }}" class="form-control" id="vehicleMaker" readonly>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" name="vehicleModel" value="{{ $caliVeh->vehicles->model }}" class="form-control" id="vehicleModel" readonly>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" name="vehicleEngine" value="{{ $caliVeh->vehicles->engine }}" class="form-control" id="vehicleEngine" readonly>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        <div class="float-end">
                            <a class="btn btn-primary btn" href="{{ route('calipers.edit', ['caliper' => $caliper->id]) }}" role="button">Edit</a>
                        </div>
                        <div class="float-start">
                            <a class="btn btn-danger" href="{{ route('calipers.index') }}">Go Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @foreach($caliperPhotos as $photo)
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <strong>Photo: {{ $caliper->id }}_{{ $photo->id }}</strong>
                        </div>
                        <a href="/storage/calipers/{{ $photo->filename }}" target="_blank"><img src="/storage/calipers/{{ $photo->filename }}" class="card-img-top"></a>
                        <div class="card-body">
                            <h5 class="card-title">Description:</h5>
                            <p class="card-text">{{ $photo->description ?? 'No description available.' }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection