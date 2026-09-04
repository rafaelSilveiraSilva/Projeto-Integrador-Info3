<?php
$mysql = new mysqli(
    "localhost",
    "root",
    "", 
    "pi_iii", 
    3306
);
?>

<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/css/bootstrap.min.css" integrity="sha512-2bBQCjcnw658Lho4nlXJcc6WkV/UxpE/sAokbXPxQNGqmNdQrWqtw26Ns9kFF/yG792pKR1Sx8/Y1Lf1XN4GKA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/js/bootstrap.min.js" integrity="sha512-nKXmKvJyiGQy343jatQlzDprflyB5c+tKCzGP3Uq67v+lmzfnZUi/ZT+fc6ITZfSC5HhaBKUIvr/nTLCV+7F+Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- <link rel="stylesheet" href="https://jsdelivr.net"> -->

</head>

<body>
    <nav class="navbar navbar-expand-lg bg-warning">
        <div class="container-fluid">

            <!-- logo -->
            <a class="navbar-brand" href="inicialUsuario.php"> Webt Finance</a>

            <div class="d-flex order-lg-last">


                <a href="usuario.php" class="btn d-flex align-items-center">



                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                    </svg>
                </a>


                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

            </div>




            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="gastosFixos.php">Ver Fixos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Opção 2</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Opção 3</a>
                    </li>

                </ul>
            </div>



        </div>
    </nav>
    <div class="container-fluid p-4">

        <div class="row ">
            <div class="col ">
                <a href="inicialUsuario.php" class="btn btn-danger mb-4">Voltar</a>
            </div>
        </div>
</div>
</body>