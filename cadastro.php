<?php
$mysql = new mysqli(
    "localhost",
    "root",
    "",
    "pi_iii",
    3306
);

if (sizeof($_POST) > 0) {



    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $saldo = $_POST["saldo"];
    if ($saldo == null) {
        $saldo = 0.00;
    }
    $dataNascimento = $_POST["dataNascimento"];


    $sexo = $_POST["sexo"];

    if ($sexo == "") {
        $sexo = "Indefinido";
    }




    $mysql->query("INSERT INTO usuario(nome, email, senha, saldo, dataNascimento, sexo) VALUES('$nome', '$email', '$senha', '$saldo', '$dataNascimento', '$sexo')");




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
            <p>E-mail (obrigatório) <input type="text" name="email" class="form-control" required></p>
            <p>Senha (obrigatório) <input type="text" name="senha" class="form-control" required></p>
            <p>Saldo <input type="text" name="saldo" class="form-control"></p>
            <p>Data de Nacimento <input type="date" name="dataNascimento" class="form-control"></p>
            <p>Sexo:
                <select name="sexo" class="form-select">
                    <option value="I" selected></option>
                    <option value="M">Masculino</option>
                    <option value="F">Feminino</option>

                </select>
            </p>
            <p>
                <button type="submit" class="btn btn-warning">Cadastrar</button>

            </p>
            <p>
                <a href="index.php" class="btn btn-danger">Voltar</a>

            </p>

        </form>
    </div>
</body>

</html>