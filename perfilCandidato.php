<?php
// 1. Inicia a sessão e valida o login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: formLogin.php");
    exit();
}

include "conexaoBD.php";

// 2. Identifica o ID do usuário conectado
$idUsuario = (int)($_SESSION['idUsuario'] ?? $_SESSION['idCandidato'] ?? 0);

// 3. Busca os dados do usuário no Banco de Dados
$sql = "SELECT * FROM usuarios WHERE idUsuario = '$idUsuario'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $usuario = mysqli_fetch_assoc($result);
} else {
    echo "Usuário não encontrado.";
    exit();
}

// 4. Tratamento das variáveis para exibição no HTML
$nome = !empty($usuario['nomeUsuario']) ? htmlspecialchars($usuario['nomeUsuario']) : "Candidato";
$email = !empty($usuario['emailUsuario']) ? htmlspecialchars($usuario['emailUsuario']) : "Não informado";
$telefone = !empty($usuario['telefoneUsuario']) ? htmlspecialchars($usuario['telefoneUsuario']) : "";
$cidade = !empty($usuario['cidadeUsuario']) ? htmlspecialchars($usuario['cidadeUsuario']) : "";
$estado = !empty($usuario['estadoUsuario']) ? htmlspecialchars($usuario['estadoUsuario']) : "";
$localizacao = (!empty($cidade) && !empty($estado)) ? "{$cidade} - {$estado}" : "Localização não informada";

// Caminho e fallback para a imagem de perfil
$foto = (!empty($usuario['fotoUsuario']) && file_exists($usuario['fotoUsuario'])) ? $usuario['fotoUsuario'] : "assets/img/default-user.png";

