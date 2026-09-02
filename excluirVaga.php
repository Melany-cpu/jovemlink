<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || !isset($_SESSION['idEmpresa'])) {
    header("Location: formLoginEmpresa.php");
    exit();
}

include "conexaoBD.php";

$idEmpresa = $_SESSION['idEmpresa'];
$idVaga = $_GET['id'] ?? 0;

if ($idVaga > 0) {
    // Garante que a vaga pertence à empresa logada antes de excluir
    $sql = "DELETE FROM vaga WHERE idVaga = '$idVaga' AND idEmpresa = '$idEmpresa'";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Vaga excluída com sucesso!'); window.location.href = 'inicioEmpresa.php';</script>";
    } else {
        echo "<script>alert('Erro ao excluir a vaga.'); window.location.href = 'inicioEmpresa.php';</script>";
    }
} else {
    header("Location: inicioEmpresa.php");
}
?>