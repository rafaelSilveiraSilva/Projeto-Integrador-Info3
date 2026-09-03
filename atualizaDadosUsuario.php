<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/css/bootstrap.min.css" integrity="sha512-2bBQCjcnw658Lho4nlXJcc6WkV/UxpE/sAokbXPxQNGqmNdQrWqtw26Ns9kFF/yG792pKR1Sx8/Y1Lf1XN4GKA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/js/bootstrap.min.js" integrity="sha512-nKXmKvJyiGQy343jatQlzDprflyB5c+tKCzGP3Uq67v+lmzfnZUi/ZT+fc6ITZfSC5HhaBKUIvr/nTLCV+7F+Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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


    if (sizeof($_POST) == 0) {
        $id = $ln['id'];
        $rs = $mysql->query("SELECT * FROM usuario WHERE id=$id");

        if ($rs->num_rows == 0) {
            $erro = "ID não existe";
        }
    } else {
        $id = $ln['id'];
        $nome = $_POST["nome"];
        


        $rs = $mysql->query("UPDATE usuario SET nome='$nome' WHERE id = $id");
        $msg = "Registro atualizado";
    }
    ?>
</head>



<body class="p-3">



    <?php if (isset($msg)): ?>
        <tr>
            <h1 class="mb-5"><?= $msg ?></h1>
        </tr>
    <?php else: ?>
        <h1 class="text-center mb-4">Atualização de Dados</h1>
        <form method="POST" action="atualizaDadosUsuario.php">
            <?php $infoUsuario = $rs->fetch_assoc() ?>




            <p>Nome: <input value="<?= $infoUsuario["nome"] ?>" type="text" name="nome" class="form-control"></p>
            
            <input type="hidden" name="id" value="<?= $infoUsuario["id"] ?>">
            <button type="submit" class="btn btn-warning"> Salvar </button>
        </form>
    <?php endif; // termina de verdade 
    ?>

    <tr class="mb-5">
        <td>
            <a href="usuario.php" class="btn btn-danger">Voltar</a>
        </td>
    </tr>

</body>



</html>