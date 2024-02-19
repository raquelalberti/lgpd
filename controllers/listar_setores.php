<?php
require_once("../models/db_connection.php");

// Consulta todos os setores na tabela 'setores'
$sql = "SELECT * FROM setores";
$result = $conn->query($sql);

// Verifica se há setores cadastrados
if ($result->num_rows > 0) {
  echo "<h2>Setores Cadastrados</h2>";
  echo "<ul>";
  while ($row = $result->fetch_assoc()) {
    echo "<li>";
    echo $row['nome'];
    echo " <a href='editar_setor.php?id={$row['id']}'>Editar</a>";
    echo " <a href='excluir_setor.php?id={$row['id']}'>Excluir</a>";
    echo "</li>";
  }
  echo "</ul>";
} else {
  echo "<p>Nenhum setor cadastrado.</p>";
}

$conn->close();
?>
