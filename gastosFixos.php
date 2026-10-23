<?php
session_start();

$mysql = new mysqli("localhost", "root", "", "pi_iii", 3306);

if ($mysql->connect_error) {
    die("Erro ao conectar ao banco de dados.");
}

$mysql->set_charset("utf8mb4");

if (!isset($_SESSION['usuario'])) {
    die("Você precisa estar logado.");
}

$usuarioId = (int) $_SESSION['usuario'];

/* Buscar usuário */
$sqlUsuario = "SELECT * FROM usuario WHERE id = $usuarioId";
$resultadoUsuario = $mysql->query($sqlUsuario);
$usuario = $resultadoUsuario->fetch_assoc();

if (!$usuario) {
    die("Usuário não encontrado.");
}

/* Buscar categorias */
$resultadoCategorias = $mysql->query("SELECT * FROM categoria");

/* Cadastrar ganho */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $valor = $_POST['valor'] ?? 0;
    $categoriaId = $_POST['categoria'] ?? '';
    $tipo = "Gasto";

    if ($nome == '' || !is_numeric($valor) || $valor <= 0 || $categoriaId == '') {
        $erro = "Preencha os campos corretamente.";
    } else {
        $nome = $mysql->real_escape_string($nome);
        $descricao = $mysql->real_escape_string($descricao);
        $valor = (float) $valor;
        $categoriaId = (int) $categoriaId;

        $sql = "INSERT INTO transacaoesporadica
                (nome, descricao, dataDaTransacao, valor, tipo, categoria_id, usuario_id)
                VALUES ('$nome', '$descricao', NOW(), $valor, '$tipo', $categoriaId, $usuarioId)";

        if ($mysql->query($sql)) {
            header("Location: inicialUsuario.php");
            exit;
        } else {
            $erro = "Erro ao cadastrar a transação. Confira as colunas do banco.";
        }
    }

    $resultadoCategorias = $mysql->query("SELECT * FROM categoria");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ganho curto - Webt Finance</title>
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
    <!-- <nav class="navbar navbar-expand-lg bg-warning border border-2 border-dark">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold fs-4" href="inicialUsuario.php">Webt Finance</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-lg-4">
                    <li class="nav-item"><a class="nav-link" href="#">Opção 1</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Opção 2</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Opção 3</a></li>
                    <li class="nav-item"><a class="nav-link" href="gastosFixos.php">Ver fixos</a></li>
                </ul>
            </div>
            <a href="usuario.php" class="btn ms-3">Perfil</a>
        </div>
    </nav> -->
   <div class="container-fluid mt-3">

        <a class="btn btn-danger" href="inicialUsuario.php">Voltar</a>

    </div>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="formulario p-4 p-md-5">
                    <h3 class="fw-bold mb-4">Formulário de Gasto Fixo</h3>

                    <?php if (isset($erro)) { ?>
                        <div class="alert alert-danger"><?php echo $erro; ?></div>
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
                                <label for="categoria" class="campo-titulo mb-2">Categoria</label>
                                <select id="categoria" name="categoria" class="form-select" required>
                                    <option value="">Selecione uma categoria</option>
                                    <?php while ($categoria = $resultadoCategorias->fetch_assoc()) { ?>
                                        <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nome']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
