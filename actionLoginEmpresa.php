<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "conexaoBD.php";

$emailEmpresa = mysqli_real_escape_string($conn, trim($_POST['emailEmpresa'] ?? '')); 
$senhaEmpresa = mysqli_real_escape_string($conn, trim($_POST['senhaEmpresa'] ?? ''));

// Criptografa a senha digitada em MD5 para comparar no banco
$senhaMD5 = md5($senhaEmpresa);

// Busca a empresa no banco de dados
$sql = "SELECT * FROM Empresa WHERE emailEmpresa = '$emailEmpresa' AND senhaEmpresa = '$senhaMD5'";
$res = mysqli_query($conn, $sql);

if ($registro = mysqli_fetch_assoc($res)) {
    // Salva as informações da empresa na sessão
    $_SESSION['idEmpresa']   = $registro['idEmpresa'];
    $_SESSION['nomeEmpresa'] = $registro['nomeEmpresa'];
    $_SESSION['logado']      = true;
    
    // Redireciona diretamente para o formulário de cadastro de vaga
    echo "<script>
            alert('Login efetuado com sucesso!');
            window.location.href = 'formCadastrarVaga.php';
          </script>";
    exit();
} else {
    // Caso o e-mail ou a senha estejam incorretos
    echo "<script>
            alert('E-mail ou senha incorretos!');
            window.location.href = 'formLoginEmpresa.php';
          </script>";
    exit();
}
?>