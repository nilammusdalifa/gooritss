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

    <div class="card m-5">
        <div class="card-header">
            <div class="card-title">
                <h3>Car Production Planning and Simulation</h3>
            </div>
        </div>
        <div class="card-body">
            <h5>Component to Build 1 Unit Car</h5>
            <table id="refferenceTable" class="table table-bordered mt-3">
                <thead>
                    <tr class="align-middle">
                        <th scope="col" style="text-center">No</th>
                        <th scope="col">Component Name</th>
                        <th scope="col" style="width: 100px;">Required Quantity</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Price /pcs</th>
                        <th scope="col">Production Time (for all quantity)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center text-black-50">


                    </tr>
                </tbody>
            </table>
            <div class="row mt-5">
                <label for="totalCar" class="form-label">Production Simulation</label>
                <div class="col">
                    <input type="number" class="form-control" name="totalCar">
                </div>
                <div class="col">
                    <button id="generateSimulation" class="btn btn-primary">Generate</button>
                </div>
            </div>

            <table id="simulationTable" class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th scope="col" style="text-center">No</th>
                        <th scope="col">Component Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Stock Status</th>
                        <th scope="col">Total Price</th>
                        <th scope="col">Total Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center text-black-50">
                        <td colspan="6">Enter the number of car to generate simulation</td>
                    </tr>
                </tbody>
            </table>
            <button id="adjustSimulation" class="btn btn-primary" hidden>Adjust Simulation</button>
        </div>
    </div>

    <x-slot name="script">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let allCarComponents = []
                $(async function() {
                    allCarComponents = await getCarComponents()
                    generateRefferenceTable()
                })

                $('#adjustSimulation').on('click', function() {
                    let tblBodyChild = $('#refferenceTable').find('tbody').children()
                    for (let i = 0; i < tblBodyChild.length; i++) {
                        let tdEl = $(tblBodyChild[i]).find('td').eq(2)
                        $(tdEl).empty()
                        let html = `<input type="number" class="form-control form-control-sm custom-quantity">`
                        $(tdEl).append(html)
                    }
                })

                $('#refferenceTable').on('input', '.custom-quantity', function() {
                    let currentRowId = $(this).closest('tr').data('id')
                    let filteredData = allCarComponents.filter((item) => {
                        if (item.id == currentRowId) return item
                    })[0];

                    let affectedSimulationRow = $('#simulationTable').find(`tr[data-id="${currentRowId}"]`)
                    let newQty = $(this).val() * $('[name="totalCar"]').val()
                    let newTotalCost;
                    let newProductionTime;
                    for (var i in allCarComponents) {
                        newTotalCost = newQty * allCarComponents[i].production_cost
                        newProductionTime = newQty * allCarComponents[i].production_time
                    }

                    console.log(newQty, newProductionTime, newTotalCost)
                    $(affectedSimulationRow).find('td').eq(2).text(newQty)
                    $(affectedSimulationRow).find('td').eq(4).text(newTotalCost)
                    $(affectedSimulationRow).find('td').eq(5).text(newProductionTime)
                    generateGrandTotal()
                })

                $('#generateSimulation').on('click', async function(e) {
                    let totalCar = $('[name="totalCar"]').val()
                    $('#simulationTable').find('tbody').empty()
                    try {
                        for (var i in allCarComponents) {
                            let currentStock = allCarComponents[i].stock
                            let totalStockNeeded = totalCar * allCarComponents[i].required_qty
                            let statusStock = (currentStock - totalStockNeeded) > 0 ? "Mencukupi" :
                                currentStock - totalStockNeeded
                            let productionCost = allCarComponents[i].production_cost * totalStockNeeded
                            let productionTime = allCarComponents[i].production_time * totalStockNeeded

                            let el = `
                            <tr data-id="${allCarComponents[i].id}">
                                <td>${parseInt(i)+1}</td>
                                <td>${allCarComponents[i].name}</td>
                                <td>${totalStockNeeded}</td>
                                <td>${statusStock}</td>
                                <td>${productionCost}</td>
                                <td>${productionTime} Hours</td>
                                </tr>
                                `
                            $('#simulationTable').find('tbody').append(el)
                        }
                        generateGrandTotal()
                    } catch (error) {
                        alert(error)
                    }
                })

                function generateGrandTotal() {
                    let tableChild = $('#simulationTable').find('tbody').children()
                    // console.log($('#simulationTable').find('tr[data-id="rowGrandTotal"]').html());
                    $('#simulationTable').find('tr[data-id="rowGrandTotal"]').remove()

                    let arrQuantity = []
                    let arrPrice = []
                    let arrStockStatus = []
                    let arrProductionTime = []
                    for (let i = 0; i < tableChild.length; i++) {
                        if($(tableChild[i]).data('id') != 'rowGrandTotal'){
                            arrPrice.push(parseFloat($(tableChild[i]).find('td').eq(4).text()))
                            arrQuantity.push(parseFloat($(tableChild[i]).find('td').eq(2).text()))
                            arrStockStatus.push($(tableChild[i]).find('td').eq(3).text())
                            arrProductionTime.push(parseInt($(tableChild[i]).find('td').eq(5).text()))
                        }
                    }

                    let totalQuantity = arrQuantity.reduce(function(total, num) {
                       return total + num
                    })
                    let totalPrice = arrPrice.reduce(function(total, num) {
                        return total + num
                    })

                    let stockIsEnough = arrStockStatus.every((item) => {
                        return item === "Mencukupi";
                    });
                    let totalProductionTime = arrProductionTime.reduce(function(total, num) {

                        return total + num
                    })

                    let html = `
                            <tr class="fw-bolder" data-id="rowGrandTotal">
                                <td colspan="2">GRAND TOTAL</td>
                                <td>${totalQuantity}</td>
                                <td>${(stockIsEnough ? "Mencukupi" : "Tidak Mencukupi")}</td>
                                <td>${totalPrice}</td>
                                <td>${totalProductionTime} Hours</td>
                            </tr>
                        `
                    $('#simulationTable').find('tbody').append(html)
                    $('#adjustSimulation').removeAttr('hidden')
                }

                function generateRefferenceTable() {
                    for (let i = 0; i < allCarComponents.length; i++) {
                        console.log(allCarComponents);
                        let el = `
                            <tr data-id="${allCarComponents[i].id}">
                                <td>${parseInt(i)+1}</td>
                                <td>${allCarComponents[i].name}</td>
                                <td>${allCarComponents[i].required_qty}</td>
                                <td>${allCarComponents[i].stock}</td>
                                <td>${allCarComponents[i].production_cost}</td>
                                <td>${allCarComponents[i].production_time} Hours</td>
                                </tr>
                                `
                        $('#refferenceTable').find('tbody').append(el)
                    }
                }

                function getCarComponents() {
                    return new Promise((resolve, reject) => {
                        $.ajax({
                            url: route('pp-get-car-components'),
                            method: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                resolve(data)
                            },
                            error: function(err) {
                                reject(err)
                            }
                        })
                    })
                }
            })
        </script>
    </x-slot>
</x-base>
