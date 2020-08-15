<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ArmaTuFiesta</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand text-primary" href="index">
        <span class="h2">
            Arma Tu Fiesta
        </span>
    </a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="main_quinces" id="xv-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    XV's
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="main_bodas" id="boda-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Boda
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="otras-fiestas" id="fiestas-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Otras fiestas
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Bautizos</a>
                    <a class="dropdown-item" href="#">Fiestas Infantiles</a>
                    <a class="dropdown-item" href="#">Despedida de solteria</a>
                    <a class="dropdown-item" href="#">Divorcio</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="about-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Sobre nosotros
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
        </ul>
    </div>

    <?php if(isset($_SESSION['user'])): ?>
        <a href="logout" class="btn btn-outline-warning mx-1">Cerrar Sesion</a>
    <?php endif; ?>

    <?php if(isset($_SESSION['user'])): ?>
        <a href="admin" class="btn btn-outline-success mx-1">ADMIN</a>
    <?php endif; ?>

    <a href="<?php echo isset($_SESSION['user']) ? 'party_select' : 'register' ?>" class="btn btn-secondary mx-1">Arma Tu Fiesta</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

</nav>
