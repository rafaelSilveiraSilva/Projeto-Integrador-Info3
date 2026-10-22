<?php
// Inicia a sessão para identificar o usuário logado
session_start();

// Verifica se o usuário está logado (substitua 'id_usuario' pela variável de sessão do seu projeto)
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

// Inclua a conexão com o banco de dados aqui (ex: include 'conexao.php';)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe e sanitiza os dados do formulário
    $nome = trim($_POST['nome']);
    $tipo = trim($_POST['tipo']);
    $id_usuario = $_SESSION['id_usuario']; // ID do usuário logado

    // Validação simples
    if (!empty($nome) && ($tipo === 'gasto' || $tipo === 'ganho')) {
        
        /* 
           EXEMPLO DE SQL COM PDO:
           Certifique-se de que sua tabela 'categorias' possua colunas como:
           id, nome, tipo, id_usuario (onde categorias globais podem ter id_usuario NULL)
        */
        
        try {
            $sql = "INSERT INTO categorias (nome, tipo, id_usuario) VALUES (:nome, :tipo, :id_usuario)";
            $stmt = $conexao->prepare($sql);
            $stmt->execute([
                ':nome' => $nome,
                ':tipo' => $tipo,
                ':id_usuario' => $id_usuario
            ]);
            

            // Redireciona de volta para a página de categorias com sucesso
            header("Location: categorias.php?sucesso=1");
            exit();

        } catch (PDOException $e) {
            // Tratamento de erro
            header("Location: categorias.php?erro=db");
            exit();
        }

    } else {
        // Dados inválidos
        header("Location: categorias.php?erro=dados");
        exit();
    }
} else {
    // Se acessado diretamente via URL sem enviar o formulário
    header("Location: categorias.php");
    exit();
}
?>
