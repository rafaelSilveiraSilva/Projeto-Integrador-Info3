<html>


<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/css/bootstrap.min.css" integrity="sha512-2bBQCjcnw658Lho4nlXJcc6WkV/UxpE/sAokbXPxQNGqmNdQrWqtw26Ns9kFF/yG792pKR1Sx8/Y1Lf1XN4GKA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <?php
    session_start();
    $mysql = new mysqli(
        "localhost",
        "root",
        "",
        "pi_iii",
        3306
    );

    $id = $_GET['id'];
    $usuarioId = $_SESSION['usuario'];

    $foi = true;

    try {
        $rs = $mysql->query("SELECT * FROM transacaoEsporadica WHERE id = $id AND usuario_id = $usuarioId");

        if ($rs && $rs->num_rows > 0) {

            $transacao = $rs->fetch_assoc();

            
            $tipo = $transacao['tipo'];
            $valor = $transacao['valor'];

            
            $mysql->query("UPDATE transacaoEsporadica SET ativo = 0 WHERE id = $id");

            
            if ($tipo == "Gasto") {
               
                $mysql->query("UPDATE usuario SET saldo = saldo + $valor WHERE id = $usuarioId");
            } else if ($tipo == "Ganho") {
                
                $mysql->query("UPDATE usuario SET saldo = saldo - $valor WHERE id = $usuarioId");
            }

        } else {
            $foi = false;
        }
    } catch (mysqli_sql_exception $e) {
        $foi = false;
    }
    ?>


</head>

<body class="p-3">

    <tr>
        <td>
            <a href="historicoCompleto.php" class="btn btn-danger">Voltar</a>
        </td>
    </tr>

    <?php if ($foi): ?>
        <tr>
            <h1>Excluído com sucesso</h1>
        </tr>
    <?php else: ?>
        <tr>
            <h1>Excluído sem sucesso</h1>
        </tr>
    <?php endif; ?>


</body>

</html>