<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "conexaoBD.php";

// Verificação de segurança da sessão
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    echo "<script>alert('Sessão expirada. Faça o login novamente.'); window.location.href = 'formLoginEmpresa.php';</script>";
    exit();
}

// Tenta obter o ID da Empresa da sessão
$idEmpresa = $_SESSION['idEmpresa'] ?? $_SESSION['id_empresa'] ?? $_SESSION['idEmpresaLogada'] ?? null;

if (!$idEmpresa) {
    die("<div style='padding:20px; color:red;'>Erro: ID da Empresa não encontrado na sessão. Verifique como o login grava a variável \$_SESSION['idEmpresa'].</div>");
}

$mensagemStatus = "";

// Processamento do formulário de criação de vaga
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tituloVaga'])) {
    $tituloVaga     = mysqli_real_escape_string($conn, trim($_POST['tituloVaga'] ?? ''));
    $descricaoVaga  = mysqli_real_escape_string($conn, trim($_POST['descricaoVaga'] ?? ''));
    $requisitosVaga = mysqli_real_escape_string($conn, trim($_POST['requisitosVaga'] ?? ''));
    $modalidadeVaga = mysqli_real_escape_string($conn, trim($_POST['modalidadeVaga'] ?? ''));
    $salarioVaga    = mysqli_real_escape_string($conn, trim($_POST['salarioVaga'] ?? ''));
    $cidadeVaga     = mysqli_real_escape_string($conn, trim($_POST['cidadeVaga'] ?? ''));
    $estadoVaga     = mysqli_real_escape_string($conn, trim($_POST['estadoVaga'] ?? ''));
    $statusVaga     = "Ativa";

    if (!empty($tituloVaga) && !empty($descricaoVaga)) {
        $sql = "INSERT INTO vaga (idEmpresa, tituloVaga, descricaoVaga, requisitosVaga, modalidadeVaga, salarioVaga, cidadeVaga, estadoVaga, statusVaga, dataCriacao) 
                VALUES ('$idEmpresa', '$tituloVaga', '$descricaoVaga', '$requisitosVaga', '$modalidadeVaga', '$salarioVaga', '$cidadeVaga', '$estadoVaga', '$statusVaga', NOW())";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Vaga cadastrada com sucesso!'); window.location.href = 'formCadastrarVaga.php';</script>";
            exit();
        } else {
            $mensagemStatus = "<div class='alert alert-danger text-center rounded-3'>Erro ao salvar vaga: " . mysqli_error($conn) . "</div>";
        }
    } else {
        $mensagemStatus = "<div class='alert alert-warning text-center rounded-3'>Preencha todos os campos obrigatórios.</div>";
    }
}

// 1. Busca os dados da Empresa no BD
$queryEmpresa = mysqli_query($conn, "SELECT * FROM empresa WHERE idEmpresa = '$idEmpresa'");
if (!$queryEmpresa || mysqli_num_rows($queryEmpresa) == 0) {
    $queryEmpresa = mysqli_query($conn, "SELECT * FROM Empresa WHERE idEmpresa = '$idEmpresa'");
}
$dadosEmpresa = ($queryEmpresa && mysqli_num_rows($queryEmpresa) > 0) ? mysqli_fetch_assoc($queryEmpresa) : [];

// 2. TRATAMENTO DA FOTO (Coluna: fotoEmpresa)
$nomeFotoBD = trim($dadosEmpresa['fotoEmpresa'] ?? '');
$caminhoFotoFinal = '';

if (!empty($nomeFotoBD)) {
    // Caso o nome já venha com pasta (ex: uploads/foto.jpg ou img/foto.jpg)
    if (str_contains($nomeFotoBD, '/') || str_contains($nomeFotoBD, '\\')) {
        $caminhoFotoFinal = ltrim($nomeFotoBD, '/\\');
    } else {
        // Se no BD está apenas o nome do arquivo (ex: "empresa_123.jpg")
        // Testa se ele está dentro de uploads/ ou img/ ou na própria pasta raiz
        if (file_exists(__DIR__ . '/uploads/' . $nomeFotoBD)) {
            $caminhoFotoFinal = 'uploads/' . $nomeFotoBD;
        } elseif (file_exists(__DIR__ . '/img/' . $nomeFotoBD)) {
            $caminhoFotoFinal = 'img/' . $nomeFotoBD;
        } else {
            $caminhoFotoFinal = 'uploads/' . $nomeFotoBD; // Padrão
        }
    }
}

