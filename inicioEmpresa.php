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

// Buscar dados da empresa logada
$queryEmpresa = mysqli_query($conn, "SELECT * FROM Empresa WHERE idEmpresa = '$idEmpresa'");
$dadosEmpresa = mysqli_fetch_assoc($queryEmpresa);

// Buscar apenas as vagas da empresa logada
$sqlVagas = "SELECT * FROM vaga WHERE idEmpresa = '$idEmpresa' ORDER BY idVaga DESC";
$resultadoVagas = mysqli_query($conn, $sqlVagas);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel da Empresa - Minhas Vagas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f4f7fc; margin: 0; padding: 0; }
        .sidebar { background-color: #ffffff; border-right: 1px solid #e2e8f0; min-height: 100vh; padding-top: 20px; }
        .sidebar .nav-link { color: #4a5568; font-weight: 500; padding: 12px 20px; border-radius: 10px; margin-bottom: 5px; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .sidebar .nav-link.active, .sidebar .nav-link:hover { background-color: #e2eefd; color: #0d6efd; font-weight: 600; }
        .card-profile { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px; margin-bottom: 30px; }
        .vaga-card { transition: transform 0.2s; border-radius: 12px; }
        .vaga-card:hover { transform: translateY(-4px); }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <div class="col-md-2 sidebar">
            <nav class="nav flex-column px-2">
                <a class="nav-link active" href="inicioEmpresa.php"><i class="bi bi-house"></i> Início</a>
                <a class="nav-link" href="perfilEmpresa.php"><i class="bi bi-building"></i> Meu Perfil</a>
                <a class="nav-link" href="formCadastrarVaga.php"><i class="bi bi-plus-circle"></i> Criar Vaga</a>
                <a class="nav-link text-danger mt-4" href="logout.php"><i class="bi bi-box-arrow-right"></i> Sair</a>
            </nav>
        </div>

        <div class="col-md-10 p-4">

            <div class="card-profile d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <img src="assets/img/img_avatar1.png" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid #0d6efd;">
                    <div>
                        <h4 class="fw-bold mb-0"><?= htmlspecialchars($dadosEmpresa['nomeEmpresa'] ?? 'Painel da Empresa') ?></h4>
                        <small class="text-muted">Recrutador • Gestão de Vagas</small>
                    </div>
                </div>
                <a href="formCadastrarVaga.php" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Criar Nova Vaga
                </a>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0">Minhas Vagas Publicadas</h3>
            </div>

            <div class="row">
                <?php if ($resultadoVagas && mysqli_num_rows($resultadoVagas) > 0): ?>
                    <?php while ($vaga = mysqli_fetch_assoc($resultadoVagas)): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm border-0 vaga-card">
                                <div class="card-body d-flex flex-column p-4">
                                    
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge bg-success-subtle text-success">
                                            <?= htmlspecialchars($vaga['statusVaga'] ?? 'Ativa') ?>
                                        </span>
                                        <small class="text-muted"><?= date('d/m/Y', strtotime($vaga['dataCriacao'])) ?></small>
                                    </div>

                                    <h5 class="card-title fw-bold text-dark mt-2 mb-3"><?= htmlspecialchars($vaga['tituloVaga']) ?></h5>

                                    <div class="small text-muted mb-3">
                                        <?php if (!empty($vaga['cidadeVaga'])): ?>
                                            <div class="mb-1"><i class="bi bi-geo-alt me-1"></i> <?= htmlspecialchars($vaga['cidadeVaga']) ?><?= !empty($vaga['estadoVaga']) ? ' - ' . htmlspecialchars($vaga['estadoVaga']) : '' ?></div>
                                        <?php endif; ?>
                                        <?php if (!empty($vaga['modalidadeVaga'])): ?>
                                            <div class="mb-1"><i class="bi bi-laptop me-1"></i> <?= htmlspecialchars($vaga['modalidadeVaga']) ?></div>
                                        <?php endif; ?>
                                        <?php if (!empty($vaga['salarioVaga'])): ?>
                                            <div class="mb-1"><i class="bi bi-cash-stack me-1"></i> R$ <?= htmlspecialchars($vaga['salarioVaga']) ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <p class="card-text text-secondary flex-grow-1 small">
                                        <?= htmlspecialchars(substr($vaga['descricaoVaga'], 0, 90)) ?>...
                                    </p>

                                    <!-- Botões de Ação da Empresa -->
                                    <div class="border-top pt-3 mt-2 d-flex justify-content-between align-items-center">
                                        <a href="formEditarVaga.php?id=<?= $vaga['idVaga'] ?>" class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil"></i> Editar
                                        </a>
                                        <a href="excluirVaga.php?id=<?= $vaga['idVaga'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir esta vaga?');">
                                            <i class="bi bi-trash"></i> Excluir
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <p class="text-muted fs-5">Nenhuma vaga cadastrada por você no momento.</p>
                        <a href="formCadastrarVaga.php" class="btn btn-primary">Cadastrar Primeira Vaga</a>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include "footer.php"; ?>
</body>
</html>