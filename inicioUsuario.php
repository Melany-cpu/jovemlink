<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário/candidato está logado (Ajuste a chave 'idUsuario' se usar outro nome na sessão)
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: formLoginUsuario.php");
    exit();
}

include "conexaoBD.php";

// Busca todas as vagas disponíveis trazendo também o nome da Empresa
$sqlVagas = "SELECT vaga.*, Empresa.nomeEmpresa 
             FROM vaga 
             INNER JOIN Empresa ON vaga.idEmpresa = Empresa.idEmpresa 
             WHERE vaga.statusVaga = 'Ativa'
             ORDER BY vaga.idVaga DESC";

$resultadoVagas = mysqli_query($conn, $sqlVagas);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vagas Disponíveis - JovemLink</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7fc; }
        .vaga-card { transition: transform 0.2s; border-radius: 12px; }
        .vaga-card:hover { transform: translateY(-4px); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">JovemLink</a>
    <div class="d-flex align-items-center">
        <span class="text-white me-3">Olá, <?= htmlspecialchars($_SESSION['nomeUsuario'] ?? 'Candidato') ?></span>
        <a href="logout.php" class="btn btn-outline-light btn-sm">Sair</a>
    </div>
  </div>
</nav>

<div class="container mb-5">
    <div class="mb-4">
        <h2 class="fw-bold">Oportunidades em Aberto</h2>
        <p class="text-muted">Encontre a vaga ideal e envie seu currículo com um clique.</p>
    </div>

    <div class="row">
        <?php if ($resultadoVagas && mysqli_num_rows($resultadoVagas) > 0): ?>
            <?php while ($vaga = mysqli_fetch_assoc($resultadoVagas)): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 vaga-card">
                        <div class="card-body d-flex flex-column p-4">
                            
                            <span class="badge bg-light text-primary border mb-2 align-self-start">
                                <i class="bi bi-building"></i> <?= htmlspecialchars($vaga['nomeEmpresa']) ?>
                            </span>

                            <h5 class="card-title fw-bold text-dark mt-1"><?= htmlspecialchars($vaga['tituloVaga']) ?></h5>

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
                                <?= htmlspecialchars(substr($vaga['descricaoVaga'], 0, 110)) ?>...
                            </p>

                            <div class="border-top pt-3 mt-2 d-flex justify-content-between align-items-center">
                                <small class="text-muted"><i class="bi bi-calendar3"></i> <?= date('d/m/Y', strtotime($vaga['dataCriacao'])) ?></small>
                                <a href="candidatarVaga.php?id=<?= $vaga['idVaga'] ?>" class="btn btn-sm btn-primary">Candidatar-se</a>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted fs-5">Nenhuma vaga aberta no momento. Volte em breve!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>