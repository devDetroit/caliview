@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <div class="col-md-6">
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
                        @if(empty($caliperComponents[0]))
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
                        @else
                        <div class="row">
                            <h5 class="card-title"><strong>Related Components</strong></h5>
                            <div class="col-sm-4">
                                <label for="componentNo" class="form-label">Component</label>
                            </div>
                            <div class="col-sm-5">
                                <label for="componentMeasure" class="form-label">Measurements</label>
                            </div>
                            <div class="col-sm-2">
                                <label for="componentQuantity" class="form-label">Quantity</label>
                            </div>
                            <div class="col-sm-1">
                                <a class="btn btn-success btn-sm" onclick="addComponents()">+</a>
                            </div>
                        </div>
                        <div id="currentComponents">
                        <!-- @for($i = 0; $i < count($caliperComponents); $i++)
                            <div class="row mb-3" id="baseRow">
                                <div class="col-sm-4">
                                    <select name="componentNo[{{$i}}]" class="form-select" id="componentNo[{{$i}}]">
                                        <option value="">Select a Component</option>
                                        @foreach($components as $component)
                                        @if($caliperComponents[$i]->component_id == $component->id)
                                        <option selected value="{{ $component->id }}">{{ $component->component_number }}</option>
                                        @else
                                        <option value="{{ $component->id }}">{{ $component->component_number }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" name="componentMeasure[{{$i}}]" value="{{ $caliperComponents[$i]->components->measure }}" class="form-control" id="componentMeasure[{{$i}}]" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" name="componentQuantity[{{$i}}]" value="{{ $caliperComponents[$i]->quantity }}" class="form-control" id="componentQuantity[{{$i}}]">
                                </div>
                                <div class="col-sm-1">
                                    <a class="btn btn-danger btn-sm" onclick="removeComponents($i)">-</a>
                                </div>
                            </div>
                        @endfor -->
                        </div>
                        @endif
                        @if(empty($caliperVehicles[0]))
                        <div class="row">
                            <h5 class="card-title"><strong>Compatible Vehicles</strong></h5>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-2">
                                <label for="vehicleYear" class="form-label">Year</label>
                                <select name="vehicleYear[0]" class="form-select" id="vehicleYear[0]" onchange="autofillMakers(0)">
                                    <option selected value="">Year</option>
                                    @for($i = date("Y"); $i >= 1960; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label for="vehicleMaker" class="form-label">Maker</label>
                                <select name="vehicleMaker[0]" class="form-select" id="vehicleMaker[0]" onchange="autofillModels(0)">
                                    <option selected value="">Maker</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label for="vehicleModel" class="form-label">Model</label>
                                <select name="vehicleModel[0]" class="form-select" id="vehicleModel[0]" onchange="autofillEngines(0)">
                                    <option selected value="">Model</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label for="vehicleEngine" class="form-label">Engine</label>
                                <select name="vehicleEngine[0]" class="form-select" id="vehicleEngine[0]">
                                    <option selected value="">Engine</option>
                                </select>
                            </div>
                            <div class="col-sm-1 mt-4">
                                <a class="btn btn-success btn-sm" onclick="addVehicles()">+</a>
                            </div>
                        </div>
                        <div id="extraVehicles"></div>
                        @else
                        <div class="row">
                            <h5 class="card-title"><strong>Compatible Vehicles</strong></h5>
                            <div class="col-sm-2">
                                <label for="vehicleYear" class="form-label">Year</label>
                            </div>
                            <div class="col-sm-3">
                                <label for="vehicleMaker" class="form-label">Maker</label>
                            </div>
                            <div class="col-sm-3">
                                <label for="vehicleModel" class="form-label">Model</label>
                            </div>
                            <div class="col-sm-3">
                                <label for="vehicleEngine" class="form-label">Engine</label>
                            </div>
                            <div class="col-sm-1 mt-1">
                                <a class="btn btn-success btn-sm" onclick="addVehicles()">+</a>
                            </div>
                        </div>
                        <div id="currentVehicles">
                        @for($i = 0; $i < count($caliperVehicles); $i++)
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <input type="text" name="vehicleYear" value="{{ $caliperVehicles[$i]->vehicles->year }}" class="form-control" id="vehicleYear">
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" name="vehicleMaker" value="{{ $caliperVehicles[$i]->vehicles->maker }}" class="form-control" id="vehicleMaker">
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" name="vehicleModel" value="{{ $caliperVehicles[$i]->vehicles->model }}" class="form-control" id="vehicleModel">
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" name="vehicleEngine" value="{{ $caliperVehicles[$i]->vehicles->engine }}" class="form-control" id="vehicleEngine">
                                </div>
                                <div class="col-sm-1">
                                    <a class="btn btn-danger btn-sm" onclick="removeVehicles({{$i}})">-</a>
                                </div>
                            </div>
                        @endfor
                        </div>
                        @endif
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
        <div class="col-md-6">
            <div class="row row-cols-1 row-cols-md-2 g-4">
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
    let compCount = 0; //Counter for the number of components added
    const caliperComponents = <?php echo json_encode($caliperComponents); ?>;
    const divCurrentComponents = document.getElementById("currentComponents");
    caliperComponents.forEach((caliComp) => {
        const divRow = document.createElement("div");
        divRow.className = "row mb-3";
        divRow.id = "row" + compCount;
        divCurrentComponents.appendChild(divRow);

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
        selectComponentNo.appendChild(defaultOptComponentNo);

        components.forEach((component) =>{
            let optionComponentNo = document.createElement("option");
            optionComponentNo.value = component.id;
            optionComponentNo.text = component.component_number;
            if (caliperComponents[compCount].component_id == component.id)
                optionComponentNo.selected = true;
            selectComponentNo.appendChild(optionComponentNo);
        })

        // Measure column
        let divComponentMeasure = document.createElement("div");
        divComponentMeasure.className = "col-sm-5";
        divRow.appendChild(divComponentMeasure);

        let inputComponentMeasure = document.createElement("input");
        inputComponentMeasure.name = `componentMeasure[${compCount}]`;
        inputComponentMeasure.className = "form-control";
        inputComponentMeasure.id = `componentMeasure[${compCount}]`;
        inputComponentMeasure.value = caliperComponents[compCount].components.measure;
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
        inputComponentQty.value = caliperComponents[compCount].quantity;
        divComponentQty.appendChild(inputComponentQty);

        if(compCount > 0) {
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
        }

        // Add to counter
        compCount += 1;
    })

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