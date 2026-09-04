<?php
session_start();

// CONEXÃO COM O BD
$mysql = new mysqli("localhost", "root", "", "pi_iii", 3306);

// VERIFICA ALGUM ERRO DE CONEXÃO
if ($mysql->connect_error) {
    die("Erro na conexão: " . $mysql->connect_error);
}

// VERIFICA SE O ID DO USUÁRIO ESTÁ PREENCHIDO
if (isset($_SESSION['usuario'])) {
    $usuario_id = (int)$_SESSION['usuario'];
} else {
    $usuario_id = 0;
}

// FAZ UMA QUERY NO BD PARA SOMAR OS GASTOS RECORRENTES DO MÊS
$sqlTotalGastoRecorrente = $mysql->query("SELECT sum(tr.valor) as totalRecorrente
FROM transacaorecorrente tr JOIN usuario u ON tr.usuario_id = u.id
WHERE tr.tipo = 'Gasto' AND tr.ativo = 1 AND u.id = $usuario_id");

//  SE AS QUERYS DEREM ERRO, ELE PARA A EXECUÇÃO E EXIBE O "LOG" DO ERRO
if (!$sqlTotalGastoRecorrente) {
    die("Erro na consulta SQL: " . $mysql->error);
}

// FAZ UMA QUERY NO BD PARA SOMAR OS GASTOS RECORRENTES MENSAIS
$sqlTotalGastoEsporadico = $mysql->query("SELECT SUM(valor) AS totalEsporadico
FROM transacaoesporadica 
WHERE tipo = 'Gasto' AND ativo = 1 AND usuario_id = $usuario_id AND MONTH(dataDaTransacao) = MONTH(CURRENT_DATE()) AND YEAR(dataDaTransacao) = YEAR(CURRENT_DATE())");

//  SE AS QUERYS DEREM ERRO, ELE PARA A EXECUÇÃO E EXIBE O "LOG" DO ERRO
if (!$sqlTotalGastoEsporadico) {
    die("Erro na consulta SQL: " . $mysql->error);
}

// TRANSFORMA A CONSULTA EM UMA LINHA QUE PODE SER ACESSADA PELOS ÍNDICES PELO FETCH_ASSOC()
$rsRecorrente = $sqlTotalGastoRecorrente->fetch_assoc();

// TRANSFORMA A CONSULTA EM UMA LINHA QUE PODE SER ACESSADA PELOS ÍNDICES PELO FETCH_ASSOC()
$rsEsporadico = $sqlTotalGastoEsporadico->fetch_assoc();


// SOMA TODOS OS GASTOS
$gastosTotaisMes = $rsRecorrente['totalRecorrente'] + $rsEsporadico['totalEsporadico'];

// FAZ UMA QUERY PARA PEGAR OS GASTOS POR CATEGORIA NO MÊS ATUAL
$rsPlot = $mysql->query("SELECT SUM(tr.valor) AS totalCat, c.nome AS nomeCategoria FROM transacaorecorrente tr JOIN categoria c ON tr.categoria_id = c.id
WHERE tr.usuario_id = $usuario_id  AND tr.tipo = 'Gasto' AND tr.ativo = 1 GROUP BY c.nome");

// SE A QUERY RSPLOT DER ERRO, ELE PARA A EXECUÇÃO E EXIBE O "LOG" DO ERRO
if (!$rsPlot) {
    die("Erro na consulta SQL: " . $mysql->error);
}

// CRIA OS ARRAYS QUE SERÃO UTLIZADOS COMO X E Y DO GRÁFICO
$categorias = array();
$total = array();

// PERCORRE CADA LINHA DA CONSULTA E ADICIONA AS CATEGORIAS EM UM ARRAY E O TOTAL POR CATEGORIA EM OUTRO ARRAY
foreach($rsPlot as $ln) {
    $categorias[] = $ln['nomeCategoria'];
    $total[] = $gastosTotaisMes > 0 ? ((float)$ln['totalCat'] / $gastosTotaisMes) * 100 : 0;
}

// SE O NÚMERO DE ELEMENTOS NA LISTA TOTAL (PODERIA SER NA OUTRA LISTA TAMBÉM) FOR ZERO, SIGNIFICA QUE NÃO HÁ DADOS E ELE PREENCHE OS ARRAYS PARA NÃO DAR ERRO
if (count($total) == 0) {
    $categorias = array("Sem Dados");
    $total = array(0);
}

// CONECTA COM A PASTA DO JPGRAPH
require_once 'jpgraph-4.4.3/src/jpgraph.php';
require_once 'jpgraph-4.4.3/src/jpgraph_bar.php';

// DEFINE A LARGURA E ALTURA, RESPECTIVAMENTE
$width = 300;
$height = 500;

// CRIA UM NOVO GRÁFICO COM OS VALORES DE ALTURA E LARGURA DEFINIDOS E COLOCO COMO ESCALA UM TEXTO PARA O X E UM NÚMERO NO Y
$graph = new Graph($width, $height);
$graph->SetScale('textlin');

// DEFINO O TÍTULO DO GRÁFICO
$graph->title->Set('Gastos recorrentes por categoria');

// CONFIGURO O EIXO X COM OS VALORES DO ARRAY CATEGORIA E O TÍTULO DE Y
$graph->xaxis->SetTickLabels($categorias);
$graph->xaxis->title->Set('Categorias');
$graph->yaxis->title->Set('Porcentagem de ganhos');

// CRIO O TIPO DE GRÁFICO BARPLOT E ADICIONO ELE
$barplot = new BarPlot($total);
$graph->Add($barplot);

// DEFINO A LARGURA DA BARRA
$barplot->SetWidth(0.2);

// VALOR DE PORCENTAGEM EXATO EM CIMA DA BARRA
$barplot->value->Show();
$barplot->value->SetFormat('%.1f%%');

// ALTERO A COR DA BARRA E SEU CONTORNO
$barplot->SetFillColor('#f8f408');
$barplot->SetColor('#0044cc');

// EXIBO O GRÁFICO E O TRANSFORMO EM IMG
$graph->Stroke();
?>