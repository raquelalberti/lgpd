<?php
require_once("verificar_login.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Setores</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"> <!-- Materialize CSS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script> <!-- Materialize JavaScript -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/setores.css">
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
    <h2>SETORES CADASTRADOS</h2>

    <!-- Lista de setores cadastrados como uma coleção -->
    <ul class="collection">
      <?php
      require_once("../models/db_connection.php");

      $conn = conectar();

      // Consulta os setores cadastrados no banco de dados
      $sql = "SELECT * FROM setores";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        // Exibe cada setor com as opções de editar e excluir
        while ($row = $result->fetch_assoc()) {
          // Consulta os valores de gin e gci com base no ID do setor
          $sql_valores = "SELECT gin, gci FROM setores WHERE id = " . $row["id"];
          $result_valores = $conn->query($sql_valores);
          $valores = $result_valores->fetch_assoc();

          echo '<li class="collection-item">';
          echo '<div>';
          echo $row["nome"];
          echo '</div>';
          echo '<div class="collection-buttons">';
          echo '<button class="btn-small" onclick="mostrarPopupEditar(' . $row["id"] . ', \'' . $row["nome"] . '\', ' . $valores["gin"] . ', ' . $valores["gci"] . ')"><i class="material-icons">edit</i> Editar</button> ';
          echo '<button class="btn-small red" onclick="excluirSetor(' . $row["id"] . ')"><i class="material-icons">delete</i> Excluir</button>';
          echo '</div>';
          echo '</li>';
        }
      } else {
        echo '<li class="collection-item">Nenhum setor cadastrado.</li>';
      }

      $conn->close();
      ?>
    </ul>

    <!-- Botão para abrir o modal de inclusão de setor -->
    <a class="waves-effect waves-light btn modal-trigger" href="#modalIncluir">Incluir Setor</a>

    <!-- Modal de inclusão de setor -->
    <div id="modalIncluir" class="modal">
      <div class="modal-content">
        <h2>Incluir Setor</h2>
        <form id="formIncluir" method="post" onsubmit="incluirSetor(event)">
          <div class="input-field">
            <input type="text" name="nome" required>
            <label for="nome">Nome do Setor</label>
          </div>
          <div class="input-field">
            <select id="gin" name="gin" required>
              <option value="" disabled selected>Escolha uma opção</option>
              <option value="1">Pouco Importante</option>
              <option value="2">Importante</option>
              <option value="3">Muito Importante</option>
            </select>
            <label>Grau de criticidade do setor para o negócio:</label>
          </div>
          <div class="input-field">
            <select id="gci" name="gci" required>
              <option value="" disabled selected>Escolha uma opção</option>
              <option value="1">Baixa</option>
              <option value="2">Média</option>
              <option value="3">Alta</option>
            </select>
            <label>Grau de criticidade da informação dos setores:</label>
          </div>
          <button type="submit" class="waves-effect waves-light btn">Incluir</button>
        </form>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
      </div>
    </div>

    <!-- Modal de edição de setor -->
    <div id="modalEditar" class="modal">
      <div class="modal-content">
        <h2>Editar Setor</h2>
        <form id="formEditar" method="post" onsubmit="atualizarSetor(event)">
          <input type="text" id="inputNomeEditar" name="nome_setor" required>
          <input type="hidden" id="inputIdEditar" name="id_setor">
          <div class="input-field">
            <select id="inputGINGIN" name="gin" required>
              <option value="1">Pouco Importante</option>
              <option value="2">Importante</option>
              <option value="3">Muito Importante</option>
            </select>
            <label>Grau de criticidade do setor para o negócio:</label>
          </div>
          <div class="input-field">
            <select id="inputGCIGCI" name="gci" required>
              <option value="1">Baixo</option>
              <option value="2">Média</option>
              <option value="3">Alta</option>
            </select>
            <label>Grau de criticidade da informação dos setores:</label>
          </div>
          <button type="submit" class="waves-effect waves-light btn">Atualizar</button>
          <button type="button" class="waves-effect waves-light btn" onclick="fecharPopupEditar()">Fechar</button>
        </form>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Inicialize os selects do Materialize CSS
      var elems = document.querySelectorAll('select');
      var instances = M.FormSelect.init(elems);

      // Inicialize os modais
      var modals = document.querySelectorAll('.modal');
      M.Modal.init(modals);
    });

    function incluirSetor(event) {
      event.preventDefault();

      var form = document.getElementById("formIncluir");
      var formData = new FormData(form);

      fetch("../controllers/incluir_setor.php", {
          method: "POST",
          body: formData,
        })
        .then(response => response.text())
        .then(data => {
          alert(data); // Exibe mensagem de sucesso ou erro

          // Fecha o modal de inclusão usando o Materialize CSS
          var modalIncluir = M.Modal.getInstance(document.getElementById("modalIncluir"));
          modalIncluir.close();

          location.reload(); // Recarrega a página para atualizar a lista de setores
        })
        .catch(error => {
          alert("Erro ao incluir o setor: " + error);
        });
    }

    function mostrarPopupEditar(id, nome, gin, gci) {
      var inputNome = document.getElementById("inputNomeEditar");
      var inputId = document.getElementById("inputIdEditar");
      var selectGIN = document.getElementById("inputGINGIN");
      var selectGCI = document.getElementById("inputGCIGCI");

      inputNome.value = nome;
      inputId.value = id;

      // Define os valores selecionados nos selects
      var instanceGIN = M.FormSelect.getInstance(selectGIN);
      instanceGIN.input.value = gin;

      var instanceGCI = M.FormSelect.getInstance(selectGCI);
      instanceGCI.input.value = gci;

      // Abre o modal de edição
      var modalEditar = M.Modal.getInstance(document.getElementById("modalEditar"));
      modalEditar.open();
    }

    function fecharPopupEditar() {
      var modalEditar = M.Modal.getInstance(document.getElementById("modalEditar"));
      modalEditar.close();
    }

    function atualizarSetor(event) {
      event.preventDefault();

      var form = document.getElementById("formEditar");
      var formData = new FormData(form);

      fetch("../controllers/atualizar_setor.php", {
          method: "POST",
          body: formData,
        })
        .then(response => response.text())
        .then(data => {
          alert(data); // Exibe mensagem de sucesso ou erro
          fecharPopupEditar(); // Fecha o popup de edição
          location.reload(); // Recarrega a página para atualizar a lista de setores
        })
        .catch(error => {
          alert("Erro ao atualizar o setor: " + error);
        });
    }

    function excluirSetor(id) {
      if (confirm("Deseja realmente excluir este setor?")) {
        fetch("../controllers/excluir_setor.php?id=" + id)
          .then(response => response.text())
          .then(data => {
            alert(data); // Exibe mensagem de sucesso ou erro
            location.reload(); // Recarrega a página para atualizar a lista de setores
          })
          .catch(error => {
            alert("Erro ao excluir o setor: " + error);
          });
      }
    }
  </script>
</body>

</html>