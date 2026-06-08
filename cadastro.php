<?php

if (sizeof($_POST) > 0) {


    $mysql = new mysqli(
        "localhost",
        "root",
        "",
        "pi_iii",
        3306
    );

    $cpf = $_POST["cpf"];
    $dataNascimento = $_POST["dataNascimento"];
    $nome = $_POST["nome"];
    $sexo = $_POST["sexo"];




    $mysql->query("INSERT INTO usuario(cpf, dataNascimento, nome, sexo) VALUES('$cpf', '$dataNascimento', '$nome', '$sexo')");


    if (isset($_POST['cpf']) && strlen($_POST['cpf']) > 0) {

        if (!isset($_SESSION)) {
            session_start();
        }

        $_SESSION['cpf'] = $_POST['cpf'];

        $rs = $mysql->query("SELECT cpf, id FROM usuario WHERE cpf = '$_SESSION[cpf]'");
        // or die($mysql->error);
        $ln = $rs->fetch_assoc();
        $contador = $rs->num_rows;

        if ($contador == 0) {
            $erro[] = "Este CPF não pertence a nenhum usuário cadastrado!";
        } else {

            $_SESSION['usuario'] = $ln['id'];
            header("Location: inicialUsuario.php");


            exit;
        }
    }

    header("Location: index.php");


    exit;
}

?>

<html>


<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/css/bootstrap.min.css" integrity="sha512-2bBQCjcnw658Lho4nlXJcc6WkV/UxpE/sAokbXPxQNGqmNdQrWqtw26Ns9kFF/yG792pKR1Sx8/Y1Lf1XN4GKA==" crossorigin="anonymous" referrerpolicy="no-referrer" />




</head>

<body>
    <div class="container-fluid p-4">


        <h1 class="text-center">Cadastro</h1>

        <form method="POST" action="cadastro.php">
            <p>Nome (obrigatório) <input type="text" name="nome" class="form-control" required></p>
            <p>CPF (obrigatório) <input type="text" name="cpf" class="form-control" required></p>
            <p>Data de Nacimento <input type="text" name="dataNascimento" class="form-control"></p>
            <p>Sexo <input type="text" name="sexo" class="form-control"></p>
            <p>
                <button type="submit" class="btn btn-primary">Cadastrar</button>

            </p>
            <p>
                <a href="index.php" class="btn btn-danger">Voltar</a>

            </p>

        </form>
    </div>
</body>

</html>