<?php
session_start();
session_destroy(); // Deleta todas as sessões

// Redireciona para a página do location
header("Location: ../index.php"); 
exit();
