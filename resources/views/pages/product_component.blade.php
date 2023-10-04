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

    <div class="p-5">
        <div class="card w-50 mx-auto" id="productCard">
            <div class="card-header">
                <div class="card-title">
                    <h3>Insert Product's Component</h3>
                </div>
            </div>
            <div class="card-body">
                <form id="insertRawComponent">
                    @csrf
                    <div class="mb-3">
                        <label for="componentName" class="form-label">Component Name</label>
                        <div class="row mb-3">
                            <div class="col" id="parentComponent">
                                <select class="form-select select2-custom" name="parentComponentName">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="rawComponentName" class="form-label">Raw Component</label>
                        <div id="componentContainer">
                            <div class="row component-custom mb-3">
                                <div class="col">
                                    <select class="form-select select2-custom" name="rawComponentName">
                                        <option></option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="number" min="1" class="form-control form-control-sm"
                                        name="componentQuantity" onkeydown="setMinLength(this)">
                                </div>
                            </div>
                        </div>
                        <button id="addRawComponent" class="btn btn-icon btn-sm btn-primary">+</button>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="template" hidden>
        <div class="row component-custom mb-3">
            <div class="col">
                <select class="form-select" name="rawComponentName">
                    <option></option>
                </select>
            </div>
            <div class="col">
                <input type="number" min="1" class="form-control form-control-sm" name="componentQuantity">
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                let allComponent = []
                $(async function() {
                    allComponent = await getComponents()
                    initSelect2()
                })

                $('#insertRawComponent').on('submit', async (e) => {
                    e.preventDefault()
                    let parentComponentId = $('#parentComponent').find('select').val()
                    let tempComponent = []

                    for (let i = 0; i < $('#componentContainer').children().length; i++) {
                        let rowEl = $('#componentContainer > .row').eq(i)
                        let componentId = rowEl.find('select').val()
                        let componentQty = rowEl.find('input').val()
                        tempComponent.push({
                            child_component_id: componentId,
                            child_component_qty: componentQty
                        })
                    }

                    let data = {
                        parentComponentId: parentComponentId,
                        rawComponent: tempComponent,
                    }

                    try {
                        let result = await insertRawComponent(data)
                        $('#insertRawComponent').trigger('reset')
                        console.log(result);
                    } catch (error) {
                        console.log(error);
                    }
                })

                $('#addRawComponent').on('click', (e) => {
                    e.preventDefault()
                    let clonedEl = $('#template').find('.component-custom').clone()
                    $(clonedEl).find('select').addClass('select2-custom')
                    $(clonedEl).find('.select2-custom').empty()
                    $(clonedEl).find('.select2-custom').select2({
                        data: allComponent,
                        width: '100%'
                    })
                    $('#componentContainer').append(clonedEl)
                })

                async function initSelect2() {
                    allComponent = generateComponentDropdown(allComponent)
                    $('.select2-custom').empty()
                    $('.select2-custom').select2({
                        data: allComponent,
                        width: '100%'
                    })
                }

                function insertRawComponent(param) {
                    return new Promise((resolve, reject) => {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            method: 'POST',
                            url: route('rc-insert-raw-component'),
                            data: param,
                            success: function(data) {
                                resolve(data)
                            },
                            error: function(e) {
                                console.log(e)
                                reject(e)
                            }
                        })
                    })
                }

                function getComponents() {
                    return new Promise((resolve, reject) => {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            method: 'GET',
                            url: route('pp-get-car-components'),
                            success: function(data) {
                                console.log(data)
                                resolve(data)
                            },
                            error: function(e) {
                                reject(e)
                            }
                        });
                    })
                }

                function generateComponentDropdown(data) {
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

                function setMinLength(el) {
                    if (el.value != "") {
                        if (parseInt(el.value) < parseInt(el.min)) {
                            el.value = el.min;
                        }
                    }
                }
            })
        </script>
    </x-slot>
</x-base>
