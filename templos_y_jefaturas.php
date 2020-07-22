<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Templos y Jefaturas</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        #map{
            height: 500px;
            width: 100%;
        }
    </style>
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
                    <div class="display-3">
                        Templos y Jefaturas a tu alcance
                    </div>
                </div>
                <div class="form-group form-inline m-auto">
                    <div class="form-check-inline">
                        <input class="form-check-input" type="radio" name="tem_jef" id="jefaturas" value="jefatura" checked>
                        <label class="form-check-label" for="jefaturas">
                            Jefaturas
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <input class="form-check-input" type="radio" name="tem_jef" id="templos" value="templo">
                        <label class="form-check-label" for="templos">
                            Templos
                        </label>
                    </div>
                    <label for="religion" class="m-1">Religión</label>
                    <select id="religion" class="form-control ">
                        <option selected>Católica</option>
                        <option>Islamismo</option>
                        <option>Judaismo</option>
                    </select>
                    <label for="estado" class="m-1 ml-2">Estado</label>
                    <select id="estado" class="form-control">
                        <option selected>Dtto. Capital</option>
                        <option>Miranda</option>
                        <option>...</option>
                    </select>
                    <input class="form-control ml-3" type="text" placeholder="Buscar" value="">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-7">
<!--                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d251097.9246351096!2d-67.03045459854464!3d10.468698790429963!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8c2a58adcd824807%3A0x93dd2eae0a998483!2sCaracas%2C%20Distrito%20Capital!5e0!3m2!1ses!2sve!4v1592609790984!5m2!1ses!2sve" width="100%" height="500px" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>-->
                    <div id="map"></div>
                </div>
                <div class="col-5">
                    <div class="row">
                        <div class="h2 mx-auto my-3">
                            Nombre del lugar
                        </div>
                        <div class="h5 mx-auto mb-3">
                            Datos varios (Mediante un JSON se llena)
                        </div>
                    </div>
                    <div class="row">
                        <a href="#" class="btn btn-primary btn-lg m-auto">Reservar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        function initMap(){
            var location = {lat: -25.363, lng: 131.044};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 4,
                center: location
            });
            var market = new google.maps.Marker({
                position: location,
                map: map
            })
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyClfbbh8JE6nwS1RGlIPO2djKvqUFZ-Vhk&callback=initMap"
            type="text/javascript"></script>
</body>
</html>
