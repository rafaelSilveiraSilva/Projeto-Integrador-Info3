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
$diff = 0;

// =-=

$rs2 = $mysql->query("SELECT te.nome, te.valor, te.descricao, te.tipo
                                        FROM transacaoEsporadica as te
                                        WHERE te.usuario_id = $_SESSION[usuario] AND te.ativo = 1
                                        
                                        ");

foreach ($rs2 as $line2) {


    if ($line2["tipo"] == "Ganho") {

        $diff += $line2["valor"];
    } else {

        $diff -= $line2["valor"];
    }
}


?>



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

        <div class="row text-center">
            <div class="col-12 mb-3  ">
                <h4><b>Histórico completo</b></h4>
            </div>
            <!-- <div class="col-4  text-end">
                <h4><b>Saldo Atual</b></h4>

            </div> -->

        </div>

        <div class="row text-center mb-3">
            <div class="col">
                <?php
                if ($diff > 0) {
                    echo "<p>Mais ganho de dinheiro do que gasto! Parabéns!</p>";
                } elseif ($diff < 0) {
                    echo "<p>Mais gasto de dinheiro do que ganho. Com ajustes, você consegue mudar isso!</p>";
                } else {
                    echo "<p>Nada a reclamar! Continue caminhando para uma economia ideal!</p>";
                }
                ?>
            </div>
        </div>

        <div class="row ">
            <div class="col-12 ">
                <table class="table table-striped table-bordered text-center">
                    <tr>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Ação de Excluir</th>
                        

                    </tr>

                    <?php
                    $rs = $mysql->query("SELECT te.nome, te.valor, te.descricao, te.tipo, c.nome as categoria, te.id
                                        FROM transacaoEsporadica as te
                                        JOIN categoria as c ON te.categoria_id = c.id
                                        WHERE te.usuario_id = $_SESSION[usuario] AND te.ativo = 1
                                        
                                        ");

                    foreach ($rs as $line): ?>

                        <tr <?php
                            if ($line["tipo"] == "Ganho") {
                                echo "class='table-success'";
                                $diff += $line["valor"];
                            } else {
                                echo "class='table-danger'";
                                $diff -= $line["valor"];
                            }
                            ?>>
                            <td><?= $line["nome"] ?></td>
                            <td><?= $line["categoria"] ?></td>
                            <td><?= $line["descricao"] ?></td>
                            <td>R$ <?= $line["valor"] ?></td>

                            <!-- Fazer aqui o lance de excluir -->
                            <td>
                                <a href="excluirEsporadico.php?id=<?= $line["id"] ?>">Excluir</a>
                            </td>

                           

                        </tr>

                    <?php endforeach ?>

                </table>
            </div>
            <!-- <div class="col-4  text-end">

                <h4><?= $ln["saldo"] ?> R$</h4>
            </div> -->

        </div>



    </div>



</body>

</html>