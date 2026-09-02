<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: formLogin.php");
    exit();
}

include "conexaoBD.php";

$idSessao = intval($_SESSION['idCandidato'] ?? $_SESSION['idUsuario'] ?? 0);
$emailSessao = mysqli_real_escape_string($conn, $_SESSION['emailUsuario'] ?? '');

// Busca os dados das tabelas sem forçar colunas inexistentes na Query
$sqlBuscaDados = "SELECT c.*, 
                         u.fotoUsuario AS fotoUser, 
                         u.nomeUsuario AS nomeUser,
                         u.cidadeUsuario AS cidadeUser
                  FROM candidato c 
                  LEFT JOIN usuarios u ON c.idCandidato = u.idUsuario OR c.emailUsuario = u.emailUsuario
                  WHERE c.idCandidato = '$idSessao' OR c.emailUsuario = '$emailSessao' OR u.idUsuario = '$idSessao' 
                  LIMIT 1";

$resBusca = mysqli_query($conn, $sqlBuscaDados);
$dadosUsuario = [];
$idCandidatoValido = null;

if ($resBusca && mysqli_num_rows($resBusca) > 0) {
    $dadosUsuario = mysqli_fetch_assoc($resBusca);
    $idCandidatoValido = $dadosUsuario['idCandidato'] ?? $dadosUsuario['idUsuario'];
} else {
    // Se não encontrou na tabela candidato, busca na tabela usuarios
    $sqlUser = mysqli_query($conn, "SELECT * FROM usuarios WHERE idUsuario = '$idSessao' OR emailUsuario = '$emailSessao' LIMIT 1");
    if ($sqlUser && mysqli_num_rows($sqlUser) > 0) {
        $user = mysqli_fetch_assoc($sqlUser);
        $dadosUsuario = $user;
        $idCandidatoValido = $user['idUsuario'];

        // Cria a linha na tabela candidato automaticamente para evitar falhas de FK
        $nome  = mysqli_real_escape_string($conn, $user['nomeUsuario'] ?? '');
        $email = mysqli_real_escape_string($conn, $user['emailUsuario'] ?? '');
        $senha = mysqli_real_escape_string($conn, $user['senhaUsuario'] ?? '');
        
        $insere = "INSERT INTO candidato (idCandidato, nomeUsuario, emailUsuario, senhaUsuario) 
                   VALUES ('$idCandidatoValido', '$nome', '$email', '$senha')";
        mysqli_query($conn, $insere);
    }
}

// Garante o ID na sessão
if ($idCandidatoValido) {
    $_SESSION['idCandidato'] = $idCandidatoValido;
}

// === TRATAMENTO E LOCALIZAÇÃO DA FOTO (FEITO VIA PHP SAFE) ===
$fotoBD = trim(
    $dadosUsuario['fotoUsuario'] ?? 
    $dadosUsuario['fotoUser'] ?? 
    $_SESSION['fotoUsuario'] ?? 
    ''
);

$fotoCandidato = '';

if (!empty($fotoBD)) {
    $nomeArquivo = basename($fotoBD);

    if (file_exists(__DIR__ . '/uploads/' . $nomeArquivo)) {
        $fotoCandidato = 'uploads/' . $nomeArquivo;
    } elseif (file_exists(__DIR__ . '/' . $fotoBD)) {
        $fotoCandidato = $fotoBD;
    } elseif (file_exists(__DIR__ . '/uploads/' . $fotoBD)) {
        $fotoCandidato = 'uploads/' . $fotoBD;
    }
}

if (empty($fotoCandidato) && file_exists(__DIR__ . '/assets/img/img_avatar1.png')) {
    $fotoCandidato = 'assets/img/img_avatar1.png';
}

// Nome e iniciais do candidato
$nomeCandidato = $dadosUsuario['nomeUsuario'] ?? $dadosUsuario['nomeUser'] ?? $_SESSION['nomeUsuario'] ?? 'Candidato';
$cidadeCandidato = $dadosUsuario['cidadeUsuario'] ?? $dadosUsuario['cidadeUser'] ?? 'Não informada';
$partesNome = explode(' ', trim($nomeCandidato));
$iniciais = strtoupper(substr($partesNome[0], 0, 1) . (isset($partesNome[1]) ? substr($partesNome[1], 0, 1) : ''));

