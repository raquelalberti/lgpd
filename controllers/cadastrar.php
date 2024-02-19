<?php
session_start();
require_once("../models/db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = conectar();
    
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha']; 

    // Verifica se o email já existe no banco de dados
    $stmt_verificar = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt_verificar->bind_param("s", $email);
    $stmt_verificar->execute();
    $result_verificar = $stmt_verificar->get_result();

    if ($result_verificar->num_rows > 0) {
        $_SESSION['erro_cadastro'] = "O email $email já está cadastrado. Por favor, use outro email.";
        header("Location: ../views/cadastro.php");
        exit;
    } else {
        $tipo = ($nome === "administrador") ? "administrador" : "padrao";
        $senha_hashed = password_hash($senha, PASSWORD_DEFAULT); // Hash da senha para segurança

        $stmt_inserir = $conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)");
        $stmt_inserir->bind_param("ssss", $nome, $email, $senha_hashed, $tipo);
        
        if ($stmt_inserir->execute()) {
            $_SESSION['sucesso_cadastro'] = "Cadastro realizado com sucesso!";
            header("Location: ../views/cadastro.php");
            exit;
        } else {
            $_SESSION['erro_cadastro'] = "Erro ao cadastrar usuário: " . $stmt_inserir->error;
            header("Location: ../views/cadastro.php");
            exit;
        }
    }

    $stmt_verificar->close();
    $stmt_inserir->close();
    $conn->close();
} else {
    echo "O formulário não foi enviado.";
}
