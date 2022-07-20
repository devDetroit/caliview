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
                        <h2>Component Types</h2>
                    </div>
                    <div class="float-end">
                        <a class="btn btn-success" href="{{ route('componentTypes.create') }}"> Create a New Type</a>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>Type Name</th>
                        <th width="15%">Edit</th>
                        <th width="15%">Delete</th>
                    </tr>
                    @foreach ($componentType as $type)
                    <tr>
                        <td>{{ $type->id }}</td>
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