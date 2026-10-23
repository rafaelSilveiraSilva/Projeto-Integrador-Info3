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

    <div class="container-fluid p-4">
        <div class="row mb-5 mt-5"></div>

        <div class="row">

            <div class="col-6">
                <h4><b>Saldo Atual</b></h4>
                <h4>R$ <?= $ln["saldo"] ?></h4>
            </div>

            <div class="col-6 text-center">
                <h4><b>Movimentações Recentes</b></h4>
                <h4><i>(últimas dez)</i></h4>
            </div>

        </div>



        <div class="row mt-5">

            <div class="col">
                <div class="row">
                    <div class="col">
                        <a href="ganhocurto.php" class="btn btn-primary">Adicionar GANHO</a>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col">
                        <a href="gastosfixos.php" class="btn btn-primary">Adicionar GASTO</a>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col">
                        <a href="ganhocurto.php" class="btn btn-secondary">Adicionar GANHO RECORRENTE</a>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col">
                        <a href="gastoreco.php" class="btn btn-secondary">Adicionar GASTO RECORRENTE</a>
                    </div>
                </div>

            </div>

            <div class="col">
                <table class="table table-striped table-bordered text-center">
                    <tr>
                        <th>Nome</th>
                        <th>Valor</th>
                    </tr>

                    <?php
                    $rs = $mysql->query("SELECT te.nome, te.valor, te.tipo
                                         FROM transacaoEsporadica as te
                                        WHERE te.usuario_id = $_SESSION[usuario] AND te.ativo = 1
                                        ORDER BY id DESC
                                        LIMIT 10
                                        
                                        ");

                    foreach ($rs as $ln): ?>

                        <tr
                            <?php
                            if ($ln["tipo"] == "Ganho") {
                                echo "class='table-success'";
                            } else {
                                echo "class='table-danger'";
                            }
                            ?>>
                            <td><?= $ln["nome"] ?></td>
                            <td><?= $ln["valor"] ?> R$</td>
                        </tr>

                    <?php endforeach ?>

                </table>
                <center>
                    <a href="historicoCompleto.php" class="btn btn-warning text-center">Acessar histórico completo</a>
                </center>
            </div>
        </div>


    </div>



</body>

</html>