<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    require_once("../models/db_connection.php");

    $conn = conectar();

    $id_setor = $_GET["id"];

    // Verifica se o setor existe no banco de dados
    $sql = "SELECT * FROM setores WHERE id = '$id_setor'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Exclui o setor do banco de dados
        $sql = "DELETE FROM setores WHERE id = '$id_setor'";

        if ($conn->query($sql) === TRUE) {
            echo "Setor excluído com sucesso.";
        } else {
            echo "Erro ao excluir o setor: " . $conn->error;
        }
    } else {
        echo "Setor não encontrado.";
    }

    $conn->close();
} else {
    echo "ID do setor não especificado.";
}
?>
