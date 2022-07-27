@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <strong>{{ $caliper->part_number }} Caliper Details</strong>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="caliperNumber" class="form-label">Part No.</label>
                            <input type="text" name="caliperNumber" value="{{ $caliper->part_number }}" class="form-control" id="caliperNumber" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="caliperFamily" class="form-label">Family</label>
                            <select name="caliperFamily" class="form-select" id="caliperFamily" disabled>
                                <option value="{{ $caliper->caliperFamilies->id }}">{{$caliper->caliperFamilies->family}}</option>
                            </select>
                        </div>
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
        <div class="col-md-8">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($caliperPhotos as $photo)
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <strong>Photo: {{ $caliper->part_number }}{{ $photo->id }}</strong>
                        </div>
                        <a href="/storage/calipers/{{ $photo->image }}" target="_blank"><img src="/storage/calipers/{{ $photo->image }}" class="card-img-top"></a>
                        <div class="card-body">
                            <h5 class="card-title">Notes:</h5>
                            <p class="card-text">No notes available</p>
                        </div>
                        <div class="card-footer">
                            <strong> Status:</strong>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection