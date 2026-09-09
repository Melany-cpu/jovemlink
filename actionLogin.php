<?php

    include "conexaoBD.php"; //Inclui o arquivo de conexão com o BD para consultar usuários
    session_start(); //Função para iniciar uma sessão

    $emailUsuario = mysqli_real_escape_string($conn, $_POST['emailUsuario']); //Função para filtrar a entrada de dados
    $senhaUsuario = mysqli_real_escape_string($conn, $_POST['senhaUsuario']);

    //QUERY para buscar dados de Login
    $buscarLogin = "SELECT *
                    FROM Usuarios
                    WHERE emailUsuario = '$emailUsuario'
                    AND senhaUsuario = md5('$senhaUsuario')
                    ";

    $efetuarLogin = mysqli_query($conn, $buscarLogin); //Executa a QUERY

    //Verifica se encontrou registros associados à a consulta
    if($registro = mysqli_fetch_assoc($efetuarLogin)){
        //Cria variáveis de sessão
        $_SESSION['idUsuario']    = $registro['idUsuario'];
        $_SESSION['nomeUsuario']  = $registro['nomeUsuario'];
        $_SESSION['emailUsuario'] = $registro['emailUsuario'];
        $_SESSION['nivelUsuario'] = $registro['nivelUsuario'];
        $_SESSION['logado']       = true;

        //Redirecion o usuário para a página inicial
        header("Location: index.php");
        exit();
    }
    else{
        //Redireciona o usuário para formLogin.php
        header("Location: formLogin.php?erroLogin=dadosInvalidos"); //Passa por GET o erro ocorrido
        exit();
    }


?>