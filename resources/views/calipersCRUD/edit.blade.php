@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <!-- @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4><strong>Edit Caliper {{ $caliper->jh_part_number }} / {{ $caliper->cardone_part_number }} / {{ $caliper->centric_part_number }}</strong></h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('calipers.update', ['caliper' => $caliper->id]) }}" method="POST" enctype="multipart/form-data" id="mainForm">
                    @csrf
                    @method('PUT')
                        <div class="row mb-3">    
                            <div class="col-sm-4">
                                <label for="jhPN" class="form-label">JH Part No.</label>
                                <input type="text" name="jhPN" value="{{ $caliper->jh_part_number }}" class="form-control" id="jhPN" required autofocus>
                            </div>
                            <div class="col-sm-4">
                                <label for="cardonePN" class="form-label">Cardone Part No.</label>
                                <input type="text" name="cardonePN" value="{{ $caliper->cardone_part_number }}" class="form-control" id="cardonePN" required>
                            </div>
                            <div class="col-sm-4">
                                <label for="centricPN" class="form-label">Centric Part No.</label>
                                <input type="text" name="centricPN" value="{{ $caliper->centric_part_number }}" class="form-control" id="centricPN" required>
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
                            <input name="newPhotos[]" class="form-control" type="file" id="caliperPhotosMultiple" multiple>
                        </div>
                        <div class="row">
                            <h5 class="card-title"><strong>Related Components</strong></h5>
                        </div>
                        <div class="row gx-2">
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
                                <a class="btn btn-success btn-sm float-end" onclick="addComponents()">+</a>
                            </div>
                        </div>
                        <div id="componentsList"></div>
                        <div class="row">
                            <h5 class="card-title"><strong>Compatible Vehicles</strong></h5>
                        </div>
                        <div class="row gx-2">
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
                                <a class="btn btn-success btn-sm float-end" onclick="addVehicles()">+</a>
                            </div>
                        </div>
                        <div id="vehiclesList"></div>
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
            @for($i = 0; $i < count($caliperPhotos); $i++)
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <strong>Photo: {{ $caliper->id }}-{{ $caliperPhotos[$i]->id }}</strong>
                            <div class="float-end">
                                <form action="{{ route('caliperPhotos.destroy', ['caliperPhoto' => $caliperPhotos[$i]->id]) }}" method="Post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                </form>
                            </div>
                        </div>
                        <a href="/storage/calipers/{{ $caliperPhotos[$i]->filename }}" target="_blank"><img src="/storage/calipers/{{ $caliperPhotos[$i]->filename }}" class="card-img-top"></a>
                        <!-- <div class="card-body">
                            <label for="photoDescription[{{$caliperPhotos[$i]->id}}]" class="form-label"><h5 class="card-title">Description:</h5></label>
                            <p class="card-text">
                                <textarea name="photoDescription[{{$caliperPhotos[$i]->id}}]" value="{{ $caliperPhotos[$i]->description ?? '' }}" class="form-control" id="photoDescription[{{$caliperPhotos[$i]->id}}]" rows="3"></textarea>
                            </p>
                        </div> -->
                    </div>
                </div>
            @endfor
            </div>
        </div>
    </div>
</div>

