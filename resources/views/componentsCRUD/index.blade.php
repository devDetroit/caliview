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
                        <h2>Components</h2>
                    </div>
                    <div class="float-end">
                        <a class="btn btn-success" href="{{ route('components.create') }}"> Create a New Component</a>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th>Part No.</th>
                        <th>Type</th>
                        <th>Measurements</th>
                        <th width="35%">Action</th>
                    </tr>
                    @foreach ($component as $component)
                    <tr>
                        <td>{{ $component->component_number }}</td>
                        <td>{{ $component->type_id }}</td>
                        <td>{{ $component->measure }}</td>
                        <td>
                            <form action="{{ route('components.destroy', ['component' => $component->id]) }}" method="Post">
                                <a class="btn btn-primary btn-sm" href="{{ route('components.edit', ['component' => $type->id]) }}" role="button">Edit</a>
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