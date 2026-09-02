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
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Seu CSS personalizado -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar Lateral -->
        <div class="col-md-3 col-lg-2 sidebar bg-white min-vh-100 shadow-sm pt-4">
            <nav class="nav flex-column px-2 gap-1">
                <a class="nav-link text-dark fw-semibold py-2" href="index.php"><i class="bi bi-house me-2"></i> Início</a>
                <a class="nav-link active bg-light text-primary fw-semibold rounded py-2" href="perfilCandidato.php"><i class="bi bi-file-earmark-person me-2"></i> Meu currículo</a>
                <a class="nav-link text-dark fw-semibold py-2" href="listarVagas.php"><i class="bi bi-briefcase me-2"></i> Oportunidades</a>
                <a class="nav-link text-dark fw-semibold py-2" href="notificacoes.php"><i class="bi bi-bell me-2"></i> Notificações</a>
                <a class="nav-link text-dark fw-semibold py-2" href="dicas.php"><i class="bi bi-lightbulb me-2"></i> Dicas</a>
                <a class="nav-link text-dark fw-semibold py-2" href="editarPerfil.php"><i class="bi bi-person me-2"></i> Perfil</a>
                <a class="nav-link text-danger fw-semibold py-2 mt-4" href="sair.php"><i class="bi bi-box-arrow-right me-2"></i> Sair</a>
            </nav>
        </div>

        <!-- Conteúdo Principal -->
        <div class="col-md-9 col-lg-10">
            <main class="px-2 px-md-4 mt-4 pt-2 mb-5 jl-font-body">
                <!-- Cabeçalho Principal -->
                <div class="row align-items-center mb-4 g-3 bg-white p-4 rounded-3 shadow-sm border-0">
                    <div class="col-md-7">
                        <h1 class="jl-font-title fw-bold mb-1 jl-color-heading">Meu Currículo</h1>
                        <p class="text-muted mb-0">Complete suas informações para se destacar para as empresas no JovemLink.</p>
                    </div>
                    <div class="col-md-5">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="jl-font-title fw-semibold text-secondary">Progresso do Currículo</span>
                            <span class="badge bg-jl-blue jl-font-title fs-6 px-3 py-2">80%</span>
                        </div>
                        <div class="progress" style="height: 12px; background-color: #e9ecef;">
                            <div class="progress-bar bg-jl-gradient progress-bar-striped progress-bar-animated" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>

                <!-- Grid Conteúdo -->
                <div class="row g-4">
                    
                    <!-- Coluna Esquerda -->
                    <div class="col-lg-8">
                        
                        <!-- Card de Perfil Resumido -->
                        <div class="card border-0 shadow-sm p-4 mb-4 rounded-3">
                            <div class="d-flex flex-column flex-sm-row align-items-center align-items-sm-start gap-4">
                                <div class="text-center">
                                    <img src="assets/img/ana.webp" alt="Ana Silva" class="rounded-circle img-thumbnail mb-2 shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
                                    <a href="editarPerfil.php" class="btn btn-sm btn-outline-secondary w-100 jl-font-title"><i class="fa-solid fa-pencil me-1"></i> Foto</a>
                                </div>
                                <div class="user-details flex-grow-1 text-center text-sm-start">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h2 class="jl-font-title fw-bold mb-0 jl-color-heading">Ana Silva</h2>
                                        <a href="editarPerfil.php" class="btn btn-jl-primary btn-sm px-3 d-none d-sm-inline-block jl-font-title">
                                            <i class="fa-solid fa-pencil me-1"></i> Editar Perfil
                                        </a>
                                    </div>
                                    
                                    <div class="row g-2 mt-2 text-muted">
                                        <div class="col-sm-6"><i class="fa-regular fa-calendar text-jl me-2"></i> 16 anos</div>
                                        <div class="col-sm-6"><i class="fa-solid fa-location-dot text-jl me-2"></i> São Paulo - SP</div>
                                        <div class="col-sm-6"><i class="fa-regular fa-envelope text-jl me-2"></i> ana.silva@email.com</div>
                                        <div class="col-sm-6"><i class="fa-solid fa-phone text-jl me-2"></i> (11) 99999-9999</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informações do Currículo -->
                        <div class="card border-0 shadow-sm p-4 rounded-3">
                            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                                <h4 class="jl-font-title fw-bold mb-0 jl-color-heading">Informações do Currículo</h4>
                                <span class="text-muted small">Última atualização hoje</span>
                            </div>
                            
                            <div class="row g-3">
                                <!-- Escolaridade -->
                                <div class="col-12">
                                    <div class="p-3 rounded-3 bg-light d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-white p-3 rounded-circle shadow-sm me-3 text-jl">
                                                <i class="fa-solid fa-graduation-cap fs-5"></i>
                                            </div>
                                            <div>
                                                <span class="text-uppercase text-muted fw-bold style-label">Escolaridade</span>
                                                <h6 class="mb-0 fw-bold text-dark jl-font-title fs-5">Ensino Médio – Cursando 1º ano</h6>
                                            </div>
                                        </div>
                                        <a href="editarPerfil.php" class="text-decoration-none text-jl jl-font-title fw-semibold pe-2">Alterar</a>
                                    </div>
                                </div>

                                <!-- Cursos -->
                                <div class="col-12">
                                    <div class="p-3 rounded-3 bg-light d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-white p-3 rounded-circle shadow-sm me-3 text-jl">
                                                <i class="fa-solid fa-book-open fs-5"></i>
                                            </div>
                                            <div>
                                                <span class="text-uppercase text-muted fw-bold style-label">Cursos Adicionais</span>
                                                <h6 class="mb-0 fw-bold text-dark jl-font-title fs-5">Informática Básica, Excel Básico</h6>
                                            </div>
                                        </div>
                                        <a href="editarPerfil.php" class="text-decoration-none text-jl jl-font-title fw-semibold pe-2">Alterar</a>
                                    </div>
                                </div>

                                <!-- Habilidades -->
                                <div class="col-12">
                                    <div class="p-3 rounded-3 bg-light d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-white p-3 rounded-circle shadow-sm me-3 text-jl">
                                                <i class="fa-regular fa-star fs-5"></i>
                                            </div>
                                            <div>
                                                <span class="text-uppercase text-muted fw-bold style-label">Habilidades Principais</span>
                                                <h6 class="mb-0 fw-bold text-dark jl-font-title fs-5">Comunicação, Organização, Aprendizado rápido</h6>
                                            </div>
                                        </div>
                                        <a href="editarPerfil.php" class="text-decoration-none text-jl jl-font-title fw-semibold pe-2">Alterar</a>
                                    </div>
                                </div>

                                <!-- Área de Interesse -->
                                <div class="col-12">
                                    <div class="p-3 rounded-3 bg-light d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-white p-3 rounded-circle shadow-sm me-3 text-jl">
                                                <i class="fa-solid fa-bullseye fs-5"></i>
                                            </div>
                                            <div>
                                                <span class="text-uppercase text-muted fw-bold style-label">Área de Interesse</span>
                                                <h6 class="mb-0 fw-bold text-dark jl-font-title fs-5">Administrativo, Informática, Atendimento</h6>
                                            </div>
                                        </div>
                                        <a href="editarPerfil.php" class="text-decoration-none text-jl jl-font-title fw-semibold pe-2">Alterar</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Coluna Direita -->
                    <div class="col-lg-4">
                        
                        <!-- Card Visualizar Currículo -->
                        <div class="card border-0 shadow-sm p-4 mb-4 text-center rounded-3">
                            <h5 class="jl-font-title fw-bold mb-3 jl-color-heading">Visualizar Currículo</h5>
                            <i class="fa-solid fa-file-invoice text-jl display-3 mb-2"></i>
                            <p class="small text-muted mb-3">Veja como as empresas visualizam seu perfil em formato de currículo.</p>
                            <button class="btn btn-jl-primary w-100 py-2 jl-font-title" data-bs-toggle="modal" data-bs-target="#modalVisualizarCurriculo">
                                <i class="fa-solid fa-eye me-2"></i> Visualizar Currículo
                            </button>
                        </div>

                        <!-- Checklist -->
                        <div class="card border-0 shadow-sm p-4 mb-4 rounded-3">
                            <h5 class="jl-font-title fw-bold mb-3 jl-color-heading">Status do Preenchimento</h5>
                            <ul class="list-unstyled mb-0">
                                <li class="py-2 border-bottom text-success"><i class="fa-solid fa-circle-check me-2"></i> Foto adicionada</li>
                                <li class="py-2 border-bottom text-success"><i class="fa-solid fa-circle-check me-2"></i> Informações pessoais</li>
                                <li class="py-2 border-bottom text-success"><i class="fa-solid fa-circle-check me-2"></i> Escolaridade</li>
                                <li class="py-2 border-bottom text-success"><i class="fa-solid fa-circle-check me-2"></i> Habilidades</li>
                                <li class="py-2 border-bottom text-muted"><i class="fa-regular fa-circle me-2"></i> Experiências</li>
                                <li class="py-2 text-success"><i class="fa-solid fa-circle-check me-2"></i> Cursos</li>
                            </ul>
                        </div>

                        <!-- Dica JovemLink -->
                        <div class="card border-0 shadow-sm bg-jl-gradient text-white p-4 rounded-3">
                            <h5 class="jl-font-title fw-bold mb-2"><i class="fa-solid fa-star me-2"></i> Dica Rápida</h5>
                            <p class="small mb-0 opacity-90">Quanto mais completo seu currículo, maiores são as chances de você aparecer em destaque nas buscas das empresas!</p>
                        </div>

                    </div>

                </div>
            </main>
        </div>

    </div>
