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

// 2. Identifica o ID da empresa na sessão
$idEmpresa = (int)($_SESSION['idEmpresa'] ?? $_SESSION['idUsuario'] ?? 0);

// 3. Consulta exata na tabela 'empresa'
$sql = "SELECT * FROM empresa WHERE idEmpresa = '$idEmpresa'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $empresa = mysqli_fetch_assoc($result);
} else {
    $empresa = [];
}

// 4. Mapeia os dados baseados na estrutura do banco
$nome = htmlspecialchars($empresa['nomeEmpresa'] ?? $_SESSION['nomeUsuario'] ?? '');
$razaoSocial = htmlspecialchars($empresa['razaoSocialEmpresa'] ?? '');
$cnpj = htmlspecialchars($empresa['cnpjEmpresa'] ?? '');
$email = htmlspecialchars($empresa['emailEmpresa'] ?? $_SESSION['emailUsuario'] ?? '');
$cidade = htmlspecialchars($empresa['cidadeEmpresa'] ?? '');
$estadoEmpresa = $empresa['estadoEmpresa'] ?? 'PR';
$dataFundacao = $empresa['dataFundacaoEmpresa'] ?? '';

$foto = (!empty($empresa['fotoEmpresa']) && file_exists($empresa['fotoEmpresa'])) ? $empresa['fotoEmpresa'] : "assets/img/default-company.png";

// Lista de estados para o menu suspenso
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
    <title>Perfil da Empresa - JovemLink</title>
    
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

        .sidebar {
            min-height: 100vh;
            background-color: #ffffff;
            border-right: 1px solid #e9ecef;
        }

        .sidebar .nav-link {
            color: #495057;
            font-weight: 500;
            padding: 10px 16px;
            border-radius: 8px;
        }

        .sidebar .nav-link:hover {
            background-color: #f1f5f9;
            color: #0d6efd;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link.active * {
            background-color: #0d6efd !important;
            color: #ffffff !important;
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">

        <!-- Sidebar Empresa -->
        <div class="col-md-3 col-lg-2 sidebar pt-4">
            <nav class="nav flex-column px-2 gap-1">
                <a class="nav-link" href="inicioEmpresa.php"><i class="bi bi-house me-2"></i> Início</a>
                <a class="nav-link active" href="perfilEmpresa.php"><i class="bi bi-building me-2"></i> Meu Perfil</a>
                <a class="nav-link" href="formCadastrarVaga.php"><i class="bi bi-plus-circle me-2"></i> Criar Vaga</a>
                <a class="nav-link text-danger mt-4" href="logoutUsuario.php"><i class="bi bi-box-arrow-right me-2"></i> Sair</a>
            </nav>
        </div>

        <!-- Conteúdo Principal -->
        <div class="col-md-9 col-lg-10">
            <main class="px-3 px-md-4 pt-4 mb-5">
                
                <!-- Cabeçalho -->
                <div class="row align-items-center mb-4 g-3 bg-white p-4 rounded-3 shadow-sm border-0">
                    <div class="col-md-8">
                        <h1 class="fw-bold mb-1" style="color: #0d6efd !important;">Perfil da Empresa</h1>
                        <hr style="border: none !important; border-top: 2px solid #000000 !important; opacity: 1 !important; margin: 10px 0 !important;">
                        <p class="mb-0" style="color: #0b2e59 !important;">Gerencie os dados cadastrais e as informações públicas da sua organização.</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="inicioEmpresa.php" class="btn btn-outline-primary px-3 py-2 fw-semibold">
                            <i class="bi bi-arrow-left me-1"></i> Voltar ao Painel
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <form action="salvarPerfilEmpresa.php" method="POST" enctype="multipart/form-data">
                    <div class="row g-4">
                        
                        <!-- Coluna Esquerda: Logotipo -->
                        <div class="col-lg-4">
                            <div class="card border-0 shadow-sm p-4 text-center rounded-3 h-100">
                                <h5 class="fw-bold mb-3" style="color: #0b2e59 !important;">Foto / Logotipo</h5>
                                <div class="mb-3 d-flex justify-content-center">
                                    <div class="rounded-circle border d-flex align-items-center justify-content-center bg-light shadow-sm" style="width: 140px; height: 140px; overflow: hidden;">
                                        <img src="<?= $foto ?>" alt="<?= $nome ?>" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                        <i class="bi bi-building fs-1 text-secondary" style="display: none;"></i>
                                    </div>
                                </div>
                                <div class="text-start">
                                    <label for="fotoEmpresa" class="form-label small fw-semibold text-muted">Alterar Imagem</label>
                                    <input class="form-control" type="file" id="fotoEmpresa" name="fotoEmpresa" accept="image/png, image/jpeg">
                                </div>
                            </div>
                        </div>

                        <!-- Coluna Direita: Dados Cadastrais -->
                        <div class="col-lg-8">
                            <div class="card border-0 shadow-sm p-4 rounded-3">
                                
                                <h5 class="fw-bold mb-3 pb-2 border-bottom d-flex align-items-center" style="color: #0b2e59 !important;">
                                    <i class="bi bi-briefcase me-2" style="color: #0d6efd !important;"></i> Informações Corporativas
                                </h5>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="nomeEmpresa" class="form-label small fw-semibold text-muted">Nome Fantasia</label>
                                        <input type="text" class="form-control" id="nomeEmpresa" name="nomeEmpresa" value="<?= $nome ?>" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="razaoSocialEmpresa" class="form-label small fw-semibold text-muted">Razão Social</label>
                                        <input type="text" class="form-control" id="razaoSocialEmpresa" name="razaoSocialEmpresa" value="<?= $razaoSocial ?>" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="cnpjEmpresa" class="form-label small fw-semibold text-muted">CNPJ</label>
                                        <input type="text" class="form-control" id="cnpjEmpresa" name="cnpjEmpresa" value="<?= $cnpj ?>" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="emailEmpresa" class="form-label small fw-semibold text-muted">E-mail Corporativo</label>
                                        <input type="email" class="form-control" id="emailEmpresa" name="emailEmpresa" value="<?= $email ?>" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="dataFundacaoEmpresa" class="form-label small fw-semibold text-muted">Data de Fundação</label>
                                        <input type="date" class="form-control" id="dataFundacaoEmpresa" name="dataFundacaoEmpresa" value="<?= $dataFundacao ?>">
                                    </div>
                                </div>

                                <!-- Localização -->
                                <h5 class="fw-bold mb-3 mt-4 pb-2 border-bottom d-flex align-items-center" style="color: #0b2e59 !important;">
                                    <i class="bi bi-geo-alt me-2" style="color: #0d6efd !important;"></i> Localização
                                </h5>

                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label for="cidadeEmpresa" class="form-label small fw-semibold text-muted">Cidade</label>
                                        <input type="text" class="form-control" id="cidadeEmpresa" name="cidadeEmpresa" value="<?= $cidade ?>" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="estadoEmpresa" class="form-label small fw-semibold text-muted">Estado (UF)</label>
                                        <select class="form-select" id="estadoEmpresa" name="estadoEmpresa" required>
                                            <?php foreach ($estados as $sigla => $nomeEstado): ?>
                                                <option value="<?= $sigla ?>" <?= ($estadoEmpresa === $sigla) ? 'selected' : '' ?>>
                                                    <?= $nomeEstado ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Botões -->
                                <div class="d-flex justify-content-end gap-2 mt-4 pt-2 border-top">
                                    <a href="inicioEmpresa.php" class="btn btn-light px-4 fw-semibold">Cancelar</a>
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