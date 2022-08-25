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
                        <h4><strong>Component Types</strong></h4>
                    </div>
                    <div class="float-end">
                        <a class="btn btn-success" href="{{ route('componentTypes.create') }}">Create New Type</a>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th>Type Name</th>
                        <th width="15%">Edit</th>
                        <th width="15%">Delete</th>
                    </tr>
                    @foreach ($componentTypes as $type)
                    <tr>
                        <td>{{ $type->type }}</td>
                        <td><a class="btn btn-primary btn-sm" href="{{ route('componentTypes.edit', ['componentType' => $type->id]) }}" role="button">Edit</a></td>
                        <td>
                            <form action="{{ route('componentTypes.destroy', ['componentType' => $type->id]) }}" method="Post">
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