// === PROCESSAMENTO DA CANDIDATURA ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idVaga']) && isset($_FILES['curriculo'])) {
    
    if (!$idCandidatoValido) {
        $_SESSION['msg_erro'] = "Erro: Candidato não identificado. Faça login novamente.";
        header("Location: listarVagas.php");
        exit();
    }

    $idVaga = intval($_POST['idVaga']);

    $verificaDuplicado = mysqli_query($conn, "SELECT idCandidatura FROM candidatura WHERE idCandidato = '$idCandidatoValido' AND idVaga = '$idVaga'");
    
    if ($verificaDuplicado && mysqli_num_rows($verificaDuplicado) > 0) {
        $_SESSION['msg_erro'] = "Você já se candidatou para esta vaga!";
    } else {
        $arquivo = $_FILES['curriculo'];
        $extensoesValidas = ['pdf', 'doc', 'docx'];
        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));

        if (in_array($extensao, $extensoesValidas)) {
            if (!is_dir('uploads')) {
                mkdir('uploads', 0777, true);
            }

            $nomeCurriculo = "curriculo_" . $idCandidatoValido . "_" . time() . "." . $extensao;
            $pastaDestino = "uploads/" . $nomeCurriculo;

            if (move_uploaded_file($arquivo['tmp_name'], $pastaDestino)) {
                $sql = "INSERT INTO candidatura (idCandidato, idVaga, dataCandidatura, statusCandidatura) 
                        VALUES ('$idCandidatoValido', '$idVaga', NOW(), 'Pendente')";
                
                if (mysqli_query($conn, $sql)) {
                    $_SESSION['msg_sucesso'] = "Candidatura enviada com sucesso!";
                } else {
                    $_SESSION['msg_erro'] = "Erro no banco de dados: " . mysqli_error($conn);
                }
            } else {
                $_SESSION['msg_erro'] = "Erro ao salvar o arquivo do currículo.";
            }
        } else {
            $_SESSION['msg_erro'] = "Formato de arquivo inválido. Apenas PDF, DOC ou DOCX.";
        }
    }
    header("Location: listarVagas.php");
    exit();
}

// Buscar vagas ativas
$sqlVagas = "SELECT vaga.*, Empresa.nomeEmpresa 
             FROM vaga 
             INNER JOIN Empresa ON vaga.idEmpresa = Empresa.idEmpresa 
             WHERE vaga.statusVaga = 'Ativa'
             ORDER BY vaga.idVaga DESC";
$resultadoVagas = mysqli_query($conn, $sqlVagas);

// Buscar candidaturas efetuadas
$sqlMinhasCandidaturas = "SELECT c.*, v.tituloVaga, v.cidadeVaga, v.estadoVaga, e.nomeEmpresa 
                          FROM candidatura c
                          INNER JOIN vaga v ON c.idVaga = v.idVaga
                          INNER JOIN Empresa e ON v.idEmpresa = e.idEmpresa
                          WHERE c.idCandidato = '$idCandidatoValido'
                          ORDER BY c.dataCandidatura DESC";
