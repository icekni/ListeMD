<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste marchandises dangereuses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

</head>

<body>
    <div class="container-sm d-flex align-items-center" style="height: 40vh;">
        <form method="post" action="processElv.php" target="pdf" enctype="multipart/form-data" autocomplete="on" class="w-100">
            <div class="mb-3 input-group">
                <label for="train" class="visually-hidden">Train numéro</label>
                <span class="input-group-text" id="trainlabel">Train n°</span>
                <input type="number" class="form-control" id="train" name="train" aria-describedby="trainlabel">
            </div>

            <div class="mb-3 input-group">
                <label for="date" class="visually-hidden">Date</label>
                <span class="input-group-text" id="datelabel">Date</span>
                <input type="date" class="form-control" id="date" name="date" aria-describedby="datelabel">
            </div>

            <div class="mb-3 input-group">
                <label for="from" class="visually-hidden">Provenance</label>
                <span class="input-group-text" id="fromlabel">Provenance</span>
                <input type="text" class="form-control" id="from" name="from" aria-describedby="fromlabel">
            </div>
            <div class="input-group mb-3">
                <label for="files" class="visually-hidden">eLV</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="3000000">
                <span class="input-group-text" id="filelabel">Lettre(s) de voiture</span>
                <input type="file" class="form-control" id="files[]" name="files[]" accept=".pdf" multiple
                    aria-describedby="filelabel">
            </div>

            <button type="submit" class="btn btn-primary">Valider</button>
        </form>
    </div>

    <iframe src="processElv.php" id="pdf" name="pdf" frameborder="0" width="100%" style="height: 60vh;"></iframe>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>

</body>

</html>
