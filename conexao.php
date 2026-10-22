<?php
$host = "sql10.freesqldatabase.com";     
$usuario = "sql10839296";
$senha = "YvLHqLX5WA";    
$porta = 3306;

$mysql = new mysqli($host, $usuario, $senha, $porta);

if ($mysql->connect_error) {
    die("Erro de conexão com o banco de dados: " . $mysql->connect_error);
}
?>
