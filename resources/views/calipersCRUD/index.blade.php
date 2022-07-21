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
                        <h2>Calipers</h2>
                    </div>
                    <div class="float-end">
                        <a class="btn btn-success" href="{{ route('calipers.create') }}"> Create New Caliper</a>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th>Part No.</th>
                        <th>Family</th>
                        <th width="15%">Edit</th>
                        <th width="15%">Delete</th>
                    </tr>
                    @foreach ($calipers as $caliper)
                    <tr>
                        <td>{{ $caliper->part_number }}</td>
                        <td>{{ $caliper->caliperFamilies->family }}</td>
                        <td>{{ $caliper->created_at }}</td>
                        <td>{{ $caliper->updated_at }}</td>
                        <td><a class="btn btn-primary btn-sm" href="{{ route('calipers.edit', ['caliper' => $caliper->id]) }}" role="button">Edit</a></td>
                        <td>
                            <form action="{{ route('calipers.destroy', ['caliper' => $caliper->id]) }}" method="Post">
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