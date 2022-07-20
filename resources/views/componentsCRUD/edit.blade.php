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
                    Edit Component Type
                </div>
                <div class="card-body">
                    <form action="{{ route('components.update', ['component' => $component->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="editComponent" class="form-label">Part No.</label>
                            <input type="text" name="type" value="{{ $components->component_number }}" class="form-control" id="editComponent" required>
                        </div>
                        <div class="mb-3">
                            <label for="editType" class="form-label">Type</label>
                            <input type="text" name="type" value="{{ $components->type_id }}" class="form-control" id="editType" required>
                        </div>
                        <div class="mb-3">
                            <label for="editMeasure" class="form-label">Measurements</label>
                            <input type="text" name="type" value="{{ $components->measure }}" class="form-control" id="editMeasure" required>
                        </div>
                        <div class="float-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <div class="float-start">
                            <a class="btn btn-danger" href="{{ route('components.index') }}"> Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection