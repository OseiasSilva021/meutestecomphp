<?php
// Define as variáveis de conexão com o banco de dados
$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
             // Senha do banco de dados (em localhost, geralmente em branco para o usuário 'root')

// Cria uma nova conexão com o banco de dados usando PDO (PHP Data Objects)
$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

// Executa uma consulta SQL para selecionar dados da tabela "entradas"
// A consulta seleciona as colunas "conteudo" e "data" da tabela e ordena os resultados em ordem decrescente por "id"
$query = $conn->query("SELECT conteudo, data FROM entradas ORDER BY id DESC");

// Usa o método fetchAll para obter todos os resultados da consulta em um array associativo
// O PDO::FETCH_ASSOC instrui o PDO a retornar apenas os dados em formato de chave => valor (sem índice numérico)
$entradas = $query->fetchAll(PDO::FETCH_ASSOC);

// Converte o array associativo $entradas em um formato JSON
// Esse JSON será enviado como resposta para o frontend, que fará o parse e exibirá os dados
echo json_encode($entradas);
?>
