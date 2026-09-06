
<?php 

session_start();
$mysql = new mysqli(
    "localhost", // Servidor
    "root", // Adiministrador da máquina (usuário)
    "", // Senha (opcional)
    "pi_iii", // Nome do banco de dados
    3306 // Porta utilizada
);

if ($mysql->connect_error) {
    die("Falha na conexão: " . $mysql->connect_error);
}

$usuario = $_SESSION['usuario'];

$rs = $mysql->query("SELECT tr.nome as nome, tr.diaVencimento as vencimento, c.nome as categoria, tr.descricao as descricao, 
IF (tr.diaVencimento < DAY(CURRENT_DATE()), 'VENCEU', IF (tr.diaVencimento > DAY(CURRENT_DATE()), 'NÃO VENCEU', 'VENCE HOJE')) as status
FROM transacaorecorrente tr JOIN categoria c on tr.categoria_id = c.id JOIN usuario u ON tr.usuario_id = u.id
WHERE tr.tipo = 'Gasto' AND u.id = '$usuario'");





?>


<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/css/bootstrap.min.css" integrity="sha512-2bBQCjcnw658Lho4nlXJcc6WkV/UxpE/sAokbXPxQNGqmNdQrWqtw26Ns9kFF/yG792pKR1Sx8/Y1Lf1XN4GKA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/js/bootstrap.min.js" integrity="sha512-nKXmKvJyiGQy343jatQlzDprflyB5c+tKCzGP3Uq67v+lmzfnZUi/ZT+fc6ITZfSC5HhaBKUIvr/nTLCV+7F+Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        var calendarEl = document.getElementById("calendar");
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: "dayGridMonth",
          locale: "pt-br" 
        });
        calendar.render();
      });
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-warning">
        <div class="container-fluid">

            <!-- logo -->
            <a class="navbar-brand" href="inicialUsuario.php"> Webt Finance</a>

            <div class="d-flex order-lg-last">


                <a href="usuario.php" class="btn d-flex align-items-center">



                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                    </svg>
                </a>


                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

            </div>




            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="gastosFixos.php">Ver Fixos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href=""></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Opção 3</a>
                    </li>       

                </ul>
            </div>



        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-6">

                <div id="calendar" ></div>

            </div>

            <div class="col-sm-6" >

            <table class="table table-striped table-bordered text-center mt-4">
                <tr>
                    <th>NOME</th>
                    <th>DIA VENCIMENTO</th>
                    <th>CATEGORIA</th>
                    <th>DESCRIÇÃO</th>
                    <th>STATUS</th>
                </tr>
                <?php foreach($rs as $ln) : ?>
                <tr>
                    <td><?= $ln['nome'] ?></td>
                    <td><?= $ln['vencimento'] ?></td>
                    <td><?= $ln['categoria'] ?></td>
                    <td><?= $ln['descricao'] ?></td>
                    <td><?= $ln['status'] ?></td>
            
                </tr>
            
                <?php endforeach ?>

            </table>

            </div>

        </div>
    </div>

    





</body>

</html>