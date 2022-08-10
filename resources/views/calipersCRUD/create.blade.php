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
                    <h4><strong>New Caliper</strong></h4>
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
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <label for="caliperPhotosMultiple" class="form-label">Upload Photos</label>
                                <input name="caliperPhotos[]" class="form-control" type="file" id="caliperPhotosMultiple" multiple>
                            </div>
                        </div>
                        <div class="row">
                            <h5 class="card-title"><strong>Related Components</strong></h5>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <label for="componentNo[0]" class="form-label">Component</label>
                                <select name="componentNo[0]" class="form-select" id="componentNo[0]" onchange="autofillMeasure(0)">
                                    <option selected value="">Select a Component</option>
                                    @foreach($components as $component)
                                    <option value="{{ $component->id }}">{{ $component->component_number }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-5">
                                <label for="componentMeasure[0]" class="form-label">Measurements</label>
                                <input type="text" name="componentMeasure[0]" class="form-control" id="componentMeasure[0]" readonly>
                            </div>
                            <div class="col-sm-2">
                                <label for="componentQuantity[0]" class="form-label">Quantity</label>
                                <input type="text" name="componentQuantity[0]" class="form-control" id="componentQuantity[0]">
                            </div>
                            <div class="col-sm-1 mt-4">
                                <a class="btn btn-success btn-sm" onclick="addComponents()">+</a>
                            </div>
                        </div>
                        <div id="extraComponents"></div>
                        <div class="row">
                            <h5 class="card-title"><strong>Compatible Vehicles</strong></h5>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-2">
                                <select name="vehicleYear[0]" class="form-select" id="vehicleYear[0]" onchange="autofillMakers(0)">
                                    <option selected value="">Year</option>
                                    @for($i = date("Y"); $i >= 1960; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select name="vehicleMaker[0]" class="form-select" id="vehicleMaker[0]" onchange="autofillModels(0)">
                                    <option selected value="">Maker</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select name="vehicleModel[0]" class="form-select" id="vehicleModel[0]" onchange="autofillEngines(0)">
                                    <option selected value="">Model</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select name="vehicleEngine[0]" class="form-select" id="vehicleEngine[0]">
                                    <option selected value="">Engine</option>
                                </select>
                            </div>
                            <div class="col-sm-1 mt-1">
                                <a class="btn btn-success btn-sm" onclick="addVehicles()">+</a>
                            </div>
                        </div>
                        <div id="extraVehicles"></div>
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
    //--------------------COMPONENTS--------------------\\
    // Autofill measure when selecting a Component and switch requirement on Quantity
    const components = <?php echo json_encode($components); ?>;
    
    function autofillMeasure(id) {
        if (event.target.value == "") {
            document.getElementById(`componentMeasure[${id}]`).value = "";
            document.getElementById(`componentQuantity[${id}]`).removeAttribute("required");
        } else {
            document.getElementById(`componentMeasure[${id}]`).value = components[(event.target.value) - 1].measure;
            document.getElementById(`componentQuantity[${id}]`).setAttribute("required", "");
        }
    }

    // Add component forms
    let compCount = 1; //Counter for the number of components added

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
        selectComponentNo.name = `componentNo[${compCount}]`;
        selectComponentNo.className = "form-select";
        selectComponentNo.id = `componentNo[${compCount}]`;
        selectComponentNo.setAttribute("onchange", `autofillMeasure(${compCount})`)
        divComponentNo.appendChild(selectComponentNo);

        let defaultOptComponentNo = document.createElement("option");
        defaultOptComponentNo.value = "";
        defaultOptComponentNo.text = "Select a Component";
        defaultOptComponentNo.selected = true;
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
        inputComponentMeasure.name = `componentMeasure[${compCount}]`;
        inputComponentMeasure.className = "form-control";
        inputComponentMeasure.id = `componentMeasure[${compCount}]`;
        inputComponentMeasure.readOnly = true;
        divComponentMeasure.appendChild(inputComponentMeasure);

        // Quantity column
        let divComponentQty = document.createElement("div");
        divComponentQty.className = "col-sm-2";
        divRow.appendChild(divComponentQty);

        let inputComponentQty = document.createElement("input");
        inputComponentQty.name = `componentQuantity[${compCount}]`;
        inputComponentQty.className = "form-control";
        inputComponentQty.id = `componentQuantity[${compCount}]`;
        divComponentQty.appendChild(inputComponentQty);

        // Add and Remove buttons
        let divButtons = document.createElement("div");
        divButtons.className = "col-sm-1";
        divRow.appendChild(divButtons);

        /* let buttonAdd = document.createElement("a");
        buttonAdd.className = "btn btn-success btn-sm";
        buttonAdd.setAttribute("onclick",  "addComponents()");
        buttonAdd.text = "+";
        divButtons.appendChild(buttonAdd); */

        let buttonRemove = document.createElement("a");
        buttonRemove.className = "btn btn-danger btn-sm";
        buttonRemove.setAttribute("onclick", `removeComponents(${compCount})`);
        buttonRemove.text = "-";
        divButtons.appendChild(buttonRemove);

        // Add to counter
        compCount += 1;
    }
    
    // Remove component forms
    function removeComponents(rowNumber) {
        let mainForm = document.getElementById("extraComponents");
        let childRow = document.getElementById(`row${rowNumber}`);
        mainForm.removeChild(childRow);
    }

    //--------------------VEHICLES--------------------\\
    // Autofill Makers when selecting a Year and switch requirement on the rest of the form
    const vehicles = <?php echo json_encode($vehicles); ?>;

    function autofillMakers(id) {
        let selectMaker = document.getElementById(`vehicleMaker[${id}]`);
        if (event.target.value != "") {
            selectMaker.replaceChildren();
            let defaultOptMaker = document.createElement("option");
            defaultOptMaker.value = "";
            defaultOptMaker.text = "Maker";
            defaultOptMaker.selected = true;
            selectMaker.appendChild(defaultOptMaker);
            vehicles.forEach((vehicle) => {
                if(vehicle.year == event.target.value) {
                    let optionMaker = document.createElement("option");
                    optionMaker.value = vehicle.maker;
                    optionMaker.text = vehicle.maker;
                    selectMaker.appendChild(optionMaker);
                }
            })
            document.getElementById(`vehicleMaker[${id}]`).setAttribute("required", "");
            document.getElementById(`vehicleModel[${id}]`).setAttribute("required", "");
            document.getElementById(`vehicleEngine[${id}]`).setAttribute("required", "");
            autofillModels(id);
            autofillEngines(id);
        } else {
            selectMaker.replaceChildren();
            let defaultOptMaker = document.createElement("option");
            defaultOptMaker.value = "";
            defaultOptMaker.text = "Maker";
            defaultOptMaker.selected = true;
            selectMaker.appendChild(defaultOptMaker);
            document.getElementById(`vehicleMaker[${id}]`).removeAttribute("required");
            document.getElementById(`vehicleModel[${id}]`).removeAttribute("required");
            document.getElementById(`vehicleEngine[${id}]`).removeAttribute("required");
            autofillModels(id);
            autofillEngines(id);
        }
    }

    // Autofill Models when selecting a Maker
    function autofillModels(id) {
        let selectYear = document.getElementById(`vehicleYear[${id}]`);
        let selectModel = document.getElementById(`vehicleModel[${id}]`);
        if (event.target.value != "") {
            selectModel.replaceChildren();
            let defaultOptModel = document.createElement("option");
            defaultOptModel.value = "";
            defaultOptModel.text = "Model";
            defaultOptModel.selected = true;
            selectModel.appendChild(defaultOptModel);
            vehicles.forEach((vehicle) => {
                if(vehicle.year == selectYear.value && vehicle.maker == event.target.value) {
                    let optionModel = document.createElement("option");
                    optionModel.value = vehicle.model;
                    optionModel.text = vehicle.model;
                    selectModel.appendChild(optionModel);
                }
            })
            autofillEngines(id);
        } else {
            selectModel.replaceChildren();
            let defaultOptModel = document.createElement("option");
            defaultOptModel.value = "";
            defaultOptModel.text = "Model";
            defaultOptModel.selected = true;
            selectModel.appendChild(defaultOptModel);
            autofillEngines(id);
        }
    }

    // Autofill Engines when selecting a Model
    function autofillEngines(id) {
        let selectYear = document.getElementById(`vehicleYear[${id}]`);
        let selectMaker = document.getElementById(`vehicleMaker[${id}]`);
        let selectEngine = document.getElementById(`vehicleEngine[${id}]`);
        if (event.target.value != "") {
            selectEngine.replaceChildren();
            let defaultOptEngine = document.createElement("option");
            defaultOptEngine.value = "";
            defaultOptEngine.text = "Engine";
            defaultOptEngine.selected = true;
            selectEngine.appendChild(defaultOptEngine);
            vehicles.forEach((vehicle) => {
                if(vehicle.year == selectYear.value && vehicle.maker == selectMaker.value && vehicle.model == event.target.value) {
                    let optionEngine = document.createElement("option");
                    optionEngine.value = vehicle.id;
                    optionEngine.text = vehicle.engine;
                    selectEngine.appendChild(optionEngine);
                }
            })
        } else {
            selectEngine.replaceChildren();
            let defaultOptEngine = document.createElement("option");
            defaultOptEngine.value = "";
            defaultOptEngine.text = "Engine";
            defaultOptEngine.selected = true;
            selectEngine.appendChild(defaultOptEngine);
        }
    }

    // Add vehicle forms
    let vehCount = 1; //Counter for the number of components added

    function addVehicles() {
        // Create new row
        let mainForm = document.getElementById("extraVehicles");
        let divRow = document.createElement("div");
        divRow.className = "row mb-3";
        divRow.id = "row" + vehCount;
        mainForm.appendChild(divRow);

        // Year column
        let divYear = document.createElement("div");
        divYear.className = "col-sm-2";
        divRow.appendChild(divYear);

        let selectYear = document.createElement("select");
        selectYear.name = `vehicleYear[${vehCount}]`;
        selectYear.className = "form-select";
        selectYear.id = `vehicleYear[${vehCount}]`;
        selectYear.setAttribute("onchange", `autofillMakers(${vehCount})`)
        divYear.appendChild(selectYear);

        let defaultOptYear = document.createElement("option");
        defaultOptYear.value = "";
        defaultOptYear.text = "Year";
        defaultOptYear.selected = true;
        selectYear.appendChild(defaultOptYear);

        for (let i = new Date().getFullYear(); i >= 1960; i--) {
            let optionYear = document.createElement("option");
            optionYear.value = i;
            optionYear.text = i;
            selectYear.appendChild(optionYear);
        };

        // Maker column
        let divMaker = document.createElement("div");
        divMaker.className = "col-sm-3";
        divRow.appendChild(divMaker);

        let selectMaker = document.createElement("select");
        selectMaker.name = `vehicleMaker[${vehCount}]`;
        selectMaker.className = "form-select";
        selectMaker.id = `vehicleMaker[${vehCount}]`;
        selectMaker.setAttribute("onchange", `autofillModels(${vehCount})`)
        divMaker.appendChild(selectMaker);

        let defaultOptMaker = document.createElement("option");
        defaultOptMaker.value = "";
        defaultOptMaker.text = "Maker";
        defaultOptMaker.selected = true;
        selectMaker.appendChild(defaultOptMaker);

        // Model column
        let divModel = document.createElement("div");
        divModel.className = "col-sm-3";
        divRow.appendChild(divModel);

        let selectModel = document.createElement("select");
        selectModel.name = `vehicleModel[${vehCount}]`;
        selectModel.className = "form-select";
        selectModel.id = `vehicleModel[${vehCount}]`;
        selectModel.setAttribute("onchange", `autofillEngines(${vehCount})`)
        divModel.appendChild(selectModel);

        let defaultOptModel = document.createElement("option");
        defaultOptModel.value = "";
        defaultOptModel.text = "Model";
        defaultOptModel.selected = true;
        selectModel.appendChild(defaultOptModel);

        // Engine column
        let divEngine = document.createElement("div");
        divEngine.className = "col-sm-3";
        divRow.appendChild(divEngine);

        let selectEngine = document.createElement("select");
        selectEngine.name = `vehicleEngine[${vehCount}]`;
        selectEngine.className = "form-select";
        selectEngine.id = `vehicleEngine[${vehCount}]`;
        divEngine.appendChild(selectEngine);

        let defaultOptEngine = document.createElement("option");
        defaultOptEngine.value = "";
        defaultOptEngine.text = "Engine";
        defaultOptEngine.selected = true;
        selectEngine.appendChild(defaultOptEngine);

        // Add and Remove buttons
        let divButtons = document.createElement("div");
        divButtons.className = "col-sm-1";
        divRow.appendChild(divButtons);

        /* let buttonAdd = document.createElement("a");
        buttonAdd.className = "btn btn-success btn-sm";
        buttonAdd.setAttribute("onclick", "addVehicles()");
        buttonAdd.text = "+";
        divButtons.appendChild(buttonAdd); */

        let buttonRemove = document.createElement("a");
        buttonRemove.className = "btn btn-danger btn-sm";
        buttonRemove.setAttribute("onclick", `removeVehicles(${vehCount})`);
        buttonRemove.text = "-";
        divButtons.appendChild(buttonRemove);

        // Add to counter
        vehCount += 1;
    }
    
    // Remove vehicle forms
    function removeVehicles(rowNumber) {
        let mainForm = document.getElementById("extraVehicles");
        let childRow = document.getElementById(`row${rowNumber}`);
        mainForm.removeChild(childRow);
    }
</script>
@endsection