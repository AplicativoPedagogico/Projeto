<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <title>Login do Professor</title>
</head>
<body>

<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ? AND tipo = "professor"');
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        header('Location: alunos.php');
    } else {
        echo  "<script>alert('Email ou senha inválidos!');</script>";
    }
}
?>


<div class="container">

   <div id="images">
        <img src="logo_ceaat_cut.png" alt="logo_ceaat" id="img_logo">
        <h3>COLÉGIO ESTADUAL DE APLICAÇÃO ANÍSIO TEIXEIRA</h3>
   </div>

    <h1>Sistema de Acompanhamento Pedagógico</h1>


    <form action="index.php" method="POST">
        
        Email: <input type="email" name="email" required>
        Senha: <input type="password" name="senha" id="senha" required>

        <div>
            <button type="submit" id="button">Entrar</button>

            <br>

            <a href="cadastro_professor.php">Cadastrar Professor</a>
        </div>
    
    </form>

</div>




</body>
</html>