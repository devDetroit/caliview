@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <strong>New Caliper</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('calipers.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="caliperNumber" class="form-label">Part No.</label>
                            <input type="text" name="caliperNumber" class="form-control" id="caliperNumber" required>
                        </div>
                        <div class="mb-3">
                            <label for="caliperFamily" class="form-label">Family</label>
                            <select name="caliperFamily" class="form-select" id="caliperFamily" required>
                                <option selected value="">Select a Family</option>
                                @foreach($caliperFamilies as $family)
                                <option value="{{ $family->id }}">{{$family->family}}</option>
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
                            <a class="btn btn-danger" href="{{ route('calipers.index') }}"> Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection