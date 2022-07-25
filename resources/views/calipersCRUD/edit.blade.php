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
                    <strong>Edit Caliper {{ $caliper->part_number }}</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('calipers.update', ['caliper' => $caliper->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="caliperNumber" class="form-label">Part No.</label>
                            <input type="text" name="caliperNumber" value="{{ $caliper->part_number }}" class="form-control" id="caliperNumber" required>
                        </div>
                        <div class="mb-3">
                            <label for="caliperFamily" class="form-label">Family</label>
                            <select name="caliperFamily" class="form-select" id="caliperFamily" required>
                                <option value="">Select a Family</option>
                                @foreach($caliperFamilies as $family)
                                @if($caliper->family_id == $family->id)
                                <option selected value="{{ $family->id }}">{{$family->family}}</option>
                                @else
                                <option value="{{ $family->id }}">{{$family->family}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="caliperPhotosMultiple" class="form-label">Upload Photos</label>
                            <input name="caliperPhotos[]" class="form-control" type="file" id="caliperPhotosMultiple" multiple>
                        </div>
                        <div class="float-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <div class="float-start">
                            <a class="btn btn-danger" href="{{ route('calipers.show', ['caliper' => $caliper->id]) }}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <strong>Photo:</strong>
                            <div class="float-end">
                                <form action="{{ route('calipers.destroy', ['caliper' => $caliper->id]) }}" method="Post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                </form>
                            </div>
                        </div>
                        <img src="..." class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">Notes:</h5>
                            <p class="card-text">No notes available</p>
                        </div>
                        <div class="card-footer">
                            <strong> Status:</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection