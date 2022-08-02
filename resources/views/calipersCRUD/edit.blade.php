@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <strong>Edit Caliper {{ $caliper->jh_part_number }} / {{ $caliper->cardone_part_number }} / {{ $caliper->centric_part_number }}</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('calipers.update', ['caliper' => $caliper->id]) }}" method="POST" enctype="multipart/form-data" id="mainForm">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">    
                            <div class="col-sm-4">
                                <label for="jhPN" class="form-label">JH Part No.</label>
                                <input type="text" name="jhPN" value="{{ $caliper->jh_part_number }}" class="form-control" id="jhPN">
                            </div>
                            <div class="col-sm-4">
                                <label for="cardonePN" class="form-label">Cardone Part No.</label>
                                <input type="text" name="cardonePN" value="{{ $caliper->cardone_part_number }}" class="form-control" id="cardonePN">
                            </div>
                            <div class="col-sm-4">
                                <label for="centricPN" class="form-label">Centric Part No.</label>
                                <input type="text" name="centricPN" value="{{ $caliper->centric_part_number }}" class="form-control" id="centricPN">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="caliperFamily" class="form-label">Family</label>
                            <select name="caliperFamily" class="form-select" id="caliperFamily" required>
                                <option value="">Select a Family</option>
                                @foreach($caliperFamilies as $family)
                                @if($caliper->family_id == $family->id)
                                <option selected value="{{ $family->id }}">{{ $family->family }}</option>
                                @else
                                <option value="{{ $family->id }}">{{ $family->family }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="casting1" class="form-label">Casting Number 1</label>
                            <input type="text" name="casting1" value="{{ $caliper->casting1 }}" class="form-control" id="casting1">
                        </div>
                        <div class="mb-3">
                            <label for="casting2" class="form-label">Casting Number 2</label>
                            <input type="text" name="casting2" value="{{ $caliper->casting2 }}" class="form-control" id="casting2">
                        </div>
                        <div class="mb-3">
                            <label for="bracketCasting" class="form-label">Bracket Casting Number</label>
                            <input type="text" name="bracketCasting" value="{{ $caliper->bracket_casting }}" class="form-control" id="bracketCasting">
                        </div>
                        <div class="mb-3">
                            <label for="caliperPhotosMultiple" class="form-label">Upload Photos</label>
                            <input name="caliperPhotos[]" class="form-control" type="file" id="caliperPhotosMultiple" multiple>
                        </div>
                        @foreach($caliperComponents as $caliComp)
                        <div class="row mb-3" id="baseRow">
                            <div class="col-sm-4">
                                <label for="componentNo" class="form-label">Component</label>
                                <select name="componentNo" class="form-select" id="componentNo">
                                    <option value="">Select a Component</option>
                                    @foreach($components as $component)
                                    @if($caliComp->component_id == $component->id)
                                    <option selected value="{{ $component->id }}">{{ $component->component_number }}</option>
                                    @else
                                    <option value="{{ $component->id }}">{{ $component->component_number }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="componentMeasure" class="form-label">Measurements</label>
                                <input type="text" name="componentMeasure" value="{{ $caliComp->components->measure }}" class="form-control" id="componentMeasure" readonly>
                            </div>
                            <div class="col-sm-2">
                                <label for="componentQuantity" class="form-label">Qty</label>
                                <input type="text" name="componentQuantity" value="{{ $caliComp->quantity }}" class="form-control" id="componentQuantity">
                            </div>
                        </div>
                        @endforeach
                        <div class="float-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <div class="float-start">
                            <a class="btn btn-danger" href="{{ route('calipers.show', ['caliper' => $caliper->id]) }}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($caliperPhotos as $photo)
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <strong>Photo: {{ $caliper->id }}-{{ $photo->id }}</strong>
                            <div class="float-end">
                                <form action="{{ route('caliperPhotos.destroy', ['caliperPhoto' => $photo->id]) }}" method="Post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                </form>
                            </div>
                        </div>
                        <a href="/storage/calipers/{{ $photo->filename }}" target="_blank"><img src="/storage/calipers/{{ $photo->filename }}" class="card-img-top"></a>
                        <div class="card-body">
                            <h5 class="card-title">Description:</h5>
                            <p class="card-text">
                                <textarea value="{{ $photo->description ?? '' }}" class="form-control" id="photoDescription" rows="3"></textarea>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    var component = document.getElementById("componentNo");
    component.addEventListener("change", function()
    {
        if(component.value == "")
        {
            document.getElementById("componentMeasure").value = "";
            document.getElementById("componentQuantity").removeAttribute("required");
        }
        else
        {
            document.getElementById("componentMeasure").value = '<?=$component->measure?>';
            document.getElementById("componentQuantity").setAttribute("required", "");
        }
    });
</script>
@endsection