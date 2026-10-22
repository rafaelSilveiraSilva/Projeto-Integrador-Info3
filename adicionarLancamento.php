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
$usuarioId = (int) $_SESSION['usuario'];
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $tipo = $_POST['tipo'] ?? '';
    $frequencia = $_POST['frequencia'] ?? '';
    $valor = str_replace(',', '.', trim($_POST['valor'] ?? ''));
    $dataVencimento = $_POST['dataVencimento'] ?? '';
    $categoriaId = filter_input(INPUT_POST, 'categoria_id', FILTER_VALIDATE_INT);

    if ($nome === '' || mb_strlen($nome) > 100) {
        $erro = 'Informe um nome válido para o lançamento.';
    } elseif (!in_array($tipo, ['Gasto', 'Ganho'], true)) {
        $erro = 'Selecione se o lançamento é um gasto ou ganho.';
    } elseif (!in_array($frequencia, ['Unico', 'Semanal', 'Mensal'], true)) {
        $erro = 'Selecione uma frequência válida.';
    } elseif (!is_numeric($valor) || (float) $valor <= 0) {
        $erro = 'Informe um valor maior que zero.';
    } elseif ($frequencia !== 'Unico' && (
        !preg_match('/^\d{4}-\d{2}-\d{2}$/', $dataVencimento)
        || !checkdate(
            (int) substr($dataVencimento, 5, 2),
            (int) substr($dataVencimento, 8, 2),
            (int) substr($dataVencimento, 0, 4)
        )
    )) {
        $erro = 'Informe uma data de vencimento válida.';
    } elseif ($categoriaId === false || $categoriaId < 1) {
        $erro = 'Selecione uma categoria.';
    } else {
        $stmt = $mysql->prepare('SELECT id FROM Categoria WHERE id = ? AND ativo = 1 LIMIT 1');
        $stmt->bind_param('i', $categoriaId);
        $stmt->execute();
        $categoriaValida = $stmt->get_result()->num_rows > 0;
        $stmt->close();

        if (!$categoriaValida) {
            $erro = 'A categoria selecionada não está disponível.';
        } else {
            $valorDecimal = (float) $valor;
            if ($frequencia === 'Unico') {
                $dataTransacao = date('Y-m-d');
                $stmt = $mysql->prepare(
                    'INSERT INTO TransacaoEsporadica
                    (nome, descricao, dataDaTransacao, ativo, valor, tipo, categoria_id, usuario_id)
                    VALUES (?, ?, ?, 1, ?, ?, ?, ?)'
                );
                $stmt->bind_param('sssdsii', $nome, $descricao, $dataTransacao, $valorDecimal, $tipo, $categoriaId, $usuarioId);
            } else {
                $diaVencimento = (int) substr($dataVencimento, 8, 2);
                $stmt = $mysql->prepare(
                    'INSERT INTO TransacaoRecorrente
                    (nome, descricao, diaVencimento, ativo, valor, tipo, categoria_id, usuario_id)
                    VALUES (?, ?, ?, 1, ?, ?, ?, ?)'
                );
                $stmt->bind_param(
                    'ssidsii',
                    $nome,
                    $descricao,
                    $diaVencimento,
                    $valorDecimal,
                    $tipo,
                    $categoriaId,
                    $usuarioId
                );
            }

            if ($stmt->execute()) {
                $stmt->close();
                header('Location: lancamentos.php?sucesso=1');
                exit();
            }
            $erro = 'Não foi possível salvar o lançamento.';
            $stmt->close();
        }
    }
}

$categorias = $mysql->query('SELECT id, nome FROM Categoria WHERE ativo = 1 ORDER BY nome');
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Webt Finance - Adicionar lançamento</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>
    <main class="container py-5 mt-5">
        <div class="card border-0 shadow-sm mx-auto" style="max-width: 760px;">
            <div class="card-body p-4">
                <a href="lancamentos.php" class="btn btn-outline-secondary mb-4">Voltar</a>
                <h1 class="h3 fw-bold">Adicionar lançamento</h1>
                <p class="text-secondary">Lançamentos únicos vão para o histórico; os demais ficam como recorrentes.</p>
                <?php if ($erro !== ''): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
                <?php endif; ?>
                <form method="post" class="row g-3">
                    <div class="col-md-8">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" id="nome" name="nome" class="form-control" maxlength="100" required>
                    </div>
                    <div class="col-md-4">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select id="tipo" name="tipo" class="form-select" required>
                            <option value="">Selecione</option>
                            <option value="Gasto">Gasto</option>
                            <option value="Ganho">Ganho</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="valor" class="form-label">Valor (R$)</label>
                        <input type="text" id="valor" name="valor" class="form-control" inputmode="decimal" placeholder="0,00" required>
                    </div>
                    <div class="col-md-4">
                        <label for="frequencia" class="form-label">Frequência</label>
                        <select id="frequencia" name="frequencia" class="form-select" required>
                            <option value="">Selecione</option>
                            <option value="Unico">Único</option>
                            <option value="Semanal">Semanal</option>
                            <option value="Mensal">Mensal</option>
                        </select>
                    </div>
                    <div class="col-md-4" id="data-vencimento-container" hidden>
                        <label for="dataVencimento" class="form-label">Data do vencimento</label>
                        <input type="date" id="dataVencimento" name="dataVencimento" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="categoria_id" class="form-label">Categoria</label>
                        <select id="categoria_id" name="categoria_id" class="form-select" required>
                            <option value="">Selecione</option>
                            <?php while ($categoria = $categorias->fetch_assoc()): ?>
                                <option value="<?= (int) $categoria['id'] ?>"><?= htmlspecialchars($categoria['nome']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="descricao" class="form-label">Descrição (opcional)</label>
                        <textarea id="descricao" name="descricao" class="form-control" maxlength="500" rows="2"></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-warning">Salvar lançamento</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script>
        const frequencia = document.getElementById('frequencia');
        const dataContainer = document.getElementById('data-vencimento-container');
        const dataVencimento = document.getElementById('dataVencimento');

        frequencia.addEventListener('change', function () {
            const recorrente = frequencia.value !== 'Unico';
            dataContainer.hidden = !recorrente;
            dataVencimento.required = recorrente;
        });
    </script>
</body>
</html>
