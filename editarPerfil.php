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
$idUsuario = $_SESSION['idUsuario'] ?? $_SESSION['idCandidato'] ?? 0;

// 3. Consulta dados do banco usando idUsuario
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
$estadoUsuario = $usuario['estadoUsuario'] ?? 'SP';

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
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Fonte Plus Jakarta Sans / Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS Customizado -->
    <link rel="stylesheet" href="css/styles.css">

    <!-- Correção de visibilidade da Sidebar -->
    <style>
        .sidebar .nav-link.active,
        .sidebar .nav-link.active * {
            background-color: #0d6efd !important;
            color: #ffffff !important;
            opacity: 1 !important;
            visibility: visible !important;
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">

        <!-- Sidebar Estática -->
        <div class="col-md-3 col-lg-2 sidebar shadow-sm pt-4">
            <nav class="nav flex-column px-2 gap-1">
                <a class="nav-link" href="perfilCandidato.php"><i class="bi bi-file-person me-2"></i> Meu currículo</a>
                <a class="nav-link" href="listarVagas.php"><i class="bi bi-briefcase me-2"></i> Oportunidades</a>
                <a class="nav-link active" href="editarPerfil.php"><i class="bi bi-person me-2"></i> Perfil</a>
                <a class="nav-link text-danger mt-4" href="sair.php"><i class="bi bi-box-arrow-right me-2"></i> Sair</a>
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
                        <p class="mb-0" style="color: #0b2e59 !important;">Atualize seus dados pessoais e de contato para que as empresas te encontrem no JovemLink.</p>
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

                        <!-- Coluna Direita: Form Dados e Endereço -->
                        <div class="col-lg-8">
                            <div class="card border-0 shadow-sm p-4 rounded-3">
                                
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