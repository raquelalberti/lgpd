<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    require_once("../models/db_connection.php");

    $id_setor = $_GET["id"];

    // Consulta o setor pelo ID no banco de dados
    $sql = "SELECT * FROM setores WHERE id = '$id_setor'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Exibe o formulário de edição do setor
        $row = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <title>Editar Setor</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
        </head>
        <body>
            <h2>Editar Setor</h2>
            <form action="atualizar_setor.php" method="post">
                <input type="hidden" name="id_setor" value="<?php echo $row["id"]; ?>">
                <input type="text" name="nome_setor" value="<?php echo $row["nome"]; ?>" required>
                <label for="gin">Grau de criticidade do setor para o negócio:</label>
                <select id="gin" name="gin" required>
                    <option value="1" <?php if ($row["GIN"] == 1) echo "selected"; ?>>1</option>
                    <option value="2" <?php if ($row["GIN"] == 2) echo "selected"; ?>>2</option>
                    <option value="3" <?php if ($row["GIN"] == 3) echo "selected"; ?>>3</option>
                </select>
                <label for="gci">Grau de criticidade da informação dos setores:</label>
                <select id="gci" name="gci" required>
                    <option value="1" <?php if ($row["GCI"] == 1) echo "selected"; ?>>1</option>
                    <option value="2" <?php if ($row["GCI"] == 2) echo "selected"; ?>>2</option>
                    <option value="3" <?php if ($row["GCI"] == 3) echo "selected"; ?>>3</option>
                </select>
                <button type="submit">Atualizar</button>
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "Setor não encontrado.";
    }

    $conn->close();
} else {
    echo "ID do setor não especificado.";
}
?>
