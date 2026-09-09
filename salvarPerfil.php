<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "conexaoBD.php";

// 1. Pega o ID da sessão
$idUsuarioSessao = (int)($_SESSION['idUsuario'] ?? $_SESSION['idCandidato'] ?? 0);

if (!$idUsuarioSessao) {
    die("Erro: Usuário não autenticado no sistema.");
}

// 2. Trata as entradas do formulário
$nome     = mysqli_real_escape_string($conn, $_POST['nome'] ?? '');
$dataNasc = mysqli_real_escape_string($conn, $_POST['dataNascimento'] ?? '');
$email    = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
$telefone = mysqli_real_escape_string($conn, $_POST['telefone'] ?? '');
$cidade   = mysqli_real_escape_string($conn, $_POST['cidade'] ?? '');
$estado   = mysqli_real_escape_string($conn, $_POST['estado'] ?? '');

// 3. Processamento da Foto de Perfil (se houver upload)
$queryFoto = "";
if (isset($_FILES['fotoPerfil']) && $_FILES['fotoPerfil']['error'] === UPLOAD_ERR_OK) {
    $extensao = strtolower(pathinfo($_FILES['fotoPerfil']['name'], PATHINFO_EXTENSION));
    $extensoesPermitidas = ['jpg', 'jpeg', 'png'];

    if (in_array($extensao, $extensoesPermitidas)) {
        $diretorio = "uploads/fotos/";
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true);
        }
        
        $nomeArquivo = "user_" . $idUsuarioSessao . "_" . time() . "." . $extensao;
        $caminhoCompleto = $diretorio . $nomeArquivo;

        if (move_uploaded_file($_FILES['fotoPerfil']['tmp_name'], $caminhoCompleto)) {
            $queryFoto = ", fotoUsuario = '$caminhoCompleto'";
        }
    }
}

// 4. Executa a atualização no Banco de Dados
$sql = "UPDATE usuarios SET 
            nomeUsuario = '$nome',
            dataNascimentoUsuario = '$dataNasc',
            emailUsuario = '$email',
            telefoneUsuario = '$telefone',
            cidadeUsuario = '$cidade',
            estadoUsuario = '$estado'
            {$queryFoto}
        WHERE idUsuario = '$idUsuarioSessao'";

if (mysqli_query($conn, $sql)) {
    // Atualiza nome na sessão caso esteja armazenado nela
    if (isset($_SESSION['nomeUsuario'])) $_SESSION['nomeUsuario'] = $nome;
    if (isset($_SESSION['nome'])) $_SESSION['nome'] = $nome;

    header("Location: perfilCandidato.php?status=sucesso");
    exit();
} else {
    die("Erro ao salvar no banco de dados: " . mysqli_error($conn));
}
?>