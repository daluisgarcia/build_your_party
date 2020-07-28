<?php require 'navbar.php'; ?>

    <br>
    <br>
    <br>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center mb-3">
                    <div class="display-4">
                        Encuentra los sitios cerca de ti
                    </div>
                </div>
                <div class="form-inline m-auto">
                    <div id="options" class="">
                        <label class="form-check-label" for="options">
                            ¿Qué buscas?
                        </label>
                        <div class="form-check-inline option">
                            <input class="form-check-input" type="radio" name="op-select" id="jefaturas" value="jefatura" checked>
                            <label class="form-check-label" for="jefaturas">
                                Jefaturas
                            </label>
                        </div>
                        <div class="form-check-inline option">
                            <input class="form-check-input" type="radio" name="op-select" id="notaria" value="notaria">
                            <label class="form-check-label" for="notaria">
                                Notarias
                            </label>
                        </div>
                        <div class="form-check-inline option">
                            <input class="form-check-input" type="radio" name="op-select" id="templos" value="templo">
                            <label class="form-check-label" for="templos">
                                Templos
                            </label>
                        </div>
                    </div>
                    <label id="religion-label" for="religion-select" class="m-1 d-none">Religión</label>
                    <select id="religion-select" class="form-control d-none">

                    </select>
                    <label for="estado-select" class="m-1 ml-2">Estado</label>
                    <select id="estado-select" class="form-control" onchange="selectMunicipio()">

                    </select>
                    <label for="municipio-select" class="m-1 ml-2">Municipio</label>
                    <select id="municipio-select" class="form-control" onchange="selectParroquia()">

                    </select>
                    <label for="parroquia-select" class="m-1 ml-2">Parroquia</label>
                    <select id="parroquia-select" class="form-control">

                    </select>
                    <button type="submit" class="btn btn-primary text-center m-1 ml-2" id="search-btn">Buscar</button>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-7">
                    <!-- MAPA AQUI ↓ -->
                    <div id="map"></div>
                </div>
                <div id="site-info" class="col-5">
                    <div class="container-fluid">
                        <div class="h2 mx-auto my-3">Selecciona tu lugar más cercano</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script onload="selectDrops()" src="./js/map_AJAX.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyClfbbh8JE6nwS1RGlIPO2djKvqUFZ-Vhk&callback=initMap" type="text/javascript"></script>
</body>
</html>