// 3. Busca as Candidaturas vinculadas às vagas da empresa
$sqlCandidaturas = "SELECT 
                        c.*, 
                        v.tituloVaga, 
                        COALESCE(cand.nomeUsuario, u.nomeUsuario, 'Candidato Sem Nome') AS nomeCandidato,
                        COALESCE(cand.emailUsuario, u.emailUsuario, 'Sem E-mail') AS emailCandidato
                    FROM vaga v
                    INNER JOIN candidatura c ON v.idVaga = c.idVaga
                    LEFT JOIN candidato cand ON c.idCandidato = cand.idCandidato
                    LEFT JOIN usuarios u ON c.idCandidato = u.idUsuario
                    WHERE v.idEmpresa = '$idEmpresa'
                    ORDER BY c.idCandidatura DESC";

$resCandidaturas = mysqli_query($conn, $sqlCandidaturas);
$erroSQL = mysqli_error($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel da Empresa - Vagas e Candidaturas</title>
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
        }
        .profile-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
        .card-form { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 30px; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar Lateral -->
        <div class="col-md-2 sidebar">
            <nav class="nav flex-column px-2">
                <a class="nav-link" href="inicioEmpresa.php"><i class="bi bi-house"></i> Início</a>
                <a class="nav-link" href="perfilEmpresa.php"><i class="bi bi-building"></i> Meu Perfil</a>
                <a class="nav-link active" href="formCadastrarVaga.php"><i class="bi bi-plus-circle"></i> Criar Vaga</a>
                <a class="nav-link" href="#secao-candidaturas"><i class="bi bi-people"></i> Candidaturas</a>
                <a class="nav-link text-danger mt-4" href="logout.php"><i class="bi bi-box-arrow-right"></i> Sair</a>
            </nav>
        </div>

        <!-- Conteúdo Principal -->
        <div class="col-md-10 p-4">

            <!-- Card de Perfil da Empresa -->
            <div class="card-profile d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="profile-img-container d-flex align-items-center justify-content-center bg-light rounded-circle border border-3 border-primary overflow-hidden shadow-sm">
                        
                        <?php if (!empty($caminhoFotoFinal)): ?>
                            <img src="<?= htmlspecialchars($caminhoFotoFinal) ?>" 
                                 class="profile-img" 
                                 alt="Foto da Empresa"
                                 onerror="console.error('Falha ao carregar a foto no caminho: ', this.src); this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            
                            <!-- Caso a imagem física não seja encontrada, mostra o ícone como reserva -->
                            <div class="w-100 h-100 align-items-center justify-content-center bg-secondary text-white" style="display: none;">
                                <i class="bi bi-building fs-3"></i>
                            </div>
                        <?php else: ?>
                            <!-- Mostra ícone padrão se não houver registro no campo fotoEmpresa -->
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-primary text-white">
                                <i class="bi bi-building fs-3"></i>
                            </div>
                        <?php endif; ?>

                    </div>
                    <div>
                        <h4 class="fw-bold mb-1 text-dark"><?= htmlspecialchars($dadosEmpresa['nomeEmpresa'] ?? $dadosEmpresa['nome'] ?? 'Minha Empresa') ?></h4>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 rounded-pill">
                                <i class="bi bi-building me-1"></i>Perfil Corporativo
                            </span>
                            <small class="text-muted"><i class="bi bi-envelope me-1"></i><?= htmlspecialchars($dadosEmpresa['emailEmpresa'] ?? $dadosEmpresa['email'] ?? 'Sem e-mail') ?></small>
                        </div>
                    </div>
                </div>
                <div>
                    <a href="perfilEmpresa.php" class="btn btn-outline-primary rounded-pill px-4">
                        <i class="bi bi-pencil-square me-1"></i> Editar Perfil
                    </a>
                </div>
            </div>

            <!-- Form de Cadastro de Vaga -->
            <div class="row justify-content-center mb-5">
                <div class="col-md-10">
                    
                    <?= $mensagemStatus ?>

                    <div class="card card-form shadow-sm">
                        <h3 class="fw-bold mb-3 text-center">Cadastrar Nova Oportunidade</h3>
                        <p class="text-muted text-center mb-4">Preencha as informações da vaga conforme os campos abaixo.</p>

                        <form action="formCadastrarVaga.php" method="POST">
                            
                            <div class="mb-3">
                                <label for="tituloVaga" class="form-label fw-bold">Título da Vaga *</label>
                                <input type="text" class="form-control" name="tituloVaga" id="tituloVaga" placeholder="Ex: Desenvolvedor Front-end" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="modalidadeVaga" class="form-label fw-bold">Modalidade</label>
                                    <select class="form-select" name="modalidadeVaga" id="modalidadeVaga">
                                        <option value="Presencial">Presencial</option>
                                        <option value="Híbrido">Híbrido</option>
                                        <option value="Remoto">Remoto</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="salarioVaga" class="form-label fw-bold">Salário (R$)</label>
                                    <input type="text" class="form-control" name="salarioVaga" id="salarioVaga" placeholder="Ex: 2500.00 ou A combinar">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="cidadeVaga" class="form-label fw-bold">Cidade</label>
                                    <input type="text" class="form-control" name="cidadeVaga" id="cidadeVaga" placeholder="Ex: São Paulo">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="estadoVaga" class="form-label fw-bold">Estado (UF)</label>
                                    <input type="text" class="form-control" name="estadoVaga" id="estadoVaga" placeholder="Ex: SP" maxlength="2">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="descricaoVaga" class="form-label fw-bold">Descrição da Vaga *</label>
                                <textarea class="form-control" name="descricaoVaga" id="descricaoVaga" rows="4" placeholder="Descreva as responsabilidades e detalhes da vaga..." required></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="requisitosVaga" class="form-label fw-bold">Requisitos da Vaga</label>
                                <textarea class="form-control" name="requisitosVaga" id="requisitosVaga" rows="3" placeholder="Ex: Conhecimento em PHP, MySQL, HTML/CSS..."></textarea>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="inicioEmpresa.php" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary" style="background-color: #0d6efd; border: none;">Publicar Vaga</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>

            <!-- Tabela de Candidaturas Recebidas -->
            <hr class="my-5" id="secao-candidaturas">
            
            <?php if (!empty($erroSQL)): ?>
                <div class="alert alert-danger mb-4">
                    <strong>Erro na Consulta do Banco de Dados:</strong> <?= $erroSQL ?>
                </div>
            <?php endif; ?>

            <div class="d-flex align-items-center justify-content-between mb-4">
                <h3 class="fw-bold text-dark mb-0">
                    <i class="bi bi-people-fill text-primary me-2"></i>Candidaturas Recebidas
                </h3>
                <span class="badge bg-primary rounded-pill px-3 py-2">
                    Total: <?= ($resCandidaturas) ? mysqli_num_rows($resCandidaturas) : 0 ?>
                </span>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Candidato</th>
                                    <th>E-mail</th>
                                    <th>Vaga Pretendida</th>
                                    <th>Data Envio</th>
                                    <th class="text-center">Currículo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($resCandidaturas && mysqli_num_rows($resCandidaturas) > 0): ?>
                                    <?php while ($cand = mysqli_fetch_assoc($resCandidaturas)): ?>
                                        <tr>
                                            <td class="fw-bold text-dark">
                                                <i class="bi bi-person-circle me-1 text-secondary"></i>
                                                <?= htmlspecialchars($cand['nomeCandidato']) ?>
                                            </td>
                                            <td><?= htmlspecialchars($cand['emailCandidato']) ?></td>
                                            <td>
                                                <span class="badge bg-light text-primary border fs-6">
                                                    <?= htmlspecialchars($cand['tituloVaga']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php 
                                                    $dataEnvio = $cand['dataCandidatura'] ?? $cand['data'] ?? $cand['created_at'] ?? null;
                                                    echo $dataEnvio ? date('d/m/Y H:i', strtotime($dataEnvio)) : 'N/D';
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <?php 
                                                    $nomeArquivo = $cand['curriculo'] ?? $cand['arquivo'] ?? $cand['arquivoCandidatura'] ?? $cand['curriculoCandidato'] ?? '';
                                                    $caminhoArquivo = !empty($nomeArquivo) ? (str_contains($nomeArquivo, 'uploads/') ? $nomeArquivo : "uploads/" . $nomeArquivo) : '';
                                                ?>

                                                <?php if (!empty($nomeArquivo)): ?>
                                                    <a href="<?= $caminhoArquivo ?>" target="_blank" class="btn btn-sm btn-outline-primary fw-bold">
                                                        <i class="bi bi-file-earmark-pdf me-1"></i> Abrir Currículo
                                                    </a>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Sem arquivo</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            Nenhuma candidatura foi cadastrada no sistema para esta empresa ainda.
                                        </td>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include "footer.php"; ?>
</body>
</html>