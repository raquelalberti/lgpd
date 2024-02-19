<?php
session_start();
require_once("../models/db_connection.php");
$conn = conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Protection contra SQL injection
    $nome = $conn->real_escape_string($_POST['nome']);
    $senha = $_POST['senha']; 

    // Prepara a consulta SQL para buscar o usuário pelo nome
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nome = ?");
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Usuário encontrado, verifica a senha
        $usuario = $result->fetch_assoc();
        
        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['nome_usuario'] = $usuario['nome'];
            $_SESSION['usuario_id'] = $usuario['id']; 

            // Direciona para a página correspondente ao tipo do usuário
            if ($usuario['tipo'] == 'administrador') {
                header("Location: ../views/acesso_adm.php");
                exit;
            } else {
                header("Location: ../views/acesso_padrao.php");
                exit;
            }
        } else {
            // Senha incorreta, mensagem de erro na sessão
            $_SESSION['erro_login'] = "Nome de usuário ou senha incorreta.";
            header("Location: ../index.php");
            exit;
        }
    } else {
        // Usuário não encontrado, mensagem de erro na sessão
        $_SESSION['erro_login'] = "Nome de usuário ou senha incorreta.";
        header("Location: ../index.php");
        exit;
    }

    $stmt->close();
} else {
    echo "O formulário não foi enviado.";
}

$conn->close();
