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
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificações - JovemLink</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Fonte Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
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

        /* Item Ativo - Notificações */
        .menu-link.active-item {
            background-color: #e8f1ff !important;
            color: #0d6efd !important;
        }

        .menu-link.active-item i {
            color: #0d6efd !important;
            font-size: 1.25rem;
        }

        /* Itens Padrão */
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

        /* Estilos dos Cards de Notificação */
        .avatar-company {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #fff;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .unread-card {
            background-color: #f0f7ff;
            border-left: 4px solid #0d6efd !important;
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">

        <!-- Sidebar / Menu Lateral -->
        <div class="col-md-3 col-lg-2 sidebar-container">
            <nav class="menu-list">
                
                <!-- 1. Meu currículo -->
                <a href="perfilCandidato.php" class="menu-link normal-item">
                    <i class="bi bi-person-vcard"></i>
                    <span>Meu currículo</span>
                </a>
                
                <!-- 2. Oportunidades -->
                <a href="listarVagas.php" class="menu-link normal-item">
                    <i class="bi bi-briefcase"></i>
                    <span>Oportunidades</span>
                </a>

                <!-- 3. Notificações (Ativo) -->
                <a href="notificacoes.php" class="menu-link active-item">
                    <i class="bi bi-bell-fill"></i>
                    <span>Notificações</span>
                </a>
                
                <!-- 4. Perfil -->
                <a href="editarPerfil.php" class="menu-link normal-item">
                    <i class="bi bi-person"></i>
                    <span>Perfil</span>
                </a>
                
                <!-- 5. Sair -->
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
                    <div class="col-md-8">
                        <h1 class="fw-bold mb-1" style="color: #0d6efd !important;">Notificações</h1>
                        <hr style="border: none !important; border-top: 2px solid #000000 !important; opacity: 1 !important; margin: 10px 0 !important;">
                        <p class="mb-0" style="color: #0b2e59 !important;">Fique por dentro das novidades e oportunidades que aparecem para você.</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <select class="form-select d-inline-block w-auto">
                            <option>Todas as notificações</option>
                            <option>Não lidas</option>
                        </select>
                    </div>
                </div>

                <!-- Lista de Notificações -->
                <div class="d-flex flex-column gap-3">

                    <!-- Notificação 1 -->
                    <div class="card border-0 shadow-sm p-3 rounded-3 unread-card">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-company bg-warning text-dark">Giraffas</div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark">Nova vaga disponível</h6>
                                    <p class="text-muted small mb-1">Giraffas está com vagas abertas para Atendente de Restaurante.</p>
                                    <span class="text-secondary style-time small"><i class="bi bi-clock me-1"></i>Há 15 minutos</span>
                                </div>
                            </div>
                            <a href="listarVagas.php" class="btn btn-outline-primary btn-sm fw-semibold px-3">Ver vaga</a>
                        </div>
                    </div>

                    <!-- Notificação 2 -->
                    <div class="card border-0 shadow-sm p-3 rounded-3 unread-card">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-company bg-danger">C&A</div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark">Empresa demonstrou interesse no seu perfil</h6>
                                    <p class="text-muted small mb-1">A C&A visualizou seu currículo e pode entrar em contato em breve.</p>
                                    <span class="text-secondary style-time small"><i class="bi bi-clock me-1"></i>Há 1 hora</span>
                                </div>
                            </div>
                            <button class="btn btn-outline-primary btn-sm fw-semibold px-3">Ver empresa</button>
                        </div>
                    </div>

                    <!-- Notificação 3 -->
                    <div class="card border-0 shadow-sm p-3 rounded-3 unread-card">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-company bg-danger fw-bold">M</div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark">Convite para processo seletivo</h6>
                                    <p class="text-muted small mb-1">A McDonald's convidou você para participar de um processo seletivo.</p>
                                    <span class="text-secondary style-time small"><i class="bi bi-clock me-1"></i>Há 2 horas</span>
                                </div>
                            </div>
                            <button class="btn btn-outline-primary btn-sm fw-semibold px-3">Ver detalhes</button>
                        </div>
                    </div>

                    <!-- Notificação 4 -->
                    <div class="card border-0 shadow-sm p-3 rounded-3 bg-white">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-company bg-dark">R</div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark">Vaga próxima ao seu perfil</h6>
                                    <p class="text-muted small mb-1">A Renner publicou uma vaga que combina com o seu perfil.</p>
                                    <span class="text-secondary style-time small"><i class="bi bi-clock me-1"></i>Ontem</span>
                                </div>
                            </div>
                            <a href="listarVagas.php" class="btn btn-outline-primary btn-sm fw-semibold px-3">Ver vaga</a>
                        </div>
                    </div>

                    <!-- Notificação 5 -->
                    <div class="card border-0 shadow-sm p-3 rounded-3 bg-white">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-company bg-primary">Magalu</div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark">Atualização de candidatura</h6>
                                    <p class="text-muted small mb-1">Seu currículo foi atualizado com sucesso para a vaga de Jovem Aprendiz.</p>
                                    <span class="text-secondary style-time small"><i class="bi bi-clock me-1"></i>2 dias atrás</span>
                                </div>
                            </div>
                            <a href="perfilCandidato.php" class="btn btn-outline-primary btn-sm fw-semibold px-3">Ver candidatura</a>
                        </div>
                    </div>

                    <!-- Notificação 6 -->
                    <div class="card border-0 shadow-sm p-3 rounded-3 bg-white">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-company bg-info text-white"><i class="bi bi-star-fill"></i></div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark">Dica para você</h6>
                                    <p class="text-muted small mb-1">Complete seu currículo para aumentar suas chances de conseguir uma vaga.</p>
                                    <span class="text-secondary style-time small"><i class="bi bi-clock me-1"></i>3 dias atrás</span>
                                </div>
                            </div>
                            <a href="editarPerfil.php" class="btn btn-outline-primary btn-sm fw-semibold px-3">Completar currículo</a>
                        </div>
                    </div>

                </div>

            </main>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>