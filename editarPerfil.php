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

// 2. Identifica o ID do usuário logado
$idUsuario = (int)($_SESSION['idUsuario'] ?? $_SESSION['idCandidato'] ?? 0);

// 3. Consulta dados do banco apenas na tabela usuarios
$sql = "SELECT * FROM usuarios WHERE idUsuario = '$idUsuario'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $usuario = mysqli_fetch_assoc($result);
} else {
    echo "Usuário não encontrado.";
    exit();
}

// 4. Prepara variáveis para preencher os campos do formulário
$nome = htmlspecialchars($usuario['nomeUsuario'] ?? '');
$dataNascimento = htmlspecialchars($usuario['dataNascimentoUsuario'] ?? '');
$email = htmlspecialchars($usuario['emailUsuario'] ?? '');
$telefone = htmlspecialchars($usuario['telefoneUsuario'] ?? '');
$cidade = htmlspecialchars($usuario['cidadeUsuario'] ?? '');
$estadoUsuario = $usuario['estadoUsuario'] ?? 'PR';

// Foto de perfil com fallback para imagem padrão
$foto = (!empty($usuario['fotoUsuario']) && file_exists($usuario['fotoUsuario'])) ? $usuario['fotoUsuario'] : "assets/img/default-user.png";

// Lista de estados brasileiros para o select
$estados = [
    'AC' => 'Acre', 'AL' => 'Alagoas', 'AP' => 'Amapá', 'AM' => 'Amazonas',
    'BA' => 'Bahia', 'CE' => 'Ceará', 'DF' => 'Distrito Federal', 'ES' => 'Espírito Santo',
    'GO' => 'Goiás', 'MA' => 'Maranhão', 'MT' => 'Mato Grosso', 'MS' => 'Mato Grosso do Sul',
    'MG' => 'Minas Gerais', 'PA' => 'Pará', 'PB' => 'Paraíba', 'PR' => 'Paraná',
    'PE' => 'Pernambuco', 'PI' => 'Piauí', 'RJ' => 'Rio de Janeiro', 'RN' => 'Rio Grande do Norte',
    'RS' => 'Rio Grande do Sul', 'RO' => 'Rondônia', 'RR' => 'Roraima', 'SC' => 'Santa Catarina',
    'SP' => 'São Paulo', 'SE' => 'Sergipe', 'TO' => 'Tocantins'
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - JovemLink</title>
    
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

        /* Item Ativo - Perfil */
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

                <!-- 3. Notificações -->
                <a href="notificacoes.php" class="menu-link normal-item">
                    <i class="bi bi-bell"></i>
                    <span>Notificações</span>
                </a>
                
                <!-- 4. Perfil (Ativo) -->
                <a href="editarPerfil.php" class="menu-link active-item">
                    <i class="bi bi-person-fill"></i>
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
                        <h1 class="fw-bold mb-1" style="color: #0d6efd !important;">Editar Perfil</h1>
                        <hr style="border: none !important; border-top: 2px solid #000000 !important; opacity: 1 !important; margin: 10px 0 !important;">
                        <p class="mb-0" style="color: #0b2e59 !important;">Atualize seus dados pessoais, endereço e informações do currículo.</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="perfilCandidato.php" class="btn btn-outline-primary px-3 py-2 fw-semibold">
                            <i class="bi bi-arrow-left me-1"></i> Voltar ao Currículo
                        </a>
                    </div>
                </div>

                <!-- Form de Edição -->
                <form action="salvarPerfil.php" method="POST" enctype="multipart/form-data">
                    <div class="row g-4">
                        
                        <!-- Coluna Esquerda: Foto -->
                        <div class="col-lg-4">
                            <div class="card border-0 shadow-sm p-4 text-center rounded-3 h-100">
                                <h5 class="fw-bold mb-3" style="color: #0b2e59 !important;">Foto do Perfil</h5>
                                <div class="mb-3">
                                    <img src="<?= $foto ?>" alt="<?= $nome ?>" class="rounded-circle img-thumbnail shadow-sm mb-3" style="width: 140px; height: 140px; object-fit: cover;">
                                </div>
                                <div class="text-start">
                                    <label for="fotoPerfil" class="form-label small fw-semibold text-muted">Alterar Imagem</label>
                                    <input class="form-control" type="file" id="fotoPerfil" name="fotoPerfil" accept="image/png, image/jpeg">
                                    <span class="small text-muted d-block mt-2">Formatos aceitos: JPG ou PNG.</span>
                                </div>
                            </div>
                        </div>

                        <!-- Coluna Direita: Form Dados, Endereço e Currículo -->
                        <div class="col-lg-8">
                            <div class="card border-0 shadow-sm p-4 rounded-3">
                                
                                <!-- Seção: Dados Pessoais -->
                                <h5 class="fw-bold mb-3 pb-2 border-bottom d-flex align-items-center" style="color: #0b2e59 !important;">
                                    <i class="bi bi-card-heading me-2" style="color: #0d6efd !important;"></i> Dados Pessoais
                                </h5>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="nome" class="form-label small fw-semibold text-muted">Nome Completo</label>
                                        <input type="text" class="form-control" id="nome" name="nome" value="<?= $nome ?>" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="dataNascimento" class="form-label small fw-semibold text-muted">Data de Nascimento</label>
                                        <input type="date" class="form-control" id="dataNascimento" name="dataNascimento" value="<?= $dataNascimento ?>" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="email" class="form-label small fw-semibold text-muted">E-mail</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="telefone" class="form-label small fw-semibold text-muted">Telefone / WhatsApp</label>
                                        <input type="text" class="form-control" id="telefone" name="telefone" value="<?= $telefone ?>" required>
                                    </div>
                                </div>

                                <!-- Seção: Endereço -->
                                <h5 class="fw-bold mb-3 mt-4 pb-2 border-bottom d-flex align-items-center" style="color: #0b2e59 !important;">
                                    <i class="bi bi-geo-alt me-2" style="color: #0d6efd !important;"></i> Endereço
                                </h5>

                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label for="cidade" class="form-label small fw-semibold text-muted">Cidade</label>
                                        <input type="text" class="form-control" id="cidade" name="cidade" value="<?= $cidade ?>" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="estado" class="form-label small fw-semibold text-muted">Estado (UF)</label>
                                        <select class="form-select" id="estado" name="estado" required>
                                            <?php foreach ($estados as $sigla => $nomeEstado): ?>
                                                <option value="<?= $sigla ?>" <?= ($estadoUsuario === $sigla) ? 'selected' : '' ?>>
                                                    <?= $nomeEstado ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Seção: Informações do Currículo -->
                                <h5 class="fw-bold mb-3 mt-4 pb-2 border-bottom d-flex align-items-center" style="color: #0b2e59 !important;">
                                    <i class="bi bi-journal-bookmark me-2" style="color: #0d6efd !important;"></i> Informações do Currículo
                                </h5>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="escolaridade" class="form-label small fw-semibold text-muted">Escolaridade</label>
                                        <input type="text" class="form-control" id="escolaridade" name="escolaridade" placeholder="Ex: Ensino Médio – Cursando">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="cursos" class="form-label small fw-semibold text-muted">Cursos Adicionais</label>
                                        <input type="text" class="form-control" id="cursos" name="cursos" placeholder="Ex: Informática Básica">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="habilidades" class="form-label small fw-semibold text-muted">Habilidades Principais</label>
                                        <input type="text" class="form-control" id="habilidades" name="habilidades" placeholder="Ex: Comunicação, Organização">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="areaInteresse" class="form-label small fw-semibold text-muted">Área de Interesse</label>
                                        <input type="text" class="form-control" id="areaInteresse" name="areaInteresse" placeholder="Ex: Administrativo, Atendimento">
                                    </div>
                                </div>

                                <!-- Botões de Ação -->
                                <div class="d-flex justify-content-end gap-2 mt-4 pt-2 border-top">
                                    <a href="perfilCandidato.php" class="btn btn-light px-4 fw-semibold">Cancelar</a>
                                    <button type="submit" class="btn text-white px-4 fw-semibold" style="background-color: #0d6efd !important;">
                                        <i class="bi bi-floppy me-1"></i> Salvar Alterações
                                    </button>
                                </div>

                            </div>
                        </div>

                    </div>
                </form>

            </main>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>