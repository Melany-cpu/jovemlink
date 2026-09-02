<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel da Empresa - Gerenciar Vagas</title>
    <!-- CSS do Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Ícones do Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            background-color: #ffffff;
            border-right: 1px solid #e2e8f0;
            min-height: 100vh;
            padding-top: 20px;
        }
        .sidebar .nav-link {
            color: #4a5568;
            font-weight: 500;
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            background-color: #e2eefd;
            color: #0d6efd;
            font-weight: 600;
        }
        .card-profile {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 20px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar Lateral (Modo Empresa) -->
        <div class="col-md-2 sidebar">
            <nav class="nav flex-column px-2">
                <a class="nav-link" href="#"><i class="bi bi-house"></i> Início</a>
                <a class="nav-link active" href="#"><i class="bi bi-briefcase"></i> Minhas Vagas</a>
                <a class="nav-link" href="#"><i class="bi bi-people"></i> Candidatos</a>
                <a class="nav-link" href="#"><i class="bi bi-bell"></i> Notificações</a>
                <a class="nav-link" href="#"><i class="bi bi-building"></i> Perfil Empresa</a>
                <a class="nav-link text-danger mt-4" href="#"><i class="bi bi-box-arrow-right"></i> Sair</a>
            </nav>
        </div>

        <!-- Conteúdo Principal -->
        <div class="col-md-10 p-4">

            <!-- Card da Empresa -->
            <div class="card-profile d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <img src="img_avatar1.png" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid #0d6efd;">
                    <div>
                        <h4 class="fw-bold mb-0">Painel do Recrutador</h4>
                        <small class="text-muted">Empresa • São Paulo - SP</small>
                    </div>
                </div>
                <!-- Botão para abrir o Modal de Nova Vaga -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNovaVaga">
                    <i class="bi bi-plus-lg"></i> Criar Nova Vaga
                </button>
            </div>

            <!-- Título da Página -->
            <h1 class="text-center mb-4 fw-bold">Gerenciar Vagas Publicadas</h1>

            <!-- Grid Responsivo com os Cards e opções de Gestão -->
            <div class="row g-3">
                
                <!-- Exemplo de Card 1 -->
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm">
                        <img class="card-img-top" src="img_avatar1.png" alt="Imagem da Vaga" style="height: 160px; object-fit: cover;">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title fw-bold">Desenvolvedor Front-end</h5>
                                <p class="card-text text-secondary">Vaga para atuação híbrida em São Paulo com foco em Bootstrap e PHP.</p>
                            </div>
                            <div class="d-flex gap-2 mt-3">
                                <button class="btn btn-outline-primary w-50" data-bs-toggle="modal" data-bs-target="#modalEditarVaga">
                                    <i class="bi bi-pencil"></i> Editar
                                </button>
                                <button class="btn btn-outline-danger w-50">
                                    <i class="bi bi-trash"></i> Excluir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exemplo de Card 2 -->
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm">
                        <img class="card-img-top" src="img_avatar1.png" alt="Imagem da Vaga" style="height: 160px; object-fit: cover;">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title fw-bold">Analista de Dados</h5>
                                <p class="card-text text-secondary">Procuramos profissionais com experiência em SQL e dashboards.</p>
                            </div>
                            <div class="d-flex gap-2 mt-3">
                                <button class="btn btn-outline-primary w-50" data-bs-toggle="modal" data-bs-target="#modalEditarVaga">
                                    <i class="bi bi-pencil"></i> Editar
                                </button>
                                <button class="btn btn-outline-danger w-50">
                                    <i class="bi bi-trash"></i> Excluir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- Modal para Adicionar Nova Vaga -->
<div class="modal fade" id="modalNovaVaga" tabindex="-1" aria-labelledby="modalNovaVagaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalNovaVagaLabel">Cadastrar Nova Vaga</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="salvar_vaga.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Título da Vaga</label>
                        <input type="text" name="titulo" class="form-control" placeholder="Ex: Desenvolvedor PHP" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição da Vaga</label>
                        <textarea name="descricao" class="form-control" rows="3" placeholder="Descreva os requisitos e detalhes..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Imagem de Capa</label>
                        <input type="file" name="imagem" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Publicar Vaga</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Editar Vaga Existente -->
<div class="modal fade" id="modalEditarVaga" tabindex="-1" aria-labelledby="modalEditarVagaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalEditarVagaLabel">Editar Vaga</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="atualizar_vaga.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id_vaga" value="1">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Título da Vaga</label>
                        <input type="text" name="titulo" class="form-control" value="Desenvolvedor Front-end" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição da Vaga</label>
                        <textarea name="descricao" class="form-control" rows="3" required>Vaga para atuação híbrida em São Paulo com foco em Bootstrap e PHP.</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alterar Imagem de Capa</label>
                        <input type="file" name="imagem" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JS do Bootstrap 5 (Necessário para acionar os Modais) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include "footer.php" ?>
</body>
</html>