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
                    New Component Type
                </div>
                <div class="card-body">
                    <form action="{{ route('componentTypes.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="newComponentType" class="form-label">Type name</label>
                            <input type="text" name="type" class="form-control" id="newComponentType" required>
                        </div>
                        <div class="float-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <div class="float-start">
                            <a class="btn btn-danger" href="{{ route('componentTypes.index') }}"> Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection