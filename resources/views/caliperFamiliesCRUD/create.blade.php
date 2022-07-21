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
                    New Caliper Family
                </div>
                <div class="card-body">
                    <form action="{{ route('caliperFamilies.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="caliperFamily" class="form-label">Family name</label>
                            <input type="text" name="family" class="form-control" id="caliperFamily" required>
                        </div>
                        <div class="float-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <div class="float-start">
                            <a class="btn btn-danger" href="{{ route('caliperFamilies.index') }}"> Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection