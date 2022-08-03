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
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <label for="jhPN" class="form-label">JH Part No.</label>
                                <input type="text" name="jhPN" class="form-control" id="jhPN" required>
                            </div>
                            <div class="col-sm-4">
                                <label for="cardonePN" class="form-label">Cardone Part No.</label>
                                <input type="text" name="cardonePN" class="form-control" id="cardonePN" required>
                            </div>
                            <div class="col-sm-4">
                                <label for="centricPN" class="form-label">Centric Part No.</label>
                                <input type="text" name="centricPN" class="form-control" id="centricPN" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <label for="caliperFamily" class="form-label">Family</label>
                                <select name="caliperFamily" class="form-select" id="caliperFamily" required>
                                    <option selected value="">Select a Family</option>
                                    @foreach($caliperFamilies as $family)
                                    <option value="{{ $family->id }}">{{ $family->family }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <label for="casting1" class="form-label">Casting Number 1</label>
                                <input type="text" name="casting1" class="form-control" id="casting1">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <label for="casting2" class="form-label">Casting Number 2</label>
                                <input type="text" name="casting2" class="form-control" id="casting2">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <label for="bracketCasting" class="form-label">Bracket Casting Number</label>
                                <input type="text" name="bracketCasting" class="form-control" id="bracketCasting">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <label for="caliperPhotosMultiple" class="form-label">Upload Photos</label>
                                <input name="caliperPhotos[]" class="form-control" type="file" id="caliperPhotosMultiple" multiple>
                            </div>
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
                                <a class="btn btn-success btn-sm" onclick="addComponents()">+</a>
                            </div>
                        </div>
                        <div id="extraComponents"></div>
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
    // Autofill measure when selcting a component and switch requirement on quantity
    var componentSelect = document.getElementById("componentNo");
    var components = <?php echo json_encode($components); ?>;

    console.log(components)
    componentSelect.addEventListener("change", function() {
        if (componentSelect.value == "") {
            document.getElementById("componentMeasure").value = "";
            document.getElementById("componentQuantity").removeAttribute("required");
        } else {
            document.getElementById("componentMeasure").value = "<?php echo $component->measure; ?>";
            document.getElementById("componentQuantity").setAttribute("required", "");
        }
    });

    // Add component forms
    var compCount = 1;

    function addComponents() {
        // Create new row
        let mainForm = document.getElementById("extraComponents");
        let divRow = document.createElement("div");
        divRow.className = "row mb-3";
        divRow.id = "row" + compCount;
        mainForm.appendChild(divRow);

        // Component column
        let divComponentNo = document.createElement("div");
        divComponentNo.className = "col-sm-4";
        divRow.appendChild(divComponentNo);

        let selectComponentNo = document.createElement("select");
        selectComponentNo.name = `componentNo${compCount}`;
        selectComponentNo.className = "form-select";
        selectComponentNo.id = `componentNo${compCount}`;
        divComponentNo.appendChild(selectComponentNo);

        let defaultOptComponentNo = document.createElement("option");
        defaultOptComponentNo.value = "";
        defaultOptComponentNo.text = "Select a Component";
        defaultOptComponentNo.setAttribute("selected", "");
        selectComponentNo.appendChild(defaultOptComponentNo);

        for (const component of components) {
            let optionComponentNo = document.createElement("option");
            optionComponentNo.value = component.id;
            optionComponentNo.text = component.component_number;
            selectComponentNo.appendChild(optionComponentNo);
        };

        // Measure column
        let divComponentMeasure = document.createElement("div");
        divComponentMeasure.className = "col-sm-5";
        divRow.appendChild(divComponentMeasure);

        let inputComponentMeasure = document.createElement("input");
        inputComponentMeasure.name = "componentMeasure[${compCount}]";
        inputComponentMeasure.className = "form-control";
        inputComponentMeasure.id = "componentMeasure[${compCount}]";
        inputComponentMeasure.readOnly = true;
        divComponentMeasure.appendChild(inputComponentMeasure);

        // Quantity column
        let divComponentQty = document.createElement("div");
        divComponentQty.className = "col-sm-2";
        divRow.appendChild(divComponentQty);

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

    function removeComponents(rowNumber) {
        let mainForm = document.getElementById("mainForm");
        let childRow = document.getElementById("row" + rowNumber);
        mainForm.removeChild(childRow);
    }
</script>
@endsection