// Cálculo de idade
$idade = "Idade não informada";
if (!empty($usuario['dataNascimentoUsuario'])) {
    $dataNasc = new DateTime($usuario['dataNascimentoUsuario']);
    $hoje = new DateTime();
    $idade = $hoje->diff($dataNasc)->y . " anos";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Currículo - JovemLink</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Fonte Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Customizado -->
    <link rel="stylesheet" href="css/styles.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f9fa;
        }

        /* Sidebar com borda fina à direita */
        .sidebar-container {
            background-color: #ffffff;
            min-height: 100vh;
            border-right: 1px solid #e5e7eb;
            padding-top: 24px;
            padding-left: 16px;
            padding-right: 16px;
        }

        .menu-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 18px;
            text-decoration: none !important;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 16px;
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            transition: background-color 0.2s ease;
        }

        /* Item Ativo - Meu Currículo */
        .menu-link.active-item {
            background-color: #e8f1ff !important;
            color: #0d6efd !important;
        }

        .menu-link.active-item i {
            color: #0d6efd !important;
            font-size: 1.25rem;
        }

        /* Itens Padrão - Oportunidades e Perfil */
        .menu-link.normal-item {
            background-color: transparent !important;
            color: #212529 !important;
        }

        .menu-link.normal-item i {
            color: #495057 !important;
            font-size: 1.25rem;
        }

        .menu-link.normal-item:hover {
            background-color: #f8f9fa !important;
        }

        /* Item Sair */
        .menu-link.logout-item {
            background-color: transparent !important;
            color: #dc3545 !important;
            margin-top: 20px;
        }

        .menu-link.logout-item i {
            color: #dc3545 !important;
            font-size: 1.25rem;
        }

        .menu-link.logout-item:hover {
            background-color: #fff5f5 !important;
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">

        <!-- Sidebar / Menu Lateral -->
        <div class="col-md-3 col-lg-2 sidebar-container">
            <nav class="menu-list">
                
                <!-- 1. Meu currículo (Ativo) -->
                <a href="perfilCandidato.php" class="menu-link active-item">
                    <i class="bi bi-person-vcard-fill"></i>
                    <span>Meu currículo</span>
                </a>
                
                <!-- 2. Oportunidades -->
                <a href="listarVagas.php" class="menu-link normal-item">
                    <i class="bi bi-briefcase"></i>
                    <span>Oportunidades</span>
                </a>
                
                <!-- 3. Perfil -->
                <a href="editarPerfil.php" class="menu-link normal-item">
                    <i class="bi bi-person"></i>
                    <span>Perfil</span>
                </a>
                
                <!-- 4. Sair -->
                <a href="logoutUsuario.php" class="menu-link logout-item">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Sair</span>
                </a>

            </nav>
        </div>

        <!-- Conteúdo Principal -->
        <div class="col-md-9 col-lg-10">
            <main class="px-3 px-md-4 pt-4 mb-5">
                
                <!-- Cabeçalho Principal -->
                <div class="row align-items-center mb-4 g-3 bg-white p-4 rounded-3 shadow-sm border-0">
                    <div class="col-md-7">
                        <h1 class="fw-bold mb-1" style="color: #0d6efd !important;">Meu Currículo</h1>
                        <hr style="border: none !important; border-top: 2px solid #000000 !important; opacity: 1 !important; margin: 10px 0 !important;">
                        <p class="mb-0" style="color: #0b2e59 !important;">Complete suas informações para se destacar para as empresas no JovemLink.</p>
                    </div>
                    <div class="col-md-5">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold" style="color: #0b2e59 !important;">Progresso do Currículo</span>
                            <span class="badge fs-6 px-3 py-1" style="background-color: #0d6efd !important;">80%</span>
                        </div>
                        <div class="progress" style="height: 10px; background-color: #e9ecef;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 80%; background-color: #0d6efd !important;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>

                <!-- Grid Conteúdo -->
                <div class="row g-4">
                    
                    <!-- Coluna Esquerda -->
                    <div class="col-lg-8">
                        
                        <!-- Card Perfil Resumido -->
                        <div class="card border-0 shadow-sm p-4 mb-4 rounded-3">
                            <div class="d-flex flex-column flex-sm-row align-items-center align-items-sm-start gap-4">
                                <div class="text-center">
                                    <img src="<?= $foto ?>" alt="<?= $nome ?>" class="rounded-circle img-thumbnail mb-2 shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
                                    <a href="editarPerfil.php" class="btn btn-sm btn-outline-primary w-100"><i class="bi bi-pencil me-1"></i> Foto</a>
                                </div>
                                <div class="user-details flex-grow-1 text-center text-sm-start">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h2 class="display-6 fw-bold mb-0" style="color: #0b2e59 !important;"><?= $nome ?></h2>
                                        <a href="editarPerfil.php" class="btn text-white btn-sm px-3 d-none d-sm-inline-block" style="background-color: #0d6efd !important;">
                                            <i class="bi bi-pencil me-1"></i> Editar Perfil
                                        </a>
                                    </div>
                                    
                                    <div class="row g-2 mt-2 text-muted">
                                        <div class="col-sm-6"><i class="bi bi-calendar me-2" style="color: #0d6efd !important;"></i> <?= $idade ?></div>
                                        <div class="col-sm-6"><i class="bi bi-geo-alt me-2" style="color: #0d6efd !important;"></i> <?= $localizacao ?></div>
                                        <div class="col-sm-6"><i class="bi bi-envelope me-2" style="color: #0d6efd !important;"></i> <?= $email ?></div>
                                        <?php if (!empty($telefone)): ?>
                                            <div class="col-sm-6"><i class="bi bi-telephone me-2" style="color: #0d6efd !important;"></i> <?= $telefone ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informações do Currículo -->
                        <div class="card border-0 shadow-sm p-4 rounded-3">
                            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                                <h4 class="h2 fw-bold mb-0" style="color: #0b2e59 !important;">Informações do Currículo</h4>
                                <span class="text-muted small">Última atualização hoje</span>
                            </div>
                            
                            <div class="row g-3">
                                <!-- Escolaridade -->
                                <div class="col-12">
                                    <div class="p-3 rounded-3 bg-light d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-white p-3 rounded-circle shadow-sm me-3" style="color: #0d6efd !important;">
                                                <i class="bi bi-mortarboard fs-4"></i>
                                            </div>
                                            <div>
                                                <span class="text-uppercase text-muted fw-bold style-label">Escolaridade</span>
                                                <h6 class="mb-0 fw-bold fs-5" style="color: #0b2e59 !important;"><?= htmlspecialchars($usuario['escolaridadeUsuario'] ?? 'Ensino Médio – Cursando') ?></h6>
                                            </div>
                                        </div>
                                        <a href="editarPerfil.php" class="text-decoration-none fw-semibold pe-2" style="color: #0d6efd !important;">Alterar</a>
                                    </div>
                                </div>

                                <!-- Cursos -->
                                <div class="col-12">
                                    <div class="p-3 rounded-3 bg-light d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-white p-3 rounded-circle shadow-sm me-3" style="color: #0d6efd !important;">
                                                <i class="bi bi-journal-bookmark fs-4"></i>
                                            </div>
                                            <div>
                                                <span class="text-uppercase text-muted fw-bold style-label">Cursos Adicionais</span>
                                                <h6 class="mb-0 fw-bold fs-5" style="color: #0b2e59 !important;"><?= htmlspecialchars($usuario['cursosUsuario'] ?? 'Informática Básica') ?></h6>
                                            </div>
                                        </div>
                                        <a href="editarPerfil.php" class="text-decoration-none fw-semibold pe-2" style="color: #0d6efd !important;">Alterar</a>
                                    </div>
                                </div>

                                <!-- Habilidades -->
                                <div class="col-12">
                                    <div class="p-3 rounded-3 bg-light d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-white p-3 rounded-circle shadow-sm me-3" style="color: #0d6efd !important;">
                                                <i class="bi bi-star fs-4"></i>
                                            </div>
                                            <div>
                                                <span class="text-uppercase text-muted fw-bold style-label">Habilidades Principais</span>
                                                <h6 class="mb-0 fw-bold fs-5" style="color: #0b2e59 !important;"><?= htmlspecialchars($usuario['habilidadesUsuario'] ?? 'Comunicação, Organização') ?></h6>
                                            </div>
                                        </div>
                                        <a href="editarPerfil.php" class="text-decoration-none fw-semibold pe-2" style="color: #0d6efd !important;">Alterar</a>
                                    </div>
                                </div>

                                <!-- Área de Interesse -->
                                <div class="col-12">
                                    <div class="p-3 rounded-3 bg-light d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-white p-3 rounded-circle shadow-sm me-3" style="color: #0d6efd !important;">
                                                <i class="bi bi-bullseye fs-4"></i>
                                            </div>
                                            <div>
                                                <span class="text-uppercase text-muted fw-bold style-label">Área de Interesse</span>
                                                <h6 class="mb-0 fw-bold fs-5" style="color: #0b2e59 !important;"><?= htmlspecialchars($usuario['interesseUsuario'] ?? 'Administrativo, Atendimento') ?></h6>
                                            </div>
                                        </div>
                                        <a href="editarPerfil.php" class="text-decoration-none fw-semibold pe-2" style="color: #0d6efd !important;">Alterar</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Coluna Direita -->
                    <div class="col-lg-4">
                        
                        <!-- Visualizar Currículo -->
                        <div class="card border-0 shadow-sm p-4 mb-4 text-center rounded-3">
                            <h5 class="h2 fw-bold mb-3" style="color: #0d6efd !important;">Visualizar Currículo</h5>
                            <i class="bi bi-file-earmark-text display-3 mb-2" style="color: #0d6efd !important;"></i>
                            <p class="small mb-3" style="color: #0b2e59 !important;">Veja como as empresas visualizam seu perfil em formato de currículo.</p>
                            <button class="btn text-white w-100 py-2" style="background-color: #0d6efd !important;" data-bs-toggle="modal" data-bs-target="#modalVisualizarCurriculo">
                                <i class="bi bi-eye me-2"></i> Visualizar Currículo
                            </button>
                        </div>

                        <!-- Status -->
                        <div class="card border-0 shadow-sm p-4 mb-4 rounded-3">
                            <h5 class="h2 fw-bold mb-3" style="color: #0d6efd !important;">Status do Preenchimento</h5>
                            <ul class="list-unstyled mb-0">
                                <li class="py-2 border-bottom text-success"><i class="bi bi-check-circle-fill me-2"></i> Foto adicionada</li>
                                <li class="py-2 border-bottom text-success"><i class="bi bi-check-circle-fill me-2"></i> Informações pessoais</li>
                                <li class="py-2 border-bottom text-success"><i class="bi bi-check-circle-fill me-2"></i> Escolaridade</li>
                                <li class="py-2 border-bottom text-success"><i class="bi bi-check-circle-fill me-2"></i> Habilidades</li>
                                <li class="py-2 border-bottom text-muted"><i class="bi bi-circle me-2"></i> Experiências</li>
                                <li class="py-2 text-success"><i class="bi bi-check-circle-fill me-2"></i> Cursos</li>
                            </ul>
                        </div>

                        <!-- Dica -->
                        <div class="card border-0 shadow-sm text-white p-4 rounded-3" style="background-color: #0d6efd !important;">
                            <h5 class="fw-bold mb-2"><i class="bi bi-star-fill me-2"></i> Dica Rápida</h5>
                            <p class="small mb-0 opacity-90">Quanto mais completo seu currículo, maiores são as chances de você aparecer em destaque nas buscas das empresas!</p>
                        </div>

                    </div>

                </div>
            </main>
        </div>

    </div>
</div>

<!-- Modal de Visualização -->
<div class="modal fade" id="modalVisualizarCurriculo" tabindex="-1" aria-labelledby="modalVisualizarCurriculoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            
            <div class="modal-header bg-light border-0">
                <h5 class="modal-title fw-bold" style="color: #0b2e59 !important;" id="modalVisualizarCurriculoLabel">
                    <i class="bi bi-file-earmark-text me-2" style="color: #0d6efd !important;"></i> Pré-visualização do Currículo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            
            <div class="modal-body p-4 bg-light">
                <div class="p-4 p-md-5 bg-white rounded-3 shadow-sm border">
                    <div class="row align-items-center pb-4 mb-4 border-bottom g-3">
                        <div class="col-sm-3 text-center">
                            <img src="<?= $foto ?>" alt="<?= $nome ?>" class="rounded-circle img-fluid border" style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                        <div class="col-sm-9 text-center text-sm-start">
                            <h2 class="display-4 fw-bold mb-1" style="color: #0b2e59 !important;"><?= $nome ?></h2>
                            <p class="text-muted fw-semibold mb-2">Jovem Aprendiz</p>
                            
                            <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-sm-start text-muted small">
                                <span><i class="bi bi-calendar me-1" style="color: #0d6efd !important;"></i> <?= $idade ?></span>
                                <span><i class="bi bi-geo-alt me-1" style="color: #0d6efd !important;"></i> <?= $localizacao ?></span>
                                <span><i class="bi bi-envelope me-1" style="color: #0d6efd !important;"></i> <?= $email ?></span>
                                <?php if (!empty($telefone)): ?>
                                    <span><i class="bi bi-telephone me-1" style="color: #0d6efd !important;"></i> <?= $telefone ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-uppercase fw-bold border-bottom pb-2 mb-3" style="color: #0d6efd !important;"><i class="bi bi-mortarboard me-2"></i> Escolaridade</h6>
                        <p class="fw-bold mb-0"><?= htmlspecialchars($usuario['escolaridadeUsuario'] ?? 'Ensino Médio') ?></p>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-uppercase fw-bold border-bottom pb-2 mb-3" style="color: #0d6efd !important;"><i class="bi bi-journal-bookmark me-2"></i> Cursos Adicionais</h6>
                        <p class="text-muted mb-0"><?= htmlspecialchars($usuario['cursosUsuario'] ?? 'Informática Básica') ?></p>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-uppercase fw-bold border-bottom pb-2 mb-3" style="color: #0d6efd !important;"><i class="bi bi-star me-2"></i> Habilidades Principais</h6>
                        <p class="text-muted mb-0"><?= htmlspecialchars($usuario['habilidadesUsuario'] ?? 'Comunicação, Organização') ?></p>
                    </div>

                    <div>
                        <h6 class="text-uppercase fw-bold border-bottom pb-2 mb-3" style="color: #0d6efd !important;"><i class="bi bi-bullseye me-2"></i> Área de Interesse</h6>
                        <p class="text-muted mb-0"><?= htmlspecialchars($usuario['interesseUsuario'] ?? 'Administrativo') ?></p>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Fechar</button>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>