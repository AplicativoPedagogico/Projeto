<?php
include 'db.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

// Lógica de Cadastro de Aluno
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $turma = $_POST['turma'];
    $notas = $_POST['notas'];
    $observacoes = $_POST['observacoes'];
    $foto = null;

    // Verifica se o arquivo foi enviado
    if (!empty($_FILES['foto']['name'])) {
        $target_dir = "uploads/";
        $foto = basename($_FILES["foto"]["name"]);
        $target_file = $target_dir . $foto;

        // Verifica o tamanho do arquivo (máx 5MB)
        if ($_FILES["foto"]["size"] > 5000000) {
            die("Arquivo muito grande. Máximo 5MB.");
        }

        // Move o arquivo para o diretório de uploads
        if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            die("Erro ao enviar a foto.");
        }
    }

    // Insere os dados no banco de dados
    $stmt = $pdo->prepare('INSERT INTO alunos (nome, idade, turma, foto, notas, observacoes) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$nome, $idade, $turma, $foto, $notas, $observacoes]);

    header('Location: alunos.php');
}

// Obtenção da lista de turmas
$stmt = $pdo->query('SELECT DISTINCT turma FROM alunos');
$turmas = $stmt->fetchAll();
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/alunos.css">
    <title>Alunos</title>
</head>
<body>

        
    <h1>Bem-vindo, <?= $_SESSION['usuario_nome'] ?>!</h1>

    <div class="turmas">
        <h2>Turmas Disponíveis</h2>

        <ul>
            <?php foreach ($turmas as $turma): ?>
                <li><a href="turma.php?turma=<?= urlencode($turma['turma']) ?>"><?= $turma['turma'] ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    

    <form action="alunos.php" method="POST" enctype="multipart/form-data">
        <h2 id="txt-cadastrar">Cadastrar Aluno</h2>
        Nome: <input type="text" name="nome" required><br>
        Idade: <input type="number" name="idade" required><br>
        Turma: <input type="text" name="turma" required><br>
        Foto: <input type="file" name="foto"><br>
        Notas: <input type="text" name="notas" placeholder="Digite as notas do aluno"><br>
        Observações: <textarea name="observacoes" placeholder="Digite observações sobre o aluno"></textarea><br>

        <button type="submit">Cadastrar</button>

        <a href="logout.php">Logout</a>
    </form>





    
</body>
</html>