$resMinhasCandidaturas = mysqli_query($conn, $sqlMinhasCandidaturas);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vagas Disponíveis - Candidato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f4f7fc; margin: 0; padding: 0; }
        .sidebar { background-color: #ffffff; border-right: 1px solid #e2e8f0; min-height: 100vh; padding-top: 20px; }
        .sidebar .nav-link { color: #4a5568; font-weight: 500; padding: 12px 20px; border-radius: 10px; margin-bottom: 5px; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .sidebar .nav-link.active, .sidebar .nav-link:hover { background-color: #e2eefd; color: #0d6efd; font-weight: 600; }
        
        .card-profile {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            padding: 24px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }
        .profile-img-container {
            width: 80px;
            height: 80px;
            min-width: 80px;
            position: relative;
            border-radius: 50%;
            overflow: hidden;
        }
        .profile-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .vaga-card { transition: transform 0.2s; border-radius: 12px; }
        .vaga-card:hover { transform: translateY(-4px); }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar">
            <nav class="nav flex-column px-2">
                <a class="nav-link active" href="listarVagas.php"><i class="bi bi-briefcase"></i> Oportunidades</a>
                <a class="nav-link" href="#minhas-candidaturas"><i class="bi bi-file-earmark-check"></i> Minhas Candidaturas</a>
                <a class="nav-link" href="PerfilCandidato.php"><i class="bi bi-person"></i> Perfil</a>
                <a class="nav-link text-danger mt-4" href="logoutUsuario.php"><i class="bi bi-box-arrow-right"></i> Sair</a>
            </nav>
        </div>

        <!-- Conteúdo Principal -->
        <div class="col-md-10 p-4">

            <!-- Card de Perfil do Candidato -->
            <div class="card-profile d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="profile-img-container d-flex align-items-center justify-content-center bg-primary text-white fw-bold border border-3 border-primary shadow-sm" style="font-size: 26px;">
                        <?php if (!empty($fotoCandidato)): ?>
                            <img src="<?= htmlspecialchars($fotoCandidato) ?>" class="profile-img" alt="Foto do Candidato">
                        <?php else: ?>
                            <span class="user-select-none"><?= $iniciais ?: '<i class="bi bi-person fs-3"></i>' ?></span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1 text-dark"><?= htmlspecialchars($nomeCandidato) ?></h4>
                        <div class="d-flex align-items-center gap-2">
                            <small class="text-muted">
                                Candidato • <?= htmlspecialchars($cidadeCandidato) ?>
                            </small>
                        </div>
                    </div>
                </div>
                <div>
                    <a href="editarPerfil.php" class="btn btn-outline-primary rounded-pill px-4">
                        <i class="bi bi-pencil-square me-1"></i> Editar Perfil
                    </a>
                </div>
            </div>

            <!-- Alertas -->
            <?php if (isset($_SESSION['msg_sucesso'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i><?= $_SESSION['msg_sucesso'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['msg_sucesso']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['msg_erro'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $_SESSION['msg_erro'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['msg_erro']); ?>
            <?php endif; ?>

            <h1 class="text-center mb-4 fw-bold">Vagas Disponíveis</h1>

            <!-- Lista de Vagas -->
            <div class="row g-3 mb-5">
                <?php if ($resultadoVagas && mysqli_num_rows($resultadoVagas) > 0): ?>
                    <?php while ($vaga = mysqli_fetch_assoc($resultadoVagas)): ?>
                        <div class="col-md-3">
                            <div class="card h-100 shadow-sm border-0 vaga-card">
                                <div class="card-body d-flex flex-column justify-content-between p-3">
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge bg-light text-primary border">
                                                <i class="bi bi-building me-1"></i><?= htmlspecialchars($vaga['nomeEmpresa']) ?>
                                            </span>
                                            <small class="text-muted" style="font-size: 0.75rem;">
                                                <?= date('d/m/Y', strtotime($vaga['dataCriacao'])) ?>
                                            </small>
                                        </div>

                                        <h5 class="card-title fw-bold text-dark mb-2"><?= htmlspecialchars($vaga['tituloVaga']) ?></h5>

                                        <div class="small text-muted mb-3">
                                            <?php if (!empty($vaga['cidadeVaga'])): ?>
                                                <div class="mb-1"><i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($vaga['cidadeVaga']) ?></div>
                                            <?php endif; ?>
                                            <?php if (!empty($vaga['modalidadeVaga'])): ?>
                                                <div class="mb-1"><i class="bi bi-laptop me-1"></i><?= htmlspecialchars($vaga['modalidadeVaga']) ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <p class="card-text text-secondary small">
                                            <?= htmlspecialchars(substr($vaga['descricaoVaga'], 0, 85)) ?>...
                                        </p>
                                    </div>

                                    <div class="pt-3 border-top mt-2">
                                        <button type="button" 
                                                class="btn btn-primary w-100" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalCandidatura"
                                                data-idvaga="<?= $vaga['idVaga'] ?>"
                                                data-titulovaga="<?= htmlspecialchars($vaga['tituloVaga']) ?>">
                                            <i class="bi bi-send me-1"></i> Candidatar-se
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <p class="text-muted fs-5">Nenhuma vaga aberta no momento.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Minhas Candidaturas -->
            <hr class="my-5">
            <h2 id="minhas-candidaturas" class="fw-bold mb-4"><i class="bi bi-file-earmark-check me-2 text-primary"></i>Minhas Candidaturas</h2>

            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Vaga</th>
                                    <th>Empresa</th>
                                    <th>Local</th>
                                    <th>Data do Envio</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($resMinhasCandidaturas && mysqli_num_rows($resMinhasCandidaturas) > 0): ?>
                                    <?php while ($cand = mysqli_fetch_assoc($resMinhasCandidaturas)): ?>
                                        <tr>
                                            <td class="fw-semibold text-dark"><?= htmlspecialchars($cand['tituloVaga']) ?></td>
                                            <td><?= htmlspecialchars($cand['nomeEmpresa']) ?></td>
                                            <td><?= htmlspecialchars($cand['cidadeVaga'] . ' - ' . $cand['estadoVaga']) ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($cand['dataCandidatura'])) ?></td>
                                            <td>
                                                <?php 
                                                    $statusBadge = 'bg-warning text-dark';
                                                    if ($cand['statusCandidatura'] === 'Aprovado') $statusBadge = 'bg-success';
                                                    if ($cand['statusCandidatura'] === 'Recusado') $statusBadge = 'bg-danger';
                                                ?>
                                                <span class="badge <?= $statusBadge ?>"><?= htmlspecialchars($cand['statusCandidatura']) ?></span>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Você ainda não se candidatou a nenhuma vaga.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Candidatura -->
<div class="modal fade" id="modalCandidatura" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="listarVagas.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Candidatar-se à Vaga</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Você está se candidatando para: <strong id="modalTituloVaga" class="text-primary"></strong></p>
                    <input type="hidden" name="idVaga" id="modalIdVaga" value="">
                    
                    <div class="mb-3">
                        <label for="curriculo" class="form-label fw-semibold">Anexe seu Currículo (PDF, DOC ou DOCX)</label>
                        <input type="file" class="form-control" id="curriculo" name="curriculo" accept=".pdf,.doc,.docx" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-upload me-1"></i> Enviar Candidatura</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const modalCandidatura = document.getElementById('modalCandidatura');
    modalCandidatura.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        document.getElementById('modalIdVaga').value = button.getAttribute('data-idvaga');
        document.getElementById('modalTituloVaga').textContent = button.getAttribute('data-titulovaga');
    });
</script>

<?php include "footer.php"; ?>
</body>
</html>