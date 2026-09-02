<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || !isset($_SESSION['idEmpresa'])) {
    header("Location: formLoginEmpresa.php");
    exit();
}

include "conexaoBD.php";

$idEmpresa = $_SESSION['idEmpresa'];
$idVaga = $_GET['id'] ?? 0;
$mensagemStatus = "";

// Carregar dados da vaga existente
$sqlVaga = "SELECT * FROM vaga WHERE idVaga = '$idVaga' AND idEmpresa = '$idEmpresa'";
$resVaga = mysqli_query($conn, $sqlVaga);
$vaga = mysqli_fetch_assoc($resVaga);

if (!$vaga) {
    header("Location: inicioEmpresa.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $tituloVaga     = mysqli_real_escape_string($conn, trim($_POST['tituloVaga'] ?? ''));
    $descricaoVaga  = mysqli_real_escape_string($conn, trim($_POST['descricaoVaga'] ?? ''));
    $requisitosVaga = mysqli_real_escape_string($conn, trim($_POST['requisitosVaga'] ?? ''));
    $modalidadeVaga = mysqli_real_escape_string($conn, trim($_POST['modalidadeVaga'] ?? ''));
    $salarioVaga    = mysqli_real_escape_string($conn, trim($_POST['salarioVaga'] ?? ''));
    $cidadeVaga     = mysqli_real_escape_string($conn, trim($_POST['cidadeVaga'] ?? ''));
    $estadoVaga     = mysqli_real_escape_string($conn, trim($_POST['estadoVaga'] ?? ''));

    if (!empty($tituloVaga) && !empty($descricaoVaga)) {
        $sql = "UPDATE vaga SET 
                    tituloVaga = '$tituloVaga',
                    descricaoVaga = '$descricaoVaga',
                    requisitosVaga = '$requisitosVaga',
                    modalidadeVaga = '$modalidadeVaga',
                    salarioVaga = '$salarioVaga',
                    cidadeVaga = '$cidadeVaga',
                    estadoVaga = '$estadoVaga'
                WHERE idVaga = '$idVaga' AND idEmpresa = '$idEmpresa'";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Vaga atualizada com sucesso!'); window.location.href = 'inicioEmpresa.php';</script>";
            exit();
        } else {
            $mensagemStatus = "<div class='alert alert-danger text-center'>Erro ao atualizar: " . mysqli_error($conn) . "</div>";
        }
    } else {
        $mensagemStatus = "<div class='alert alert-warning text-center'>Preencha todos os campos obrigatórios.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Vaga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?= $mensagemStatus ?>
            <div class="card shadow-sm p-4">
                <h3 class="fw-bold mb-3 text-center">Editar Vaga</h3>
                <form action="formEditarVaga.php?id=<?= $idVaga ?>" method="POST">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Título da Vaga *</label>
                        <input type="text" class="form-control" name="tituloVaga" value="<?= htmlspecialchars($vaga['tituloVaga']) ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Modalidade</label>
                            <select class="form-select" name="modalidadeVaga">
                                <option value="Presencial" <?= $vaga['modalidadeVaga'] == 'Presencial' ? 'selected' : '' ?>>Presencial</option>
                                <option value="Híbrido" <?= $vaga['modalidadeVaga'] == 'Híbrido' ? 'selected' : '' ?>>Híbrido</option>
                                <option value="Remoto" <?= $vaga['modalidadeVaga'] == 'Remoto' ? 'selected' : '' ?>>Remoto</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Salário (R$)</label>
                            <input type="text" class="form-control" name="salarioVaga" value="<?= htmlspecialchars($vaga['salarioVaga']) ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-bold">Cidade</label>
                            <input type="text" class="form-control" name="cidadeVaga" value="<?= htmlspecialchars($vaga['cidadeVaga']) ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Estado (UF)</label>
                            <input type="text" class="form-control" name="estadoVaga" value="<?= htmlspecialchars($vaga['estadoVaga']) ?>" maxlength="2">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Descrição da Vaga *</label>
                        <textarea class="form-control" name="descricaoVaga" rows="4" required><?= htmlspecialchars($vaga['descricaoVaga']) ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Requisitos da Vaga</label>
                        <textarea class="form-control" name="requisitosVaga" rows="3"><?= htmlspecialchars($vaga['requisitosVaga']) ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="inicioEmpresa.php" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>