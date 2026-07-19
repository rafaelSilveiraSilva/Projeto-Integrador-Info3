<?php
$mysql = new mysqli(
    "localhost",
    "root",
    "",
    "pi_iii",
    3306
);
$erro = [];
if (sizeof($_POST) > 0) {



    if (isset($_POST['email']) && strlen($_POST['email']) > 0) {

        if (!isset($_SESSION)) {
            session_start();
        }

        $_SESSION['email'] = $mysql->escape_string($_POST['email']);
        $_SESSION['senha'] = md5(md5($_POST['senha']));

        $rs = $mysql->query("SELECT senha, id FROM Usuario WHERE email = '$_SESSION[email]'") or die($mysql->error);
        $ln = $rs->fetch_assoc();
        $contador = $rs->num_rows;

        if ($contador == 0) {
            $erro[] = "Este email não pertence à nenhum usuário cadastrado!";
        } else {

            if ($ln['senha'] == $_POST['senha']) {
                $_SESSION['usuario'] = $ln['id'];
            } else {
                $erro[] = "Senha incorreta!";
            }
        }

        if (count($erro) == 0 || !isset($erro)) {
            echo "<script>alert('Login afetuado!'); location.href='inicialUsuario.php';</script>";
        }
    }
}

?>

<html>


<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/css/bootstrap.min.css" integrity="sha512-2bBQCjcnw658Lho4nlXJcc6WkV/UxpE/sAokbXPxQNGqmNdQrWqtw26Ns9kFF/yG792pKR1Sx8/Y1Lf1XN4GKA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/js/bootstrap.min.js" integrity="sha512-nKXmKvJyiGQy343jatQlzDprflyB5c+tKCzGP3Uq67v+lmzfnZUi/ZT+fc6ITZfSC5HhaBKUIvr/nTLCV+7F+Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



</head>

<body>

    <div class="container-fluid p-4">



        <h1 class="text-center">Login</h1>

        <form method="POST" action="login.php">
            <p>Informe seu email (obrigatório) <input type="text" name="email" class="form-control" value="<?php if(isset($_SESSION['email'])){ echo $_SESSION['email'];} ?>" required></p>
            <p>Informe sua senha (obrigatório) <input type="text" name="senha" class="form-control" required></p>
            <?php if (count($erro) > 0)
                foreach ($erro as $msg) {
                    echo "<h3 class='mt-3 mb-3'>$msg</h3>";
                }
            ?>
            <p>
                <button type="submit" class="btn btn-primary">Logar</button>

            </p>
            <p>
                <a href="index.php" class="btn btn-danger">Voltar</a>

            </p>

        </form>
    </div>
</body>

</html>