</div>

<!-- Modal de Visualização do Currículo -->
<div class="modal fade" id="modalVisualizarCurriculo" tabindex="-1" aria-labelledby="modalVisualizarCurriculoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            
            <div class="modal-header bg-light border-0">
                <h5 class="modal-title jl-font-title fw-bold jl-color-heading" id="modalVisualizarCurriculoLabel">
                    <i class="fa-solid fa-file-invoice text-jl me-2"></i> Pré-visualização do Currículo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            
            <div class="modal-body p-4 bg-light">
                <!-- Modelo de Folha do Currículo -->
                <div class="p-4 p-md-5 bg-white rounded-3 shadow-sm border">
                    
                    <!-- Cabeçalho -->
                    <div class="row align-items-center pb-4 mb-4 border-bottom g-3">
                        <div class="col-sm-3 text-center">
                            <img src="assets/img/ana.webp" alt="Ana Silva" class="rounded-circle img-fluid border" style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                        <div class="col-sm-9 text-center text-sm-start">
                            <h2 class="jl-font-title fw-bold mb-1 jl-color-heading">Ana Silva</h2>
                            <p class="text-muted fw-semibold mb-2">Jovem Aprendiz / Assistente Administrativo</p>
                            
                            <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-sm-start text-muted small">
                                <span><i class="fa-regular fa-calendar text-jl me-1"></i> 16 anos</span>
                                <span><i class="fa-solid fa-location-dot text-jl me-1"></i> São Paulo - SP</span>
                                <span><i class="fa-regular fa-envelope text-jl me-1"></i> ana.silva@email.com</span>
                                <span><i class="fa-solid fa-phone text-jl me-1"></i> (11) 99999-9999</span>
                            </div>
                        </div>
                    </div>

                    <!-- Conteúdo em Seções -->
                    <div class="mb-4">
                        <h6 class="text-uppercase fw-bold text-jl border-bottom pb-2 mb-3"><i class="fa-solid fa-graduation-cap me-2"></i> Escolaridade</h6>
                        <p class="fw-bold mb-0">Ensino Médio</p>
                        <p class="text-muted small mb-0">Cursando o 1º ano</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-uppercase fw-bold text-jl border-bottom pb-2 mb-3"><i class="fa-solid fa-book-open me-2"></i> Cursos Adicionais</h6>
                        <ul class="list-unstyled mb-0 text-muted">
                            <li class="mb-2"><i class="fa-solid fa-check text-jl me-2"></i><strong>Informática Básica:</strong> Operação de Sistemas e Navegação.</li>
                            <li><i class="fa-solid fa-check text-jl me-2"></i><strong>Excel Básico:</strong> Planilhas e Fórmulas Iniciais.</li>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-uppercase fw-bold text-jl border-bottom pb-2 mb-3"><i class="fa-regular fa-star me-2"></i> Habilidades Principais</h6>
                        <div class="d-flex flex-wrap gap-2 pt-1">
                            <span class="badge bg-light text-dark border px-3 py-2 fw-normal">Comunicação</span>
                            <span class="badge bg-light text-dark border px-3 py-2 fw-normal">Organização</span>
                            <span class="badge bg-light text-dark border px-3 py-2 fw-normal">Aprendizado rápido</span>
                        </div>
                    </div>

                    <div>
                        <h6 class="text-uppercase fw-bold text-jl border-bottom pb-2 mb-3"><i class="fa-solid fa-bullseye me-2"></i> Área de Interesse</h6>
                        <p class="text-muted mb-0">Administrativo, Informática, Atendimento ao Cliente</p>
                    </div>

                </div>
            </div>

            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-secondary px-4 jl-font-title" data-bs-dismiss="modal">Fechar</button>
            </div>

        </div>
    </div>
</div>

<!-- Scripts do Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>