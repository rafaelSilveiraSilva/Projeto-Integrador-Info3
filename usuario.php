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
    <?php include 'navbar.php' ?>
    <!-- esse <div class="row mb-5 mt-5"></div> é pra dar um espaçamento pra navbar não tampar o conteúdo da página. -->
    <div class="row mb-5 mt-5"></div>

    <div class="container-fluid p-4">
        <div class="row ">
            <!-- <div class="col-3  text-center">
                <img
                    class="img-fluid"
                    width="200"
                    src="https://img.magnific.com/vetores-premium/ilustracao-plana-vetorial-em-escala-de-cinza-avatar-perfil-de-usuario-icone-de-pessoa-imagem-de-perfil-de-silhueta-neutra-de-genero-adequado-para-perfis-de-midia-social-icones-protetores-de-tela-e-como-um-modelo-x9xa_719432-2191.jpg?semt=ais_hybrid&w=740&q=80">
            </div> -->

            <div class="col-10  ">
                <h1><b>Nome: </b><?= $ln['nome'] ?></h1>
                <h2><b>Email: </b><?= $ln['email'] ?></h2>
                <h2><b>Gênero: </b><?= $ln['sexo'] ?></h2>
            </div>

            <div class="col-2 text-end">
                <a
                    class="btn btn-warning mt-3"
                    href="atualizaDadosUsuario.php">
                    <b>Mudar nome</b>
                </a>

                <a
                    href="index.php"
                    class="btn btn-secondary mt-3"
                    onclick="<?php unset($_SESSION); ?>">

                    <b>Logout</b>
                </a>

                




            </div>
        </div>
        <hr class="mt-5 mb-5">
        <div class="mt-3 mb-3 row  text-center">
            <h1><b>Gráficos Pessoais</b></h1>
        </div>



        <div class="row  mt-3">
            <div class="col  text-center">
                <img src="graficoGastosEsporadicosCategoria.php"
                    class="img-fluid"
                    width="350">
            </div>
            <div class="col  text-center">
                <img src="graficoGanhosEsporadicosCategoria.php"
                    class="img-fluid"
                    width="350">
            </div>
        </div>



        <div class="row ">
            <div class="col  text-center">
                <img src="graficoGastosRecorrentesCategoria.php"
                    class="img-fluid"
                    width="350">
            </div>
            <div class="col  text-center">
                <img src="graficoGanhosRecorrentesCategoria.php"
                    class="img-fluid"
                    width="350">
            </div>
        </div>


    </div>



</body>

</html>