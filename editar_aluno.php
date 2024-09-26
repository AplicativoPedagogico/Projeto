<?php
include 'db.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

$id = $_GET['id'];

// Obtém as informações do aluno
$stmt = $pdo->prepare('SELECT * FROM alunos WHERE id = ?');
$stmt->execute([$id]);
$aluno = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $turma = $_POST['turma'];
    $notas = $_POST['notas'];
    $observacoes = $_POST['observacoes'];
    $foto = $aluno['foto'];

    // Verifica se há uma nova foto
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

    // Atualiza as informações do aluno
    $stmt = $pdo->prepare('UPDATE alunos SET nome = ?, idade = ?, turma = ?, foto = ?, notas = ?, observacoes = ? WHERE id = ?');
    $stmt->execute([$nome, $idade, $turma, $foto, $notas, $observacoes, $id]);

    header('Location: turma.php?turma=' . urlencode($turma));
}
?>

<h1>Editar Aluno</h1>

<form action="editar_aluno.php?id=<?= $aluno['id'] ?>" method="POST" enctype="multipart/form-data">
    Nome: <input type="text" name="nome" value="<?= htmlspecialchars($aluno['nome']) ?>" required><br>
    Idade: <input type="number" name="idade" value="<?= $aluno['idade'] ?>" required><br>
    Turma: <input type="text" name="turma" value="<?= htmlspecialchars($aluno['turma']) ?>" required><br>
    Foto: <input type="file" name="foto"><br>
    Notas: <input type="text" name="notas" value="<?= htmlspecialchars($aluno['notas']) ?>"><br>
    Observações: <textarea name="observacoes"><?= htmlspecialchars($aluno['observacoes']) ?></textarea><br>
    <button type="submit">Salvar</button>
</form>

<a href="turma.php?turma=<?= urlencode($aluno['turma']) ?>">Voltar</a>