<script>
    //--------------------COMPONENTS--------------------\\
    const components = <?php echo json_encode($components); ?>;

    // Generate current component forms
    let compCount = 0; //Counter for the number of components added
    const caliperComponents = <?php echo json_encode($caliperComponents); ?>;
    const divComponents = document.getElementById("componentsList");
    
    if (caliperComponents.length == 0 || caliperComponents[0] === null) {
        // Create new row
        const divRow = document.createElement("div");
        divRow.className = "row mb-3 gx-2";
        divRow.id = "rowComp" + compCount;
        divComponents.appendChild(divRow);

        // Component column
        const divComponentNo = document.createElement("div");
        divComponentNo.className = "col-sm-4";
        divRow.appendChild(divComponentNo);

        const selectComponentNo = document.createElement("select");
        selectComponentNo.name = "componentNo";
        selectComponentNo.className = "form-select";
        selectComponentNo.id = `componentNo[${compCount}]`;
        selectComponentNo.setAttribute("onchange", `checkComponents(${compCount})`)
        selectComponentNo.required = true;
        divComponentNo.appendChild(selectComponentNo);

        const defaultOptComponentNo = document.createElement("option");
        defaultOptComponentNo.value = "";
        defaultOptComponentNo.text = "Select a Component";
        defaultOptComponentNo.selected = true;
        selectComponentNo.appendChild(defaultOptComponentNo);

        for (const component of components) {
            const optionComponentNo = document.createElement("option");
            optionComponentNo.setAttribute("name", "componentOption");
            optionComponentNo.value = component.id;
            optionComponentNo.text = component.component_number;
            selectComponentNo.appendChild(optionComponentNo);
        };

        // Measure column
        const divComponentMeasure = document.createElement("div");
        divComponentMeasure.className = "col-sm-5";
        divRow.appendChild(divComponentMeasure);

        const inputComponentMeasure = document.createElement("input");
        inputComponentMeasure.name = "componentMeasure";
        inputComponentMeasure.className = "form-control";
        inputComponentMeasure.id = `componentMeasure[${compCount}]`;
        inputComponentMeasure.readOnly = true;
        divComponentMeasure.appendChild(inputComponentMeasure);

        // Quantity column
        const divComponentQty = document.createElement("div");
        divComponentQty.className = "col-sm-2";
        divRow.appendChild(divComponentQty);

        const inputComponentQty = document.createElement("input");
        inputComponentQty.name = "componentQuantity";
        inputComponentQty.className = "form-control";
        inputComponentQty.id = `componentQuantity[${compCount}]`;
        divComponentQty.appendChild(inputComponentQty);

        // Add to counter
        compCount += 1;
    } else {
        caliperComponents.forEach((caliComp) => {
            const divRow = document.createElement("div");
            divRow.className = "row mb-3 gx-2";
            divRow.id = "rowComp" + compCount;
            divComponents.appendChild(divRow);

            // Component column
            const divComponentNo = document.createElement("div");
            divComponentNo.className = "col-sm-4";
            divRow.appendChild(divComponentNo);

            const selectComponentNo = document.createElement("select");
            selectComponentNo.name = "componentNo";
            selectComponentNo.className = "form-select";
            selectComponentNo.id = `componentNo[${compCount}]`;
            selectComponentNo.setAttribute("onchange", `checkComponents(${compCount})`)
            selectComponentNo.required = true;
            divComponentNo.appendChild(selectComponentNo);

            const defaultOptComponentNo = document.createElement("option");
            defaultOptComponentNo.value = "";
            defaultOptComponentNo.text = "Select a Component";
            selectComponentNo.appendChild(defaultOptComponentNo);

            components.forEach((component) =>{
                const optionComponentNo = document.createElement("option");
                optionComponentNo.setAttribute("name", "componentOption");
                optionComponentNo.value = component.id;
                optionComponentNo.text = component.component_number;
                if (caliperComponents[compCount].component_id == component.id)
                    optionComponentNo.selected = true;
                selectComponentNo.appendChild(optionComponentNo);
            })

            // Measure column
            const divComponentMeasure = document.createElement("div");
            divComponentMeasure.className = "col-sm-5";
            divRow.appendChild(divComponentMeasure);

            const inputComponentMeasure = document.createElement("input");
            inputComponentMeasure.name = "componentMeasure";
            inputComponentMeasure.className = "form-control";
            inputComponentMeasure.id = `componentMeasure[${compCount}]`;
            inputComponentMeasure.value = caliperComponents[compCount].components.measure;
            inputComponentMeasure.readOnly = true;
            divComponentMeasure.appendChild(inputComponentMeasure);

            // Quantity column
            const divComponentQty = document.createElement("div");
            divComponentQty.className = "col-sm-2";
            divRow.appendChild(divComponentQty);

            const inputComponentQty = document.createElement("input");
            inputComponentQty.name = "componentQuantity";
            inputComponentQty.className = "form-control";
            inputComponentQty.id = `componentQuantity[${compCount}]`;
            inputComponentQty.value = caliperComponents[compCount].quantity;
            inputComponentQty.required = true;
            divComponentQty.appendChild(inputComponentQty);

            if(compCount > 0) {
                // Add and Remove buttons
                const divButtons = document.createElement("div");
                divButtons.className = "col-sm-1";
                divRow.appendChild(divButtons);
    
                /* const buttonAdd = document.createElement("a");
                buttonAdd.className = "btn btn-success btn-sm";
                buttonAdd.setAttribute("onclick",  "addComponents()");
                buttonAdd.text = "+";
                divButtons.appendChild(buttonAdd); */

                const buttonRemove = document.createElement("a");
                buttonRemove.className = "btn btn-danger btn-sm float-end";
                buttonRemove.setAttribute("onclick", `removeComponents(${compCount})`);
                buttonRemove.text = "-";
                divButtons.appendChild(buttonRemove);
            }

            // Add to counter
            compCount += 1;
        })
    }
    
    // Autofill measure when selecting a Component and switch requirement on Quantity
    function autofillMeasure(id) {
        if (event.target.value == "") {
            document.getElementById(`componentMeasure[${id}]`).value = "";
            document.getElementById(`componentQuantity[${id}]`).removeAttribute("required");
        } else {
            document.getElementById(`componentMeasure[${id}]`).value = components[(event.target.value) - 1].measure;
            document.getElementById(`componentQuantity[${id}]`).setAttribute("required", "");
        }
    }
    
    // Prevent from choosing duplicate components
    function checkComponents(id) {
        const options = document.getElementsByName("componentOption");
        options.forEach(option => {
            option.disabled = false;
        });
        const compSelects = document.getElementsByName("componentNo");
        if(compSelects.length > 1) {
            compSelects.forEach(select => {
                if(select.id != event.target.id) {
                    options.forEach(option => {
                        if(option.value == event.target.value || option.value == select.value)
                            option.disabled = true;
                    });
                }
            });
        }
        autofillMeasure(id);
    }

    // Add new component forms
    function addComponents() {
        // Create new row
        const divRow = document.createElement("div");
        divRow.className = "row mb-3 gx-2";
        divRow.id = "rowComp" + compCount;
        divComponents.appendChild(divRow);

        // Component column
        const divComponentNo = document.createElement("div");
        divComponentNo.className = "col-sm-4";
        divRow.appendChild(divComponentNo);

        const selectComponentNo = document.createElement("select");
        selectComponentNo.name = "componentNo";
        selectComponentNo.className = "form-select";
        selectComponentNo.id = `componentNo[${compCount}]`;
        selectComponentNo.setAttribute("onchange", `checkComponents(${compCount})`)
        divComponentNo.appendChild(selectComponentNo);

        const defaultOptComponentNo = document.createElement("option");
        defaultOptComponentNo.value = "";
        defaultOptComponentNo.text = "Select a Component";
        defaultOptComponentNo.selected = true;
        selectComponentNo.appendChild(defaultOptComponentNo);

        for (const component of components) {
            const optionComponentNo = document.createElement("option");
            optionComponentNo.setAttribute("name", "componentOption");
            optionComponentNo.value = component.id;
            optionComponentNo.text = component.component_number;
            selectComponentNo.appendChild(optionComponentNo);
        };

        // Measure column
        const divComponentMeasure = document.createElement("div");
        divComponentMeasure.className = "col-sm-5";
        divRow.appendChild(divComponentMeasure);

        const inputComponentMeasure = document.createElement("input");
        inputComponentMeasure.name = "componentMeasure";
        inputComponentMeasure.className = "form-control";
        inputComponentMeasure.id = `componentMeasure[${compCount}]`;
        inputComponentMeasure.readOnly = true;
        divComponentMeasure.appendChild(inputComponentMeasure);

        // Quantity column
        const divComponentQty = document.createElement("div");
        divComponentQty.className = "col-sm-2";
        divRow.appendChild(divComponentQty);

        const inputComponentQty = document.createElement("input");
        inputComponentQty.name = "componentQuantity";
        inputComponentQty.className = "form-control";
        inputComponentQty.id = `componentQuantity[${compCount}]`;
        divComponentQty.appendChild(inputComponentQty);

        // Add and Remove buttons
        const divButtons = document.createElement("div");
        divButtons.className = "col-sm-1";
        divRow.appendChild(divButtons);

        /* const buttonAdd = document.createElement("a");
        buttonAdd.className = "btn btn-success btn-sm";
        buttonAdd.setAttribute("onclick",  "addComponents()");
        buttonAdd.text = "+";
        divButtons.appendChild(buttonAdd); */

        const buttonRemove = document.createElement("a");
        buttonRemove.className = "btn btn-danger btn-sm float-end";
        buttonRemove.setAttribute("onclick", `removeComponents(${compCount})`);
        buttonRemove.text = "-";
        divButtons.appendChild(buttonRemove);

        // Add to counter
        compCount += 1;
    }
    
    // Remove component forms
    function removeComponents(rowNumber) {
        const childRow = document.getElementById(`rowComp${rowNumber}`);
        divComponents.removeChild(childRow);
    }

    //--------------------VEHICLES--------------------\\
    const vehicles = <?php echo json_encode($vehicles); ?>;
    
    // Generate current vehicle forms
    let vehCount = 0; // Counter for the number of vehicles added
    const caliperVehicles = <?php echo json_encode($caliperVehicles); ?>;
    const divVehicles = document.getElementById("vehiclesList");
    
    if (caliperVehicles.length == 0 || caliperVehicles[0] === null) {
        // Create new row
        const divRow = document.createElement("div");
        divRow.className = "row mb-3 gx-2";
        divRow.id = "rowVeh" + vehCount;
        divVehicles.appendChild(divRow);

        // Year column
        const divYear = document.createElement("div");
        divYear.className = "col-sm-2";
        divRow.appendChild(divYear);

        const selectYear = document.createElement("select");
        selectYear.name = "vehicleYear";
        selectYear.className = "form-select";
        selectYear.id = `vehicleYear[${vehCount}]`;
        selectYear.setAttribute("onchange", `autofillMakers(${vehCount})`)
        divYear.appendChild(selectYear);

        const defaultOptYear = document.createElement("option");
        defaultOptYear.value = "";
        defaultOptYear.text = "Year";
        defaultOptYear.selected = true;
        selectYear.appendChild(defaultOptYear);

        for (let i = new Date().getFullYear(); i >= 1960; i--) {
            const optionYear = document.createElement("option");
            optionYear.value = i;
            optionYear.text = i;
            selectYear.appendChild(optionYear);
        };

        // Maker column
        const divMaker = document.createElement("div");
        divMaker.className = "col-sm-3";
        divRow.appendChild(divMaker);

        const selectMaker = document.createElement("select");
        selectMaker.name = "vehicleMaker";
        selectMaker.className = "form-select";
        selectMaker.id = `vehicleMaker[${vehCount}]`;
        selectMaker.setAttribute("onchange", `autofillModels(${vehCount})`)
        divMaker.appendChild(selectMaker);

        const defaultOptMaker = document.createElement("option");
        defaultOptMaker.value = "";
        defaultOptMaker.text = "Maker";
        defaultOptMaker.selected = true;
        selectMaker.appendChild(defaultOptMaker);

        // Model column
        const divModel = document.createElement("div");
        divModel.className = "col-sm-3";
        divRow.appendChild(divModel);

        const selectModel = document.createElement("select");
        selectModel.name = "vehicleModel";
        selectModel.className = "form-select";
        selectModel.id = `vehicleModel[${vehCount}]`;
        selectModel.setAttribute("onchange", `autofillEngines(${vehCount})`)
        divModel.appendChild(selectModel);

        const defaultOptModel = document.createElement("option");
        defaultOptModel.value = "";
        defaultOptModel.text = "Model";
        defaultOptModel.selected = true;
        selectModel.appendChild(defaultOptModel);

        // Engine column
        const divEngine = document.createElement("div");
        divEngine.className = "col-sm-3";
        divRow.appendChild(divEngine);

        const selectEngine = document.createElement("select");
        selectEngine.name = "vehicleEngine";
        selectEngine.className = "form-select";
        selectEngine.id = `vehicleEngine[${vehCount}]`;
        divEngine.appendChild(selectEngine);

        const defaultOptEngine = document.createElement("option");
        defaultOptEngine.value = "";
        defaultOptEngine.text = "Engine";
        defaultOptEngine.selected = true;
        selectEngine.appendChild(defaultOptEngine);

        if(vehCount > 0) {
            // Add and Remove buttons
            const divButtons = document.createElement("div");
            divButtons.className = "col-sm-1";
            divRow.appendChild(divButtons);

            /* const buttonAdd = document.createElement("a");
            buttonAdd.className = "btn btn-success btn-sm";
            buttonAdd.setAttribute("onclick", "addVehicles()");
            buttonAdd.text = "+";
            divButtons.appendChild(buttonAdd); */

            const buttonRemove = document.createElement("a");
            buttonRemove.className = "btn btn-danger btn-sm float-end";
            buttonRemove.setAttribute("onclick", `removeVehicles(${vehCount})`);
            buttonRemove.text = "-";
            divButtons.appendChild(buttonRemove);
        }

        // Add to counter
        vehCount += 1;
    } else {
        caliperVehicles.forEach((caliVeh) => {
            // Create new row
            const divRow = document.createElement("div");
            divRow.className = "row mb-3 gx-2";
            divRow.id = "rowVeh" + vehCount;
            divVehicles.appendChild(divRow);

            // Year column
            const divYear = document.createElement("div");
            divYear.className = "col-sm-2";
            divRow.appendChild(divYear);

            const selectYear = document.createElement("select");
            selectYear.name = "vehicleYear";
            selectYear.className = "form-select";
            selectYear.id = `vehicleYear[${vehCount}]`;
            selectYear.setAttribute("onchange", `autofillMakers(${vehCount})`);
            divYear.appendChild(selectYear);

            const defaultOptYear = document.createElement("option");
            defaultOptYear.value = "";
            defaultOptYear.text = "Year";
            selectYear.appendChild(defaultOptYear);

            for(let i = new Date().getFullYear(); i >= 1960; i--) {
                const optionYear = document.createElement("option");
                optionYear.value = i;
                optionYear.text = i;
                if(caliVeh.vehicles.year == i)
                    optionYear.selected = true;
                selectYear.appendChild(optionYear);
            };

            // Maker column
            const divMaker = document.createElement("div");
            divMaker.className = "col-sm-3";
            divRow.appendChild(divMaker);

            const selectMaker = document.createElement("select");
            selectMaker.name = "vehicleMaker";
            selectMaker.className = "form-select";
            selectMaker.id = `vehicleMaker[${vehCount}]`;
            selectMaker.setAttribute("onchange", `autofillModels(${vehCount})`);
            selectMaker.required = true;
            divMaker.appendChild(selectMaker);

            const defaultOptMaker = document.createElement("option");
            defaultOptMaker.value = "";
            defaultOptMaker.text = "Maker";
            selectMaker.appendChild(defaultOptMaker);

            vehicles.forEach((vehicle) => {
                if(vehicle.year == caliVeh.vehicles.year) {
                    const optionMaker = document.createElement("option");
                    optionMaker.value = vehicle.maker;
                    optionMaker.text = vehicle.maker;
                    if(vehicle.id == caliVeh.vehicle_id)
                        optionMaker.selected = true;
                    selectMaker.appendChild(optionMaker);
                }
            })

            // Model column
            const divModel = document.createElement("div");
            divModel.className = "col-sm-3";
            divRow.appendChild(divModel);

            const selectModel = document.createElement("select");
            selectModel.name = "vehicleModel";
            selectModel.className = "form-select";
            selectModel.id = `vehicleModel[${vehCount}]`;
            selectModel.setAttribute("onchange", `autofillEngines(${vehCount})`);
            selectModel.required = true;
            divModel.appendChild(selectModel);

            const defaultOptModel = document.createElement("option");
            defaultOptModel.value = "";
            defaultOptModel.text = "Model";
            selectModel.appendChild(defaultOptModel);

            vehicles.forEach((vehicle) => {
                if(vehicle.year == caliVeh.vehicles.year && vehicle.maker == caliVeh.vehicles.maker) {
                    const optionModel = document.createElement("option");
                    optionModel.value = vehicle.model;
                    optionModel.text = vehicle.model;
                    if(vehicle.id == caliVeh.vehicle_id)
                        optionModel.selected = true;
                    selectModel.appendChild(optionModel);
                }
            })

            // Engine column
            const divEngine = document.createElement("div");
            divEngine.className = "col-sm-3";
            divRow.appendChild(divEngine);

            const selectEngine = document.createElement("select");
            selectEngine.name = "vehicleEngine";
            selectEngine.className = "form-select";
            selectEngine.id = `vehicleEngine[${vehCount}]`;
            selectEngine.required = true;
            divEngine.appendChild(selectEngine);

            const defaultOptEngine = document.createElement("option");
            defaultOptEngine.value = "";
            defaultOptEngine.text = "Engine";
            selectEngine.appendChild(defaultOptEngine);

            vehicles.forEach((vehicle) => {
                if(vehicle.year == caliVeh.vehicles.year && vehicle.maker == caliVeh.vehicles.maker && vehicle.model == caliVeh.vehicles.model) {
                    const optionEngine = document.createElement("option");
                    optionEngine.setAttribute("name", "engineOption");
                    optionEngine.value = vehicle.id;
                    optionEngine.text = vehicle.engine;
                    if(vehicle.id == caliVeh.vehicle_id)
                        optionEngine.selected = true;
                    selectEngine.appendChild(optionEngine);
                }
            })

            if(vehCount > 0) {
                // Add and Remove buttons
                const divButtons = document.createElement("div");
                divButtons.className = "col-sm-1";
                divRow.appendChild(divButtons);

                /* const buttonAdd = document.createElement("a");
                buttonAdd.className = "btn btn-success btn-sm";
                buttonAdd.setAttribute("onclick", "addVehicles()");
                buttonAdd.text = "+";
                divButtons.appendChild(buttonAdd); */

                const buttonRemove = document.createElement("a");
                buttonRemove.className = "btn btn-danger btn-sm float-end";
                buttonRemove.setAttribute("onclick", `removeVehicles(${vehCount})`);
                buttonRemove.text = "-";
                divButtons.appendChild(buttonRemove);
            }

            // Add to counter
            vehCount += 1;
        })
    }    
    
    // Autofill Makers when selecting a Year and switch requirement on the rest of the form
    function autofillMakers(id) {
        const selectMaker = document.getElementById(`vehicleMaker[${id}]`);
        if (event.target.value != "") {
            selectMaker.replaceChildren();
            const defaultOptMaker = document.createElement("option");
            defaultOptMaker.value = "";
            defaultOptMaker.text = "Maker";
            defaultOptMaker.selected = true;
            selectMaker.appendChild(defaultOptMaker);
            vehicles.forEach((vehicle) => {
                if(vehicle.year == event.target.value) {
                    const optionMaker = document.createElement("option");
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
            const defaultOptMaker = document.createElement("option");
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
        const selectYear = document.getElementById(`vehicleYear[${id}]`);
        const selectModel = document.getElementById(`vehicleModel[${id}]`);
        if (event.target.value != "") {
            selectModel.replaceChildren();
            const defaultOptModel = document.createElement("option");
            defaultOptModel.value = "";
            defaultOptModel.text = "Model";
            defaultOptModel.selected = true;
            selectModel.appendChild(defaultOptModel);
            vehicles.forEach((vehicle) => {
                if(vehicle.year == selectYear.value && vehicle.maker == event.target.value) {
                    const optionModel = document.createElement("option");
                    optionModel.value = vehicle.model;
                    optionModel.text = vehicle.model;
                    selectModel.appendChild(optionModel);
                }
            })
            autofillEngines(id);
        } else {
            selectModel.replaceChildren();
            const defaultOptModel = document.createElement("option");
            defaultOptModel.value = "";
            defaultOptModel.text = "Model";
            defaultOptModel.selected = true;
            selectModel.appendChild(defaultOptModel);
            autofillEngines(id);
        }
    }

    // Autofill Engines when selecting a Model
    function autofillEngines(id) {
        const selectYear = document.getElementById(`vehicleYear[${id}]`);
        const selectMaker = document.getElementById(`vehicleMaker[${id}]`);
        const selectEngine = document.getElementById(`vehicleEngine[${id}]`);
        if (event.target.value != "") {
            selectEngine.replaceChildren();
            const defaultOptEngine = document.createElement("option");
            defaultOptEngine.value = "";
            defaultOptEngine.text = "Engine";
            defaultOptEngine.selected = true;
            selectEngine.appendChild(defaultOptEngine);
            vehicles.forEach((vehicle) => {
                if(vehicle.year == selectYear.value && vehicle.maker == selectMaker.value && vehicle.model == event.target.value) {
                    const optionEngine = document.createElement("option");
                    optionEngine.setAttribute("name", "engineOption");
                    optionEngine.value = vehicle.id;
                    optionEngine.text = vehicle.engine;
                    selectEngine.appendChild(optionEngine);
                }
            })
        } else {
            selectEngine.replaceChildren();
            const defaultOptEngine = document.createElement("option");
            defaultOptEngine.value = "";
            defaultOptEngine.text = "Engine";
            defaultOptEngine.selected = true;
            selectEngine.appendChild(defaultOptEngine);
        }
    }

    // Prevent from choosing duplicate vehicles
    function checkVehicles(id) {
        const options = document.getElementsByName("engineOption");
        options.forEach(option => {
            option.disabled = false;
        });
        autofillEngines(id);
        const vehSelects = document.getElementsByName("vehicleEngine");
        if(vehSelects.length > 1) {
            vehSelects.forEach(select => {
                if(select.id != event.target.id) {
                    options.forEach(option => {
                        if(option.value == event.target.value || option.value == select.value)
                            option.disabled = true;
                    });
                }
            });
        }
    }

    // Add new vehicle forms
    function addVehicles() {
        // Create new row
        const divRow = document.createElement("div");
        divRow.className = "row mb-3 gx-2";
        divRow.id = "rowVeh" + vehCount;
        divVehicles.appendChild(divRow);

        // Year column
        const divYear = document.createElement("div");
        divYear.className = "col-sm-2";
        divRow.appendChild(divYear);

        const selectYear = document.createElement("select");
        selectYear.name = `vehicleYear[${vehCount}]`;
        selectYear.className = "form-select";
        selectYear.id = `vehicleYear[${vehCount}]`;
        selectYear.setAttribute("onchange", `autofillMakers(${vehCount})`)
        divYear.appendChild(selectYear);

        const defaultOptYear = document.createElement("option");
        defaultOptYear.value = "";
        defaultOptYear.text = "Year";
        defaultOptYear.selected = true;
        selectYear.appendChild(defaultOptYear);

        for (let i = new Date().getFullYear(); i >= 1960; i--) {
            const optionYear = document.createElement("option");
            optionYear.value = i;
            optionYear.text = i;
            selectYear.appendChild(optionYear);
        };

        // Maker column
        const divMaker = document.createElement("div");
        divMaker.className = "col-sm-3";
        divRow.appendChild(divMaker);

        const selectMaker = document.createElement("select");
        selectMaker.name = `vehicleMaker[${vehCount}]`;
        selectMaker.className = "form-select";
        selectMaker.id = `vehicleMaker[${vehCount}]`;
        selectMaker.setAttribute("onchange", `autofillModels(${vehCount})`)
        divMaker.appendChild(selectMaker);

        const defaultOptMaker = document.createElement("option");
        defaultOptMaker.value = "";
        defaultOptMaker.text = "Maker";
        defaultOptMaker.selected = true;
        selectMaker.appendChild(defaultOptMaker);

        // Model column
        const divModel = document.createElement("div");
        divModel.className = "col-sm-3";
        divRow.appendChild(divModel);

        const selectModel = document.createElement("select");
        selectModel.name = `vehicleModel[${vehCount}]`;
        selectModel.className = "form-select";
        selectModel.id = `vehicleModel[${vehCount}]`;
        selectModel.setAttribute("onchange", `autofillEngines(${vehCount})`)
        divModel.appendChild(selectModel);

        const defaultOptModel = document.createElement("option");
        defaultOptModel.value = "";
        defaultOptModel.text = "Model";
        defaultOptModel.selected = true;
        selectModel.appendChild(defaultOptModel);

        // Engine column
        const divEngine = document.createElement("div");
        divEngine.className = "col-sm-3";
        divRow.appendChild(divEngine);

        const selectEngine = document.createElement("select");
        selectEngine.name = `vehicleEngine[${vehCount}]`;
        selectEngine.className = "form-select";
        selectEngine.id = `vehicleEngine[${vehCount}]`;
        divEngine.appendChild(selectEngine);

        const defaultOptEngine = document.createElement("option");
        defaultOptEngine.value = "";
        defaultOptEngine.text = "Engine";
        defaultOptEngine.selected = true;
        selectEngine.appendChild(defaultOptEngine);

        // Add and Remove buttons
        const divButtons = document.createElement("div");
        divButtons.className = "col-sm-1";
        divRow.appendChild(divButtons);

        /* const buttonAdd = document.createElement("a");
        buttonAdd.className = "btn btn-success btn-sm";
        buttonAdd.setAttribute("onclick", "addVehicles()");
        buttonAdd.text = "+";
        divButtons.appendChild(buttonAdd); */

        const buttonRemove = document.createElement("a");
        buttonRemove.className = "btn btn-danger btn-sm float-end";
        buttonRemove.setAttribute("onclick", `removeVehicles(${vehCount})`);
        buttonRemove.text = "-";
        divButtons.appendChild(buttonRemove);

        // Add to counter
        vehCount += 1;
    }
    
    // Remove vehicle forms
    function removeVehicles(rowNumber) {
        const childRow = document.getElementById(`rowVeh${rowNumber}`);
        divVehicles.removeChild(childRow);
    }
</script>
@endsection