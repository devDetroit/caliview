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
                        <h4><strong>Components</strong></h4>
                    </div>
                    <div class="float-end">
                        <a class="btn btn-success" href="{{ route('components.create') }}">Create New Component</a>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th>Part No.</th>
                        <th>Type</th>
                        <th>Measurements</th>
                        <th width="15%">Edit</th>
                        <th width="15%">Delete</th>
                    </tr>
                    @foreach ($components as $component)
                    <tr>
                        <td>{{ $component->component_number }}</td>
                        <td>{{ $component->componentTypes->type }}</td>
                        <td>{{ $component->measure }}</td>
                        <td><a class="btn btn-primary btn-sm" href="{{ route('components.edit', ['component' => $component->id]) }}" role="button">Edit</a></td>
                        <td>
                            <form action="{{ route('components.destroy', ['component' => $component->id]) }}" method="Post">
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