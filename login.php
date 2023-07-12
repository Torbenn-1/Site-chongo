<?php
session_start(); // Inicia a sessão (caso ainda não esteja iniciada)

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Obtém os dados do formulário
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Verifica as credenciais
  if (verificarCredenciais($username, $password)) {
    // Autenticação bem-sucedida
    $_SESSION["username"] = $username; // Armazena o nome de usuário na sessão
    header("Location: dashboard.html"); // Redireciona para a página de dashboard (ou qualquer outra página desejada)
    exit();
  } else {
    // Autenticação falhou
    $erro = "Credenciais inválidas. Por favor, tente novamente.";
  }
}

// Função para verificar as credenciais no banco de dados SQLite
function verificarCredenciais($username, $password) {
  $db = new PDO('sqlite:login.db'); // Conecta ao banco de dados SQLite (certifique-se de ter um arquivo "database.db" no mesmo diretório)

  // Consulta o banco de dados para verificar as credenciais
  $query = "SELECT COUNT(*) FROM users WHERE username = :username AND password = :password";
  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->bindValue(':password', $password);
  $statement->execute();

  $result = $statement->fetchColumn();
  return $result > 0; // Retorna true se as credenciais forem válidas, false caso contrário
}
?>