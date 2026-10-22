<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$mysql = new mysqli('localhost', 'root', '', 'pi_iii', 3306);
if ($mysql->connect_error) {
    die('Falha na conexão com o banco de dados: ' . $mysql->connect_error);
}
$mysql->set_charset('utf8mb4');
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');

    if ($nome === '' || mb_strlen($nome) > 100) {
        $erro = 'Informe um nome com até 100 caracteres.';
    } else {
        $stmt = $mysql->prepare('SELECT id FROM Categoria WHERE nome = ? AND ativo = 1 LIMIT 1');
        $stmt->bind_param('s', $nome);
        $stmt->execute();
        $existe = $stmt->get_result()->num_rows > 0;
        $stmt->close();

        if ($existe) {
            $erro = 'Essa categoria já está cadastrada.';
        } else {
            $stmt = $mysql->prepare('INSERT INTO Categoria (nome, ativo) VALUES (?, 1)');
            $stmt->bind_param('s', $nome);
            $stmt->execute();
            $stmt->close();
            header('Location: lancamentos.php?categoria_sucesso=1');
            exit();
        }
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Webt Finance - Criar categoria</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>
    <main class="container py-5 mt-5">
        <div class="card border-0 shadow-sm mx-auto" style="max-width: 560px;">
            <div class="card-body p-4">
                <a href="lancamentos.php" class="btn btn-outline-secondary mb-4">Voltar</a>
                <h1 class="h3 fw-bold">Criar Categoria</h1>
                <p class="text-secondary">Adicione uma categoria para organizar seus lançamentos.</p>
                <?php if ($erro !== ''): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
                <?php endif; ?>
                <form method="post">
                    <label for="nome" class="form-label">Nome da categoria</label>
                    <input type="text" id="nome" name="nome" class="form-control mb-3"
                           maxlength="100" placeholder="Ex.: Academia" required>
                    <button type="submit" class="btn btn-warning">Criar Categoria</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
