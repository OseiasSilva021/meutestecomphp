<?php
// Define as variáveis de conexão com o banco de dados
$servername = "sql101.infinityfree.com";  // substitua pelo host do banco de dados gerado
$username = "	if0_37715443";       // substitua pelo seu usuário do banco de dados
$password = "MKpZNUO7ISKVG";           // substitua pela sua senha do banco de dados
$dbname = "if0_37715443_meu_banco_de_dados";
             // Senha para acessar o banco de dados (em ambiente local, geralmente em branco para o usuário "root")

// Cria uma nova instância de PDO para estabelecer uma conexão com o banco de dados
// O PDO é utilizado para interagir com o banco de dados de forma segura e eficiente
$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

// Verifica se o método da requisição HTTP é POST, ou seja, se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtém o valor do campo 'conteudo' enviado via POST, ou uma string vazia caso não tenha sido enviado
    $conteudo = $_POST['conteudo'] ?? '';

    // Prepara uma consulta SQL para inserir um novo registro na tabela 'entradas'
// O uso de prepared statements ajuda a evitar SQL injection (injeção de código malicioso)
    $stmt = $conn->prepare("INSERT INTO entradas (conteudo) VALUES (:conteudo)");

    // Faz o "bind" (vinculação) do valor da variável $conteudo à posição nomeada :conteudo na consulta SQL
    // Isso assegura que o valor será passado de forma segura para a consulta
    $stmt->bindParam(':conteudo', $conteudo);

    // Executa a consulta SQL para inserir o novo registro
    $stmt->execute();

    // Após a inserção, uma nova consulta é executada para buscar todas as entradas armazenadas no banco
    // A consulta retorna as colunas "conteudo" e "data", ordenadas pela coluna "id" de forma decrescente (do mais recente para o mais antigo)
    $query = $conn->query("SELECT conteudo, data FROM entradas ORDER BY id DESC");

    // Os resultados da consulta são armazenados em um array associativo usando fetchAll()
    // O PDO::FETCH_ASSOC instrui o PDO a retornar os dados apenas como chave => valor, sem índices numéricos
    $entradas = $query->fetchAll(PDO::FETCH_ASSOC);

    // Converte o array de entradas para o formato JSON e o envia como resposta para o cliente
    // O frontend pode usar esse JSON para exibir dinamicamente as entradas na interface do usuário
    echo json_encode($entradas);
}
?>
