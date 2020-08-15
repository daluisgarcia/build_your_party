
    <?php   session_start();
        //CHECKEAR FIESTAS Y SI TIENEN CONTRATOS SIN FECHA DE PAGO PARA CARGAR UNA ALERTA
        if(isset($_SESSION["user"])) {
            try {
                include_once 'model/PaymentSQL.php';
                $connect = new PaymentSQL();

                $alert = $connect->get_payment_alert($_SESSION['id_user']);
                if(!empty($alert)){
                    echo "<script>alert('Tiene pagos pendientes')</script>";
                }

            } catch (PDOException $e) {

            }
        }
        include 'navbar.php';
    ?>

    <br>
    <br>

    <section class="mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="display-3">
                        <img style="width: 3rem;" src="https://www.svgrepo.com/show/268804/balloons-party.svg" alt="Globos">
                        Arma tu fiesta perfecta
                        <img style="width: 3rem;" src="https://www.svgrepo.com/show/243576/party-blower-birthday.svg">
                    </div>
                </div>
                <div class="col-12 col-md-7 align-self-center text-center">
                    <p class="mx-3 sangria">
                        ArmaTuFiesta es una empresa dedicada a los servicios de festejos para todo
                        tipo de fiestas (bodas, quinceaños, cumpleaños, aniversarios, graduaciones,
                        divorcios, despedidas de solteros, entre otros) en todo el país. Se fundó el 23
                        de Agosto de 1986 en la ciudad de Caracas.
                    </p>
                    <p class="mx-3 sangria">
                        Como ves tenemos casi 34 años de experiencia en el campo, organizando y llevando hacia ti la fiesta ideal.
                        Contamos con el mejor repertorio para formar tu fiesta perfecta, para cualquier ocasión y hora del dia.
                        ArmaTuFiesta con los mejores.
                    </p>
                    <div class="text-center">
                        <a class="btn btn-outline-primary m-auto" href="#">Mas sobre nosotros</a>
                        <a class="btn btn-primary m-auto" href="party_select">ArmarMiFiesta</a>
                    </div>
                </div>
                <div class="col-12 col-md-5 p-2">
                    <img style="width: 80%;" src="https://img.rawpixel.com/s3fs-private/rawpixel_images/website_content/400-mj-21a1127.jpg?w=800&dpr=1&fit=default&crop=default&q=65&vib=3&con=3&usm=15&bg=F4F4F3&ixlib=js-2.2.1&s=cb5867ac087acc861728b75a52d26d43" alt="fiesta">
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="bg-wed-img parallax">
            <!--IMAGEN DE BODA-->
        </div>
        <div class="container-fluid">
            <div class="row py-3 mx-3">
                <div class="col-12 mb-3 display-3">Para tu matrimonio tenemos:</div>
                <div class="row">
                    <div class="col-12 col-md-6 mb-3 text-center hover-shadow">
                        <a href="wedding_courses.php" class="no-deco-hover row" title="Templos y cursos matrimoniales">
                            <div class="col-4">
                                <img class="land-icon" src="https://www.svgrepo.com/show/43798/church.svg" alt="icono de iglesia">
                            </div>
                            <div class="h4 text-dark col-8 align-content-center">
                                Los templos más populares y cursos matrimoniales (para bodas católicas)
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-6 mb-3 text-center hover-shadow">
                        <a href="vestidos" class="no-deco-hover row" title="Corte y costura">
                            <div class="col-4">
                                <img class="land-icon" src="https://www.svgrepo.com/show/6317/wedding-dress.svg" alt="icono de vestido">
                            </div>
                            <div class="text-dark h4 col-8">
                                Los mejores diseñadores para tu vestido
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-6 mb-3 text-center hover-shadow">
                        <a href="#" class="no-deco-hover row" title="Generar carta de solteria">
                            <div class="col-4">
                                <img class="land-icon" src="https://www.svgrepo.com/show/159332/paper.svg" alt="icono de carta">
                            </div>
                            <div class="text-dark h4 col-8">
                                Generación de carta de soltería
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-6 mb-3 text-center hover-shadow">
                        <a href="products.php" class="no-deco-hover row" title="Ver opciones para la musica">
                            <div class="col-4">
                                <img class="land-icon" src="https://www.svgrepo.com/show/31588/dancers.svg" alt="icono de baile">
                            </div>
                            <div class="text-dark h4 col-8">
                                Los mejores DJ´s para el ambiente de la celebración
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-6 text-center">
                        <div class="btn btn-lg btn-block btn-primary my-2">Contrata nuestros servicios</div>
                    </div>
                    <div class="col-12 col-md-6 text-center">
                        <div class="btn btn-lg btn-block btn-secondary my-2">Ver mas informacion</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section >
        <div class="bg-xv-img parallax">
            <!--IMAGEN DE QUINCES-->
        </div>
        <div class="container-fluid">
            <div class="row py-3">
                <div class="col-12 display-3 mb-1 text-center">Tus quince años perfectos</div>
                <div class="row">
                    <div class="col-12 col-md-6 align-content-center">
                        <p class="m-4 sangria">
                            En ArmaTuFiesta sabemos lo importante que son esas quince primaveras para ti, y por eso tenemos a los mejores para
                            la organizacion y entretenimiento de tu fiesta. Muchas opciones, temáticas, decoraciones y cientos
                            de cosas más!! Atrevete a ArmarTusQuinces con nuestros servicios:
                        </p>
                        <p class="m-4 sangria">
                            En ArmaTuFiesta sabemos lo importante que son esas quince primaveras para ti, y por eso tenemos a los mejores para
                            la organizacion y entretenimiento de tu fiesta. Muchas opciones, temáticas, decoraciones y cientos
                            de cosas más!! Atrevete a ArmarTusQuinces con nuestros servicios:
                        </p>
                    </div>
                    <div class="col-12 col-md-6">
                        <a href="tips_quinces" class="hover-shadow p-2 my-1 d-block no-deco-hover text-dark" title="Ver consejos">
                            <img class="tab-icon m-1" src="https://www.svgrepo.com/show/287536/bulb.svg" alt="icono de bombillo">
                            Tips para quinceañeras
                        </a>
                        <a href="temas_quinces" class="hover-shadow p-2 my-1 d-block no-deco-hover text-dark" title="Ver tematicas">
                            <img class="tab-icon m-1" src="https://www.svgrepo.com/show/221333/theme.svg" alt="icono de tematica">
                            Temáticas para tu fiesta
                        </a>
                        <a href="products" class="hover-shadow p-2 my-1 d-block no-deco-hover text-dark" title="Ver accesorios">
                            <img class="tab-icon m-1" src="https://www.svgrepo.com/show/162904/women-accesories.svg" alt="icono de zarcillos">
                            Todo tipo de accesorios
                        </a>
                        <a href="vestidos" class="hover-shadow p-2 my-1 d-block no-deco-hover text-dark" title="Corte y costura">
                            <img class="tab-icon m-1" src="https://www.svgrepo.com/show/6317/wedding-dress.svg" alt="icono de vestido">
                            Los mejores para confeccionar tu vestido
                        </a>
                    </div>
                    <div class="btn btn-lg btn-block btn-primary mt-2 mx-5"><a href="products">Mira todos los servicios que ofrecemos</a></div>
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid bg-dark p-3">
        <div class="row">
            <div class="col-12 display-4 m-2 mb-3 text-light text-center">
                Armamos todo tipo de fiesta!!
            </div>

            <div class="col-12 col-md-3 text-center">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Bautizo</h5>
                        <p class="card-text">
                            Encuentra todo lo necesario para el bautizo de tu hij@ y dejanos lo demás a nosotros
                        </p>
                        <a href="party_select" class="btn btn-outline-primary">Ver más</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3 text-center">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Fiesta infantil/cumpleaños</h5>
                        <p class="card-text">
                            Organizar los cumpleaños o fiestas de los niños siempre es estresante, aqui estás a tan solo unos
                            clicks de tener todo listo, ¿lo vas a dejar pasar?
                        </p>
                        <a href="party_select" class="btn btn-outline-primary">Ver más</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3 text-center">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Despedida de solter@</h5>
                        <p class="card-text">
                            Ofrecemos lo necesario para que le organices a tu amigo o a ti mismo una despedida de soltería
                            como se debe, unos clicks y todo listo!!
                        </p>
                        <a href="party_select" class="btn btn-outline-primary">Ver más</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3 text-center">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Divorcios</h5>
                        <p class="card-text">
                            Un divorcio es algo triste en muchas ocasiones y en otras puede ser una liberación, para ambas
                            oportunidades tenemos lo que necesitas!! ArmaTuDivorcio ahora.
                        </p>
                        <a href="party_select" class="btn btn-outline-primary">Ver más</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
