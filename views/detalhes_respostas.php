<?php
require_once("../models/db_connection.php");
require_once("verificar_login.php"); //verificação de login

if (!isset($_GET['setor'])) {
  header("Location: respostas.php");
  exit();
}

$setor = $_GET['setor'];
$conn = conectar();

// Consulta para obter as perguntas e respostas do setor especificado
$sql_respostas = "SELECT nome_usuario, pergunta, resposta FROM perguntas_respostas WHERE setor = ?";
$stmt_respostas = $conn->prepare($sql_respostas);
$stmt_respostas->bind_param("s", $setor);
$stmt_respostas->execute();
$result_respostas = $stmt_respostas->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <title>Detalhes das Respostas</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Adiciona a referência ao Materialize CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../css/detalhes_respostas.css">
</head>

<body>
  <!-- Navbar com Materialize CSS -->
  <nav style="background-color: #007bff; font-family: fantasy;">
    <div class="nav-wrapper">
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="logout.php" style="color: white; font-size:1.5rem;">LOGOUT</a></li>
      </ul>
    </div>
  </nav>
  <div id="conteudo">
    <h2>Respostas do Setor: <?php echo htmlspecialchars($setor); ?></h2>

    <?php
    $primeiro_registro = true;
    while ($row = $result_respostas->fetch_assoc()) {
      if ($primeiro_registro) {
        // Exibe o nome do usuário e os títulos das colunas da tabela no primeiro registro
        echo "<h3>Respondido por: " . htmlspecialchars($row['nome_usuario']) . "</h3>";
        echo "<table>";
        echo "<tr><th>Pergunta</th><th>Resposta</th></tr>";
        $primeiro_registro = false;
      }
      // Linhas da tabela com perguntas e respostas
      echo "<tr>";
      echo "<td>" . htmlspecialchars($row['pergunta']) . "</td>";
      echo "<td>" . htmlspecialchars($row['resposta']) . "</td>";
      echo "</tr>";
    }
    if (!$primeiro_registro) {
      // Fecha a tabela se pelo menos um registro foi exibido
      echo "</table>";
    }
    ?>
    <br>
    <a href="respostas.php">Voltar</a>
  </div>

  <!-- Adiciona a referência ao Materialize JavaScript -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>

</html>