<?php
    error_reporting(0); //Desabilita alertas de erros de execução
    session_start(); //Inicia sessão

    //Configura o fuso horário para América/São Paulo
    date_default_timezone_set('America/Sao_Paulo');

    //Verifica se há sessão ativa
    if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
        //Armazena em variáveis PHP os dados das variáveis de Sessão 
        $idUsuario    = $_SESSION['idUsuario'];
        $nomeUsuario  = $_SESSION['nomeUsuario'];
        $emailUsuario = $_SESSION['emailUsuario'];
        $nivelUsuario = $_SESSION['nivelUsuario'];

        $nomeCompleto = explode(' ', $nomeUsuario); //Usa a função explode para fragmentar o nome do usuário
        $primeiroNome = $nomeCompleto[0]; //Armazena na primeira posição do array o primeiro fragmento do nome
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>UniMarket - Unindo pessoas, produtos e possibilidades.</title>
        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- CDN para Ícones do Bootstrap (Bootstrap Icons) -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- CSS dos temas do Template (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />

        <!-- CDN da fonte do Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">

        <!-- CSS da fonte do Slogan -->
        <style>
            .audiowide-regular {
                font-family: "Audiowide", sans-serif;
                font-weight: 400;
                font-style: normal;
                font-size: 1.5rem;
            }
        </style>

    </head>
    <body>
        <!-- Barra de Navegação do Sistema -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="index.php" title="Retornar para a Página Inicial">UniMarket</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link" href="#!">Sobre</a></li>
                    </ul>
                    <ul class="navbar-nav mb2 mb-lg-0 ms-lg-4">
                        <?php
                            //Verifica se há sessão ativa
                            if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
                                if($nivelUsuario == 'administrador'){
                                    echo "
                                        <li class='nav-item dropdown'>
                                            <a class='nav-link dropdown-toggle' id='navbarDropdown' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'><i class='bi bi-person-circle'></i> $primeiroNome</a>
                                            <ul class='dropdown-menu' aria-labelledby='navbarDropdown'>
                                                <li><a class='dropdown-item' href='formAnuncio.php'>Criar Anúncio</a></li>
                                                <li><hr class='dropdown-divider' /></li>
                                                <li><a class='dropdown-item' href='#!'>Meus Anúncios</a></li>
                                                <li><a class='dropdown-item' href='#!'>Minhas Compras</a></li>
                                                <li><hr class='dropdown-divider' /></li>
                                                <li><a class='dropdown-item' href='#!'>Gerenciar Anúncios</a></li>
                                                <li><a class='dropdown-item' href='listarUsuarios.php'>Gerenciar Usuários</a></li>
                                                <li><hr class='dropdown-divider' /></li>
                                                <li><a class='dropdown-item' href='logout.php' title='Sair do Sistema'>Sair</a></li>
                                            </ul>
                                        </li>
                                    ";
                                }
                                else{
                                    echo "
                                        <li class='nav-item dropdown'>
                                            <a class='nav-link dropdown-toggle' id='navbarDropdown' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'><i class='bi bi-person-circle'></i> $primeiroNome</a>
                                            <ul class='dropdown-menu' aria-labelledby='navbarDropdown'>
                                                <li><a class='dropdown-item' href='formAnuncio.php'>Criar Anúncio</a></li>
                                                <li><hr class='dropdown-divider' /></li>
                                                <li><a class='dropdown-item' href='#!'>Meus Anúncios</a></li>
                                                <li><a class='dropdown-item' href='#!'>Minhas Compras</a></li>
                                                <li><hr class='dropdown-divider' /></li>
                                                <li><a class='dropdown-item' href='logout.php' title='Sair do Sistema'>Sair</a></li>
                                            </ul>
                                        </li>
                                    ";
                                }
                            }
                            else{
                                echo "<li class='nav-item'><a class='nav-link' href='formLogin.php'>Login</a></li>";
                            }   
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Cabeçalho -->
        <header class="bg-dark py-2">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <img src="assets/img/Logo_Unimarket_Branco.png" style="width: 150px" class="pb-2">
                    <p class="lead fw-normal text-white mb-0 audiowide-regular">Unindo pessoas, produtos e possibilidades.</p>
                </div>
            </div>
        </header>
        <!-- Seção Principal -->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">