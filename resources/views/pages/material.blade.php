<x-base>
    <x-slot name="materialIsActive">
        {{ $materialIsActive }}
    </x-slot>

    <x-slot name="ppIsActive">
        {{ $ppIsActive }}
    </x-slot>

    <x-slot name="ccIsActive">
        {{ $ccIsActive }}
    </x-slot>

    <x-slot name="pcIsActive">
        {{ $pcIsActive }}
    </x-slot>

    <div class="m-5">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3>Insert Components</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="formInsertComponent">
                            <div class="mb-3">
                                <label for="componentName" class="form-label">Component Name</label>
                                <input type="text" class="form-control" name="componentName">
                            </div>
                            <div class="mb-3">
                                <label for="stock" class="form-label">Current Stock</label>
                                <input type="number" min="1" class="form-control" name="componentStock" onkeydown="setMinLength(this)">
                            </div>
                            <div class="mb-3">
                                <label for="cost" class="form-label">Cost per Component</label>
                                <input type="number" min="1" class="form-control" name="componentCost" onkeydown="setMinLength(this)">
                            </div>
                            <div class="mb-3">
                                <label for="cost" class="form-label">Required Material</label>
                                <div id="materialContainer">
                                    <div class="row material-custom mb-3">
                                        <div class="col">
                                            <select class="form-select select2-custom" name="materialDropdown">
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <input type="number" min="1" class="form-control form-control-sm"
                                                name="materialQuantity" onkeydown="setMinLength(this)">
                                        </div>
                                    </div>
                                </div>
                                <button id="addMaterial" class="btn btn-icon btn-sm btn-primary">+</button>
                            </div>
                            <div class="mb-3">
                                <label for="production_time" class="form-label">Production Time in Hours</label>
                                <input type="number" min="1" class="form-control" name="productionTime" onkeydown="setMinLength(this)">
                            </div>
                            <div class="mb-3">
                                <label for="default_qty" class="form-label">Default Quantity</label>
                                <input type="number" min="1" class="form-control" name="defaultQty" onkeydown="setMinLength(this)">
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3>Insert Raw Materials</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="formInsertMaterial">
                            @csrf
                            <div class="mb-3">
                                <label for="materialName" class="form-label">Material Name</label>
                                <input type="text" class="form-control" name="materialName">
                            </div>
                            <div class="mb-3">
                                <label for="materialStock" class="form-label">Stock</label>
                                <input type="number" min="1" class="form-control" name="materialStock" onkeydown="setMinLength(this)">
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="template" hidden>
        <div class="row material-custom mb-3">
            <div class="col">
                <select class="form-select" name="materialDropdown">
                    <option></option>
                </select>
            </div>
            <div class="col">
                <input type="number" min="1" class="form-control form-control-sm" name="materialQuantity">
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let allMaterial = []
                $(async function() {
                    initSelect2()
                })

                async function initSelect2() {
                    let data = await getMaterial()
                    allMaterial = generateMaterialDropdown(data)
                    $('.select2-custom').empty()
                    $('.select2-custom').select2({
                        data: allMaterial,
                        width: '100%'
                    })
                }

                function setMinLength(el) {
                    if (el.value != "") {
                        if (parseInt(el.value) < parseInt(el.min)) {
                            el.value = el.min;
                        }
                    }
                }

                function generateMaterialDropdown(data) {
                    tempData = []
                    for (var i in data) {
                        var t = {
                            id: data[i].id,
                            text: data[i].name
                        }
                        tempData.push(t)
                    }
                    return tempData
                }

                let selectedValues = $('[name="materialDropdown"]').val();

                $('#formInsertComponent').on('submit', async (e) => {
                    e.preventDefault()
                    // let data = $('#formInsertComponent').serialize()
                    let tempMaterial = []
                    //get all material
                    for (let i = 0; i < $('#materialContainer').children().length; i++) {
                        let rowEl = $('#materialContainer > .row').eq(i)
                        let materialId = rowEl.find('select').val()
                        let materialQty = rowEl.find('input').val()
                        console.log(materialQty)
                        tempMaterial.push({
                            raw_material_id: materialId,
                            raw_material_qty: materialQty
                        })
                    }

                    let data = {
                        name: $('[name="componentName"]').val(),
                        stock: $('[name="componentStock"]').val(),
                        production_cost: $('[name="componentCost"]').val(),
                        production_time: $('[name="productionTime"]').val(),
                        default_qty: $('[name="defaultQty"]').val(),
                        material: tempMaterial
                    }

                    console.log(data)

                    try {
                        let result = await insertComponent(data)
                        $('#formInsertComponent').trigger('reset')
                        alert(result)
                    } catch (error) {
                        alert(error)
                    }
                })

                $('#formInsertMaterial').on('submit', async (e) => {
                    e.preventDefault()
                    let data = $('#formInsertMaterial').serialize()
                    try {
                        let result = await insertMaterial(data)
                        $('#formInsertMaterial').trigger('reset')
                        initSelect2()
                        alert(result)
                    } catch (error) {
                        alert(error)
                    }
                })

                $('#addMaterial').on('click', function(e) {
                    e.preventDefault()
                    let clonedEl = $('#template').find('.material-custom').clone()
                    $(clonedEl).find('select').addClass('select2-custom')
                    $(clonedEl).find('.select2-custom').empty()
                    $(clonedEl).find('.select2-custom').select2({
                        data: allMaterial,
                        width: '100%'
                    })
                    $('#materialContainer').append(clonedEl)

                })

                function getMaterial() {
                    return new Promise((resolve, reject) => {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            method: 'GET',
                            url: route('cm-get-material'),
                            success: function(data) {
                                console.log(data);
                                resolve(data)
                            },
                            error: function(e) {
                                console.log(e);
                                reject(e)
                            }
                        });
                    })
                }

                function insertComponent(param) {
                    return new Promise((resolve, reject) => {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            method: 'POST',
                            url: route('cm-insert-component'),
                            data: param,
                            success: function(data) {
                                resolve(data)
                            },
                            error: function(e) {
                                console.log(e.responseJSON);
                                reject(e)
                            }
                        })
                    })
                }

                function insertMaterial(param) {
                    return new Promise((resolve, reject) => {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            method: 'POST',
                            url: route('cm-insert-material'),
                            data: param,
                            success: function(data) {
                                console.log(data);
                                resolve(data)
                            },
                            error: function(e) {
                                console.log(e);
                                reject(e)
                            }
                        })
                    })
                }
            })
        </script>
    </x-slot>
</x-base>
