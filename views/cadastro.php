<?php
session_start();
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Cadastro de Usuários</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
</head>

<body>
    <form class="login" action="../controllers/cadastrar.php" method="POST">
        <h2>Cadastro de Usuários</h2>

        <?php if (isset($_SESSION['erro_cadastro'])) : ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['erro_cadastro']; ?>
                <?php unset($_SESSION['erro_cadastro']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['sucesso_cadastro'])) : ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['sucesso_cadastro']; ?>
                <?php unset($_SESSION['sucesso_cadastro']); ?>
            </div>
        <?php endif; ?>

        <div class="box-user">
            <input type="text" name="nome" required>
            <label>Nome</label>
        </div>
        <div class="box-user">
            <input type="email" name="email" required>
            <label>Email</label>
        </div>
        <div class="box-user">
            <input type="password" name="senha" required>
            <label>Senha</label>
        </div>
        <div class="container-login100-form-btn m-t-32">
            <button type="submit" class="btn">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                Cadastrar
            </button>
        </div>

        <div class="text-center p-t-20">
            <a class="new-account" href="../index.php">
                <br>Já possui uma conta? Faça login aqui
            </a>
        </div>
    </form>
</body>

</html>