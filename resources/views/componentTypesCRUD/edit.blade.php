@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="float-end">
                <a class="btn btn-primary" href="{{ route('componentTypes.index') }}" enctype="multipart/form-data"> Back</a>
                @if(session('status'))
                <div class="alert alert-success mb-1 mt-1">
                    {{ session('status') }}
                </div>
                @endif
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Edit Component Type
                    </div>
                    <div class="card-body">
                        <form action="{{ route('componentTypes.update',$type->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="editComponentType" class="form-label">Type name</label>
                                <input type="text" name="type" value="{{ $type->type }}" class="form-control" id="editComponentType" required>
                            </div>
                            <button type="submit" class="btn btn-primary ml-3">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection