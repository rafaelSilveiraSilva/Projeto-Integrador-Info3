<?php
session_start();
$mysql = new mysqli(
    "localhost", // Servidor
    "root", // Adiministrador da máquina (usuário)
    "", // Senha (opcional)
    "pi_iii", // Nome do banco de dados
    3306 // Porta utilizada
);
$rs = $mysql->query("SELECT * FROM usuario WHERE id = $_SESSION[usuario] ");
$ln = $rs->fetch_assoc();
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


                <a href="#" class="btn d-flex align-items-center">



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
                        <a class="nav-link" href="#">Ver Fixos</a>
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
            <div class="col  text-center">
                <img
                    class="img-fluid"
                    width="200"
                    src="https://img.magnific.com/vetores-premium/ilustracao-plana-vetorial-em-escala-de-cinza-avatar-perfil-de-usuario-icone-de-pessoa-imagem-de-perfil-de-silhueta-neutra-de-genero-adequado-para-perfis-de-midia-social-icones-protetores-de-tela-e-como-um-modelo-x9xa_719432-2191.jpg?semt=ais_hybrid&w=740&q=80">
            </div>

            <div class="col  ">
                <h1><b>Nome: </b><?= $ln['nome'] ?></h1>
                <h2><b>Email: </b><?= $ln['email'] ?></h2>
                <h2><b>Gênero: </b><?= $ln['sexo'] ?></h2>
            </div>

            <div class="col  d-flex justify-content-center align-items-center">
                <a
                    class="btn btn-warning"
                    href="atualizaDadosUsuario.php">
                    <b>Editar dados</b>
                </a>
            </div>
        </div>
        <hr class="mt-5 mb-5">
        <div class="mt-3 mb-3 row  text-center">
            <h1><b>Gráficos Pessoais</b></h1>
        </div>



        <div class="row  mt-3">
            <div class="col  text-center">
                <img src="https://s4.static.brasilescola.uol.com.br/be/2020/03/shutterstock-396863464.jpg"
                    class="img-fluid"
                    width="350">
            </div>
            <div class="col  text-center">
                <img src="https://s4.static.brasilescola.uol.com.br/be/2020/03/shutterstock-396863464.jpg"
                    class="img-fluid"
                    width="350">
            </div>
        </div>

        <div class="row ">
            <div class="col  text-center">
                <p>Gráfico do percentual de gastos esporádicos por categorias</p>
            </div>
            <div class="col  text-center">
                <p>Gráfico do percentual de ganhos esporádicos por categorias</p>
            </div>
        </div>

        <div class="row ">
            <div class="col  text-center">
                <img src="https://s4.static.brasilescola.uol.com.br/be/2020/03/shutterstock-396863464.jpg"
                    class="img-fluid"
                    width="350">
            </div>
            <div class="col  text-center">
                <img src="https://s4.static.brasilescola.uol.com.br/be/2020/03/shutterstock-396863464.jpg"
                    class="img-fluid"
                    width="350">
            </div>
        </div>

        <div class="row ">
            <div class="col  text-center">
                <p>Gráfico do percentual de gastos recorrentes por categorias</p>
            </div>
            <div class="col  text-center">
                <p>Gráfico do percentual de ganhos recorrentes por categorias</p>
            </div>
        </div>
    </div>



</body>

</html>