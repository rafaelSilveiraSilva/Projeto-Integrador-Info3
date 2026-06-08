<?php 
session_start();
$mysql = new mysqli(
        "localhost", // Servidor
        "root", // Adiministrador da máquina (usuário)
        "", // Senha (opcional)
        "pi_iii", // Nome do banco de dados
        3306 // Porta utilizada
    );
$rs = $mysql->query("SELECT * FROM usuario WHERE id= $_SESSION[usuario] ");
$ln = $rs->fetch_assoc();
?>

<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/css/bootstrap.min.css" integrity="sha512-2bBQCjcnw658Lho4nlXJcc6WkV/UxpE/sAokbXPxQNGqmNdQrWqtw26Ns9kFF/yG792pKR1Sx8/Y1Lf1XN4GKA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/js/bootstrap.min.js" integrity="sha512-nKXmKvJyiGQy343jatQlzDprflyB5c+tKCzGP3Uq67v+lmzfnZUi/ZT+fc6ITZfSC5HhaBKUIvr/nTLCV+7F+Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   

</head>

<body>
    
    <div class="container-fluid p-4 ">
        <div class="row mt-2 mb-4">
            
            <h1> Ativo: <?= $ln['ativo'] ?></h1>
            <h1> Seu CPF: <?= $ln['cpf'] ?></h1>
            <h1> Data Nascimento: <?= $ln['dataNascimento'] ?></h1>
            <h1> Seu ID no sistema: <?= $ln['id'] ?></h1>
            <h1> Seu nome: <?= $ln['nome'] ?></h1>
            <h1> Seu sexo:<?= $ln['sexo'] ?></h1>
            

       
    </div>



</body>

</html>