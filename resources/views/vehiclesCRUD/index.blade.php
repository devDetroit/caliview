@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        <h4><strong>Vehicles</strong></h4>
                    </div>
                    <div class="float-end">
                        <a class="btn btn-success" href="{{ route('vehicles.create') }}">Add New Vehicle</a>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th>Maker</th>
                        <th>Model</th>
                        <th>Year</th>
                        <th>Engine</th>
                        <th width="15%">Edit</th>
                        <th width="15%">Delete</th>
                    </tr>
                    @foreach ($vehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->maker }}</td>
                        <td>{{ $vehicle->model }}</td>
                        <td>{{ $vehicle->year }}</td>
                        <td>{{ $vehicle->engine }}</td>
                        <td><a class="btn btn-primary btn-sm" href="{{ route('vehicles.edit', ['vehicle' => $vehicle->id]) }}" role="button">Edit</a></td>
                        <td>
                            <form action="{{ route('vehicles.destroy', ['vehicle' => $vehicle->id]) }}" method="Post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection