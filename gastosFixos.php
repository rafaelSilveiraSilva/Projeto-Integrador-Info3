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

$rs2 = $mysql->query("SELECT te.id, te.nome, te.valor, te.descricao, te.tipo, te.diaVencimento, c.nome AS categoria_nome
                      FROM transacaoRecorrente AS te
                      JOIN categoria AS c ON te.categoria_id = c.id
                      WHERE te.usuario_id = $_SESSION[usuario]
                      ORDER BY te.diaVencimento ASC");

























































?>

<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/css/bootstrap.min.css" integrity="sha512-2bBQCjcnw658Lho4nlXJcc6WkV/UxpE/sAokbXPxQNGqmNdQrWqtw26Ns9kFF/yG792pKR1Sx8/Y1Lf1XN4GKA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/js/bootstrap.min.js" integrity="sha512-nKXmKvJyiGQy343jatQlzDprflyB5c+tKCzGP3Uq67v+lmzfnZUi/ZT+fc6ITZfSC5HhaBKUIvr/nTLCV+7F+Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>









</head>

<body>
    <?php include 'navbar.php' ?>

    <div class="row mb-5 mt-5"></div>

    <div class="container-fluid p-4">
        <div class="row">
            <div class="col">
                <a href="inicialUsuario.php" class="btn btn-danger mb-4">Voltar</a>





            </div>

        </div>


        <div class="row align-items-end mb-4">
            <div class="col-6 text-start">
                <h3><b>Transações Recorrentes</b></h3>
            </div>
            <div class="col-6 text-end">
                <h4><b>Saldo Atual:</b> R$ <?= $ln["saldo"] ?></h4>
            </div>
        </div>




















        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center">
                        <tr>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Descrição</th>
                            <th>Vencimento</th>
                            <th>Tipo</th>
                            <th>Valor</th>
                            <th>Ação de Excluir</th>
                        </tr>
                        <?php
                        $rs = $mysql->query("SELECT te.id, te.nome, te.valor, te.descricao, te.tipo, te.diaVencimento, c.nome AS categoria_nome
                                                    FROM transacaoRecorrente AS te
                                                    JOIN categoria AS c ON te.categoria_id = c.id
                                                    WHERE te.usuario_id = $_SESSION[usuario]
                                                    ORDER BY te.diaVencimento ASC");

                        if ($rs->num_rows > 0) {
                            while ($transacao = $rs->fetch_assoc()) {
                        ?>
                                <!-- Linha colorida dinamicamente conforme o tipo -->
                                <tr <?php
                                    if ($transacao["tipo"] == "Ganho") {
                                        echo "class='table-success'";
                                    } else {
                                        echo "class='table-danger'";
                                    }
                                    ?>>
                                    <td><?= $transacao['nome'] ?></td>
                                    <td><?= $transacao['categoria_nome'] ?></td>
                                    <td><?= $transacao['descricao'] ?></td>
                                    <td>Dia <?= $transacao['diaVencimento'] ?></td>
                                    <td><?= $transacao['tipo'] ?></td>
                                    <td>R$ <?= $transacao['valor'] ?></td>
                                    <td>
                                        <a href="gastosFixosEXC.php?id=<?= $transacao['id'] ?>">Excluir</a>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="7"><b>Nenhuma transação recorrente cadastrada.</b></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>