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
                    Edit Component
                </div>
                <div class="card-body">
                    <form action="{{ route('components.update', ['component' => $component->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="componentNumber" class="form-label">Part No.</label>
                            <input type="text" name="componentNumber" value="{{ $component->component_number }}" class="form-control" id="componentNumber" required>
                        </div>
                        <div class="mb-3">
                            <label for="componentType" class="form-label">Type</label>
                            <select name="componentType" class="form-select" id="componentType" required>
                                <option selected value="">Select a component type</option>
                                @foreach($componentTypes as $type)
                                <option value="{{ $type->id }}">{{$type->type}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="measurement" class="form-label">Measurements</label>
                            <input type="text" name="measure" value="{{ $component->measure }}" class="form-control" id="measurement" required>
                        </div>
                        <div class="float-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <div class="float-start">
                            <a class="btn btn-danger" href="{{ route('components.index') }}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection