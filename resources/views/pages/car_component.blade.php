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

    <div class="m-5 align-items-center">
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3>Insert Car Component</h3>
                        </div>
                    </div>
                    <div class="car-body m-3">
                        <form id="formInsertCar">
                            @csrf
                            <div class="mb-3">
                                <label for="carName" class="form-label">Car Name</label>
                                <input type="text" class="form-control" name="carName">
                            </div>
                            <div class="mb-3">
                                <label for="cost" class="form-label">Component</label>
                                <div id="componentContainer">
                                    <div class="row component-custom mb-3">
                                        <div class="col">
                                            <select class="form-select select2-custom" name="componentDropdown">
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <input type="number" minlength="1" class="form-control form-control-sm"
                                                name="componentQuantity">
                                        </div>
                                    </div>
                                </div>
                                <button id="addComponent" class="btn btn-icon btn-sm btn-primary">+</button>
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
        <div class="row component-custom mb-3">
            <div class="col">
                <select class="form-select" name="componentDropdown">
                    <option></option>
                </select>
            </div>
            <div class="col">
                <input type="number" minlength="1" class="form-control form-control-sm" name="componentQuantity">
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            let allComponent = []
            $(async function() {
                initSelect2()
            })

            async function initSelect2() {
                let data = await getComponents()
                allComponent = generateComponentDropdown(data)
                $('.select2-custom').empty()
                $('.select2-custom').select2({
                    data: allComponent,
                    width: '100%'
                })
            }

            $('#addComponent').on('click', (e) => {
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

            $('#formInsertCar').on('submit', async (e) => {
                e.preventDefault()
                // let data = $('#formInsertComponent').serialize()
                let tempComponent = []
                //get all component
                for (let i = 0; i < $('#componentContainer').children().length; i++) {
                    let rowEl = $('#componentContainer > .row').eq(i)
                    let componentId = rowEl.find('select').val()
                    let componentQty = rowEl.find('input').val()
                    tempComponent.push({
                        component_id: componentId,
                        component_qty: componentQty
                    })
                }

                let data = {
                    carName: $('[name="carName"]').val(),
                    component: tempComponent
                }

                console.log(data)

                try {
                    let result = await insertCar(data)
                    $('#formInsertCar').trigger('reset')
                } catch (error) {
                    alert(error)
                }
            })

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

            function getComponents() {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'GET',
                        url: route('pp-get-car-components'),
                        success: function(data) {
                            resolve(data)
                        },
                        error: function(e) {
                            reject(e)
                        }
                    });
                })
            }

            function insertCar(param) {
                    return new Promise((resolve, reject) => {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            method: 'POST',
                            url: route('cc-insert-car'),
                            data: param,
                            success: function(data) {
                                alert('Berhasil ditambahkan!')
                                resolve(data)
                            },
                            error: function(e) {
                                reject(e)
                            }
                        })
                    })
                }
        </script>
    </x-slot>
</x-base>
