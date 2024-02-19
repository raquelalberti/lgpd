<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../models/db_connection.php");

    $conn = conectar();

    $nome_setor = mysqli_real_escape_string($conn, $_POST["nome"]);
    $gin = mysqli_real_escape_string($conn, $_POST["gin"]); // Grau de criticidade do setor para o negócio
    $gci = mysqli_real_escape_string($conn, $_POST["gci"]); // Grau de criticidade da informação dos setores

    // Verifica se o setor já existe no banco de dados
    $sql_check = "SELECT id FROM setores WHERE nome = '$nome_setor'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        echo "OPS! O setor '$nome_setor' já está cadastrado.";
    } else {
        // Insere o novo setor no banco de dados
        $sql_insert = "INSERT INTO setores (nome, GIN, GCI) VALUES ('$nome_setor', '$gin', '$gci')";
        if ($conn->query($sql_insert) === TRUE) {
            echo "Setor '$nome_setor' cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar o setor: " . $conn->error;
        }
    }

    $conn->close();
} else {
    echo "O formulário não foi enviado.";
}
?>
