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
                    <strong>New Caliper</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('calipers.store') }}" method="POST" enctype="multipart/form-data" id="mainForm">
                        @csrf
                        <div class="mb-3">
                            <label for="caliperNumber" class="form-label">Part No.</label>
                            <input type="text" name="caliperNumber" class="form-control" id="caliperNumber" required>
                        </div>
                        <div class="mb-3">
                            <label for="caliperFamily" class="form-label">Family</label>
                            <select name="caliperFamily" class="form-select" id="caliperFamily" required>
                                <option selected value="">Select a Family</option>
                                @foreach($caliperFamilies as $family)
                                <option value="{{ $family->id }}">{{ $family->family }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="caliperPhotosMultiple" class="form-label">Upload Photos</label>
                            <input name="caliperPhotos[]" class="form-control" type="file" id="caliperPhotosMultiple"multiple>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <label for="componentNo" class="form-label">Component</label>
                                <select name="componentNo" class="form-select" id="componentNo">
                                    <option selected value="">Select a Component</option>
                                    @foreach($components as $component)
                                    <option value="{{ $component->id }}">{{ $component->component_number }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-5">
                                <label for="componentMeasure" class="form-label">Measurements</label>
                                <input type="text" name="componentMeasure" class="form-control" id="componentMeasure" readonly>
                            </div>
                            <div class="col-sm-2">
                                <label for="componentQuantity" class="form-label">Quantity</label>
                                <input type="text" name="componentQuantity" class="form-control" id="componentQuantity">
                            </div>
                            <div class="col-sm-1 mt-4">
                                <a class="btn btn-success btn-sm" onclick="addComponents();">+</a>
                            </div>
                        </div>
                        <div class="float-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <div class="float-start">
                            <a class="btn btn-danger" href="{{ route('calipers.index') }}"> Cancel</a>
                        </div>
                    </form>
                </div>
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
            document.getElementById("componentMeasure").value = "<?=$component->measure?>";
            document.getElementById("componentQuantity").setAttribute("required", "");
        }
    });

    var compCount = 1;
    function addComponents()
    {
        // Create new row
        let mainForm = document.getElementById("mainForm");
        let divRow = document.createElement("div");
        divRow.className = "row mb-3";
        divRow.id = "row" + compCount;
        mainForm.appendChild(divRow);

        // Component column
        let divComponentNo = document.createElement("div");
        divComponentNo.className = "col-sm-4";
        divRow.appendChild(divComponentNo);

        let labelComponentNo = document.createElement("label");
        labelComponentNo.htmlFor = "componentNo[${compCount}]";
        labelComponentNo.className = "form-label";
        labelComponentNo.contains = "Component";
        divComponentNo.appendChild(labelComponentNo);

        let selectComponentNo = document.createElement("select");
        selectComponentNo.name = "componentNo[${compCount}]";
        selectComponentNo.className = "form-select";
        selectComponentNo.id = "componentNo[${compCount}]";
        divComponentNo.appendChild(selectComponentNo);

        let defaultOptComponentNo = document.createElement("option");
        defaultOptComponentNo.value = "";
        defaultOptComponentNo.contains = "Select a Component";
        defaultOptComponentNo.setAttribute("selected", "");
        selectComponentNo.appendChild(defaultOptComponentNo);

        let components = <?=$components?>;
        let optionComponentNo = createElement("option");
        components.foreach(function createOptions(component)
        {
            optionComponentNo.value = "<?=$component->id?>";
            selectComponentNo.appendChild(optionComponentNo);
        });

        // Measure column
        let divComponentMeasure = document.createElement("div");
        divComponentMeasure.className = "col-sm-5";
        divRow.appendChild(divComponentMeasure);

        let labelComponentMeasure = document.createElement("label");
        labelComponentMeasure.htmlFor = "componentMeasure[${compCount}]";
        labelComponentMeasure.className = "form-label";
        labelComponentMeasure.contains = "Measurements";
        divComponentMeasure.appendChild(labelComponentMeasure);

        let inputComponentMeasure = document.createElement("input");
        inputComponentMeasure.name = "componentMeasure[${compCount}]";
        inputComponentMeasure.className = "form-control";
        inputComponentMeasure.id = "componentMeasure[${compCount}]";
        divComponentMeasure.appendChild(inputComponentMeasure);

        // Quantity column
        let divComponentQty = document.createElement("div");
        divComponentQty.className = "col-sm-2";
        divRow.appendChild(divComponentQty);

        let labelComponentQty = document.createElement("label");
        labelComponentQty.htmlFor = "componentQuantity[${icompCount}]";
        labelComponentQty.className = "form-label";
        labelComponentQty.contains = "Measurements";
        divComponentQty.appendChild(labelComponentQty);

        let inputComponentQty = document.createElement("input");
        inputComponentQty.name = "componentQuantity[${compCount}]";
        inputComponentQty.className = "form-control";
        inputComponentQty.id = "componentQuantity[${compCount}]";
        divComponentQty.appendChild(inputComponentQty);

        // Add and Remove buttons
        let divButtons = document.createElement("div");
        divButtons.className = "col-sm-1";
        divRow.appendChild(divButtons);

        let buttonAdd = document.createElement("a");
        buttonAdd.className = "btn btn-success btn-sm";
        buttonAdd.onclick = "addComponents();";
        buttonAdd.contains = "+";
        divButtons.appendChild(buttonAdd);

        let buttonRemove = document.createElement("a");
        buttonRemove.className = "btn btn-danger btn-sm";
        buttonRemove.onclick = "removeComponents(${compCount});";
        buttonRemove.contains = "-";
        divButtons.appendChild(buttonRemove);

        // Add to counter
        compCount += 1;
    }

    function removeComponents(rowNumber)
    {
        let mainForm = document.getElementById("mainForm");
        let childRow = document.getElementById("row" + rowNumber);
        mainForm.removeChild(childRow);
    }
</script>
@endsection