<x-base>
    <div class="m-5">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Form Components
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="formInsertComponent">
                            <div class="mb-3">
                                <label for="componentName" class="form-label" @required(true)>Component Name</label>
                                <input type="text" class="form-control" name="componentName">
                            </div>
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" minlength="1" class="form-control" name="componentStock">
                            </div>
                            <div class="mb-3">
                                <label for="cost" class="form-label">Cost</label>
                                <input type="number" minlength="1" class="form-control" name="componentCost">
                            </div>
                            <div class="mb-3">
                                <label for="production_time" class="form-label">Production Time</label>
                                <input type="number" minlength="1" class="form-control" name="productionTime">
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
                            Form Materials
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
                                <input type="number" minlength="1" class="form-control" name="materialStock">
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

    <x-slot name="script">
        <script>
            $('#formInsertComponent').on('submit', async (e) => {
                e.preventDefault()
                let data = $('#formInsertComponent').serialize()
                try {
                    let result = await insertComponent(data)
                    console.log(result)
                } catch (error) {
                    alert(error)
                }
            })

            $('#formInsertMaterial').on('submit', async (e) => {
                e.preventDefault()
                let data = $('#formInsertMaterial').serialize()
                try {
                    let result = await insertMaterial(data)
                    console.log(result)
                } catch (error) {
                    alert(error)
                }
            })

            function insertComponent(param) {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: route('cm-insert'),
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

            function insertMaterial(param) {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: route('cm-insert'),
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
        </script>
    </x-slot>
</x-base>
