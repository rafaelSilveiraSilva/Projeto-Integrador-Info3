<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$mysql = new mysqli(
    "localhost", 
    "root",      
    "",          
    "pi_iii",    
    3306         
);

if ($mysql->connect_error) {
    die("Falha na conexão: " . $mysql->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['acao']) && $_POST['acao'] == 'cadastrar') {
    $nome = $mysql->real_escape_string(trim($_POST['nome']));
    $tipo = $mysql->real_escape_string(trim($_POST['tipo']));
    $usuario_id = $_SESSION['usuario'];

    if (!empty($nome) && ($tipo === 'gasto' || $tipo === 'ganho')) {
        $mysql->query("INSERT INTO categorias (nome, tipo, usuario_id) VALUES ('$nome', '$tipo', '$usuario_id')");
        header("Location: categorias.php?sucesso=1");
        exit();
    }
}


if (isset($_GET['deletar'])) {
    $id_cat = intval($_GET['deletar']);
    $usuario_id = $_SESSION['usuario'];

    $mysql->query("DELETE FROM categorias WHERE id = $id_cat AND usuario_id = '$usuario_id'");
    header("Location: categorias.php");
    exit();
}


$res_sistema = $mysql->query("SELECT * FROM categorias WHERE usuario_id IS NULL OR usuario_id = 0");


$res_usuario = $mysql->query("SELECT * FROM categorias WHERE usuario_id = '$_SESSION[usuario]'");
?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webt Finance - Gerenciar Categorias</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/css/bootstrap.min.css" integrity="sha512-2bBQCjcnw658Lho4nlXJcc6WkV/UxpE/sAokbXPxQNGqmNdQrWqtw26Ns9kFF/yG792pKR1Sx8/Y1Lf1XN4GKA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/js/bootstrap.min.js" integrity="sha512-nKXmKvJyiGQy343jatQlzDprflyB5c+tKCzGP3Uq67v+lmzfnZUi/ZT+fc6ITZfSC5HhaBKUIvr/nTLCV+7F+Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <?php include 'navbar.php' ?>

    
    <div class="row mb-5 mt-5"></div>

    <div class="container-fluid p-4">
        
        <div class="row text-center mb-4">
            <div class="col">
                <h1><b>Gerenciamento de Categorias</b></h1>
                <p class="text-secondary">Adicione suas próprias categorias de gastos ou ganhos ou consulte as categorias padrão do sistema.</p>
            </div>
        </div>

        <?php if (isset($_GET['sucesso'])): ?>
            <div class="alert alert-success text-center" role="alert">
                Categoria cadastrada com sucesso!
            </div>
        <?php endif; ?>

        <div class="row justify-content-center">
            
            
            <div class="col-12 col-md-4 mb-4">
                <div class="card border-0 shadow-sm p-4 h-100">
                    <h3 class="h5 fw-bold mb-3">➕ Nova Categoria</h3>
                    
                    <form action="categorias.php" method="POST">
                        <input type="hidden" name="acao" value="cadastrar">
                        
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome da Categoria</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: Lazer, Freelance..." required>
                        </div>

                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select class="form-select" id="tipo" name="tipo" required>
                                <option value="" selected disabled>Selecione...</option>
                                <option value="gasto">Gasto (Despesa)</option>
                                <option value="ganho">Ganho (Receita)</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 py-2">Salvar Categoria</button>
                    </form>
                </div>
            </div>

            
            <div class="col-12 col-md-7">
                <div class="card border-0 shadow-sm p-4 h-100">
                    <h3 class="h5 fw-bold mb-3">📋 Categorias Disponíveis</h3>

                    
                    <div class="mb-4">
                        <h6 class="text-muted fw-bold">Categorias Globais do Sistema</h6>
                        <ul class="list-group mb-3">
                            <?php if ($res_sistema && $res_sistema->num_rows > 0): ?>
                                <?php while ($cat = $res_sistema->fetch_assoc()): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?= htmlspecialchars($cat['nome']) ?>
                                        <span class="badge <?= ($cat['tipo'] == 'ganho') ? 'bg-success' : 'bg-danger' ?> rounded-pill">
                                            <?= ucfirst($cat['tipo']) ?>
                                        </span>
                                    </li>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <li class="list-group-item text-muted">Nenhuma categoria padrão cadastrada.</li>
                            <?php endif; ?>
                        </ul>
                    </div>

                    
                    <div>
                        <h6 class="text-muted fw-bold">Suas Categorias Personalizadas</h6>
                        <ul class="list-group">
                            <?php if ($res_usuario && $res_usuario->num_rows > 0): ?>
                                <?php while ($cat = $res_usuario->fetch_assoc()): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?= htmlspecialchars($cat['nome']) ?>
                                        <div class="d-flex align-items-center">
                                            <span class="badge <?= ($cat['tipo'] == 'ganho') ? 'bg-success' : 'bg-danger' ?> rounded-pill me-3">
                                                <?= ucfirst($cat['tipo']) ?>
                                            </span>
                                            <a href="categorias.php?deletar=<?= $cat['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir esta categoria?');">Excluir</a>
                                        </div>
                                    </li>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <li class="list-group-item text-muted">Você ainda não criou nenhuma categoria personalizada.</li>
                            <?php endif; ?>
                        </ul>
                    </div>

                </div>
            </div>

        </div>

    </div>

</body>

</html>
