<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Hasheando a senha

    // Insere o professor no banco de dados
    $stmt = $pdo->prepare('INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, "professor")');
    if ($stmt->execute([$nome, $email, $senha])) {
        header('Location: index.php'); // Redireciona para a página de login após o cadastro
    } else {
        echo "Erro ao cadastrar professor!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cadastro_professor.css">
    <title>Document</title>
</head>
<body>

    
    <form action="cadastro_professor.php" method="POST">

        <h1>Cadastrar Professor</h1>

        Nome: <input type="text" name="nome" required><br>
        Email: <input type="email" name="email" required><br>
        Senha: <input type="password" name="senha" placeholder="Minimo de 8 caracteres" required><br>

        <button type="submit">Cadastrar</button>

        <br>

        <a href="index.php">Voltar para Login</a>
    </form>




















    
</body>
</html>