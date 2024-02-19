<?php
require_once("../models/db_connection.php");

$conn = conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $id = $_POST["id_setor"];
    $nome = $_POST["nome_setor"];
    $gin = $_POST["gin"];
    $gci = $_POST["gci"];

    // Atualiza o setor no banco de dados
    $sql = "UPDATE setores SET nome='$nome', GIN='$gin', GCI='$gci' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Setor atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar o setor: " . $conn->error;
    }

    $conn->close();
} else {
    echo "O formulário não foi enviado.";
}
