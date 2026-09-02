<?php
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JOVEMLINK - Dicas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Seu CSS Separado -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <!-- Container flex para colocar a sidebar ao lado do conteúdo -->
    <div class="d-flex w-100">
        
        <!-- Sua Sidebar Bootstrap -->
        <div class="col-md-3 col-lg-2 sidebar bg-white min-vh-100 shadow-sm pt-4 flex-shrink-0">
            <nav class="nav flex-column px-2 gap-1">
                <a class="nav-link text-dark fw-semibold py-2" href="index.php"><i class="bi bi-house me-2"></i> Início</a>
                <a class="nav-link text-dark fw-semibold py-2" href="perfilCandidato.php"><i class="bi bi-file-earmark-person me-2"></i> Meu currículo</a>
                <a class="nav-link text-dark fw-semibold py-2" href="listarVagas.php"><i class="bi bi-briefcase me-2"></i> Oportunidades</a>
                <a class="nav-link text-dark fw-semibold py-2" href="notificacoes.php"><i class="bi bi-bell me-2"></i> Notificações</a>
                <a class="nav-link active bg-light text-primary fw-semibold rounded py-2" href="dicas.php"><i class="bi bi-lightbulb me-2"></i> Dicas</a>
                <a class="nav-link text-dark fw-semibold py-2" href="editarPerfil.php"><i class="bi bi-person me-2"></i> Perfil</a>
                <a class="nav-link text-danger fw-semibold py-2 mt-4" href="sair.php"><i class="bi bi-box-arrow-right me-2"></i> Sair</a>
            </nav>
        </div>

        <!-- Conteúdo principal -->
        <main class="main-content flex-grow-1 p-4">
            <h1 class="page-title">Dicas</h1>
            <p class="page-subtitle">Conteúdos para te ajudar a se preparar e conquistar sua vaga.</p>

            <div class="container-fluid p-0">
                <div class="row g-4">
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card-box">
                            <div class="icon-circle">
                                <i class="fa-solid fa-file-pen"></i>
                            </div>
                            <h3>Como montar um currículo jovem</h3>
                            <p>Mesmo sem experiência, você pode destacar suas qualidades, habilidades e atividades que já realizou, como cursos, trabalhos voluntários e projetos escolares.</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card-box">
                            <div class="icon-circle">
                                <i class="fa-solid fa-comments"></i>
                            </div>
                            <h3>Como se sair bem em uma entrevista</h3>
                            <p>Seja educado, demonstre interesse e confiança. Responda com clareza, conte um pouco sobre você e mostre que quer aprender e crescer.</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card-box">
                            <div class="icon-circle">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <h3>Organização é tudo!</h3>
                            <p>Saber organizar seu tempo é essencial para conciliar estudos, trabalho e vida pessoal. Planeje sua rotina e defina prioridades para dar conta de tudo.</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card-box">
                            <div class="icon-circle">
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <h3>Desenvolva suas habilidades</h3>
                            <p>Invista em cursos, leia, pratique e busque sempre aprender coisas novas. Habilidades como comunicação, trabalho em equipe e proatividade fazem a diferença.</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card-box">
                            <div class="icon-circle">
                                <i class="fa-solid fa-shirt"></i>
                            </div>
                            <h3>Como se vestir para uma entrevista</h3>
                            <p>Prefira roupas simples, limpas e adequadas. Sua aparência também comunica profissionalismo e respeito com a empresa.</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card-box">
                            <div class="icon-circle">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <h3>Como encontrar a vaga ideal para você</h3>
                            <p>Pense nos seus interesses e habilidades e procure vagas que combinam com o que você gosta e sabe fazer.</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card-box">
                            <div class="icon-circle">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <h3>Como se comunicar no ambiente de trabalho</h3>
                            <p>Fale com respeito, escute os outros e seja claro nas suas mensagens. Uma boa comunicação ajuda a construir boas relações.</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card-box">
                            <div class="icon-circle">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <h3>Seus direitos como jovem trabalhador</h3>
                            <p>Conhecer seus direitos é importante para trabalhar com segurança e respeito. Informe-se sobre jornada, folga, salário e benefícios.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>