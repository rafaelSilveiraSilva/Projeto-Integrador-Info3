<?php
session_start();

$mysql = new mysqli("localhost", "root", "", "pi_iii", 3306);

if ($mysql->connect_error) {
    die("Erro ao conectar com o banco de dados.");
}

$mysql->set_charset("utf8mb4");

if (!isset($_SESSION['usuario'])) {
    die("Faça login para continuar.");
}

$usuario_id = $_SESSION['usuario'];

$consultaUsuario = $mysql->query("SELECT * FROM usuario WHERE id = $usuario_id");
$usuario = $consultaUsuario->fetch_assoc();

$categorias = $mysql->query("SELECT * FROM categoria ORDER BY nome");

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $data = $_POST["diaVencimento"];
    $valor = $_POST["valor"];
    $categoria_id = $_POST["categoria"];
    $tipo = "Gasto";

    if ($nome == "" || $valor == "" || $categoria_id == "" || $data == "") {
        $mensagem = "Preencha todos os campos obrigatórios.";
    } elseif ($valor <= 0) {
        $mensagem = "O valor precisa ser maior que zero.";
    } else {
        $sql = "INSERT INTO transacaorecorrente
                (nome, descricao, diaVencimento, valor, tipo, categoria_id, usuario_id)
                VALUES ('$nome', '$descricao', '$data', '$valor', '$tipo', '$categoria_id', '$usuario_id')";

        if ($mysql->query($sql)) {
            header("Location: inicialUsuario.php");
            exit;
        } else {
            $mensagem = "Erro ao cadastrar. Confira o nome da tabela e das colunas.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ganho recorrente - Webt Finance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/js/bootstrap.bundle.min.js" defer></script>
    <style>
        body { background-color: #f8f9fa; }
        .formulario { background: white; border-radius: 18px; box-shadow: 0 4px 18px rgba(0,0,0,.08); }
        .campo-titulo { font-weight: bold; }
        .saldo-box { background: #fff3cd; border: 1px solid #ffe69c; border-radius: 14px; padding: 20px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-warning border border-2 border-dark">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold fs-4" href="inicialUsuario.php">Webt Finance</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-lg-4">
                    <li class="nav-item"><a class="nav-link" href="gastosFixos.php">Ver Fixos</a></li>
                    <li class="nav-item"><a class="nav-link" href="ganhocurto.php">Adicionar Ganho</a></li>
                    <li class="nav-item"><a class="nav-link" href="gastoreco.php">Adicionar Gasto Recorrente</a></li>
                </ul>
            </div>
            <a href="usuario.php" class="btn ms-3">Perfil</a>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="formulario p-4 p-md-5">
                    <h3 class="fw-bold mb-4">Formulário de Gasto Recorrente</h3>

                    <?php if ($mensagem != "") { ?>
                        <div class="alert alert-danger"><?php echo $mensagem; ?></div>
                    <?php } ?>

                    <form method="POST">
                        <div class="row g-4">
                            <div class="col-12 col-lg-7">
                                <div class="row align-items-center mb-3">
                                    <div class="col-5"><label for="nome" class="campo-titulo">Nome</label></div>
                                    <div class="col-7"><input type="text" id="nome" name="nome" class="form-control" placeholder="Nome" required></div>
                                </div>

                                <div class="row align-items-center mb-3">
                                    <div class="col-5"><label for="descricao" class="campo-titulo">Descrição</label></div>
                                    <div class="col-7"><input type="text" id="descricao" name="descricao" class="form-control" placeholder="Opcional"></div>
                                </div>

                                <div class="row align-items-center mb-3">
                                    <div class="col-5"><label for="valor" class="campo-titulo">Valor</label></div>
                                    <div class="col-7"><input type="number" id="valor" name="valor" class="form-control" placeholder="100.00" min="0.01" step="0.01" required></div>
                                </div>

                                <button type="submit" class="btn btn-secondary btn-lg rounded-pill px-5 mt-2">Adicionar</button>
                            </div>

                            <div class="col-12 col-lg-5">
                                <div class="saldo-box mb-4">
                                    <h4 class="fw-bold">Saldo atual</h4>
                                    <h3 class="mb-0">R$ <?php echo number_format((float) $usuario['saldo'], 2, ',', '.'); ?></h3>
                                </div>

                                <div class="mb-4">
                                    <label for="categoria" class="campo-titulo mb-2">Categoria</label>
                                    <select id="categoria" name="categoria" class="form-select" required>
                                        <option value="">Selecione uma categoria</option>
                                        <?php while ($categoria = $categorias->fetch_assoc()) { ?>
                                            <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nome']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div>
                                   <div class="col-5"><label for="diaVencimento" class="campo-titulo">Dia do Vencimento</label></div>
                                    <div class="col-7"><input type="number" id="diaVencimento" name="diaVencimento" class="form-control" placeholder="1-31" min="1" max="31" required></div>
                                </div>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
