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
                        <h2>Caliper Families</h2>
                    </div>
                    <div class="float-end">
                        <a class="btn btn-success" href="{{ route('caliperFamilies.create') }}">Create New Family</a>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th>Family Name</th>
                        <th width="15%">Edit</th>
                        <th width="15%">Delete</th>
                    </tr>
                    @foreach ($caliperFamilies as $family)
                    <tr>
                        <td>{{ $family->family }}</td>
                        <td><a class="btn btn-primary btn-sm" href="{{ route('caliperFamilies.edit', ['caliperFamily' => $family->id]) }}" role="button">Edit</a></td>
                        <td>
                            <form action="{{ route('caliperFamilies.destroy', ['caliperFamily' => $family->id]) }}" method="Post">
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