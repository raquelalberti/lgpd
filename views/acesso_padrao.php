<!DOCTYPE html>
<html lang="pt-br">

<head>
  <title>Questionário</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <?php session_start(); ?>
  <link rel="stylesheet" type="text/css" href="../css/acesso_padrao.css">
</head>

<body>
  <div class="container">
    <h1 style="font-size: 40px;">PARA COMEÇAR O QUESTIONÁRIO CLIQUE NO BOTÃO ABAIXO</h1>
    <a class="waves-effect waves-light btn btn-raised blue" onclick="iniciar()">Começar<i class="material-icons icon">navigate_next</i></a>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

  <script>
    function iniciar() {
      window.location.href = "quest_setores.php";
    }
  </script>
</body>

</html>