<?php
session_start();
$mysql = new mysqli(
    "localhost",
    "root",
    "", 
    "pi_iii", 
    3306
);
$rs = $mysql->query("SELECT * FROM usuario WHERE id = $_SESSION[usuario] ");
$ln = $rs->fetch_assoc();
?>

<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/css/bootstrap.min.css" integrity="sha512-2bBQCjcnw658Lho4nlXJcc6WkV/UxpE/sAokbXPxQNGqmNdQrWqtw26Ns9kFF/yG792pKR1Sx8/Y1Lf1XN4GKA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/js/bootstrap.min.js" integrity="sha512-nKXmKvJyiGQy343jatQlzDprflyB5c+tKCzGP3Uq67v+lmzfnZUi/ZT+fc6ITZfSC5HhaBKUIvr/nTLCV+7F+Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- <link rel="stylesheet" href="https://jsdelivr.net"> -->


    <style>
    .progress-container {
        width: 100%;
        background-color: #ddd;
        border-radius: 5px;
        overflow: hidden;
        height: 30px;
    }
    .progress-bar {
        height: 100%;
        width: 0%;
        background-color: #4CAF50;
        text-align: center;
        color: white;
        line-height: 30px;
        transition: width 0.3s ease;
    }
    </style>
</head>

<body>
    <?php include 'navbar.php' ?>
    <!-- esse <div class="row mb-5 mt-5"></div> é pra dar um espaçamento pra navbar não tampar o conteúdo da página. -->
    <div class="row mb-5 mt-5"></div>

    <div class="container-fluid p-4">

        <div class="row">
            <div class="col ">
                <a href="inicialUsuario.php" class="btn btn-danger mb-4">Voltar</a>
            </div>
        </div>

        <div class="row  align-items-end text-center">
            <div class="col-6  ">
                <h3><b>Formulario de Gastos</b></h3>
            </div>
            <div class="col-4  text-end">
                <h4><b>Saldo Atual</b></h4>
            </div>
            <div class="col-2 "></div>
        </div>
         <div class="row ">
            <div class="col-6 ">

               

            </div>
            <div class="col-4  text-end">
                <h4><?= $ln["saldo"] ?> R$</h4>
            
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="..." alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            
            <div class="col-2 "></div>
        </div>
    </div>
</body>
