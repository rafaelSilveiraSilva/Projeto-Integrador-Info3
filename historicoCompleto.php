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
            <div class="col ">
                <a href="inicialUsuario.php" class="btn btn-danger mb-4">Voltar</a>
            </div>
        </div>

        <div class="row  align-items-end text-center">
            <div class="col-6  ">
                <h4><b>Histórico completo</b></h4>
            </div>
            <div class="col-4  text-end">
                <h4><b>Saldo Atual</b></h4>

            </div>
            <div class="col-2 "></div>
        </div>

        <div class="row ">
            <div class="col-6 ">
                <table class="table table-striped table-bordered text-center">
                    <tr>
                        <th>Nome</th>
                        <th>Valor</th>
                    </tr>

                    <?php
                    $rs = $mysql->query("SELECT te.nome, te.valor
                                         FROM transacaoEsporadica as te
                                        WHERE te.usuario_id = $_SESSION[usuario]
                                        
                                        ");

                    foreach ($rs as $line): ?>

                        <tr>
                            <td><?= $line["nome"] ?></td>
                            <td><?= $line["valor"] ?> R$</td>
                        </tr>

                    <?php endforeach ?>

                </table>
            </div>
            <div class="col-4  text-end">

                <h4><?= $ln["saldo"] ?> R$</h4>
            </div>
            <div class="col-2 "></div>
        </div>



    </div>



</body>

</html>