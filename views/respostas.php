<?php
require_once("../models/db_connection.php");
require_once("verificar_login.php");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Respostas</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/respostas.css">
</head>

<body>

    <div class="background"></div>

    <nav style="background-color: #007bff; font-family: fantasy;">
        <div class="nav-wrapper">
            <a href="#" data-target="menu" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="logout.php" style="color: white; font-size:1.5rem;">LOGOUT</a></li>
            </ul>
        </div>
    </nav>

    <div id="menu" class="sidenav sidenav-fixed">
        <ul>
            <!-- Opções de direcionamento do menu -->
            <li><a href="acesso_adm.php">INÍCIO</a></li>
            <li><a href="setores.php">SETORES</a></li>
            <li><a href="respostas.php">RESPOSTAS</a></li><br>
        </ul>
    </div>

    <div id="conteudo" style="margin-top: 40px; margin-left: 250px; padding: 20px;">
        <h3>RESPOSTAS POR SETOR</h3>
        <div class="collection">
            <?php
            $conn = conectar();

            // Consulta para obter os nomes dos setores que possuem respostas
            $sql = "SELECT DISTINCT setor FROM respostas";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<a href='detalhes_respostas.php?setor=" . urlencode($row['setor']) . "' class='collection-item'>" . $row['setor'] . "</a>";
            }

            $conn->close();
            ?>
        </div>
    </div>


    <!-- Adicione a referência ao Materialize JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>

</html>