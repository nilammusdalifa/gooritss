<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" integrity="sha384-nU14brUcp6StFntEOOEBvcJm4huWjB0OcIeQ3fltAfSmuZFrkAif0T+UtNGlKKQv" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div>
            <form class="row g-3 my-auto">
                <h3 class="text-center">Product Report</h3>
                <div class="row g-3 justify-content-center">
                    <div class="col-auto">
                      <label for="totalCar" class="col-form-label">Jumlah Mobil</label>
                    </div>
                    <div class="col-auto">
                      <input type="number" min="0" id="totalCar" class="form-control" aria-describedby="totalCarRule" onkeydown="setMinValue(this)">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Show Details</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script>
        function setMinValue(el) {
            if (el.value != "") {
                if (parseInt(el.value) < parseInt(el.min)) {
                    el.value = el.min;
                }
            }
        }
    </script>
</body>
</html>
