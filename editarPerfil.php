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
                <a class="nav-link text-dark fw-semibold py-2" href="perfilCandidato.php"><i class="bi bi-file-earmark-person me-2"></i> Meu currículo</a>
                <a class="nav-link text-dark fw-semibold py-2" href="listarVagas.php"><i class="bi bi-briefcase me-2"></i> Oportunidades</a>
                <a class="nav-link text-dark fw-semibold py-2" href="notificacoes.php"><i class="bi bi-bell me-2"></i> Notificações</a>
                <a class="nav-link text-dark fw-semibold py-2" href="dicas.php"><i class="bi bi-lightbulb me-2"></i> Dicas</a>
                <a class="nav-link active bg-light text-primary fw-semibold rounded py-2" href="editarPerfil.php"><i class="bi bi-person me-2"></i> Perfil</a>
                <a class="nav-link text-danger fw-semibold py-2 mt-4" href="sair.php"><i class="bi bi-box-arrow-right me-2"></i> Sair</a>
            </nav>
        </div>

        <!-- Conteúdo Principal -->
        <div class="col-md-9 col-lg-10">
            <main class="px-2 px-md-4 mt-4 pt-2 mb-5 jl-font-body">
                
                <!-- Cabeçalho Principal -->
                <div class="row align-items-center mb-4 g-3 bg-white p-4 rounded-3 shadow-sm border-0">
                    <div class="col-md-8">
                        <h1 class="jl-font-title fw-bold mb-1 jl-color-heading">Editar Perfil</h1>
                        <p class="text-muted mb-0">Atualize seus dados pessoais e de contato para que as empresas te encontrem.</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="perfilCandidato.php" class="btn btn-outline-secondary jl-font-title">
                            <i class="fa-solid fa-arrow-left me-1"></i> Voltar ao Currículo
                        </a>
                    </div>
                </div>

                <!-- Formulário de Edição -->
                <form action="salvar-perfil.php" method="POST" enctype="multipart/form-data">
                    <div class="row g-4">
                        
                        <!-- Coluna Esquerda: Foto e Dicas -->
                        <div class="col-lg-4">
                            <div class="card border-0 shadow-sm p-4 rounded-3 text-center mb-4">
                                <h5 class="jl-font-title fw-bold mb-3 jl-color-heading">Foto do Perfil</h5>
                                
                                <div class="mb-3">
                                    <img src="assets/img/ana.webp" alt="Ana Silva" class="rounded-circle img-thumbnail shadow-sm" style="width: 140px; height: 140px; object-fit: cover;">
                                </div>
                                
                                <div class="mb-2 text-start">
                                    <label for="foto" class="form-label fw-semibold text-dark small">Alterar Imagem</label>
                                    <input type="file" id="foto" name="foto" class="form-control form-control-sm" accept="image/*">
                                </div>
                                
                                <small class="text-muted d-block mt-2">Formatos aceitos: JPG ou PNG.</small>
                            </div>

                            <div class="card border-0 shadow-sm p-4 rounded-3 bg-jl-gradient text-white">
                                <h5 class="jl-font-title fw-bold mb-2"><i class="fa-solid fa-lightbulb me-2"></i> Dica de Foto</h5>
                                <p class="small mb-0 opacity-90">Escolha um ambiente bem iluminado, neutro e evite usar óculos escuros ou chapéus na foto do perfil.</p>
                            </div>
                        </div>

                        <!-- Coluna Direita: Dados Pessoais e de Contato -->
                        <div class="col-lg-8">
                            <div class="card border-0 shadow-sm p-4 rounded-3">
                                <h5 class="jl-font-title fw-bold mb-4 pb-2 border-bottom jl-color-heading">
                                    <i class="fa-regular fa-id-card text-jl me-2"></i> Dados Pessoais
                                </h5>

                                <div class="row g-3">
                                    <!-- Nome Completo -->
                                    <div class="col-md-6">
                                        <label for="nome" class="form-label fw-semibold text-dark">Nome Completo</label>
                                        <input type="text" class="form-control form-control-lg fs-6" id="nome" name="nome" value="Ana Silva" required>
                                    </div>

                                    <!-- Data de Nascimento -->
                                    <div class="col-md-6">
                                        <label for="nascimento" class="form-label fw-semibold text-dark">Data de Nascimento</label>
                                        <input type="date" class="form-control form-control-lg fs-6" id="nascimento" name="nascimento" value="2009-05-14" required>
                                    </div>

                                    <!-- E-mail -->
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-semibold text-dark">E-mail</label>
                                        <input type="email" class="form-control form-control-lg fs-6" id="email" name="email" value="ana.silva@email.com" required>
                                    </div>

                                    <!-- Telefone / WhatsApp -->
                                    <div class="col-md-6">
                                        <label for="telefone" class="form-label fw-semibold text-dark">Telefone / WhatsApp</label>
                                        <input type="tel" class="form-control form-control-lg fs-6" id="telefone" name="telefone" value="(11) 99999-9999" required>
                                    </div>

                                    <h5 class="jl-font-title fw-bold mt-4 mb-3 pb-2 border-bottom jl-color-heading">
                                        <i class="fa-solid fa-location-dot text-jl me-2"></i> Endereço
                                    </h5>

                                    <!-- Cidade -->
                                    <div class="col-md-8">
                                        <label for="cidade" class="form-label fw-semibold text-dark">Cidade</label>
                                        <input type="text" class="form-control form-control-lg fs-6" id="cidade" name="cidade" value="São Paulo" required>
                                    </div>

                                    <!-- Estado -->
                                    <div class="col-md-4">
                                        <label for="estado" class="form-label fw-semibold text-dark">Estado (UF)</label>
                                        <select class="form-select form-select-lg fs-6" id="estado" name="estado" required>
                                           <option value="AC">Acre</option>
                                                <option value="AL">Alagoas</option>
                                                <option value="AP">Amapá</option>
                                                <option value="AM">Amazonas</option>
                                                <option value="BA">Bahia</option>
                                                <option value="CE">Ceará</option>
                                                <option value="DF">Distrito Federal</option>
                                                <option value="ES">Espírito Santo</option>
                                                <option value="GO">Goiás</option>
                                                <option value="MA">Maranhão</option>
                                                <option value="MT">Mato Grosso</option>
                                                <option value="MS">Mato Grosso do Sul</option>
                                                <option value="MG">Minas Gerais</option>
                                                <option value="PA">Pará</option>
                                                <option value="PB">Paraíba</option>
                                                <option value="PR" selected>Paraná</option>
                                                <option value="PE">Pernambuco</option>
                                                <option value="PI">Piauí</option>
                                                <option value="RJ">Rio de Janeiro</option>
                                                <option value="RN">Rio Grande do Norte</option>
                                                <option value="RS">Rio Grande do Sul</option>
                                                <option value="RO">Rondônia</option>
                                                <option value="RR">Roraima</option>
                                                <option value="SC">Santa Catarina</option>
                                                <option value="SP">São Paulo</option>
                                                <option value="SE">Sergipe</option>
                                                <option value="TO">Tocantins</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Botões de Ação -->
                                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                                    <a href="perfilCandidato.php" class="btn btn-light px-4 jl-font-title">Cancelar</a>
                                    <button type="submit" class="btn btn-jl-primary px-4 jl-font-title">
                                        <i class="fa-solid fa-floppy-disk me-1"></i> Salvar Alterações
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

<!-- Scripts do Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>