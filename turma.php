<?php
include 'db.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

$turma = $_GET['turma'];

// Obtenção da lista de alunos da turma
$stmt = $pdo->prepare('SELECT * FROM alunos WHERE turma = ?');
$stmt->execute([$turma]);
$alunos = $stmt->fetchAll();
?>

<h1>Alunos da Turma <?= htmlspecialchars($turma) ?></h1>

<table border="1">
    <tr>
        <th>Nome</th>
        <th>Idade</th>
        <th>Notas</th>
        <th>Observações</th>
        <th>Foto</th>
        <th>Ações</th>
    </tr>
    <?php foreach ($alunos as $aluno): ?>
    <tr>
        <td><?= htmlspecialchars($aluno['nome']) ?></td>
        <td><?= $aluno['idade'] ?></td>
        <td><?= htmlspecialchars($aluno['notas']) ?></td>
        <td><?= htmlspecialchars($aluno['observacoes']) ?></td>
        <td>
            <?php if ($aluno['foto']): ?>
                <img src="uploads/<?= htmlspecialchars($aluno['foto']) ?>" alt="<?= htmlspecialchars($aluno['nome']) ?>" width="50">
            <?php else: ?>
                Sem foto
            <?php endif; ?>
        </td>
        <td>
            <a href="editar_aluno.php?id=<?= $aluno['id'] ?>">Editar</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<a href="alunos.php">Voltar para Turmas</a>
<a href="logout.php">Logout</a>
