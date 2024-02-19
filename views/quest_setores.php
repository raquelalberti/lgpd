<?php
require_once("verificar_login.php"); // Inclui o arquivo de verificação de login
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Selecionar Setor</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/quest_setores.css">
</head>

<body>
    <nav style="background-color: #007bff; font-family: fantasy;">
        <div class="nav-wrapper">
            <a href="#" class="brand-logo">SETOR</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="logout.php" style="color: white; font-size:1.5rem;">LOGOUT</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h2></h2>
        <form method="post" action="quest_perg.php">
            <ul class="collection with-header">
                <li class="collection-header">
                    <h4>SELECIONE SEU SETOR</h4>
                </li>
                <?php
                require_once("../models/db_connection.php");
                $conn = conectar();

                // Consulta os setores e verifica se já existe resposta
                $sql = "SELECT setores.nome, COUNT(respostas.id) as resposta_count
                        FROM setores
                        LEFT JOIN respostas ON setores.nome = respostas.setor
                        GROUP BY setores.nome";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $setorNome = htmlspecialchars($row["nome"], ENT_QUOTES, 'UTF-8');
                        $respostaCadastrada = (int)$row["resposta_count"] > 0 ? "true" : "false";
                        echo "<li class='collection-item'>
                                <div>{$setorNome}
                                    <a href='#' class='secondary-content setor-link' data-setor='{$setorNome}' data-resposta-cadastrada='{$respostaCadastrada}'>
                                        <i class='material-icons'>send</i>
                                    </a>
                                </div>
                              </li>";
                    }
                } else {
                    echo "Nenhum setor cadastrado.";
                }
                $conn->close();
                ?>
            </ul>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.setor-link');
            elems.forEach(function(elem) {
                elem.addEventListener('click', function(e) {
                    e.preventDefault();
                    var setor = this.dataset.setor;
                    var respostaCadastrada = this.dataset.respostaCadastrada === 'true';
                    if (respostaCadastrada) {
                        alert('Resposta já cadastrada para este setor, contate o administrador.');
                    } else {
                        window.location.href = "quest_perg.php?setor=" + encodeURIComponent(setor);
                    }
                });
            });
        });
    </script>
</body>

</html>