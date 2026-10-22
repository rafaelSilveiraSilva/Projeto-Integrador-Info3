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
$stmt = $mysql->prepare(
    "SELECT nome, valor, tipo, categoria, frequencia, dataLancamento
     FROM (
         SELECT te.nome, te.valor, te.tipo, c.nome AS categoria,
                'Esporádico' AS frequencia,
                DATE_FORMAT(te.dataDaTransacao, '%d/%m/%Y') AS dataLancamento
         FROM TransacaoEsporadica te
         INNER JOIN Categoria c ON c.id = te.categoria_id
         WHERE te.usuario_id = ? AND te.ativo = 1
         UNION ALL
         SELECT tr.nome, tr.valor, tr.tipo, c.nome AS categoria,
                'Recorrente' AS frequencia,
                CONCAT('Dia ', tr.diaVencimento) AS dataLancamento
         FROM TransacaoRecorrente tr
         INNER JOIN Categoria c ON c.id = tr.categoria_id
         WHERE tr.usuario_id = ? AND tr.ativo = 1
     ) AS lancamentos
     ORDER BY frequencia, nome"
);
$stmt->bind_param('ii', $usuarioId, $usuarioId);
$stmt->execute();
$lancamentos = $stmt->get_result();
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Webt Finance - Lançamentos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="index.css">
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>

    <main class="container py-5 mt-5">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <a href="inicialUsuario.php" class="btn btn-outline-secondary mb-3">Voltar</a>
                <h1 class="fw-bold mb-1">Lançamentos</h1>
                <p class="text-secondary mb-0">Consulte seus lançamentos recorrentes e esporádicos.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="criarCategoria.php" class="btn btn-outline-dark">Criar Categoria</a>
                <a href="adicionarLancamento.php" class="btn btn-warning">Adicionar lançamento</a>
            </div>
        </div>

        <?php if (isset($_GET['sucesso'])): ?>
            <div class="alert alert-success">Lançamento criado com sucesso.</div>
        <?php elseif (isset($_GET['categoria_sucesso'])): ?>
            <div class="alert alert-success">Categoria criada com sucesso.</div>
        <?php endif; ?>

        <section class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h2 class="h4 mb-3">Meus lançamentos</h2>
                <?php if ($lancamentos->num_rows === 0): ?>
                    <p class="text-secondary mb-0">Você ainda não possui lançamentos cadastrados.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Categoria</th>
                                    <th>Tipo de lançamento</th>
                                    <th>Tipo</th>
                                    <th>Data / vencimento</th>
                                    <th class="text-end">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($lancamento = $lancamentos->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($lancamento['nome']) ?></td>
                                        <td><?= htmlspecialchars($lancamento['categoria']) ?></td>
                                        <td>
                                            <span class="badge text-bg-<?= $lancamento['frequencia'] === 'Recorrente' ? 'primary' : 'secondary' ?>">
                                                <?= htmlspecialchars($lancamento['frequencia']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge text-bg-<?= $lancamento['tipo'] === 'Ganho' ? 'success' : 'danger' ?>">
                                                <?= htmlspecialchars($lancamento['tipo']) ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($lancamento['dataLancamento']) ?></td>
                                        <td class="text-end">
                                            R$ <?= number_format((float) $lancamento['valor'], 2, ',', '.') ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>
</html>
