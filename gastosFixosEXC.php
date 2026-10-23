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

$id = $_GET['id'];

$rs2 = $mysql->query("SELECT * FROM transacaorecorrente WHERE id = $id");

if($rs2->num_rows == 0) {
    $err = "Registro não existe";
}else{
    
    try {
        $mysql->query("DELETE FROM transacaorecorrente WHERE id=$id");
    } catch(Exception $e) {
        $mysql->query("UPDATE transacaorecorrente SET id > 0 WHERE id=$id");
    }
}

?>

<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/css/bootstrap.min.css" integrity="sha512-2bBQCjcnw658Lho4nlXJcc6WkV/UxpE/sAokbXPxQNGqmNdQrWqtw26Ns9kFF/yG792pKR1Sx8/Y1Lf1XN4GKA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/js/bootstrap.min.js" integrity="sha512-nKXmKvJyiGQy343jatQlzDprflyB5c+tKCzGP3Uq67v+lmzfnZUi/ZT+fc6ITZfSC5HhaBKUIvr/nTLCV+7F+Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <?php include 'navbar.php' ?>

    <div class="row mb-5 mt-5"></div>

    <div class="container mt-5">
        <h1>Exclusão de transações</h1>

        <?php if(isset($err)) : ?>
            <p><b><?=$err?></b></p>
        <?php else: ?>
            <p><b>Exclusão realizada com sucesso</b></p>
        <?php endif ?>

        <p><a href="gastosFixos.php" class = "btn btn-danger">Voltar</a></p>
    </div>

</body>
</html>
