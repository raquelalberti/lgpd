<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
    <form class="login" action="controllers/autenticar.php" method="post">
        <h2>Login</h2>

        <?php
        if (isset($_SESSION['erro_login'])) {
            echo '<div class="alert">' . $_SESSION['erro_login'] . '</div>';
            unset($_SESSION['erro_login']); // Limpa a mensagem de erro da sessão
        }
        ?>

        <div class="box-user">
            <input type="text" name="nome" required>
            <label>Usuário</label>
        </div>

        <div class="box-user">
            <input type="password" name="senha" required>
            <label>Senha</label>
        </div>
        <?php
if (isset($_SESSION['erro_login'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['erro_login'] . '</div>';
    unset($_SESSION['erro_login']); // Limpa a mensagem de erro da sessão
}
?>
        <button type="submit" class="btn">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            Entrar
        </button>

        <div class="text-center">
            <a class="new-account" href="views/cadastro.php">
                <br> Cadastre-se aqui
            </a>
        </div>
    </form>
</body>
</html>
