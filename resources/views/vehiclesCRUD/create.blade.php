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
                    New Vehicle
                </div>
                <div class="card-body">
                    <form action="{{ route('vehicles.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="maker" class="form-label">Maker</label>
                            <input type="text" name="maker" class="form-control" id="maker" maxlength="32" required>
                        </div>
                        <div class="mb-3">
                            <label for="model" class="form-label">Model</label>
                            <input type="text" name="model" class="form-control" id="model" maxlength="32" required>
                        </div>
                        <div class="mb-3">
                            <label for="year" class="form-label">Year</label>
                            <input type="number" name="year" class="form-control" id="year" min="1960" max="2022" required>
                        </div>
                        <div class="mb-3">
                            <label for="engine" class="form-label">Engine</label>
                            <input type="text" name="engine" class="form-control" id="engine" maxlength="32" required>
                        </div>
                        <div class="float-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <div class="float-start">
                            <a class="btn btn-danger" href="{{ route('vehicles.index') }}"> Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection