<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cursos matrimoniales</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
    require 'navbar.php';
    ?>

    <br>
    <br>
    <br>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center mb-3">
                    <div class="display-4">
                        Cursos matrimoniales
                    </div>
                </div>
                <div class="form-group form-inline m-auto">
                    <label for="estado-select" class="m-1 ml-2">Estado</label>
                    <select id="estado-select" class="form-control" onchange="selectMunicipio()">

                    </select>
                    <label for="municipio-select" class="m-1 ml-2">Municipio</label>
                    <select id="municipio-select" class="form-control" onchange="selectParroquia()">

                    </select>
                    <label for="parroquia-select" class="m-1 ml-2">Parroquia</label>
                    <select id="parroquia-select" class="form-control" onchange="selectChurch()">

                    </select>
                    <label for="iglesia-select" class="m-1 ml-2">Iglesia</label>
                    <select id="iglesia-select" class="form-control">

                    </select>
                    <button type="button" id="search-course-btn" class="btn btn-primary m-1 ml-2" onclick="searchCourses()">Ver curso</button>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-7">
                    <!-- MAPA AQUI ↓ -->
                    <div id="map"></div>
                </div>
                <div class="col-5">
                    <div class="row" id="site-info">
                        <div class="h2 mx-auto my-3">
                            Selecciona tu lugar para hacer el curso
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script onload="selectEstado()" src="./js/map_AJAX.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyClfbbh8JE6nwS1RGlIPO2djKvqUFZ-Vhk&callback=initMap" type="text/javascript"></script>
</body>
</html>
